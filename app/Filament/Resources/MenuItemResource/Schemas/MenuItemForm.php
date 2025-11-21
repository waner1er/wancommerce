<?php

namespace App\Filament\Resources\MenuItemResource\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('type')
                    ->required()
                    ->options([
                        'category' => 'Category Link (Auto-generated)',
                        'custom_link' => 'Custom Link',
                    ])
                    ->default('custom_link')
                    ->live()
                    ->disabled(fn ($record) => $record && $record->type === 'category')
                    ->helperText('Category links are auto-generated. Only create custom links here.'),

                // Afficher la catégorie liée (read-only) pour les items de type category
                Select::make('category_id')
                    ->label('Catégorie liée')
                    ->relationship('category', 'name')
                    ->disabled()
                    ->visible(fn ($get, $record): bool => $record && $get('type') === 'category')
                    ->helperText('Cette association est automatique. Modifiez la catégorie pour changer ce lien.'),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->disabled(fn ($record) => $record && $record->type === 'category')
                    ->columnSpanFull()
                    ->helperText(fn ($record) => $record && $record->type === 'category'
                        ? 'Le titre est synchronisé avec le nom de la catégorie'
                        : 'Le texte affiché dans le menu'),

                TextInput::make('url')
                    ->label('URL')
                    ->maxLength(255)
                    ->required(fn ($get): bool => $get('type') === 'custom_link')
                    ->visible(fn ($get): bool => $get('type') === 'custom_link')
                    ->helperText('URL complète (ex: /about ou https://example.com)'),

                Select::make('parent_id')
                    ->label('Parent')
                    ->relationship('parent', 'title')
                    ->searchable()
                    ->preload()
                    ->placeholder('Aucun (Niveau racine)')
                    ->disabled(fn ($record) => $record && $record->type === 'category')
                    ->helperText(fn ($record) => $record && $record->type === 'category'
                        ? 'La hiérarchie est synchronisée avec celle des catégories'
                        : 'Sélectionnez un parent pour créer un sous-menu'),

                TextInput::make('icon')
                    ->maxLength(255)
                    ->helperText('Nom d\'icône Heroicon optionnel (ex: heroicon-o-home)')
                    ->placeholder('heroicon-o-home'),

                TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Les numéros plus petits apparaissent en premier'),

                Toggle::make('is_visible')
                    ->label('Visible dans le menu')
                    ->default(true)
                    ->helperText('Masquer cet élément sans le supprimer'),
            ]);
    }
}
