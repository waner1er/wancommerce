<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    @php
        $breadcrumbItems = [];

        // Construire le fil d'ariane
        $ancestors = [];
        $current = $product->category;
        while ($current) {
            array_unshift($ancestors, $current);
            $current = $current->parent;
        }

        foreach ($ancestors as $ancestor) {
            $breadcrumbItems[] = [
                'label' => $ancestor->name,
                'url' => route('shop.category', ['path' => $ancestor->slug_path])
            ];
        }

        $breadcrumbItems[] = ['label' => $product->name];
    @endphp
    @livewire('breadcrumb', ['items' => $breadcrumbItems])

    <!-- Messages flash -->
    @if (session()->has('message'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    <!-- Contenu principal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Galerie d'images -->
        <div>
            <div class="bg-gray-50 rounded-lg overflow-hidden">
                @if(!empty($product->image))
                    <div class="aspect-square flex items-center justify-center p-8">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="max-w-full max-h-full object-contain">
                    </div>
                @else
                    <div class="aspect-square bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                        <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        <!-- Informations produit -->
        <div>
            <div class="mb-4">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

                <!-- SKU -->
                <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
            </div>

            <!-- Prix -->
            <div class="mb-6 pb-6 border-b">
                <div class="flex items-baseline gap-3">
                    <span class="text-4xl font-bold text-green-600">
                        {{ number_format($product->getPriceTTC(), 2) }}€
                    </span>
                    <span class="text-lg text-gray-500">TTC</span>
                </div>
                <p class="text-sm text-gray-600 mt-1">
                    {{ number_format($product->getPriceHT(), 2) }}€ HT
                    <span class="text-gray-500">
                        (TVA {{ number_format($product->getTaxAmount(), 2) }}€)
                    </span>
                </p>
            </div>

            <!-- Stock -->
            <div class="mb-6">
                @if($product->stock > 0)
                    <div class="flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">En stock ({{ $product->stock }} disponibles)</span>
                    </div>
                @else
                    <div class="flex items-center text-red-600">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">Rupture de stock</span>
                    </div>
                @endif
            </div>

            <!-- Sélecteur de quantité et bouton d'ajout au panier -->
            @if($product->stock > 0)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantité</label>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button
                                wire:click="decrementQuantity"
                                class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <span class="px-6 py-2 text-lg font-semibold">{{ $quantity }}</span>
                            <button
                                wire:click="incrementQuantity"
                                class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition-colors"
                                @if($quantity >= $product->stock) disabled @endif>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>

                        <button
                            wire:click="addToCart"
                            wire:loading.attr="disabled"
                            class="flex-1 bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold text-lg flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span wire:loading.remove wire:target="addToCart">Ajouter au panier</span>
                            <span wire:loading wire:target="addToCart">Ajout en cours...</span>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Description -->
            @if($product->description)
                <div class="mb-6 pt-6 border-t">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Description</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                </div>
            @endif

            <!-- Catégorie -->
            <div class="pt-6 border-t">
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Catégorie</h2>
                <a href="{{ route('shop.category', ['path' => $product->category->slug_path]) }}"
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    {{ $product->category->name }}
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
