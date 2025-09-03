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
                Forms\Components\Section::make('Informasi Peminjam')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'username')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Peminjam Terdaftar')
                            ->helperText('Pilih dari daftar user yang sudah terdaftar')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $user = \App\Models\User::find($state);
                                    if ($user) {
                                        $set('user_email', $user->email);
                                        $set('class_major', $user->class_major); // Mengisi kelas/jurusan
                                    }
                                } else {
                                    $set('user_email', null);
                                    $set('class_major', null);
                                }
                            }),

                        Forms\Components\TextInput::make('user_email')
                            ->label('Email Peminjam')
                            ->email()
                            ->readOnly()
                            ->dehydrated(false)
                            ->helperText('Email akan terisi otomatis.'),

                        Forms\Components\TextInput::make('class_major')
                            ->label('Kelas / Jurusan')
                            ->readOnly()
                            ->dehydrated(false)
                            ->helperText('Kelas/Jurusan akan terisi otomatis.'),
                    ])
                    ->columns(3), // Diubah ke 3 kolom agar rapi

                Forms\Components\Section::make('Informasi Buku')
                    ->schema([
                        Forms\Components\Select::make('book_id')
                            ->relationship('book', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Judul Buku')
                            ->helperText('Pilih buku yang akan dipinjam'),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(10)
                            ->default(1)
                            ->required()
                            ->helperText('Jumlah buku yang dipinjam'),

                        Forms\Components\TextInput::make('book_condition')
                            ->label('Kondisi Buku')
                            ->maxLength(255)
                            ->helperText('Kondisi buku saat dipinjam'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Jadwal Peminjaman')
                    ->schema([
                        Forms\Components\DatePicker::make('borrowed_at')
                            ->label('Tanggal Pinjam')
                            ->required()
                            ->default(now())
                            ->helperText('Tanggal mulai peminjaman'),

                        Forms\Components\DatePicker::make('due_at')
                            ->label('Tanggal Kembali')
                            ->required()
                            ->default(now()->addDays(7))
                            ->helperText('Tanggal harus dikembalikan'),

                        Forms\Components\DatePicker::make('returned_at')
                            ->label('Tanggal Dikembalikan')
                            ->helperText('Kosongkan jika belum dikembalikan'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Status & Catatan')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Menunggu Persetujuan',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'returned' => 'Dikembalikan',
                            ])
                            ->required()
                            ->default('approved')
                            ->label('Status Peminjaman'),

                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Catatan Admin')
                            ->rows(3)
                            ->helperText('Catatan tambahan dari admin'),

                        Forms\Components\Textarea::make('return_notes')
                            ->label('Catatan Pengembalian')
                            ->rows(3)
                            ->helperText('Catatan saat pengembalian'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Denda Keterlambatan')
                    ->schema([
                        Forms\Components\TextInput::make('fine_amount')
                            ->label('Jumlah Denda (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(fn(?Borrowing $record) => $record && $record->fine_paid)
                            ->helperText('Denda akan dihitung otomatis saat buku dikembalikan terlambat'),

                        Forms\Components\Toggle::make('fine_paid')
                            ->label('Denda Sudah Dibayar')
                            ->disabled(fn(?Borrowing $record) => !$record || $record->fine_amount <= 0)
                            ->helperText('Centang jika denda sudah dibayar'),

                        Forms\Components\DateTimePicker::make('fine_paid_at')
                            ->label('Tanggal Pembayaran Denda')
                            ->disabled()
                            ->helperText('Tanggal otomatis saat denda dibayar'),
                    ])
                    ->columns(2)
                    ->visible(fn(?Borrowing $record) => $record && $record->status === 'returned'),
            ]);
    }

    public static function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['user_id'])) {
            $user = User::find($data['user_id']);
            if ($user) {
                $data['user_email'] = $user->email;
                $data['class_major'] = $user->class_major;
            }
        }

        return $data;
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
                    ->label('Tanggal Pinjam')
                    ->date(),


                Tables\Columns\TextColumn::make('due_at')
                    ->label('Tanggal Kembali')
                    ->date(),


                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'returned' => 'info',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'returned' => 'Dikembalikan',
                    }),

                Tables\Columns\TextColumn::make('fine_amount')
                    ->label('Denda')
                    ->money('IDR')
                    ->color('danger')
                    ->sortable(),

                Tables\Columns\IconColumn::make('fine_paid')
                    ->label('Status Denda')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->tooltip(fn(?Borrowing $record) => $record->fine_paid ? 'Denda sudah dibayar' : 'Denda belum dibayar'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diajukan')
                    ->dateTime(),

                Tables\Columns\TextColumn::make('days_remaining')
                    ->label('Hari Tersisa')
                    ->state(fn(Borrowing $record) => $record->days_remaining)
                    ->color(fn(Borrowing $record) => $record->is_overdue ? 'danger' : ($record->days_remaining <= 3 ? 'warning' : 'success'))
                    ->sortable()
                    ->tooltip(fn(Borrowing $record) => $record->is_overdue ? 'Sudah terlambat' : ($record->days_remaining . ' hari tersisa')),

                Tables\Columns\IconColumn::make('is_overdue')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->tooltip(fn(Borrowing $record) => $record->is_overdue ? 'Sudah terlambat' : 'Masih dalam waktu'),

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

                Tables\Filters\Filter::make('pending')
                    ->query(fn(Builder $query): Builder => $query->where('status', 'pending'))
                    ->label('Menunggu Persetujuan'),

            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function (Borrowing $record) {
                        $record->update([
                            'status' => 'approved',
                            'approved_at' => now(),
                        ]);
                    })
                    ->visible(fn(Borrowing $record) => $record->status === 'pending')
                    ->requiresConfirmation(),

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
                    })
                    ->visible(fn(Borrowing $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3),
                    ])
                    ->requiresConfirmation(),

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
                    // ->modalDescription('Apakah Anda yakin denda sebesar Rp) ' . number_format($record->fine_amount) . ' sudah dibayar?')
                    ->modalSubmitActionLabel('Ya, Sudah Dibayar'),

                Tables\Actions\Action::make('return_book')
                    ->label('Kembalikan Buku')
                    ->icon('heroicon-o-arrow-left-circle')
                    ->color('primary')
                    ->action(function (Borrowing $record, array $data) {
                        $record->update([
                            'returned_at' => now(),
                            'return_notes' => $data['return_notes'] ?? null,
                            'book_condition' => $data['book_condition'] ?? null,
                        ]);

                        // Update fine if applicable
                        $record->updateFine();
                    })
                    ->visible(fn(Borrowing $record) => $record->status === 'approved' && !$record->returned_at)
                    ->form([
                        Forms\Components\Textarea::make('return_notes')
                            ->label('Catatan Pengembalian')
                            ->rows(3)
                            ->helperText('Catatan kondisi buku saat dikembalikan'),

                        Forms\Components\TextInput::make('book_condition')
                            ->label('Kondisi Buku Saat Dikembalikan')
                            ->maxLength(255)
                            ->helperText('Kondisi buku saat dikembalikan'),
                    ])
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pengembalian Buku')
                    ->modalSubmitActionLabel('Ya, Kembalikan'),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
