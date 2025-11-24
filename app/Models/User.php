<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
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
        ];
    }

    /**
     * Get the user's full name
     */
    public function getNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? '')) ?: 'Utilisateur';
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $name = $this->name;
        return Str::of($name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Check if user has a separate shipping address
     */
    public function hasShippingAddress(): bool
    {
        return !empty($this->shipping_address);
    }

    /**
     * Get the full billing address
     */
    public function getFullAddressAttribute(): string
    {
        return trim(
            implode(', ', array_filter([
                $this->address,
                $this->city,
                $this->postal_code,
                $this->country,
            ]))
        );
    }

    /**
     * Get the full shipping address
     */
    public function getFullShippingAddressAttribute(): string
    {
        if (!$this->hasShippingAddress()) {
            return $this->full_address;
        }

        return trim(
            implode(', ', array_filter([
                $this->shipping_address,
                $this->shipping_city,
                $this->shipping_postal_code,
                $this->shipping_country,
            ]))
        );
    }

    public function canAccessPanel(Panel $panel): bool
    {
       return true;
    }
}
