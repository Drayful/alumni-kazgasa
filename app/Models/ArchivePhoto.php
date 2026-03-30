<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivePhoto extends Model
{
    public const DECADES = ['80s', '90s', '00s', '10s', '20s'];

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
        return match ($key) {
            '80s' => '80‑е',
            '90s' => '90‑е',
            '00s' => '00‑е',
            '10s' => '10‑е',
            '20s' => '20‑е',
            default => $key,
        };
    }
}
