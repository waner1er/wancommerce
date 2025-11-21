<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        if (!$get('slug')) {
                            $set('slug', \Illuminate\Support\Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('Le slug est utilisé dans l\'URL. Ex: electronique'),

                Select::make('parent_id')
                    ->label('Catégorie parente')
                    ->options(function ($record) {
                        return Category::query()
                            ->when($record, function ($query) use ($record) {
                                $query->where('id', '!=', $record->id)
                                    ->whereNotIn('id', $record->children()->pluck('id'));
                            })
                            ->orderBy('name')
                            ->pluck('name', 'id');
                    })
                    ->searchable()
                    ->placeholder('Aucune (catégorie racine)')
                    ->helperText('Laissez vide pour une catégorie racine, ou sélectionnez une catégorie parente.'),
                FileUpload::make('image')
                    ->label('Image de la catégorie')
                    ->image()
                    ->disk('public')
                    ->directory('category-images')
                    ->maxSize(2048)
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->imagePreviewHeight('200')
                    ->downloadable()
                    ->openable()
                    ->helperText('Téléchargez une image représentative pour cette catégorie (max 2MB).'),
                Textarea::make('description')
                    ->columnSpanFull(),

                Toggle::make('is_visible_in_menu')
                    ->label('Visible dans le menu')
                    ->default(true),
            ]);
    }
}
