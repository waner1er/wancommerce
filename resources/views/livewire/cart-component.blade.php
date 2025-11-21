<div class="max-w-7xl mx-auto p-6">
    @livewire('breadcrumb', ['items' => [['label' => 'Mon Panier']]])

    <h1 class="text-3xl font-bold mb-6">Mon Panier</h1>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($items->isEmpty())
        <div class="bg-gray-100 border border-gray-300 rounded-lg p-8 text-center">
            <p class="text-gray-600 text-lg mb-4">Votre panier est vide</p>
            <a href="/" class="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">
                Continuer mes achats
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md">
            <div class="divide-y divide-gray-200">
                @foreach ($items as $item)
                    <div class="p-6 flex items-center justify-between" wire:key="item-{{ $item->id }}">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold">{{ $item->product->name }}</h3>
                            <p class="text-gray-600">Prix unitaire: {{ number_format($item->product->getPriceTTC(), 2) }}€ TTC</p>
                            <p class="text-gray-500 text-sm">{{ number_format($item->price, 2) }}€ HT</p>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <button
                                    wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                    class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">
                                    -
                                </button>
                                <span class="px-4 py-1 bg-gray-100 rounded">{{ $item->quantity }}</span>
                                <button
                                    wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                    class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">
                                    +
                                </button>
                            </div>

                            <div class="text-lg font-bold text-green-600 w-24 text-right">
                                {{ number_format($item->product->getPriceTTC() * $item->quantity, 2) }}€
                            </div>

                            <button
                                wire:click="removeItem({{ $item->id }})"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Supprimer
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-200 p-6 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xl font-semibold">Total:</span>
                    <span class="text-2xl font-bold text-green-600">{{ number_format($total, 2) }}€</span>
                </div>

                <div class="flex justify-between items-center space-x-4">
                    <a href="/" class="px-6 py-3 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Continuer mes achats
                    </a>

                    @auth
                        <button
                            wire:click="createOrder"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700 transition-opacity">
                            <span wire:loading.remove wire:target="createOrder">Valider la commande</span>
                            <span wire:loading wire:target="createOrder">Traitement en cours...</span>
                        </button>
                    @else
                        <a href="/login" class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Se connecter pour commander
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    @endif
</div>
