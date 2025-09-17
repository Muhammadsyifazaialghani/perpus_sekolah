<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements HasName
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'class_major', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function scopeMostActive($query, $limit = 10, $startDate = null, $endDate = null)
    {
        return $query->withCount([
            'borrowings' => function ($query) use ($startDate, $endDate) {
                $query->approved();
                if ($startDate) {
                    $query->whereDate('borrowed_at', '>=', $startDate);
                }
                if ($endDate) {
                    $query->whereDate('borrowed_at', '<=', $endDate);
                }
            }
        ])
            ->orderBy('borrowings_count', 'desc')
            ->limit($limit);
    }

    public static function getMostActiveUsers($limit = 10, $startDate = null, $endDate = null)
    {
        return self::mostActive($limit, $startDate, $endDate)->get();
    }

    public function canAccessPanel(Panel $panel): bool

    {

        return $this->role === 'admin';
    }

    public function getFilamentName(): string
    {
        return $this->username ?? $this->email ?? 'User';
    }
}
