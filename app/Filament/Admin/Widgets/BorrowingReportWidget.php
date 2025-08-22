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
            Stat::make('Total Peminjaman Hari Ini', Borrowing::getBorrowingCount($today, $today))
                ->description('Peminjaman hari ini')
                ->descriptionIcon('heroicon-m-arrow-up-circle')
                ->color('success'),

            Stat::make('Total Peminjaman Bulan Ini', Borrowing::getBorrowingCount($startOfMonth, $today))
                ->description('Peminjaman bulan ini')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

            Stat::make('Total Peminjaman Tahun Ini', Borrowing::getBorrowingCount($startOfYear, $today))
                ->description('Peminjaman tahun ini')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),

            Stat::make('Total Pengembalian Bulan Ini', Borrowing::getReturnCount($startOfMonth, $today))
                ->description('Buku dikembalikan')
                ->descriptionIcon('heroicon-m-arrow-down-circle')
                ->color('success'),

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
