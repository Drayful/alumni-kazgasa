<?php

namespace App\Models;

use App\Services\PortalPhotoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlumniProfile extends Model
{
    protected $fillable = [
        'user_id',
        'iin',
        'portal_persons_id',
        'first_name',
        'last_name',
        'middle_name',
        'photo',
        'photo_path',
        'school',
        'graduation_year',
        'specialty',
        'degree',
        'study_group',
        'study_group_name',
        'study_form',
        'study_form_name',
        'institut_id',
        'faculty_name',
        'edu_op',
        'edu_op_name',
        'edu_program',
        'edu_program_name',
        'study_level_name',
        'status',
        'public_id',
        'membership_type',
        'membership_expiry_date',
        'verification_status',
        'current_company',
        'position',
        'bio',
    ];

    protected $casts = [
        'graduation_year' => 'integer',
        'membership_expiry_date' => 'date',
        'study_group' => 'integer',
        'study_form' => 'integer',
        'institut_id' => 'integer',
        'edu_op' => 'integer',
        'edu_program' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->last_name} {$this->first_name} {$this->middle_name}");
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->photo_path && Storage::disk('public')->exists($this->photo_path)) {
            return Storage::url($this->photo_path);
        }

        if ($this->iin) {
            $service = app(PortalPhotoService::class);
            $photo = $service->getPhotoForAlumni($this->iin);

            return (string) ($photo['value'] ?? asset('images/user.png'));
        }

        return asset('images/user.png');
    }

    public static function generatePublicId(): string
    {
        do {
            $id = strtoupper(Str::random(12));
        } while (self::where('public_id', $id)->exists());

        return $id;
    }
}
