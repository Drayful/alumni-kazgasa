<?php

namespace App\Support;

/**
 * Единый формат хранения мобильных номеров (KZ/RU): 11 цифр, начинается с 7.
 * Примеры: +7 700 123 45 67 → 77001234567; 8 700 … → 7700…
 */
final class PhoneNormalizer
{
    /**
     * Приводит номер к каноническому виду (только цифры) или null, если пусто.
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

        if (strlen($d) === 10 && str_starts_with($d, '8')) {
            $d = '7'.substr($d, 1);
        }

        if (strlen($d) === 10 && str_starts_with($d, '7')) {
            $d = '7'.$d;
        }

        return $d;
    }

    /**
     * Полный мобильный номер KZ в формате 7XXXXXXXXXX (11 цифр).
     */
    public static function isValidKzMobile(?string $normalized): bool
    {
        if ($normalized === null || $normalized === '') {
            return false;
        }

        return (bool) preg_match('/^7\d{10}$/', $normalized);
    }
}
