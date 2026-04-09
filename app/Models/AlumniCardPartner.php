<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AlumniCardPartner extends Model
{
    use HasTranslations;

    protected $fillable = [
        'sort_order',
        'is_active',
        'name',
        'discount',
        'description',
        'logo_letter',
        'popup',
        'note',
        'url',
        'translations',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'translations' => 'array',
        ];
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
