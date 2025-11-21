<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        @php
            $breadcrumbItems = [];
            if($category->parent) {
                $breadcrumbItems[] = [
                    'label' => $category->parent->name,
                    'url' => route('shop.category', ['path' => $category->parent->slug_path])
                ];
            }
            $breadcrumbItems[] = ['label' => $category->name];
        @endphp
        @livewire('breadcrumb', ['items' => $breadcrumbItems])

        <!-- En-tête de la catégorie -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-lg text-gray-600">{{ $category->description }}</p>
            @endif
        </div>

        <!-- Grille des sous-catégories -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($subcategories as $subcategory)
                <a href="{{ route('shop.category', ['path' => $subcategory->slug_path]) }}"
                   class="group block bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">

                    <!-- Image de la sous-catégorie -->
                    @if($subcategory->image)
                        <div class="aspect-video overflow-hidden bg-gray-100">
                            <img src="{{ asset('storage/' . $subcategory->image) }}"
                                 alt="{{ $subcategory->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Contenu de la carte -->
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                            {{ $subcategory->name }}
                        </h2>

                        @if($subcategory->description)
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ $subcategory->description }}
                            </p>
                        @endif

                        <!-- Nombre de produits ou sous-catégories -->
                        <div class="flex items-center text-sm text-gray-500">
                            @php
                                $productCount = $subcategory->products->count();
                                $childrenCount = $subcategory->children->count();
                            @endphp

                            @if($productCount > 0)
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <span>{{ $productCount }} {{ $productCount > 1 ? 'produits' : 'produit' }}</span>
                            @elseif($childrenCount > 0)
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                <span>{{ $childrenCount }} {{ $childrenCount > 1 ? 'catégories' : 'catégorie' }}</span>
                            @endif
                        </div>

                        <!-- Flèche de navigation -->
                        <div class="mt-4 flex items-center text-blue-600 font-medium">
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Découvrir</span>
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($subcategories->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Aucune sous-catégorie disponible pour le moment.</p>
            </div>
        @endif
    </div>
</x-app-layout>
