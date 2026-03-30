<?php

namespace App\Models;

use App\Support\PhoneNormalizer;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
        ];
    }

    public function alumniProfile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AlumniProfile::class);
    }

    public function archivePhotos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ArchivePhoto::class);
    }

    public function setPhoneAttribute(?string $value): void
    {
        if ($value === null || trim($value) === '') {
            $this->attributes['phone'] = null;

            return;
        }

        $this->attributes['phone'] = PhoneNormalizer::normalize($value);
    }
}
