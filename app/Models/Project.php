<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasTranslations;

    protected $fillable = [
        'sort_order', 'is_active', 'icon',
        'title', 'tags', 'button_text',
        'short', 'how_it_works', 'what_you_get',
        'translations',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true)->orderBy('sort_order');
    }
}

