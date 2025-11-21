<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        if (empty($get('sku'))) {
                            $cleanName = strtoupper(preg_replace('/[^A-Z0-9]/', '', strtoupper($state)));
                            $prefix = substr($cleanName, 0, 8);
                            $suffix = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
                            $set('sku', $prefix . '-' . $suffix);
                        }
                    })
                    ->helperText('Le SKU sera généré automatiquement à partir du nom'),

                TextInput::make('sku')
                    ->label('SKU')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('Généré automatiquement ou saisissez-le manuellement')
                    ->maxLength(50),

                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(3),

                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('€')
                    ->minValue(0)
                    ->step(0.01)
                    ->helperText('Prix en euros'),
                FileUpload::make('image')
                    ->disk('public')
                    ->image()
                    ->maxSize(2048)
                    ->helperText('Téléchargez une image du produit (max 2MB)'),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->helperText('Quantité en stock'),

                Select::make('category_id')
                    ->label('Catégorie')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('Sélectionnez la catégorie du produit'),
            ]);
    }
}
