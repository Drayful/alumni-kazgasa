<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AlumniCardPartner extends Model
{
    protected $fillable = [
        'sort_order',
        'is_active',
        'name',
        'discount',
        'description',
        'logo_letter',
        'popup',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
