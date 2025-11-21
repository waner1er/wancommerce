@php
use Illuminate\Support\Facades\Storage;
@endphp

<div class="grid grid-cols-1 gap-8">
    @if (session()->has('message'))
    <div class="col-span-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('message') }}
    </div>
    @endif

    @foreach ($categories as $category)
    <div>
        @if ($category->products->isNotEmpty())
        @if($categories->count() > 1)
        <div class="flex items-center gap-4 mb-4">
            @if(!empty($category->image))
            <img src="{{ asset('storage/' . $category->image) }}"
            alt="{{ $category->name }}"
            class="w-16 h-16 object-cover rounded-lg"
            onerror="this.style.display='none'">
            @endif
            <div class="flex-1 flex justify-between items-center">
                <h2 class="text-xl font-bold">{{ $category->name }}</h2>
                <a href="{{ route('shop.category', ['path' => $category->slug_path]) }}" class="text-blue-600 hover:text-blue-800">
                    Voir plus →
                </a>
            </div>
        </div>
        @else
        @if(!empty($category->image))
        <div class="mb-6">
            <img src="{{ asset('storage/' . $category->image) }}"
            alt="{{ $category->name }}"
            class="w-full h-48 object-cover rounded-lg"
            onerror="this.style.display='none'">
        </div>
        @endif
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">
            @foreach ($category->products as $product)
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow">
                <a href="{{ route('product.show', ['sku' => $product->sku]) }}" class="block">
                    <h3 class="text-lg font-semibold mb-2 hover:text-blue-600 transition-colors">{{ $product->name }}</h3>
                    @if(!empty($product->image))
                    <div class="flex items-center justify-center bg-gray-50 rounded-lg mb-4">
                        <img src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="h-48 object-contain p-2"
                        onerror="this.style.display='none'">
                    </div>
                    @endif
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $product->description }}</p>

                    <div class="text-green-600 font-bold">{{ number_format($product->getPriceTTC(), 2) }}€ TTC</div>
                    <div class="text-gray-500 text-sm">{{ number_format($product->getPriceHT(), 2) }}€ HT</div>
                </a>
                <button
                wire:click="addToCart({{ $product->id }})"
                class="mt-4 w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                {{ __('wancommerce.add_to_cart') }}
            </button>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endforeach
</div>
