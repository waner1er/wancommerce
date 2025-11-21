<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Boutique</h1>
            <p class="text-lg text-gray-600">Découvrez notre sélection de produits</p>
        </div>

        <div class="space-y-16">
            @foreach($categories as $category)
                @if($category->children->count() > 0)
                    <section>
                        <div class="mb-6">
                            <a href="{{ route('shop.category', ['path' => $category->slug_path]) }}"
                               class="inline-flex items-center group">
                                <h2 class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $category->name }}
                                </h2>
                                <svg class="w-6 h-6 ml-2 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            @if($category->description)
                                <p class="text-gray-600 mt-2">{{ $category->description }}</p>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($category->children->take(4) as $subcategory)
                                <a href="{{ route('shop.category', ['path' => $subcategory->slug_path]) }}"
                                   class="group block bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">

                                    @if($subcategory->image)
                                        <div class="aspect-square overflow-hidden bg-gray-100">
                                            <img src="{{ asset('storage/' . $subcategory->image) }}"
                                                 alt="{{ $subcategory->name }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                        </div>
                                    @else
                                        <div class="aspect-square bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Contenu -->
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                            {{ $subcategory->name }}
                                        </h3>

                                        @php
                                            $productCount = $subcategory->products->count();
                                            $childrenCount = $subcategory->children->count();
                                        @endphp

                                        <div class="flex items-center text-sm text-gray-500 mt-2">
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
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Lien "Voir tout" si plus de 4 sous-catégories -->
                        @if($category->children->count() > 4)
                            <div class="mt-6 text-center">
                                <a href="{{ route('shop.category', ['path' => $category->slug_path]) }}"
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                    Voir toutes les catégories {{ $category->name }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </section>
                @endif
            @endforeach
        </div>

        @if($categories->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Aucune catégorie disponible pour le moment.</p>
            </div>
        @endif
    </div>
</x-app-layout>
