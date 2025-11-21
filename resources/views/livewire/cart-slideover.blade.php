<div>
    <!-- Overlay -->
    <div
        x-data="{ open: @entangle('isOpen') }"
        @keydown.escape.window="open = false"
        class="relative z-100"
        x-show="open"
        style="display: none;"
    >
        <!-- Background overlay -->
        <div
            x-show="open"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/20 backdrop-blur-sm"
            @click="$wire.closeCart()"
        ></div>

        <!-- Slideover Panel -->
        <div
            x-show="open"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 w-full max-w-md bg-white dark:bg-[#1a1a1a] shadow-xl flex flex-col"
        >
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('wancommerce.cart') }}
                </h2>
                <button
                    wire:click="closeCart"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6">
                @if($items->count() > 0)
                    <div class="space-y-4">
                        @foreach($items as $item)
                            <div class="flex gap-4 p-4 border dark:border-gray-700 rounded-lg" wire:key="item-{{ $item->id }}">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $item->product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ number_format($item->product->getPriceTTC(), 2) }}€ TTC
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ number_format($item->price, 2) }}€ HT
                                    </p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <button
                                            wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                            class="w-8 h-8 flex items-center justify-center border rounded hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800 dark:text-gray-100"
                                        >
                                            -
                                        </button>
                                        <span class="w-8 text-center dark:text-gray-100">{{ $item->quantity }}</span>
                                        <button
                                            wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                            class="w-8 h-8 flex items-center justify-center border rounded hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800 dark:text-gray-100"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end justify-between">
                                    <button
                                        wire:click="removeItem({{ $item->id }})"
                                        class="text-red-500 hover:text-red-700"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ number_format($item->product->getPriceTTC() * $item->quantity, 2) }}€
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">Votre panier est vide</p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            @if($items->count() > 0)
                <div class="border-t dark:border-gray-700 p-6 space-y-4">
                    <div class="flex justify-between text-lg font-semibold">
                        <span class="dark:text-gray-100">{{ __('wancommerce.total') }}</span>
                        <span class="text-green-600">{{ number_format($total, 2) }}€</span>
                    </div>
                    <a
                        href="{{ route('cart') }}"
                        wire:click="closeCart"
                        class="block w-full py-3 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition"
                    >
                        Voir le panier complet
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
