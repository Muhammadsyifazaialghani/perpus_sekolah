<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Borrowing;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class MonthlyBorrowingsChart extends ChartWidget
{
    protected static ?string $heading = 'Peminjaman Buku Tahun Ini';

    protected function getData(): array
    {
        $data = Borrowing::query()
            ->whereYear('created_at', Carbon::now()->year)
            ->get()
            ->groupBy(function ($borrowing) {
                return $borrowing->created_at->format('m'); // Group by month
            })
            ->map(function ($group) {
                return $group->count();
            });

        $labels = [];
        $dataset = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $labels[] = Carbon::create()->month($i)->format('F');
            $dataset[] = $data->get($month, 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Peminjaman',
                    'data' => $dataset,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
