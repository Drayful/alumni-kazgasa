<?php

namespace App\Services;

use App\Models\AlumniProfile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class GoogleWalletPassService
{
    public function createSaveUrlForAlumni(AlumniProfile $profile): string
    {
        $this->assertConfigured();

        $issuerId    = Config::get('google-wallet.issuer_id');
        $classSuffix = Config::get('google-wallet.class_suffix', 'alumni_card');
        $classId     = "{$issuerId}.{$classSuffix}";

        $objectSuffix = $profile->public_id ?: Str::uuid()->toString();
        $objectId     = "{$issuerId}.{$classSuffix}_{$objectSuffix}";

        $serviceAccount = $this->loadServiceAccount();
        $accessToken    = $this->getAccessToken($serviceAccount);
        $this->ensureClassExists($classId, $accessToken);

        // QR ведёт на страницу проверки карты выпускника
        $publicUrl = url('/card/' . $profile->public_id);
        $status    = (string) ($profile->status ?: 'Connect');

        $textModules = array_values(array_filter([
            $profile->school ? [
                'id'     => 'school',
                'header' => 'ШКОЛА / ФАКУЛЬТЕТ',
                'body'   => $profile->school,
            ] : null,
            $profile->graduation_year ? [
                'id'     => 'year',
                'header' => 'ГОД ВЫПУСКА',
                'body'   => (string) $profile->graduation_year,
            ] : null,
            $profile->membership_type ? [
                'id'     => 'type',
                'header' => 'ТИП ЧЛЕНСТВА',
                'body'   => $profile->membership_type === 'paid' ? 'Платный' : 'Бесплатный',
            ] : null,
            [
                'id'     => 'status',
                'header' => 'СТАТУС КАРТЫ',
                'body'   => $status,
            ],
            $profile->public_id ? [
                'id'     => 'card_id',
                'header' => 'ID КАРТЫ',
                'body'   => strtoupper($profile->public_id),
            ] : null,
        ]));

        $linksModule           = [];
        $linksModule['uris'][] = [
            'uri'         => $publicUrl,
            'description' => 'Проверить подлинность карты',
            'id'          => 'verify',
        ];

        $infoModule = array_values(array_filter([
            $profile->iin ? [
                'id'     => 'iin',
                'header' => 'ИИН',
                'body'   => (string) $profile->iin,
            ] : null,
            $profile->membership_expiry_date ? [
                'id'     => 'expiry',
                'header' => 'Действительна до',
                'body'   => $profile->membership_expiry_date->format('d.m.Y'),
            ] : null,
        ]));

        $validTimeInterval = [];
        if ($profile->membership_expiry_date) {
            $validTimeInterval = [
                'validTimeInterval' => [
                    'end' => [
                        'date' => $profile->membership_expiry_date->toIso8601String(),
                    ],
                ],
            ];
        }

        $genericObject = array_merge([
            'id'      => $objectId,
            'classId' => $classId,
            'state'   => 'ACTIVE',

            'hexBackgroundColor' => '#8F161C',

            'cardTitle' => [
                'defaultValue' => [
                    'language' => 'ru-RU',
                    'value'    => 'КАРТА ВЫПУСКНИКА',
                ],
            ],
            'header' => [
                'defaultValue' => [
                    'language' => 'ru-RU',
                    'value'    => trim($profile->full_name) ?: 'Alumni',
                ],
            ],
            'subheader' => [
                'defaultValue' => [
                    'language' => 'ru-RU',
                    'value'    => 'Выпускник · KazGASA Alumni',
                ],
            ],

            'textModulesData' => $textModules,

            // Back fields — видны при открытии карты (листаешь вниз)
            'infoModuleData' => empty($infoModule) ? null : [
                'labelValueRows' => array_map(fn ($f) => [
                    'columns' => [[
                        'label' => $f['header'],
                        'value' => [
                            'defaultValue' => [
                                'language' => 'ru-RU',
                                'value'    => $f['body'],
                            ],
                        ],
                    ]],
                ], $infoModule),
                'showLastUpdateTime' => false,
            ],

            // Ссылка для проверки подлинности
            'linksModuleData' => $linksModule,

            // QR-код — значение = URL страницы проверки карты
            // Google показывает QR внизу карты при раскрытии
            'barcode' => [
                'type'          => 'QR_CODE',
                'value'         => $publicUrl,
                'alternateText' => strtoupper($profile->public_id ?? ''),
            ],

        ], array_filter($validTimeInterval), ['infoModuleData' => null]);

        // Убираем null значения из массива
        $genericObject = array_filter($genericObject, fn($v) => $v !== null);

        $this->ensureObjectUpsert($genericObject, $accessToken);

        $jwtPayload = [
            'iss'     => $serviceAccount['client_email'],
            'aud'     => 'google',
            'typ'     => 'savetowallet',
            'iat'     => time(),
            'payload' => [
                'genericObjects' => [$genericObject],
            ],
        ];

        $jwt = $this->encodeJwtRs256($jwtPayload, $serviceAccount['private_key']);

        return 'https://pay.google.com/gp/v/save/' . $jwt;
    }

    private function getAccessToken(array $serviceAccount): string
    {
        $jwt = $this->encodeJwtRs256([
            'iss'   => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/wallet_object.issuer',
            'aud'   => 'https://oauth2.googleapis.com/token',
            'iat'   => time(),
            'exp'   => time() + 3600,
        ], $serviceAccount['private_key']);

        $tokenResponse = \Http::post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt,
        ]);

        $accessToken = (string) $tokenResponse->json('access_token');
        if ($accessToken === '') {
            throw new \RuntimeException('Не удалось получить access_token для Google Wallet Issuer API.');
        }

        return $accessToken;
    }

    private function ensureObjectUpsert(array $genericObject, string $accessToken): void
    {
        $objectId = $genericObject['id'] ?? null;
        if (! is_string($objectId) || $objectId === '') {
            return;
        }

        $check = \Http::withToken($accessToken)
            ->get("https://walletobjects.googleapis.com/walletobjects/v1/genericObject/{$objectId}");

        if ($check->status() === 404) {
            $create = \Http::withToken($accessToken)
                ->post(
                    'https://walletobjects.googleapis.com/walletobjects/v1/genericObject',
                    $genericObject
                );
            \Log::info('Google object created', ['status' => $create->status(), 'body' => $create->json()]);
            return;
        }

        $patch = \Http::withToken($accessToken)
            ->patch(
                "https://walletobjects.googleapis.com/walletobjects/v1/genericObject/{$objectId}",
                $genericObject
            );
        \Log::info('Google object patched', ['status' => $patch->status(), 'body' => $patch->json()]);
    }

    private function ensureClassExists(string $classId, string $accessToken): void
    {
        $check = \Http::withToken($accessToken)
            ->get("https://walletobjects.googleapis.com/walletobjects/v1/genericClass/{$classId}");

        \Log::info('Google class check', ['status' => $check->status()]);

        // Минимальный класс — БЕЗ logo и heroImage вообще
        $classData = [
            'id'           => $classId,
            'issuerName'   => 'KazGASA Alumni',
            'reviewStatus' => 'UNDER_REVIEW',
        ];

        if ($check->status() === 404) {
            $result = \Http::withToken($accessToken)
                ->post(
                    'https://walletobjects.googleapis.com/walletobjects/v1/genericClass',
                    $classData
                );
            \Log::info('Google class created', ['status' => $result->status(), 'body' => $result->json()]);
        } else {
            // PUT полностью перезаписывает класс — logo/heroImage исчезают
            $result = \Http::withToken($accessToken)
                ->put(
                    "https://walletobjects.googleapis.com/walletobjects/v1/genericClass/{$classId}",
                    $classData
                );
            \Log::info('Google class replaced via PUT', ['status' => $result->status(), 'body' => $result->json()]);
        }
    }



    private function resolvePublicImageUrl(string $localPath, string $publicName): string
    {
        $destDir  = public_path('images');
        $destPath = $destDir . DIRECTORY_SEPARATOR . $publicName;

        if (! is_dir($destDir)) {
            mkdir($destDir, 0775, true);
        }

        if (is_file($localPath) && (! is_file($destPath) || filemtime($localPath) > filemtime($destPath))) {
            copy($localPath, $destPath);
        }

        return url('/images/' . $publicName);
    }

    private function resolveAvatarPublicUrl(AlumniProfile $profile): ?string
    {
        $avatarUrl = $profile->avatar_url ?? null;
        if (! is_string($avatarUrl) || $avatarUrl === '') {
            return null;
        }

        $localAvatarPath = null;
        $parsed          = parse_url($avatarUrl);

        if (! empty($parsed['path']) && str_starts_with($parsed['path'], '/storage/')) {
            $relative        = substr($parsed['path'], strlen('/storage/'));
            $candidate       = storage_path('app/public/' . $relative);
            if (is_file($candidate)) {
                $localAvatarPath = $candidate;
            }
        } elseif (! str_starts_with($avatarUrl, 'http')) {
            $candidate = public_path(ltrim($avatarUrl, '/'));
            if (is_file($candidate)) {
                $localAvatarPath = $candidate;
            }
        } elseif (str_starts_with($avatarUrl, 'https://')) {
            return $avatarUrl;
        }

        if ($localAvatarPath && is_readable($localAvatarPath)) {
            $destDir  = public_path('images/avatars');
            if (! is_dir($destDir)) {
                mkdir($destDir, 0775, true);
            }
            $ext      = pathinfo($localAvatarPath, PATHINFO_EXTENSION) ?: 'jpg';
            $destName = ($profile->public_id ?? Str::random(8)) . '.' . $ext;
            $destPath = $destDir . DIRECTORY_SEPARATOR . $destName;
            copy($localAvatarPath, $destPath);

            return url('/images/avatars/' . $destName);
        }

        return null;
    }

    private function loadServiceAccount(): array
    {
        $path = Config::get('google-wallet.service_account_path');
        if (! is_file($path)) {
            throw new \RuntimeException("Файл сервисного аккаунта Google не найден: {$path}");
        }

        $json = file_get_contents($path);
        $data = json_decode($json ?? '', true);
        if (! is_array($data) || empty($data['client_email']) || empty($data['private_key'])) {
            throw new \RuntimeException('Некорректный json сервисного аккаунта Google.');
        }

        return $data;
    }

    private function encodeJwtRs256(array $payload, string $privateKeyPem): string
    {
        $header     = ['alg' => 'RS256', 'typ' => 'JWT'];
        $segments   = [];
        $segments[] = $this->base64UrlEncode(json_encode($header, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        $segments[] = $this->base64UrlEncode(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $signingInput = implode('.', $segments);
        $privateKey   = openssl_pkey_get_private($privateKeyPem);

        if (! $privateKey) {
            throw new \RuntimeException('Не удалось загрузить приватный ключ Google Wallet (RS256).');
        }

        $signature = '';
        $ok        = openssl_sign($signingInput, $signature, $privateKey, 'sha256WithRSAEncryption');
        openssl_pkey_free($privateKey);

        if (! $ok) {
            throw new \RuntimeException('Не удалось подписать JWT для Google Wallet.');
        }

        $segments[] = $this->base64UrlEncode($signature);

        return implode('.', $segments);
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function assertConfigured(): void
    {
        if (! Config::get('google-wallet.enabled')) {
            throw new \RuntimeException('Google Wallet отключён (GOOGLE_WALLET_ENABLED=false).');
        }

        foreach ([
                     'google-wallet.issuer_id',
                     'google-wallet.class_suffix',
                     'google-wallet.service_account_path',
                 ] as $key) {
            if (! Config::get($key)) {
                throw new \RuntimeException("Не настроено: {$key}");
            }
        }
    }
}
