<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\MenuItem;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        // Créer automatiquement un MenuItem pour cette catégorie
        $menuItem = new MenuItem();
        $menuItem->title = $category->name;
        $menuItem->type = 'category';
        $menuItem->category_id = $category->id;
        $menuItem->is_visible = $category->is_visible_in_menu ?? true;

        // Si la catégorie a un parent, lier le MenuItem au MenuItem parent correspondant
        if ($category->parent_id) {
            $parentMenuItem = MenuItem::where('category_id', $category->parent_id)->first();
            if ($parentMenuItem) {
                $menuItem->parent_id = $parentMenuItem->id;
            }
        }

        // Définir l'ordre : dernier élément du même niveau
        if ($menuItem->parent_id) {
            $maxOrder = MenuItem::where('parent_id', $menuItem->parent_id)->max('order') ?? 0;
        } else {
            $maxOrder = MenuItem::whereNull('parent_id')->max('order') ?? 0;
        }
        $menuItem->order = $maxOrder + 1;

        $menuItem->save();
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        // Mettre à jour le MenuItem correspondant
        $menuItem = MenuItem::where('category_id', $category->id)->first();

        if ($menuItem) {
            $menuItem->title = $category->name;
            $menuItem->is_visible = $category->is_visible_in_menu ?? true;

            // Si le parent de la catégorie a changé, mettre à jour la hiérarchie du menu
            if ($category->wasChanged('parent_id')) {
                if ($category->parent_id) {
                    $parentMenuItem = MenuItem::where('category_id', $category->parent_id)->first();
                    $menuItem->parent_id = $parentMenuItem?->id;
                } else {
                    $menuItem->parent_id = null;
                }
            }

            $menuItem->save();
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        // Supprimer le MenuItem correspondant
        MenuItem::where('category_id', $category->id)->delete();
    }
}
