<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Électronique',
                'slug' => 'electronique',
                'description' => 'Découvrez notre sélection de produits électroniques',
                'order' => 1,
                'children' => [
                    [
                        'name' => 'Ordinateurs',
                        'slug' => 'ordinateurs',
                        'description' => 'PC portables, fixes et accessoires',
                        'order' => 1,
                        'products' => 8,
                        'children' => [
                            ['name' => 'PC Portables', 'slug' => 'pc-portables', 'order' => 1, 'products' => 12],
                            ['name' => 'PC Fixes', 'slug' => 'pc-fixes', 'order' => 2, 'products' => 8],
                            ['name' => 'Composants PC', 'slug' => 'composants-pc', 'order' => 3, 'products' => 15],
                        ]
                    ],
                    [
                        'name' => 'Téléphones',
                        'slug' => 'telephones',
                        'description' => 'Smartphones et accessoires',
                        'order' => 2,
                        'products' => 10,
                        'children' => [
                            ['name' => 'Smartphones', 'slug' => 'smartphones', 'order' => 1, 'products' => 20],
                            ['name' => 'Téléphones Classiques', 'slug' => 'telephones-classiques', 'order' => 2, 'products' => 5],
                        ]
                    ],
                    [
                        'name' => 'Accessoires',
                        'slug' => 'accessoires',
                        'description' => 'Accessoires électroniques variés',
                        'order' => 3,
                        'products' => 20,
                    ]
                ]
            ],
            [
                'name' => 'Mode',
                'slug' => 'mode',
                'description' => 'Vêtements et accessoires de mode',
                'order' => 2,
                'children' => [
                    [
                        'name' => 'Hommes',
                        'slug' => 'hommes',
                        'description' => 'Mode masculine',
                        'order' => 1,
                        'products' => 15,
                        'children' => [
                            ['name' => 'T-shirts & Polos', 'slug' => 't-shirts-polos', 'order' => 1, 'products' => 18],
                            ['name' => 'Pantalons & Jeans', 'slug' => 'pantalons-jeans', 'order' => 2, 'products' => 15],
                            ['name' => 'Vestes & Manteaux', 'slug' => 'vestes-manteaux', 'order' => 3, 'products' => 12],
                        ]
                    ],
                    [
                        'name' => 'Femmes',
                        'slug' => 'femmes',
                        'description' => 'Mode féminine',
                        'order' => 2,
                        'products' => 20,
                        'children' => [
                            ['name' => 'Robes', 'slug' => 'robes', 'order' => 1, 'products' => 22],
                            ['name' => 'Hauts & Chemisiers', 'slug' => 'hauts-chemisiers', 'order' => 2, 'products' => 18],
                            ['name' => 'Pantalons & Jupes', 'slug' => 'pantalons-jupes', 'order' => 3, 'products' => 16],
                        ]
                    ],
                    [
                        'name' => 'Enfants',
                        'slug' => 'enfants',
                        'description' => 'Mode pour enfants',
                        'order' => 3,
                        'products' => 18,
                    ]
                ]
            ],
            [
                'name' => 'Maison',
                'slug' => 'maison',
                'description' => 'Tout pour votre maison',
                'order' => 3,
                'children' => [
                    [
                        'name' => 'Meubles',
                        'slug' => 'meubles',
                        'description' => 'Mobilier pour toute la maison',
                        'order' => 1,
                        'products' => 10,
                        'children' => [
                            ['name' => 'Salon', 'slug' => 'salon', 'order' => 1, 'products' => 15],
                            ['name' => 'Chambre', 'slug' => 'chambre', 'order' => 2, 'products' => 12],
                            ['name' => 'Bureau', 'slug' => 'bureau', 'order' => 3, 'products' => 10],
                        ]
                    ],
                    [
                        'name' => 'Décoration',
                        'slug' => 'decoration',
                        'description' => 'Objets déco et art',
                        'order' => 2,
                        'products' => 25,
                        'children' => [
                            ['name' => 'Cadres & Tableaux', 'slug' => 'cadres-tableaux', 'order' => 1, 'products' => 20],
                            ['name' => 'Luminaires', 'slug' => 'luminaires', 'order' => 2, 'products' => 15],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Sport',
                'slug' => 'sport',
                'description' => 'Équipements et vêtements de sport',
                'order' => 4,
                'children' => [
                    [
                        'name' => 'Fitness',
                        'slug' => 'fitness',
                        'description' => 'Équipements de musculation et fitness',
                        'order' => 1,
                        'products' => 12,
                        'children' => [
                            ['name' => 'Musculation', 'slug' => 'musculation', 'order' => 1, 'products' => 18],
                            ['name' => 'Cardio', 'slug' => 'cardio', 'order' => 2, 'products' => 12],
                        ]
                    ],
                    [
                        'name' => 'Outdoor',
                        'slug' => 'outdoor',
                        'description' => 'Sports de plein air',
                        'order' => 2,
                        'products' => 15,
                        'children' => [
                            ['name' => 'Randonnée', 'slug' => 'randonnee', 'order' => 1, 'products' => 20],
                            ['name' => 'Camping', 'slug' => 'camping', 'order' => 2, 'products' => 16],
                        ]
                    ],
                ]
            ],
        ];

        $this->createCategories($categories);
    }

    private function createCategories(array $categories, $parentId = null, $level = 0): void
    {
        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            $productsCount = $categoryData['products'] ?? 0;
            unset($categoryData['children'], $categoryData['products']);

            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'description' => $categoryData['description'] ?? null,
                'parent_id' => $parentId,
                'order' => $categoryData['order'],
                'is_visible_in_menu' => true,
            ]);

            // Créer les enfants récursivement
            if (!empty($children)) {
                $this->createCategories($children, $category->id, $level + 1);
            }
        }
    }
}
