<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some categories to link to
        $categories = Category::visibleInMenu()->get();

        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please seed categories first.');
            return;
        }

        // Create root menu items
        $shopItem = MenuItem::create([
            'title' => 'Boutique',
            'type' => 'category',
            'category_id' => $categories->first()->id,
            'order' => 1,
            'is_visible' => true,
        ]);

        // Create a few sub-menu items under Shop
        foreach ($categories->take(3) as $index => $category) {
            MenuItem::create([
                'parent_id' => $shopItem->id,
                'title' => $category->name,
                'type' => 'category',
                'category_id' => $category->id,
                'order' => $index + 1,
                'is_visible' => true,
            ]);
        }

        // Create a custom link
        MenuItem::create([
            'title' => 'À propos',
            'type' => 'custom_link',
            'url' => '/about',
            'order' => 2,
            'is_visible' => true,
        ]);

        // Create a contact link
        MenuItem::create([
            'title' => 'Contact',
            'type' => 'custom_link',
            'url' => '/contact',
            'order' => 3,
            'is_visible' => true,
            'icon' => 'heroicon-o-envelope',
        ]);

        $this->command->info('Menu items seeded successfully!');
    }
}
