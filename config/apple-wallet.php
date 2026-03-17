<?php

return [
    /*
     * Apple Wallet (.pkpass) settings.
     *
     * Required values come from your Apple Developer account:
     * - team_identifier: your Team ID (e.g. "ABCDE12345")
     * - pass_type_identifier: Pass Type ID (e.g. "pass.com.example.alumni")
     *
     * Certificates/keys are expected to exist at these paths (already added by you):
     *   certs/wwdr.pem
     *   certs/signerCert.pem
     *   certs/signerKey.pem
     */
    'enabled' => env('APPLE_WALLET_ENABLED', false),

    'organization_name' => env('APPLE_WALLET_ORG_NAME', 'KazGASA Alumni'),
    'description' => env('APPLE_WALLET_DESCRIPTION', 'Карта выпускника KazGASA Alumni'),

    'team_identifier' => env('APPLE_WALLET_TEAM_ID'),
    'pass_type_identifier' => env('APPLE_WALLET_PASS_TYPE_ID'),

    'cert_wwdr_path' => env('APPLE_WALLET_WWDR_PATH', base_path('certs/wwdr.pem')),
    'cert_signer_path' => env('APPLE_WALLET_SIGNER_CERT_PATH', base_path('certs/signerCert.pem')),
    'key_signer_path' => env('APPLE_WALLET_SIGNER_KEY_PATH', base_path('certs/signerKey.pem')),
    'key_signer_password' => env('APPLE_WALLET_SIGNER_KEY_PASSWORD'),

    /*
     * Images included into the pass bundle.
     * Apple requires at least icon.png (and icon@2x.png on Retina devices).
     */
    'icon_path' => env('APPLE_WALLET_ICON_PATH', public_path('images/alumni-card-bg.png')),
    'logo_path' => env('APPLE_WALLET_LOGO_PATH', public_path('images/alumni-card-fon.png')),
];

