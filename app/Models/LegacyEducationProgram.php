<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LegacyEducationProgram extends Model
{
    protected $fillable = [
        'graduation_year',
        'specialty_code',
        'name',
        'group_of_programs',
        'sort_order',
    ];

    protected $casts = [
        'graduation_year' => 'integer',
        'sort_order' => 'integer',
    ];

    public function alumniProfiles(): HasMany
    {
        return $this->hasMany(AlumniProfile::class);
    }
}
