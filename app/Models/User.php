<?php

namespace App\Models;

use Filament\Models\Contracts\HasName; // Add this import
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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

    public function canAccessFilament(): bool
    {
        // Contoh: Hanya user dengan role 'admin' yang bisa mengakses Filament
        // Pastikan user yang Anda gunakan untuk login memiliki role='admin' di database
        return $this->role === 'admin';

        // Jika semua user boleh mengakses admin panel (tidak disarankan untuk produksi):
        // return true;
    }

    // Add this method to satisfy HasName interface and avoid null user name
    public function getFilamentName(): string
    {
        // Return username or email as fallback user name
        return $this->username ?? $this->email ?? 'User';
    }
}
