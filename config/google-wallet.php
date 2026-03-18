<?php

return [
    /*
     * Google Wallet (Google Pay Passes) настройки.
     *
     * Значения берутся из Google Pay & Wallet Console:
     * - issuer_id: идентификатор эмитента (например "3388000000XXXXXXX")
     * - class_suffix: суффикс класса (например "alumni_card")
     *
     * Сервисный аккаунт:
     * - json ключ сохранён по пути GOOGLE_WALLET_SERVICE_ACCOUNT_PATH
     */

    'enabled' => env('GOOGLE_WALLET_ENABLED', false),

    'issuer_id' => env('GOOGLE_WALLET_ISSUER_ID'),
    'class_suffix' => env('GOOGLE_WALLET_CLASS_SUFFIX', 'alumni_card'),

    'service_account_path' => env('GOOGLE_WALLET_SERVICE_ACCOUNT_PATH', base_path('certs/google-service-account.json')),

    // Базовый цвет карты (в стиле KazGASA Alumni)
    'hex_background_color' => env('GOOGLE_WALLET_BACKGROUND_COLOR', '#8F161C'),
];

