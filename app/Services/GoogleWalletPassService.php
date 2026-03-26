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
        $this->ensureClassExists($classId, $issuerId, $serviceAccount);
        $publicUrl = url(route('alumni.card.show', ['publicId' => $profile->public_id], false));
        $status = (string) ($profile->status ?: 'Connect');

// Secondary fields (школа + год выпуска)
        $textModules = array_values(array_filter([
            $profile->school ? [
                'id'     => 'school',
                'header' => 'Школа/Факультет',
                'body'   => $profile->school,
            ] : null,
            $profile->graduation_year ? [
                'id'     => 'year',
                'header' => 'Год выпуска',
                'body'   => (string) $profile->graduation_year,
            ] : null,
            $profile->membership_type ? [
                'id'     => 'type',
                'header' => 'Тип',
                'body'   => $profile->membership_type === 'paid' ? 'Платный' : 'Бесплатный',
            ] : null,
            [
                'id'     => 'status',
                'header' => 'Статус',
                'body'   => $status,
            ],
        ]));

// Back fields (ИИН, срок, ссылка проверки)
        $linksModule = [];
        $linksModule['uris'][] = [
            'uri'         => $publicUrl,
            'description' => 'Проверка карты',
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

        $genericObject = [
            'id'      => $objectId,
            'classId' => $classId,
            'state'   => 'ACTIVE',

            // Основное — аналог primaryFields
            'cardTitle' => [
                'defaultValue' => ['language' => 'ru-RU', 'value' => 'Карта выпускника'],
            ],
            'header' => [
                'defaultValue' => ['language' => 'ru-RU', 'value' => trim($profile->full_name) ?: 'Alumni'],
            ],
            'subheader' => [
                'defaultValue' => ['language' => 'ru-RU', 'value' => 'Выпускник'],
            ],

            // Secondary + auxiliary — аналог secondaryFields/auxiliaryFields
            'textModulesData' => $textModules,

            // Back fields — ИИН, срок действия
            'infoModuleData' => [
                'labelValueRows' => array_map(fn($f) => [
                    'columns' => [[
                        'label' => $f['header'],
                        'value' => ['defaultValue' => ['language' => 'ru-RU', 'value' => $f['body']]],
                    ]],
                ], $infoModule),
                'showLastUpdateTime' => false,
            ],

            // Ссылка проверки карты
            'linksModuleData' => $linksModule,

            // QR-код — аналог barcodes
            'barcode' => [
                'type'          => 'QR_CODE',
                'value'         => $publicUrl,
                'alternateText' => $profile->public_id,
            ],

            // Цвета — аналог foreground/background/labelColor
            'hexBackgroundColor' => '#8F161C',
            'hexForegroundColor' => '#FFFFFF',
            'hexLabelColor' => '#E5C68D',
        ];

        // Фото выпускника (если есть) — как hero/image module.
        $avatar = $this->avatarUrlAbsolute($profile);
        if (is_string($avatar) && $avatar !== '') {
            $genericObject['heroImage'] = [
                'sourceUri' => [
                    'uri' => $avatar,
                ],
                'contentDescription' => [
                    'defaultValue' => [
                        'language' => 'ru-RU',
                        'value' => trim($profile->full_name) ?: 'Фото выпускника',
                    ],
                ],
            ];
        }



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


    private function ensureClassExists(string $classId, string $issuerId, array $serviceAccount): void
    {
        $jwt = $this->encodeJwtRs256([
            'iss' => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/wallet_object.issuer',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => time(),
            'exp' => time() + 3600,
        ], $serviceAccount['private_key']);

        $tokenResponse = \Http::post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        \Log::info('Google token response', $tokenResponse->json()); // ← лог

        $accessToken = $tokenResponse->json('access_token');

        $check = \Http::withToken($accessToken)
            ->get("https://walletobjects.googleapis.com/walletobjects/v1/genericClass/{$classId}");

        \Log::info('Google class check', ['status' => $check->status(), 'body' => $check->json()]); // ← лог

        if ($check->status() === 404) {
            $create = \Http::withToken($accessToken)
                ->post('https://walletobjects.googleapis.com/walletobjects/v1/genericClass', [
                    'id' => $classId,
                    'issuerName' => 'KazGASA Alumni',
                    'reviewStatus' => 'UNDER_REVIEW',
                ]);

            \Log::info('Google class create', ['status' => $create->status(), 'body' => $create->json()]); // ← лог
        }
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

