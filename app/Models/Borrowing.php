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

    public function getClassMajorAttribute()
    {
        if ($this->user) {
            return $this->user->class_major;
        }
        return null;
    }

    public function calculateFine(): float
    {
        if ($this->returned_at && $this->due_at) {
            $dueDate = Carbon::parse($this->due_at);
            $returnDate = Carbon::parse($this->returned_at);
            
            if ($returnDate->gt($dueDate)) {
                $daysLate = $dueDate->diffInDays($returnDate);
                return $daysLate * 2000;
            }
        }
        
        return 0;
    }

    public function updateFine(): void
    {
        $this->fine_amount = $this->calculateFine();
        $this->save();
    }

    public function markFineAsPaid(): void
    {
        $this->fine_paid = true;
        $this->fine_paid_at = now();
        $this->save();
    }

    public function hasUnpaidFine(): bool
    {
        return $this->fine_amount > 0 && !$this->fine_paid;
    }

    public function getDaysLateAttribute(): int
    {
        if ($this->returned_at && $this->due_at) {
            $dueDate = Carbon::parse($this->due_at);
            $returnDate = Carbon::parse($this->returned_at);
            
            return max(0, $dueDate->diffInDays($returnDate));
        }
        
        return 0;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'approved')
                    ->whereNull('returned_at');
    }

    public function getDaysRemainingAttribute(): int
    {
        if ($this->due_at && !$this->returned_at) {
            $dueDate = Carbon::parse($this->due_at);
            $today = Carbon::today();
            
            return max(0, $today->diffInDays($dueDate, false));
        }
        
        return 0;
    }

    public function getIsOverdueAttribute(): bool
    {
        if ($this->due_at && !$this->returned_at) {
            $dueDate = Carbon::parse($this->due_at);
            $today = Carbon::today();
            
            return $today->gt($dueDate);
        }
        
        return false;
    }

    public function scopeDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->whereDate('borrowed_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('borrowed_at', '<=', $endDate);
        }
        
        return $query;
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    public static function getBorrowingCount($startDate = null, $endDate = null): int
    {
        return self::approved()
            ->dateRange($startDate, $endDate)
            ->count();
    }

    public static function getReturnCount($startDate = null, $endDate = null): int
    {
        return self::returned()
            ->dateRange($startDate, $endDate)
            ->count();
    }

    public static function getTotalFines($startDate = null, $endDate = null): float
    {
        return self::returned()
            ->dateRange($startDate, $endDate)
            ->sum('fine_amount');
    }
}
