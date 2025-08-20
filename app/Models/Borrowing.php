<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_at',
        'returned_at',
        'status',
        'admin_notes',
        'return_notes',
        'book_condition',
        'fine_amount',
        'fine_paid',
        'fine_paid_at',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
        'fine_paid_at' => 'datetime',
        'fine_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Hitung denda keterlambatan
     * Default: Rp 2.000 per hari keterlambatan
     */
    public function calculateFine(): float
    {
        if ($this->returned_at && $this->due_at) {
            $dueDate = Carbon::parse($this->due_at);
            $returnDate = Carbon::parse($this->returned_at);
            
            if ($returnDate->gt($dueDate)) {
                $daysLate = $dueDate->diffInDays($returnDate);
                return $daysLate * 2000; // Rp 2.000 per hari
            }
        }
        
        return 0;
    }

    /**
     * Update denda berdasarkan perhitungan
     */
    public function updateFine(): void
    {
        $this->fine_amount = $this->calculateFine();
        $this->save();
    }

    /**
     * Tandai denda sudah dibayar
     */
    public function markFineAsPaid(): void
    {
        $this->fine_paid = true;
        $this->fine_paid_at = now();
        $this->save();
    }

    /**
     * Cek apakah ada denda yang belum dibayar
     */
    public function hasUnpaidFine(): bool
    {
        return $this->fine_amount > 0 && !$this->fine_paid;
    }

    /**
     * Get hari keterlambatan
     */
    public function getDaysLateAttribute(): int
    {
        if ($this->returned_at && $this->due_at) {
            $dueDate = Carbon::parse($this->due_at);
            $returnDate = Carbon::parse($this->returned_at);
            
            return max(0, $dueDate->diffInDays($returnDate));
        }
        
        return 0;
    }
}
