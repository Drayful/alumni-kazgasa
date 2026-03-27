<?php

namespace App\Support;

final class PhoneNormalizer
{
    /**
     * Приводит номер к виду из цифр (для KZ: 8… → 7…, 10 цифр с 7… → 77…).
     */
    public static function normalize(?string $input): ?string
    {
        if ($input === null || trim($input) === '') {
            return null;
        }

        $d = preg_replace('/\D/u', '', $input);
        if ($d === '') {
            return null;
        }

        if (strlen($d) === 11 && str_starts_with($d, '8')) {
            $d = '7'.substr($d, 1);
        }

        if (strlen($d) === 10 && str_starts_with($d, '7')) {
            $d = '7'.$d;
        }

        return $d;
    }
}
