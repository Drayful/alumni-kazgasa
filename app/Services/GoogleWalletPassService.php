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

        $issuerId = Config::get('google-wallet.issuer_id');
        $classSuffix = Config::get('google-wallet.class_suffix', 'alumni_card');
        $classId = "{$issuerId}.{$classSuffix}";

        $objectSuffix = $profile->public_id ?: Str::uuid()->toString();
        $objectId = "{$issuerId}.{$classSuffix}_{$objectSuffix}";

        $serviceAccount = $this->loadServiceAccount();

        $genericObject = [
            'id' => $objectId,
            'classId' => $classId,
            'state' => 'ACTIVE',
            'heroImage' => [
                'sourceUri' => [
                    'uri' => $this->avatarUrlAbsolute($profile),
                ],
                'contentDescription' => [
                    'defaultValue' => [
                        'language' => 'ru-RU',
                        'value' => 'Фотография выпускника',
                    ],
                ],
            ],
            'logo' => [
                'sourceUri' => [
                    'uri' => url('/images/AV-logotip-2.svg'),
                ],
                'contentDescription' => [
                    'defaultValue' => [
                        'language' => 'ru-RU',
                        'value' => 'KazGASA Alumni',
                    ],
                ],
            ],
            'cardTitle' => [
                'defaultValue' => [
                    'language' => 'ru-RU',
                    'value' => 'Карта выпускника',
                ],
            ],
            'subheader' => [
                'defaultValue' => [
                    'language' => 'ru-RU',
                    'value' => $profile->school ?: 'KazGASA Alumni',
                ],
            ],
            'header' => [
                'defaultValue' => [
                    'language' => 'ru-RU',
                    'value' => trim($profile->full_name),
                ],
            ],
            'hexBackgroundColor' => Config::get('google-wallet.hex_background_color', '#8F161C'),
            'textModulesData' => array_values(array_filter([
                [
                    'header' => 'Год выпуска',
                    'body' => $profile->graduation_year ? (string) $profile->graduation_year : '—',
                ],
                $profile->specialty ? [
                    'header' => 'Специальность',
                    'body' => $profile->specialty,
                ] : null,
                [
                    'header' => 'Проверка карты',
                    'body' => route('alumni.card.show', ['publicId' => $profile->public_id]),
                ],
            ])),
        ];

        $jwtPayload = [
            'iss' => $serviceAccount['client_email'],
            'aud' => 'google',
            'typ' => 'savetowallet',
            'iat' => time(),
            'payload' => [
                'genericObjects' => [$genericObject],
            ],
        ];

        $jwt = $this->encodeJwtRs256($jwtPayload, $serviceAccount['private_key']);

        return 'https://pay.google.com/gp/v/save/' . $jwt;
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
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];

        $segments = [];
        $segments[] = $this->base64UrlEncode(json_encode($header, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        $segments[] = $this->base64UrlEncode(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $signingInput = implode('.', $segments);

        $privateKey = openssl_pkey_get_private($privateKeyPem);
        if (! $privateKey) {
            throw new \RuntimeException('Не удалось загрузить приватный ключ Google Wallet (RS256).');
        }

        $signature = '';
        $ok = openssl_sign($signingInput, $signature, $privateKey, 'sha256WithRSAEncryption');
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

    private function avatarUrlAbsolute(AlumniProfile $profile): string
    {
        $url = $profile->avatar_url ?? url('/images/user.png');
        // Если ссылка относительная — превратим в абсолютную
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        return url($url);
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

