<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // Charger les catégories racines avec leurs enfants et produits
        $categories = Category::whereNull('parent_id')
            ->with(['children.children.products', 'children.products', 'products'])
            ->orderBy('order')
            ->get()
            ->filter(function ($category) {
                // Ne garder que les catégories qui ont des enfants avec des produits
                return $category->children->count() > 0 && $this->categoryHasProducts($category);
            });

        return view('shop.index', ['categories' => $categories]);
    }

    public function category($path)
    {
        // Séparer le chemin en segments
        $slugs = explode('/', $path);

        // Trouver la catégorie finale en suivant la hiérarchie
        $category = null;
        $parentId = null;

        foreach ($slugs as $slug) {
            $query = Category::where('slug', $slug);

            if ($parentId !== null) {
                $query->where('parent_id', $parentId);
            } else {
                $query->whereNull('parent_id');
            }

            $category = $query->firstOrFail();
            $parentId = $category->id;
        }

        // Charger les relations nécessaires
        $category->load(['children.children.products', 'children.products', 'products']);

        // Vérifier si cette catégorie a des produits directs
        $hasDirectProducts = $category->products->count() > 0;

        // Si la catégorie a des produits directs, les afficher
        if ($hasDirectProducts) {
            return view('shop.category', [
                'category' => $category,
                'products' => $category->products,
            ]);
        }

        // Sinon, vérifier si elle a des enfants
        if ($category->children->count() > 0) {
            // Filtrer les enfants qui ont des produits (directs ou dans leurs descendants)
            $childrenWithProducts = $category->children->filter(function ($child) {
                return $this->categoryHasProducts($child);
            });

            // Si elle a des enfants avec produits, afficher une page d'archive
            if ($childrenWithProducts->count() > 0) {
                return view('shop.category-archive', [
                    'category' => $category,
                    'subcategories' => $childrenWithProducts,
                ]);
            }
        }

        // Si aucun produit n'est trouvé, afficher une page vide
        return view('shop.empty-category', [
            'categoryName' => $category->name,
            'parentCategory' => $category->parent,
        ]);
    }

    private function categoryHasProducts($category): bool
    {
        // Vérifier si la catégorie a des produits directement
        if ($category->products && $category->products->count() > 0) {
            return true;
        }

        // Vérifier récursivement dans les descendants
        if ($category->children && $category->children->count() > 0) {
            foreach ($category->children as $child) {
                if ($this->categoryHasProducts($child)) {
                    return true;
                }
            }
        }

        return false;
    }
}
