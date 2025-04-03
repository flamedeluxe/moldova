<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Panel;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $casts = [
        'city' => 'array',
    ];

    protected $appends = [
        'card_number'
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'manager']) && $this->active;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'blocked',
        'city',
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

    public function isAdmin(): bool
    {
        return $this->role === 'admin'; // Предполагаем, что у пользователя есть поле role
    }

    public static function getRoleOptions(): array
    {
        return [
            'admin' => 'Админ',
            'manager' => 'Менеджер',
            'user' => 'Пользователь',
        ];
    }

    protected function roleLabel(): Attribute
    {
        return Attribute::get(fn () => self::getRoleOptions()[$this->role] ?? 'Неизвестно');
    }

    public function getCardNumberAttribute(): string
    {
        return preg_replace("/(\d{4})(\d{4})\d{5}/", "$1 $2 *****", $this->card);
    }
}
