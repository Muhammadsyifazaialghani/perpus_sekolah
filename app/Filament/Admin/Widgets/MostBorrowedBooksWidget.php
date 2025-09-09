<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Book;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MostBorrowedBooksWidget extends BaseWidget
{
    protected static ?string $heading = 'Buku Paling Sering Dipinjam';

    protected static ?string $description = 'Daftar 3 buku yang paling sering dipinjam berdasarkan data peminjaman yang disetujui.';

    protected static ?string $pollingInterval = '30s';

    protected static bool $isLazy = true;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Book::mostBorrowed(3))
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Sampul')
                    ->square()
                    ->size(50)
                    ->defaultImageUrl(url('/images/no-image.png')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Buku')
                    ->limit(30)
                    ->tooltip(function (string $state): ?string {
                        return strlen($state) > 30 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('author')
                    ->label('Penulis')
                    ->limit(25),

                Tables\Columns\TextColumn::make('borrowings_count')
                    ->label('Jumlah Peminjaman')
                    ->alignCenter()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 10 => 'success',
                        $state >= 5 => 'warning',
                        default => 'danger',
                    })
                    ->icon('heroicon-o-chart-bar'),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->color('primary')
                    ->icon('heroicon-o-tag'),
            ])
            ->paginated(false)
            ->defaultSort('borrowings_count', 'desc')
            ->actions([
                Tables\Actions\ActionGroup::make([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat Detail')
                    ->url(fn (Book $record): string => route('filament.admin.resources.books.edit', $record)),
                     Tables\Actions\Action::make('borrowings')
                        ->label('Lihat Peminjaman')
                        ->icon('heroicon-o-eye')
                        ->url(fn (Book $record): string => route('filament.admin.resources.borrowings.index', ['tableFilters[book_id][value]' => $record->id])),
                ]),
            ]);
    }

    public static function canView(): bool
    {
        return true;
    }
}