<?php

namespace App\Services;

use App\Models\AlumniProfile;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use ZipArchive;

class AppleWalletPassService
{
    public function createPkPassForAlumni(AlumniProfile $profile): array
    {
        $this->assertConfigured();

        $serial = $profile->public_id ?: (string) Str::uuid();
        $passJson = $this->buildPassJson($profile, $serial);

        $tmpRoot = storage_path('app/pkpass/tmp_' . Str::random(12));
        if (! is_dir($tmpRoot)) {
            mkdir($tmpRoot, 0775, true);
        }

        // 1) pass.json
        $passJsonPath = $tmpRoot . DIRECTORY_SEPARATOR . 'pass.json';
        file_put_contents($passJsonPath, json_encode($passJson, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        // 2) images
        $this->putImages($tmpRoot);

        // 3) manifest.json
        $manifest = $this->buildManifest($tmpRoot);
        $manifestPath = $tmpRoot . DIRECTORY_SEPARATOR . 'manifest.json';
        file_put_contents($manifestPath, json_encode($manifest, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        // 4) signature (DER)
        $signaturePath = $tmpRoot . DIRECTORY_SEPARATOR . 'signature';
        $this->signManifest($manifestPath, $signaturePath);

        // 5) zip as .pkpass
        $outDir = storage_path('app/pkpass');
        if (! is_dir($outDir)) {
            mkdir($outDir, 0775, true);
        }

        $fileName = 'kazgasa-alumni-' . $serial . '.pkpass';
        $pkpassPath = $outDir . DIRECTORY_SEPARATOR . $fileName;

        $zip = new ZipArchive();
        if ($zip->open($pkpassPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            $this->cleanupDir($tmpRoot);
            throw new \RuntimeException('Не удалось создать .pkpass (ZipArchive)');
        }

        foreach (scandir($tmpRoot) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $full = $tmpRoot . DIRECTORY_SEPARATOR . $entry;
            if (is_file($full)) {
                $zip->addFile($full, $entry);
            }
        }
        $zip->close();

        $this->cleanupDir($tmpRoot);

        return [
            'path' => $pkpassPath,
            'filename' => $fileName,
        ];
    }

    private function buildPassJson(AlumniProfile $p, string $serial): array
    {
        $publicUrl = URL::to(route('alumni.card.show', ['publicId' => $p->public_id], false));
        $status = (string) ($p->status ?: 'Connect');

        $primaryFields = [
            [
                'key' => 'name',
                'label' => 'Выпускник',
                'value' => $p->full_name,
            ],
        ];

        $secondaryFields = array_values(array_filter([
            $p->school ? [
                'key' => 'school',
                'label' => 'Школа/Факультет',
                'value' => $p->school,
            ] : null,
            $p->graduation_year ? [
                'key' => 'year',
                'label' => 'Год выпуска',
                'value' => (string) $p->graduation_year,
            ] : null,
        ]));

        $auxiliaryFields = array_values(array_filter([
            $p->membership_type ? [
                'key' => 'type',
                'label' => 'Тип',
                'value' => $p->membership_type === 'paid' ? 'Платный' : 'Бесплатный',
            ] : null,
            [
                'key' => 'status',
                'label' => 'Статус',
                'value' => $status,
            ],
        ]));

        $backFields = array_values(array_filter([
            [
                'key' => 'verify',
                'label' => 'Проверка карты',
                'value' => $publicUrl,
            ],
            $p->iin ? [
                'key' => 'iin',
                'label' => 'ИИН',
                'value' => (string) $p->iin,
            ] : null,
            $p->membership_expiry_date ? [
                'key' => 'expiry',
                'label' => 'Действительна до',
                'value' => $p->membership_expiry_date->format('d.m.Y'),
            ] : null,
        ]));

        return [
            'formatVersion' => 1,
            'passTypeIdentifier' => config('apple-wallet.pass_type_identifier'),
            'teamIdentifier' => config('apple-wallet.team_identifier'),
            'serialNumber' => $serial,
            'organizationName' => config('apple-wallet.organization_name'),
            'description' => config('apple-wallet.description'),

            // Visuals
            'foregroundColor' => 'rgb(255,255,255)',
            'backgroundColor' => 'rgb(143,22,28)', // #8F161C
            'labelColor' => 'rgb(229,198,141)', // #E5C68D

            // Card type
            'storeCard' => [
                'primaryFields' => $primaryFields,
                'secondaryFields' => $secondaryFields,
                'auxiliaryFields' => $auxiliaryFields,
                'backFields' => $backFields,
            ],

            // Barcode (QR)
            'barcodes' => [
                [
                    'format' => 'PKBarcodeFormatQR',
                    'message' => $publicUrl,
                    'messageEncoding' => 'iso-8859-1',
                    'altText' => $p->public_id,
                ],
            ],
        ];
    }

    private function putImages(string $dir): void
    {
        $iconPath = (string) config('apple-wallet.icon_path');
        $logoPath = (string) config('apple-wallet.logo_path');

        if (! is_file($iconPath)) {
            throw new \RuntimeException("Не найден файл иконки для Wallet: {$iconPath}");
        }
        if (! is_file($logoPath)) {
            throw new \RuntimeException("Не найден файл логотипа для Wallet: {$logoPath}");
        }

        // Reuse existing PNG assets. Apple requires icon.png and icon@2x.png.
        $icon = file_get_contents($iconPath);
        $logo = file_get_contents($logoPath);

        file_put_contents($dir . DIRECTORY_SEPARATOR . 'icon.png', $icon);
        file_put_contents($dir . DIRECTORY_SEPARATOR . 'icon@2x.png', $icon);
        file_put_contents($dir . DIRECTORY_SEPARATOR . 'logo.png', $logo);
        file_put_contents($dir . DIRECTORY_SEPARATOR . 'logo@2x.png', $logo);
    }

    private function buildManifest(string $dir): array
    {
        $manifest = [];
        foreach (scandir($dir) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $full = $dir . DIRECTORY_SEPARATOR . $entry;
            if (is_file($full)) {
                $manifest[$entry] = sha1_file($full);
            }
        }
        ksort($manifest);
        return $manifest;
    }

    private function signManifest(string $manifestPath, string $signaturePath): void
    {
        $cert = 'file://' . (string) config('apple-wallet.cert_signer_path');
        $key = 'file://' . (string) config('apple-wallet.key_signer_path');
        $keyPassword = (string) config('apple-wallet.key_signer_password');
        $wwdr = (string) config('apple-wallet.cert_wwdr_path');

        foreach ([$cert, $key, $wwdr] as $path) {
            $fsPath = str_starts_with($path, 'file://') ? substr($path, 7) : $path;
            if (! is_file($fsPath)) {
                throw new \RuntimeException("Не найден сертификат/ключ Wallet: {$fsPath}");
            }
        }

        $smimeOut = $signaturePath . '.smime';
        $headers = [];
        $flags = PKCS7_BINARY | PKCS7_DETACHED;

        $ok = openssl_pkcs7_sign(
            $manifestPath,
            $smimeOut,
            $cert,
            [$key, $keyPassword],
            $headers,
            $flags,
            $wwdr
        );

        if (! $ok) {
            throw new \RuntimeException('Не удалось подписать manifest.json (OpenSSL)');
        }

        $smime = file_get_contents($smimeOut);
        @unlink($smimeOut);

        if ($smime === false) {
            throw new \RuntimeException('Не удалось прочитать подпись (S/MIME)');
        }

        // Extract base64 payload from S/MIME and convert to DER bytes for "signature" file.
        $parts = preg_split("/\\R\\R/", $smime, 2);
        if (! $parts || count($parts) < 2) {
            throw new \RuntimeException('Не удалось разобрать подпись (S/MIME формат)');
        }
        $b64 = trim($parts[1]);
        $b64 = preg_replace('/-----BEGIN PKCS7-----|-----END PKCS7-----/i', '', $b64);
        $b64 = preg_replace('/\\s+/', '', $b64);
        $der = base64_decode($b64, true);

        if ($der === false) {
            throw new \RuntimeException('Не удалось декодировать подпись (base64)');
        }

        file_put_contents($signaturePath, $der);
    }

    private function assertConfigured(): void
    {
        if (! config('apple-wallet.enabled')) {
            throw new \RuntimeException('Apple Wallet отключён (APPLE_WALLET_ENABLED=false).');
        }

        $required = [
            'apple-wallet.team_identifier' => config('apple-wallet.team_identifier'),
            'apple-wallet.pass_type_identifier' => config('apple-wallet.pass_type_identifier'),
            'apple-wallet.key_signer_password' => config('apple-wallet.key_signer_password'),
        ];

        foreach ($required as $key => $value) {
            if (! $value) {
                throw new \RuntimeException("Не настроено: {$key}");
            }
        }
    }

    private function cleanupDir(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }
        foreach (scandir($dir) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $full = $dir . DIRECTORY_SEPARATOR . $entry;
            if (is_file($full)) {
                @unlink($full);
            }
        }
        @rmdir($dir);
    }
}

