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
    protected static ?string $navigationGroup = 'Manajemen';
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
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('author')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('isbn')
                    ->maxLength(13),
                Forms\Components\TextInput::make('year_published')
                    ->numeric()
                    ->minValue(1000)
                    ->maxValue(date('Y'))
                    ->label('Tahun Terbit'),
                Forms\Components\TextInput::make('publisher')
                    ->maxLength(255)
                    ->label('Penerbit'),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255)
                    ->label('Lokasi'),
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
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->label('Kategori'),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('cover_image')
                ->label('Sampul')
                ->square() // biar rapi (opsional: bisa ->circular() kalau mau bulat)
                ->size(60), // ukuran thumbnail di tabel
            Tables\Columns\TextColumn::make('title')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('author')
                ->sortable()
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
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
