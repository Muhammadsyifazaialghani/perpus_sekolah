<?php

namespace App\Models;

use Filament\Models\Contracts\HasName; // Add this import
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;

use Filament\Panel;



class User extends Authenticatable implements HasName // Implement HasName interface
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
        'class_major', // tambahkan ini
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

    /**
     * Relasi dengan peminjaman
     */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Scope untuk mendapatkan anggota teraktif
     */
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

    /**
     * Mendapatkan anggota teraktif
     */
    public static function getMostActiveUsers($limit = 10, $startDate = null, $endDate = null)
    {
        return self::mostActive($limit, $startDate, $endDate)->get();
    }

    public function canAccessPanel(Panel $panel): bool

    {

        // Logika ini sudah benar!

        // Hanya user dengan role 'admin' yang bisa mengakses panel Filament.

        return $this->role === 'admin';
    }




    // Add this method to satisfy HasName interface and avoid null user name
    public function getFilamentName(): string
    {
        // Return username or email as fallback user name
        return $this->username ?? $this->email ?? 'User';
    }
}
