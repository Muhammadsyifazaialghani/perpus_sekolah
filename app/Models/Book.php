<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'available',
        'description',
        'isbn',
        'published_year',
        'category_id',
        'year_published',
        'publisher',
        'location',
        'cover_image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi dengan peminjaman
     */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Scope untuk mendapatkan buku paling sering dipinjam
     */
    // File: app/Models/Book.php

    public function scopeMostBorrowed($query, $limit = 10, $startDate = null, $endDate = null)
    {
        return $query->withCount([
            'borrowings' => function ($query) use ($startDate, $endDate) {
                // Hapus baris "$query->approved();" dari sini.
                // Anda bisa membiarkannya kosong jika tidak ada filter tanggal,
                // atau hanya sisakan filter tanggal jika diperlukan.

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
     * Mendapatkan buku paling populer
     */
    public static function getMostBorrowedBooks($limit = 10, $startDate = null, $endDate = null)
    {
        return self::mostBorrowed($limit, $startDate, $endDate)->get();
    }
}
