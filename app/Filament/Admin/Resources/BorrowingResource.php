<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BorrowingResource\Pages;
use App\Filament\Admin\Resources\BorrowingResource\RelationManagers;
use App\Models\Borrowing;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;


class BorrowingResource extends Resource
{
    protected static ?string $model = Borrowing::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Peminjaman';
    protected static ?string $modelLabel = 'Peminjaman';
    protected static ?string $pluralModelLabel = 'Peminjaman';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::active()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }
    protected static ?string $navigationGroup = 'Manajemen Anggota';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Peminjaman')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'username')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Peminjam')
                            ->live()
                            ->afterStateUpdated(function (\Filament\Forms\Set $set, ?string $state) {
                                if ($state) {
                                    $user = \App\Models\User::find($state);
                                    if ($user) {
                                        $set('user_email', $user->email);
                                        $set('class_major', $user->class . ' ' . $user->major);
                                    }
                                } else {
                                    $set('user_email', null);
                                    $set('class_major', null);
                                }
                            }),
                        Forms\Components\Select::make('book_id')
                            ->relationship('book', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Judul Buku'),
                        Forms\Components\TextInput::make('user_email')
                            ->label('Email Peminjam')
                            ->email()
                            ->readOnly()
                            ->dehydrated(false)
                            ->helperText('Email akan terisi otomatis.'),
                        Forms\Components\TextInput::make('class_major')
                            ->label('Status Peminjam')
                            ->readOnly()
                            ->dehydrated(false)
                            ->helperText('Status peminjam akan terisi otomatis.'),
                        Forms\Components\DatePicker::make('borrowed_at')
                            ->label('Tanggal Pinjam')
                            ->required()
                            ->default(now())
                            ->disabled(),
                        Forms\Components\DatePicker::make('due_at')
                            ->label('Tanggal Kembali')
                            ->required()
                            ->default(now()->addDays(7))
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Menunggu Persetujuan',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'returned' => 'Dikembalikan',
                            ])
                            ->required()
                            ->default('approved')
                            ->label('Status'),
                        Forms\Components\TextInput::make('book_condition')
                            ->label('Kondisi Buku')
                            ->readOnly()
                            ->maxLength(255)
                            ->helperText('Kondisi buku saat dipinjam'),
                    ])->columns(2),

                Forms\Components\Section::make('Catatan')
                    ->schema([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Catatan Admin')
                            ->rows(3),
                        Forms\Components\Textarea::make('return_notes')
                            ->label('Catatan Pengembalian')
                            ->rows(3),
                    ])->columns(1),

                Forms\Components\Section::make('Pengembalian & Denda')
                    ->schema([
                        Forms\Components\DateTimePicker::make('returned_at')
                            ->label('Tanggal dan Waktu Dikembalikan')
                            ->readOnly(),
                        Forms\Components\TextInput::make('fine_amount')
                            ->label('Jumlah Denda (Rp)')
                            ->readOnly()
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(fn(?Borrowing $record) => $record && $record->fine_paid),
                        Forms\Components\Toggle::make('fine_paid')
                            ->label('Denda Sudah Dibayar')
                            ->disabled(fn(?Borrowing $record) => !$record || $record->fine_amount <= 0),
                        Forms\Components\DateTimePicker::make('fine_paid_at')
                            ->label('Tanggal Pembayaran Denda')
                            ->disabled(),
                    ])
                    ->columns(2)
                    ->visible(fn(?Borrowing $record) => $record && ($record->status === 'returned' || $record->is_overdue)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Nama Peminjam')
                    ->searchable(),
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Judul Buku')
                    ->searchable(),
                Tables\Columns\TextColumn::make('borrowed_at')
                    ->label('Tgl. Pinjam')
                    ->date('d M Y'),
                Tables\Columns\TextColumn::make('due_at')
                    ->label('Tgl. Kembali')
                    ->date('d M Y'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'returned' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'returned' => 'Dikembalikan',
                        default => 'Tidak Diketahui',
                    }),
                Tables\Columns\TextColumn::make('fine_amount')
                    ->label('Denda')
                    ->money('IDR')
                    ->color('danger'),
                Tables\Columns\IconColumn::make('fine_paid')
                    ->label('Denda Lunas')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu Persetujuan',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'returned' => 'Dikembalikan',
                    ])
                    ->label('Status'),
                Tables\Filters\Filter::make('overdue')
                    ->label('Jatuh Tempo')
                    ->query(fn(Builder $query): Builder => $query->where('due_at', '<', now())->where('status', 'approved')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('approve')
                        ->label('Setujui')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(fn(Borrowing $record) => $record->update(['status' => 'approved']))
                        ->visible(fn(Borrowing $record) => $record->status === 'pending'),
                    Tables\Actions\Action::make('reject')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->action(function (Borrowing $record, array $data) {
                            $record->update([
                                'status' => 'rejected',
                                'rejected_at' => now(),
                                'admin_notes' => $data['admin_notes'] ?? null,
                            ]);

                            $book = $record->book;
                            $book->available = true;
                            $book->save();
                        })
                        ->visible(fn(Borrowing $record) => $record->status === 'pending')
                        ->form([
                            Forms\Components\Textarea::make('admin_notes')
                                ->label('Alasan Penolakan')
                                ->required()
                                ->rows(3),
                        ])
                        ->requiresConfirmation(),
                    Tables\Actions\Action::make('return_book')
                        ->label('Kembalikan Buku')
                        ->icon('heroicon-o-arrow-left-circle')
                        ->color('primary')
                        ->action(function (Borrowing $record, array $data) {
                            $record->update([
                                'status' => 'returned',
                                'returned_at' => now(),
                                'return_notes' => $data['return_notes'] ?? null,
                                'book_condition' => $data['book_condition'] ?? null,
                            ]);

                            $book = $record->book;
                            if ($data['book_condition'] === 'hilang') {
                                $book->available = false;
                            } else {
                                $book->available = true;
                            }
                            $book->save();

                            $record->updateFine();
                        })
                        ->visible(fn(Borrowing $record) => $record->status === 'approved' && !$record->returned_at)
                        ->form([
                            Forms\Components\Textarea::make('return_notes')
                                ->label('Catatan Pengembalian')
                                ->rows(3)
                                ->helperText('Catatan kondisi buku saat dikembalikan'),

                            Forms\Components\Select::make('book_condition')
                                ->label('Kondisi Buku Saat Dikembalikan')
                                ->options([
                                    'baik' => 'Baik',
                                    'rusak' => 'Rusak',
                                    'hilang' => 'Hilang',
                                ])
                                ->native(false)
                                ->required()
                                ->helperText('Pilih kondisi buku saat dikembalikan.'),
                        ])
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Pengembalian Buku')
                        ->modalSubmitActionLabel('Ya, Kembalikan'),
                    Tables\Actions\Action::make('pay_fine')
                        ->label('Bayar Denda')
                        ->icon('heroicon-o-currency-dollar')
                        ->color('warning')
                        ->action(function (Borrowing $record) {
                            $record->markFineAsPaid();
                        })
                        ->modalDescription(fn(?Borrowing $record) => 'Apakah Anda yakin denda sebesar Rp ' . number_format($record->fine_amount, 0, ',', '.') . ' sudah dibayar?')
                        ->visible(fn(?Borrowing $record) => $record->hasUnpaidFine())
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Pembayaran Denda')
                        ->modalSubmitActionLabel('Ya, Sudah Dibayar'),
                ]),
            ])
            ->bulkActions([]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Peminjaman')
                    ->schema([
                        TextEntry::make('user.username')
                            ->label('Peminjam'),

                        TextEntry::make('book.title')
                            ->label('Judul Buku'),

                        TextEntry::make('user.email')
                            ->label('Email Peminjam'),

                        TextEntry::make('class_major')
                            ->label('Status Peminjam'),

                        TextEntry::make('borrowed_at')
                            ->label('Tanggal Pinjam')
                            ->date('d/m/Y'),

                        TextEntry::make('due_at')
                            ->label('Tanggal Kembali')
                            ->date('d/m/Y'),

                        TextEntry::make('status')
                            ->label('Status Peminjaman'),

                        TextEntry::make('returned_at')
                            ->label('Tanggal Dikembalikan')
                            ->date('d/m/Y H:i')
                            ->visible(fn(?Borrowing $record) => $record && $record->returned_at),
                    ])->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBorrowings::route('/'),
            'create' => Pages\CreateBorrowing::route('/create'),
            'edit' => Pages\EditBorrowing::route('/{record}/edit'),
        ];
    }
}
