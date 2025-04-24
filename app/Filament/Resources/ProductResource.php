<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Support\RawJs;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255)
                ->live(),

            Forms\Components\TextInput::make('price')
                ->label('Precio')
                ->required()
                ->rules(['numeric', 'min:0'])
                ->stripCharacters(',')
                ->mask(RawJs::make('$money($input)')),

            Forms\Components\Select::make('category_id')
                ->label('Categoría')
                ->relationship('category', 'name')
                ->searchable()
                ->required(),

            Forms\Components\RichEditor::make('description')
                ->label('Descripción'),

            Forms\Components\TextInput::make('stock')
                ->label('Stock')
                ->numeric()
                ->minValue(0)
                ->required(),

            Forms\Components\FileUpload::make('image_path')
                ->label('Imagen del producto')
                ->image()
                ->previewable(true)
                ->imageEditor()
                ->directory('products')
                ->preserveFilenames()
                ->imagePreviewHeight('150')
                ->disk('public')
                ->maxSize(1024)
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->getStateUsing(fn($record) => $record->image_path ? Storage::disk('public')->url($record->image_path) : null)
                    ->circular(),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Precio')
                    ->money('USD', true)
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Categoría'),

                TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable(),

                TextColumn::make('agotado')
                    ->label('¿Agotado?')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Categoría'),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
