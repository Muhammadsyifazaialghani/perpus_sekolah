<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrowing;
use Carbon\Carbon;

class CalculateFinesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fines:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghitung denda otomatis untuk peminjaman yang terlambat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai perhitungan denda otomatis...');

        // Hitung denda untuk buku yang sudah dikembalikan terlambat
        $returnedLate = Borrowing::where('status', 'returned')
            ->whereNull('fine_paid_at')
            ->where('fine_amount', 0)
            ->get();

        $returnedCount = 0;
        foreach ($returnedLate as $borrowing) {
            $fine = $borrowing->calculateFine();
            if ($fine > 0) {
                $borrowing->fine_amount = $fine;
                $borrowing->save();
                $returnedCount++;
            }
        }

        $this->info("Denda dihitung untuk {$returnedCount} buku yang sudah dikembalikan terlambat.");

        // Hitung denda untuk peminjaman aktif yang sudah lewat jatuh tempo
        $overdueBorrowings = Borrowing::where('status', 'approved')
            ->whereNull('returned_at')
            ->where('due_at', '<', now())
            ->get();

        $overdueCount = 0;
        foreach ($overdueBorrowings as $borrowing) {
            $daysLate = Carbon::parse($borrowing->due_at)->diffInDays(now());
            $fine = $daysLate * 2000; // Rp 2.000 per hari
            
            if ($fine > 0 && $borrowing->fine_amount != $fine) {
                $borrowing->fine_amount = $fine;
                $borrowing->save();
                $overdueCount++;
            }
        }

        $this->info("Denda dihitung untuk {$overdueCount} peminjaman aktif yang terlambat.");

        // Kirim notifikasi untuk denda yang belum dibayar
        $unpaidFines = Borrowing::where('fine_amount', '>', 0)
            ->where('fine_paid', false)
            ->count();

        $this->info("Total {$unpaidFines} denda yang belum dibayar.");

        $this->info('Perhitungan denda selesai!');
        
        return Command::SUCCESS;
    }
}
