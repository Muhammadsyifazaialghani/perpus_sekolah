<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BorrowingResource\Pages;
use App\Filament\Admin\Resources\BorrowingResource\RelationManagers;
use App\Models\Borrowing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BorrowingResource extends Resource
{
    protected static ?string $model = Borrowing::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Peminjaman';
    protected static ?string $modelLabel = 'Peminjaman';
    protected static ?string $pluralModelLabel = 'Peminjaman';
    protected static ?string $navigationGroup = 'Manajemen';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Peminjam')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Peminjam Terdaftar')
                            ->helperText('Pilih dari daftar user yang sudah terdaftar'),
                        
                        Forms\Components\TextInput::make('borrower_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Nama lengkap peminjam'),
                        
                        Forms\Components\TextInput::make('nis_nip')
                            ->label('NIS/NIP')
                            ->maxLength(50)
                            ->helperText('Nomor identitas peminjam'),
                        
                        Forms\Components\TextInput::make('class_major')
                            ->label('Kelas/Jurusan')
                            ->maxLength(100)
                            ->helperText('Kelas atau jurusan peminjam'),
                        
                        Forms\Components\TextInput::make('school_institution')
                            ->label('Sekolah/Instansi')
                            ->maxLength(255)
                            ->helperText('Nama sekolah atau instansi'),
                        
                        Forms\Components\TextInput::make('contact_address')
                            ->label('Alamat Kontak')
                            ->maxLength(255)
                            ->helperText('Alamat atau nomor telepon peminjam'),
                    ])
                    ->columns(2),
                
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
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
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'returned' => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'returned' => 'Dikembalikan',
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diajukan')
                    ->dateTime(),
                    
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
                    ->query(fn (Builder $query): Builder => $query->where('status', 'pending'))
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
                    ->visible(fn (Borrowing $record) => $record->status === 'pending')
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
                    ->visible(fn (Borrowing $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3),
                    ])
                    ->requiresConfirmation(),
                
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
