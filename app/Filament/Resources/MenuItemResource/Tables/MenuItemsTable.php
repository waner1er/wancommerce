<?php

namespace App\Filament\Resources\MenuItemResource\Tables;

use App\Models\MenuItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MenuItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->formatStateUsing(function (MenuItem $record): string {
                        $level = 0;
                        if ($record->parent_id) {
                            $level = $record->parent?->parent_id ? 2 : 1;
                        }

                        $indent = match($level) {
                            0 => '',
                            1 => '<span class="text-gray-400">├─</span> ',
                            2 => '<span class="text-gray-400">│&nbsp;&nbsp;└─</span> ',
                            default => ''
                        };

                        $weight = $level === 0 ? 'font-bold text-gray-900' : 'text-gray-700';

                        return '<span class="' . $weight . '">' . $indent . $record->title . '</span>';
                    })
                    ->html(),

                TextColumn::make('level')
                    ->label('Niveau')
                    ->badge()
                    ->getStateUsing(function (MenuItem $record): string {
                        if (!$record->parent_id) {
                            return 'Parent';
                        } elseif ($record->parent?->parent_id) {
                            return 'Niveau 3';
                        } else {
                            return 'Enfant';
                        }
                    })
                    ->color(function (MenuItem $record): string {
                        if (!$record->parent_id) {
                            return 'warning';
                        } elseif ($record->parent?->parent_id) {
                            return 'info';
                        } else {
                            return 'gray';
                        }
                    }),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'category' => 'success',
                        'custom_link' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->placeholder('—'),

                TextColumn::make('url')
                    ->label('Custom URL')
                    ->limit(40)
                    ->toggleable()
                    ->placeholder('—'),

                TextColumn::make('order')
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_visible')
                    ->label('Visible')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->defaultPaginationPageOption(100)
            ->deferLoading()
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'category' => 'Category',
                        'custom_link' => 'Custom Link',
                    ]),
                TernaryFilter::make('is_visible')
                    ->label('Visible')
                    ->placeholder('All')
                    ->trueLabel('Visible only')
                    ->falseLabel('Hidden only'),
                SelectFilter::make('parent_id')
                    ->label('Parent Item')
                    ->relationship('parent', 'title')
                    ->placeholder('All levels'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
