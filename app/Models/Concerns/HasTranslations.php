<?php

namespace App\Models\Concerns;

trait HasTranslations
{
    /**
     * @param  list<string>  $translatedAttributes  Attribute names stored in translations JSON
     * @return array<string, array<string, string>>
     */
    public static function translationFieldDefaults(): array
    {
        return [];
    }

    public function localized(string $field, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $translations = $this->translations;
        if (! is_array($translations)) {
            $translations = [];
        }

        $try = array_unique(array_filter([$locale, 'ru', 'en', 'kk']));
        foreach ($try as $loc) {
            $v = data_get($translations, $loc.'.'.$field);
            if (is_string($v) && $v !== '') {
                return $v;
            }
        }

        $fallback = $this->getAttribute($field);

        return $fallback !== null ? (string) $fallback : '';
    }

    /**
     * @param  array<string, mixed>  $translations
     * @param  list<string>  $fields
     * @return array<string, mixed>
     */
    public static function normalizeTranslationsInput(array $translations, array $fields): array
    {
        $locales = ['kk', 'ru', 'en'];
        $out = [];
        foreach ($locales as $loc) {
            $out[$loc] = [];
            foreach ($fields as $f) {
                $val = $translations[$loc][$f] ?? null;
                $out[$loc][$f] = is_string($val) ? trim($val) : '';
            }
        }

        return $out;
    }
}
