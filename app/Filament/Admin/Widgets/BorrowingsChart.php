<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Borrowing;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class BorrowingsChart extends ChartWidget
{
    protected static ?string $heading = 'Peminjaman Buku Hari Ini';

    protected function getData(): array
    {
        $data = Borrowing::query()
            ->whereDate('created_at', Carbon::today())
            ->get()
            ->groupBy(function ($borrowing) {
                return $borrowing->created_at->format('H'); 
            })
            ->map(function ($group) {
                return $group->count();
            });

        $labels = [];
        $dataset = [];

        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $labels[] = $hour . ':00';
            $dataset[] = $data->get($hour, 0);
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
        return 'line';
    }
}
