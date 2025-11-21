<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run(): void
    {
        $products = [
            'PC Portables' => [
                ['name' => 'MacBook Pro 16"', 'price' => 249900, 'description' => 'Apple M3 Pro, 18Go RAM, 512Go SSD'],
                ['name' => 'Dell XPS 15', 'price' => 189900, 'description' => 'Intel Core i7, 16Go RAM, 1To SSD'],
                ['name' => 'Lenovo ThinkPad X1', 'price' => 169900, 'description' => 'Intel Core i7, 16Go RAM, 512Go SSD'],
                ['name' => 'HP Pavilion 14"', 'price' => 79900, 'description' => 'Intel Core i5, 8Go RAM, 256Go SSD'],
                ['name' => 'Asus ZenBook 13', 'price' => 119900, 'description' => 'AMD Ryzen 7, 16Go RAM, 512Go SSD'],
                ['name' => 'Acer Swift 3', 'price' => 69900, 'description' => 'Intel Core i5, 8Go RAM, 512Go SSD'],
                ['name' => 'MSI Gaming GF63', 'price' => 99900, 'description' => 'Intel Core i7, 16Go RAM, RTX 3050'],
                ['name' => 'Microsoft Surface Laptop 5', 'price' => 149900, 'description' => 'Intel Core i7, 16Go RAM, 512Go SSD'],
            ],
            'PC Fixes' => [
                ['name' => 'iMac 24"', 'price' => 179900, 'description' => 'Apple M3, 8Go RAM, 256Go SSD'],
                ['name' => 'PC Gaming RGB Ultimate', 'price' => 149900, 'description' => 'Intel i9, RTX 4070, 32Go RAM, 1To SSD'],
                ['name' => 'HP Pavilion Desktop', 'price' => 79900, 'description' => 'Intel Core i5, 16Go RAM, 512Go SSD'],
                ['name' => 'Dell OptiPlex', 'price' => 69900, 'description' => 'Intel Core i5, 8Go RAM, 256Go SSD'],
                ['name' => 'PC Gamer Pro', 'price' => 119900, 'description' => 'AMD Ryzen 7, RTX 3060, 16Go RAM'],
            ],
            'Composants PC' => [
                ['name' => 'Carte Graphique RTX 4080', 'price' => 129900, 'description' => 'NVIDIA GeForce RTX 4080, 16Go GDDR6X'],
                ['name' => 'Processeur AMD Ryzen 9', 'price' => 54900, 'description' => 'AMD Ryzen 9 7950X, 16 cœurs'],
                ['name' => 'RAM Corsair Vengeance 32Go', 'price' => 14900, 'description' => '32Go DDR5, 5600MHz'],
                ['name' => 'SSD Samsung 980 Pro 1To', 'price' => 12900, 'description' => 'NVMe M.2, 7000 Mo/s'],
                ['name' => 'Carte Mère ASUS ROG', 'price' => 32900, 'description' => 'Socket AM5, PCIe 5.0, Wi-Fi 6E'],
                ['name' => 'Alimentation Corsair 850W', 'price' => 15900, 'description' => '850W, Modulaire, 80+ Gold'],
                ['name' => 'Boîtier NZXT H510', 'price' => 8900, 'description' => 'Moyen tour, Verre trempé, RGB'],
                ['name' => 'Ventirad Noctua NH-D15', 'price' => 9900, 'description' => 'Refroidissement CPU haute performance'],
            ],
            'Smartphones' => [
                ['name' => 'iPhone 15 Pro Max', 'price' => 139900, 'description' => '256Go, Titane naturel, A17 Pro'],
                ['name' => 'Samsung Galaxy S24 Ultra', 'price' => 129900, 'description' => '256Go, Snapdragon 8 Gen 3'],
                ['name' => 'Google Pixel 8 Pro', 'price' => 109900, 'description' => '128Go, Tensor G3, Photo IA'],
                ['name' => 'iPhone 14', 'price' => 79900, 'description' => '128Go, Plusieurs coloris'],
                ['name' => 'Samsung Galaxy A54', 'price' => 44900, 'description' => '128Go, 5G, Triple caméra'],
                ['name' => 'Xiaomi 13T Pro', 'price' => 59900, 'description' => '256Go, Charge 120W'],
                ['name' => 'OnePlus 11', 'price' => 69900, 'description' => '256Go, Snapdragon 8 Gen 2'],
                ['name' => 'Google Pixel 7a', 'price' => 49900, 'description' => '128Go, Photo Google'],
            ],
            'Téléphones Classiques' => [
                ['name' => 'Nokia 3310', 'price' => 4900, 'description' => 'Le légendaire, Batterie longue durée'],
                ['name' => 'Nokia 2720 Flip', 'price' => 7900, 'description' => 'Format clapet, 4G, KaiOS'],
                ['name' => 'Doro 7010', 'price' => 8900, 'description' => 'Clapet, Seniors, Touche SOS'],
            ],
            'Accessoires' => [
                ['name' => 'AirPods Pro 2', 'price' => 27900, 'description' => 'Réduction bruit active, USB-C'],
                ['name' => 'Clavier Logitech MX Keys', 'price' => 11900, 'description' => 'Mécanique, Rétroéclairé, Multi-device'],
                ['name' => 'Souris Logitech MX Master 3S', 'price' => 9900, 'description' => 'Ergonomique, 8K DPI, Multi-device'],
                ['name' => 'Webcam Logitech Brio 4K', 'price' => 21900, 'description' => '4K Ultra HD, HDR, Autofocus'],
                ['name' => 'Casque Sony WH-1000XM5', 'price' => 39900, 'description' => 'Réduction bruit, 30h autonomie'],
                ['name' => 'Chargeur Anker 100W', 'price' => 5900, 'description' => 'USB-C, GaN, 3 ports'],
                ['name' => 'Hub USB-C 7 en 1', 'price' => 4900, 'description' => 'HDMI, USB-A, USB-C, lecteur SD'],
                ['name' => 'Support PC Portable', 'price' => 3900, 'description' => 'Réglable, Aluminium, Ventilé'],
            ],
            'T-shirts & Polos' => [
                ['name' => 'T-shirt Ralph Lauren', 'price' => 8900, 'description' => 'Polo classique, 100% coton'],
                ['name' => 'T-shirt Lacoste', 'price' => 7900, 'description' => 'Crocodile emblématique, Coupe ajustée'],
                ['name' => 'T-shirt Tommy Hilfiger', 'price' => 4900, 'description' => 'Logo brodé, Coton premium'],
                ['name' => 'T-shirt Uniqlo Basique', 'price' => 1490, 'description' => 'Lot de 3, 100% coton'],
                ['name' => 'Polo Fred Perry', 'price' => 9900, 'description' => 'Couronne de laurier, Made in England'],
                ['name' => 'T-shirt Graphic Nike', 'price' => 3990, 'description' => 'Swoosh oversize, Coton recyclé'],
            ],
            'Pantalons & Jeans' => [
                ['name' => 'Jean Levi\'s 501', 'price' => 11900, 'description' => 'Coupe droite, Denim authentique'],
                ['name' => 'Chino Dockers', 'price' => 7900, 'description' => 'Coupe slim, Stretch confort'],
                ['name' => 'Jean Diesel Slim', 'price' => 15900, 'description' => 'Stretch denim, Délavage moderne'],
                ['name' => 'Pantalon Costume Hugo Boss', 'price' => 19900, 'description' => 'Laine mélangée, Coupe ajustée'],
                ['name' => 'Jogging Nike Tech Fleece', 'price' => 10900, 'description' => 'Molleton léger, Coupe fuselée'],
            ],
            'Vestes & Manteaux' => [
                ['name' => 'Doudoune The North Face', 'price' => 29900, 'description' => 'Duvet 700, Déperlant'],
                ['name' => 'Veste en Jean Levi\'s', 'price' => 9900, 'description' => 'Trucker jacket, Denim rigid'],
                ['name' => 'Manteau Cachemire', 'price' => 39900, 'description' => '80% laine, 20% cachemire'],
                ['name' => 'Blouson Cuir', 'price' => 49900, 'description' => 'Cuir véritable, Doublure matelassée'],
                ['name' => 'Parka Hiver', 'price' => 19900, 'description' => 'Capuche fourrure, -20°C'],
            ],
            'Robes' => [
                ['name' => 'Robe d\'été Zara', 'price' => 4990, 'description' => 'Fleurie, Coton léger, Mi-longue'],
                ['name' => 'Robe Cocktail Mango', 'price' => 7990, 'description' => 'Noire, Cintrée, Élégante'],
                ['name' => 'Robe Longue Bohème', 'price' => 6990, 'description' => 'Imprimé ethnique, Fluide'],
                ['name' => 'Robe Chemise Lin', 'price' => 5990, 'description' => '100% lin, Ceinturée'],
                ['name' => 'Robe Soirée Paillettes', 'price' => 12990, 'description' => 'Sequins dorés, Dos nu'],
            ],
            'Hauts & Chemisiers' => [
                ['name' => 'Chemisier Blanc Satin', 'price' => 5990, 'description' => 'Col V, Manches longues'],
                ['name' => 'Top Crop Zara', 'price' => 2990, 'description' => 'Côtelé, Plusieurs coloris'],
                ['name' => 'Blouse Fleurie', 'price' => 4490, 'description' => 'Imprimé floral, Manches bouffantes'],
                ['name' => 'Pull Cachemire', 'price' => 9990, 'description' => '100% cachemire, Col rond'],
                ['name' => 'Débardeur Soie', 'price' => 7990, 'description' => 'Soie naturelle, Dentelle'],
            ],
            'Pantalons & Jupes' => [
                ['name' => 'Jean Mom Fit', 'price' => 6990, 'description' => 'Taille haute, Délavé vintage'],
                ['name' => 'Jupe Plissée Midi', 'price' => 4990, 'description' => 'Plissé soleil, Mi-longue'],
                ['name' => 'Pantalon Tailleur', 'price' => 7990, 'description' => 'Coupe cigarette, Pince'],
                ['name' => 'Jupe Courte Jean', 'price' => 3990, 'description' => 'Mini, Boutons devant'],
                ['name' => 'Legging Sport', 'price' => 2990, 'description' => 'Compression, Taille haute'],
            ],
            'Enfants' => [
                ['name' => 'Ensemble Jogging Enfant', 'price' => 2990, 'description' => 'Sweat + Pantalon, 2-12 ans'],
                ['name' => 'Robe Princesse', 'price' => 3490, 'description' => 'Tulle brodé, 3-10 ans'],
                ['name' => 'Jean Enfant', 'price' => 2490, 'description' => 'Denim stretch, 2-14 ans'],
                ['name' => 'T-shirt Disney', 'price' => 1490, 'description' => 'Personnages Disney, 100% coton'],
                ['name' => 'Doudoune Enfant', 'price' => 4990, 'description' => 'Capuche, Duvet synthétique'],
            ],
            'Salon' => [
                ['name' => 'Canapé 3 Places Tissu', 'price' => 79900, 'description' => 'Confortable, Gris chiné, Pieds bois'],
                ['name' => 'Table Basse Scandinave', 'price' => 24900, 'description' => 'Bois chêne, Design nordique'],
                ['name' => 'Fauteuil Relax', 'price' => 39900, 'description' => 'Inclinable, Cuir synthétique'],
                ['name' => 'Meuble TV Moderne', 'price' => 29900, 'description' => '180cm, Blanc mat, Rangements'],
                ['name' => 'Bibliothèque Murale', 'price' => 19900, 'description' => '5 étagères, Chêne massif'],
            ],
            'Chambre' => [
                ['name' => 'Lit 160x200 avec Rangements', 'price' => 49900, 'description' => 'Tiroirs intégrés, Tête de lit'],
                ['name' => 'Armoire 3 Portes', 'price' => 39900, 'description' => 'Miroir central, Penderie + étagères'],
                ['name' => 'Matelas Mémoire de Forme', 'price' => 59900, 'description' => '160x200, 7 zones, Housse bambou'],
                ['name' => 'Table de Chevet', 'price' => 8900, 'description' => '2 tiroirs, Chêne clair'],
                ['name' => 'Commode 6 Tiroirs', 'price' => 29900, 'description' => 'Pin massif, Poignées métal'],
            ],
            'Bureau' => [
                ['name' => 'Bureau Assis-Debout Électrique', 'price' => 49900, 'description' => '140x70cm, Hauteur réglable'],
                ['name' => 'Chaise Bureau Ergonomique', 'price' => 29900, 'description' => 'Soutien lombaire, Accoudoirs 4D'],
                ['name' => 'Caisson 3 Tiroirs', 'price' => 14900, 'description' => 'Mobile, Serrure, Blanc'],
                ['name' => 'Étagère Murale Bureau', 'price' => 9900, 'description' => '100cm, 3 niveaux, Acier noir'],
            ],
            'Cadres & Tableaux' => [
                ['name' => 'Tableau Abstrait 80x120', 'price' => 19900, 'description' => 'Toile, Couleurs vives, Moderne'],
                ['name' => 'Lot 3 Cadres Photo', 'price' => 2990, 'description' => '30x40cm, Noir mat, Verre'],
                ['name' => 'Poster Vintage Encadré', 'price' => 4990, 'description' => '50x70cm, Style rétro'],
                ['name' => 'Triptyque Nature', 'price' => 14900, 'description' => '3x 40x60cm, Forêt brumeuse'],
                ['name' => 'Miroir Mural Doré', 'price' => 8900, 'description' => 'Rond 60cm, Cadre métal'],
            ],
            'Luminaires' => [
                ['name' => 'Lampe Suspension Design', 'price' => 12900, 'description' => 'Métal noir mat, E27, 40cm'],
                ['name' => 'Lampe de Table LED', 'price' => 5990, 'description' => 'Tactile, 3 intensités, USB'],
                ['name' => 'Lampadaire Trépied', 'price' => 9900, 'description' => 'Bois + Lin, 160cm, E27'],
                ['name' => 'Guirlande LED 10m', 'price' => 2490, 'description' => 'Blanc chaud, Étanche, Télécommande'],
                ['name' => 'Spot LED Encastrable x3', 'price' => 3990, 'description' => 'Orientable, Dimmable, GU10'],
            ],
            'Musculation' => [
                ['name' => 'Banc de Musculation', 'price' => 19900, 'description' => 'Inclinable, Charge max 200kg'],
                ['name' => 'Set Haltères 20kg', 'price' => 8900, 'description' => 'Paire haltères, Disques caoutchouc'],
                ['name' => 'Barre Traction Murale', 'price' => 6990, 'description' => 'Fixation solide, Charge max 150kg'],
                ['name' => 'Tapis de Sol Fitness', 'price' => 2990, 'description' => '180x60cm, Antidérapant, 15mm'],
                ['name' => 'Élastiques Résistance x5', 'price' => 1990, 'description' => '5 niveaux, Sac de transport'],
            ],
            'Cardio' => [
                ['name' => 'Tapis de Course Pliable', 'price' => 59900, 'description' => 'Moteur 2.5HP, 12 programmes, LCD'],
                ['name' => 'Vélo d\'Appartement', 'price' => 39900, 'description' => 'Magnétique, 8 niveaux, Écran LCD'],
                ['name' => 'Rameur Concept2', 'price' => 99900, 'description' => 'Pro, Moniteur PM5, Pliable'],
                ['name' => 'Corde à Sauter Pro', 'price' => 1490, 'description' => 'Roulements, Compteur, Ajustable'],
                ['name' => 'Stepper Fitness', 'price' => 14900, 'description' => 'Hydraulique, Affichage LCD'],
            ],
            'Randonnée' => [
                ['name' => 'Sac à Dos 50L', 'price' => 12900, 'description' => 'Imperméable, Dorsale ventilée'],
                ['name' => 'Chaussures Randonnée', 'price' => 14900, 'description' => 'Gore-Tex, Semelle Vibram'],
                ['name' => 'Bâtons de Marche x2', 'price' => 4990, 'description' => 'Aluminium, Ajustables, Poignée liège'],
                ['name' => 'Gourde Isotherme 1L', 'price' => 2990, 'description' => 'Inox, 12h chaud/24h froid'],
                ['name' => 'Veste Imperméable', 'price' => 9900, 'description' => 'Gore-Tex, Respirante, Capuche'],
            ],
            'Camping' => [
                ['name' => 'Tente 4 Places', 'price' => 19900, 'description' => 'Double toit, Imperméable 3000mm'],
                ['name' => 'Sac de Couchage -10°C', 'price' => 7990, 'description' => 'Sarcophage, Duvet synthétique'],
                ['name' => 'Matelas Gonflable', 'price' => 5990, 'description' => 'Auto-gonflant, Compact, R-value 5'],
                ['name' => 'Réchaud Camping Gaz', 'price' => 3490, 'description' => 'Compact, Piezo, 2800W'],
                ['name' => 'Lampe Frontale LED', 'price' => 2990, 'description' => '500 lumens, Rechargeable USB'],
            ],
        ];

        foreach ($products as $categoryName => $productList) {
            $category = Category::where('name', $categoryName)->first();

            if ($category) {
                foreach ($productList as $productData) {
                    $sku = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', strtoupper($productData['name'])), 0, 8))
                           . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);

                    Product::create([
                        'name' => $productData['name'],
                        'sku' => $sku,
                        'description' => $productData['description'],
                        'price' => $productData['price'] / 100, // Prix en euros (était en centimes)
                        'stock' => rand(5, 50),
                        'category_id' => $category->id,
                    ]);
                }
            }
        }
    }
}
