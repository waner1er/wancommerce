<?php

namespace App\Filament\Resources\MenuItemResource\Pages;

use App\Filament\Resources\MenuItemResource;
use App\Models\MenuItem;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMenuItems extends ListRecords
{
    protected static string $resource = MenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajouter un lien personnalisé')
                ->modalHeading('Ajouter un lien personnalisé')
                ->successNotificationTitle('Lien ajouté au menu'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    public function getTitle(): string
    {
        return 'Organisation du Menu';
    }

    public function getSubheading(): ?string
    {
        return 'Les catégories sont ajoutées automatiquement. Glissez pour réorganiser l\'ordre dans chaque niveau.';
    }

    protected function getTableQuery(): Builder
    {
        // Construire une liste hiérarchique ordonnée
        $allItems = MenuItem::with(['parent', 'children', 'category'])->get();
        $orderedIds = [];

        // Fonction récursive pour ajouter les items dans l'ordre hiérarchique
        $addItemsRecursively = function($parentId, $level = 0) use ($allItems, &$orderedIds, &$addItemsRecursively) {
            $items = $allItems->where('parent_id', $parentId)->sortBy('order');
            foreach ($items as $item) {
                $orderedIds[] = $item->id;
                // Récursivement ajouter les enfants
                $addItemsRecursively($item->id, $level + 1);
            }
        };

        // Commencer par les parents (parent_id = null)
        $addItemsRecursively(null);

        // Retourner une query ordonnée par nos IDs
        if (empty($orderedIds)) {
            return MenuItem::query()->whereRaw('1 = 0'); // Aucun résultat
        }

        return MenuItem::query()
            ->whereIn('id', $orderedIds)
            ->orderByRaw('FIELD(id, ' . implode(',', $orderedIds) . ')');
    }
}
