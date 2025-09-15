<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class BorrowingReportWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();
        $activeBorrowings = Borrowing::active()->count();
        $returnedBorrowings = Borrowing::returned()->count();
        $overdueBorrowings = Borrowing::active()->where('due_at', '<', Carbon::now())->count();

        return [
             Stat::make('Total Pengguna', User::count())
                ->description('Jumlah semua pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Total Buku', Book::count())
                ->description('Jumlah semua buku di perpustakaan')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary'),

            Stat::make('Total Denda Bulan Ini', 'Rp ' . number_format(Borrowing::getTotalFines($startOfMonth, $today), 0, ',', '.'))
                ->description('Denda terkumpul')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
             Stat::make('Buku Sedang Dipinjam', $activeBorrowings)
                ->description('Jumlah buku yang sedang dipinjam')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary'),

                
            Stat::make('Buku Belum Dikembalikan (Terlambat)', $overdueBorrowings)
                ->description('Jumlah buku yang belum dikembalikan dan terlambat')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
                Stat::make('Buku Sudah Dikembalikan', $returnedBorrowings)
                    ->description('Jumlah buku yang sudah dikembalikan')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),
            ];
    }

    public static function canView(): bool
    {
        return true;
    }
}
