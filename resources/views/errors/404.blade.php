<x-app-layout>
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto text-center">
            <div class="mb-8">
                <div class="text-2xl font-bold text-gray-200 mb-4">404</div>
                <svg class="w-8 h-8 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-3">
                Oups ! Page introuvable
            </h1>

            <p class="text-base text-gray-600 mb-6">
                La page que vous recherchez n'existe pas ou a été déplacée.
            </p>

            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-amber-800">
                    💡 Vérifiez l'URL ou utilisez notre menu de navigation pour trouver ce que vous cherchez.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center mb-8">
                <a href="{{ route('shop.index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Voir la boutique
                </a>

                <a href="{{ url('/') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Page d'accueil
                </a>
            </div>

            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    Catégories populaires
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @php
                        $popularCategories = \App\Models\Category::whereNull('parent_id')
                            ->whereHas('products')
                            ->withCount('products')
                            ->orderBy('products_count', 'desc')
                            ->limit(4)
                            ->get();
                    @endphp

                    @foreach($popularCategories as $category)
                    <a href="{{ route('shop.category', ['path' => $category->slug_path]) }}"
                       class="p-4 bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition text-center">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $category->products_count }} produits</p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
