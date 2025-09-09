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
        ];
    }

    public static function canView(): bool
    {
        return true;
    }
}
