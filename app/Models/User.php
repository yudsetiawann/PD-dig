<?php

namespace App\Models;

use Filament\Panel;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
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
        'username',
        'role',
        'email',
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
        ];
    }

    // Relasi ke Event (jika user membuat event)
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // Relasi ke Order (jika user membeli tiket)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper Cek Role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isScanner(): bool
    {
        return $this->role === 'scanner';
    }

    // Filament Panel Access
    public function canAccessPanel(Panel $panel): bool
    {
        // Izinkan admin atau scanner masuk ke panel
        return $this->isAdmin() || $this->isScanner();
    }


    /**
     * Mendapatkan nama panggilan yang disesuaikan.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $words = explode(' ', $attributes['name']);
                $displayName = $words[0] ?? ''; // Default-nya kata pertama

                foreach ($words as $word) {
                    // Cari kata pertama yang kurang dari 7 huruf
                    if (strlen($word) < 7) {
                        $displayName = $word;
                        break;
                    }
                }

                return $displayName;
            }
        );
    }
}
