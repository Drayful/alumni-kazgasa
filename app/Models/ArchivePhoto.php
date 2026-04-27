<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivePhoto extends Model
{
    public const DECADES = ['apr15', '80s', '90s', '00s', '10s', '20s'];

    /** Максимум превью на главной странице (на одно десятилетие). */
    public const HOME_PREVIEW_LIMIT = 6;

    protected $fillable = [
        'user_id',
        'decade',
        'path',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function decadeLabel(string $key): string
    {
        $translated = __('site.archive_decades.'.$key);
        if (is_string($translated) && $translated !== 'site.archive_decades.'.$key) {
            return $translated;
        }

        return $key;
    }
}
