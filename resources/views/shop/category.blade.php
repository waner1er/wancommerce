<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [];

            // Construire le fil d'ariane en remontant la hiérarchie
            $ancestors = [];
            $current = $category->parent;
            while ($current) {
                array_unshift($ancestors, $current);
                $current = $current->parent;
            }

            // Ajouter tous les ancêtres
            foreach ($ancestors as $ancestor) {
                $breadcrumbItems[] = [
                    'label' => $ancestor->name,
                    'url' => route('shop.category', ['path' => $ancestor->slug_path])
                ];
            }

            // Ajouter la catégorie actuelle
            $breadcrumbItems[] = ['label' => $category->name];
        @endphp
        @livewire('breadcrumb', ['items' => $breadcrumbItems])

        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-lg text-gray-600">{{ $category->description }}</p>
            @endif
            <p class="text-sm text-gray-500 mt-2">{{ $products->count() }} {{ $products->count() > 1 ? 'produits' : 'produit' }}</p>
        </div>

        <!-- Liste des produits -->
        @livewire('products-component', ['categoryId' => $category->id])
    </div>
</x-app-layout>
