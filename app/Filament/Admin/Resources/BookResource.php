<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Manajemen Buku';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Buku';
    protected static ?string $modelLabel = 'Buku';
    protected static ?string $pluralModelLabel = 'Buku';

    public static function canCreate(): bool
    {
        return true;
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // Membuat layout utama menjadi 3 kolom
                Forms\Components\Grid::make()
                    ->columns(3)
                    ->schema([
                        // Grup kolom kiri (mengambil 2/3 dari lebar)
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Informasi Utama')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('author')
                                            ->label('Author')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Deskripsi')
                                            ->rows(5) // Membuat textarea lebih tinggi
                                            ->maxLength(65535)
                                            ->required()
                                            ->columnSpanFull(), // Mengambil lebar penuh di section ini
                                    ])->columns(2), // Section ini memiliki 2 kolom internal

                                Forms\Components\Section::make('Detail Publikasi')
                                    ->schema([
                                        Forms\Components\TextInput::make('isbn')
                                            ->label('ISBN')
                                            ->maxLength(13)
                                            ->required(),
                                        Forms\Components\TextInput::make('year_published')
                                            ->label('Tahun Terbit')
                                            ->numeric()
                                            ->minValue(1000)
                                            ->maxValue(date('Y'))
                                            ->required(),
                                        Forms\Components\TextInput::make('publisher')
                                            ->label('Penerbit')
                                            ->maxLength(255)
                                            ->required(),
                                        Forms\Components\TextInput::make('location')
                                            ->label('Lokasi')
                                            ->maxLength(255)
                                            ->required(),
                                    ])->columns(2), // Section ini juga memiliki 2 kolom
                            ])
                            ->columnSpan(2), // Grup ini mengambil 2 kolom dari grid utama

                        // Grup kolom kanan (mengambil 1/3 dari lebar)
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Status & Kategori')
                                    ->schema([
                                        Forms\Components\Select::make('category_id')
                                            ->relationship('category', 'name')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->label('Kategori'),
                                    ]),
                                Forms\Components\Section::make('Sampul')
                                    ->schema([
                                        Forms\Components\FileUpload::make('cover_image')
                                            ->label('Gambar Sampul')
                                            ->image()
                                            ->required()
                                            ->maxSize(5120) // 5MB
                                            ->imageResizeMode('contain')
                                            ->imageResizeTargetWidth(800)
                                            ->imageResizeTargetHeight(600)
                                            ->imageResizeUpscale(false)
                                            ->preserveFilenames()
                                            ->uploadProgressIndicatorPosition('right')
                                            ->helperText('Maksimum 5MB. Gambar akan otomatis di-resize ke 800x600px untuk optimasi.'),
                                    ]),
                            ])
                            ->columnSpan(1), // Grup ini mengambil 1 kolom dari grid utama
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        // ... (Tidak ada perubahan di sini, biarkan seperti semula)
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Sampul')
                    ->square()
                    ->size(60),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Judul')
                    ->formatStateUsing(function ($state, $record) {
                        $category = $record->category ? "<div class='text-xs text-gray-500'>{$record->category->name}</div>" : '';
                        return $state . $category;
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('author')
                    ->searchable(),
                Tables\Columns\TextColumn::make('isbn'),
                Tables\Columns\TextColumn::make('year_published')
                    ->label('Tahun Terbit'),
                Tables\Columns\TextColumn::make('publisher')
                    ->label('Penerbit'),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    tables\Actions\ViewAction::make()->label('Lihat'),
                    Tables\Actions\EditAction::make()->label('Ubah'),
                    Tables\Actions\DeleteAction::make()->label('Hapus'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        // ... (Tidak ada perubahan di sini, biarkan seperti semula)
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}