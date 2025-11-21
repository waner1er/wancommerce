<?php

namespace App\Livewire;

use App\Models\MenuItem;
use Livewire\Component;

class MainNavigation extends Component
{
    public $menuItems;

    public function mount()
    {
        $this->menuItems = MenuItem::rootItems()
            ->visible()
            ->with([
                'children' => function ($query) {
                    $query->visible()->orderBy('order')->with(['children' => function ($subQuery) {
                        $subQuery->visible()->orderBy('order');
                    }]);
                },
                'category.children.children.products',
                'category.children.products',
                'category.products'
            ])
            ->get()
            ->filter(function ($menuItem) {
                // Garder les liens personnalisés
                if ($menuItem->type === 'custom_link') {
                    return true;
                }

                // Pour les catégories, vérifier qu'elles ont des produits
                if ($menuItem->category) {
                    return $this->categoryHasProducts($menuItem->category);
                }

                return false;
            })
            ->map(function ($menuItem) {
                // Filtrer récursivement tous les niveaux d'enfants
                if ($menuItem->children) {
                    $menuItem->setRelation('children', $this->filterMenuChildren($menuItem->children));
                }
                return $menuItem;
            });
    }

    private function categoryHasProducts($category): bool
    {
        // Vérifier si la catégorie a des produits directement
        if ($category->products && $category->products->count() > 0) {
            return true;
        }

        // Vérifier récursivement dans tous les descendants
        return $this->hasProductsInDescendants($category);
    }

    private function hasProductsInDescendants($category): bool
    {
        $children = $category->children;

        if ($children->isEmpty()) {
            return false;
        }

        foreach ($children as $child) {
            // Si l'enfant a des produits
            if ($child->products()->exists()) {
                return true;
            }

            // Sinon vérifier récursivement ses descendants
            if ($this->hasProductsInDescendants($child)) {
                return true;
            }
        }

        return false;
    }

    private function filterMenuChildren($children)
    {
        return $children->filter(function ($child) {
            if ($child->type === 'custom_link') {
                return true;
            }
            if ($child->category) {
                return $this->categoryHasProducts($child->category);
            }
            return false;
        })->map(function ($child) {
            // Filtrer récursivement les enfants de cet enfant
            if ($child->children && $child->children->count() > 0) {
                $child->setRelation('children', $this->filterMenuChildren($child->children));
            }
            return $child;
        });
    }

    public function render()
    {
        return view('livewire.main-navigation');
    }
}
