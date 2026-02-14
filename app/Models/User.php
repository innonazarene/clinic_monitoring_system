<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_expires_at' => 'datetime',
        ];
    }

    /**
     * Generate a new two-factor authentication code.
     */
    public function generateTwoFactorCode(): void
    {
        $this->update([
            'two_factor_code' => str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);
    }

    /**
     * Reset the two-factor authentication code.
     */
    public function resetTwoFactorCode(): void
    {
        $this->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isNurse(): bool
    {
        return $this->role === 'nurse';
    }
}
