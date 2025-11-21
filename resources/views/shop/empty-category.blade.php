<x-app-layout>
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto text-center">
            <div class="mb-8">
                <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                Aucun produit disponible
            </h1>

            <p class="text-lg text-gray-600 mb-8">
                Nous sommes désolés, la catégorie <span class="font-semibold text-gray-900">{{ $categoryName }}</span> ne contient actuellement aucun produit.
            </p>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <p class="text-blue-800">
                    💡 Cette catégorie sera bientôt enrichie avec de nouveaux produits.
                    En attendant, découvrez nos autres catégories !
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('shop.index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Retour à la boutique
                </a>

                @if($parentCategory)
                <a href="{{ route('shop.category', ['path' => $parentCategory->slug_path]) }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à {{ $parentCategory->name }}
                </a>
                @endif
            </div>

            @if($suggestedCategories && $suggestedCategories->count() > 0)
            <div class="mt-12">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                    Catégories suggérées
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($suggestedCategories as $suggested)
                    <a href="{{ route('shop.category', ['path' => $suggested->slug_path]) }}"
                       class="p-4 bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $suggested->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $suggested->products_count }} produits</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
