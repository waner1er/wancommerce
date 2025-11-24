<div class="max-w-4xl mx-auto px-4 py-8">
    <livewire:breadcrumb :items="[
        ['label' => 'Panier', 'url' => '/cart'],
        ['label' => 'Livraison', 'url' => null]
    ]" />

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Adresse de livraison</h1>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="lg:col-span-2">
            <form wire:submit.prevent="submitShipping" class="space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Informations personnelles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                            <input type="text" wire:model="first_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                            <input type="text" wire:model="last_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Adresse de livraison</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                            <input type="text" wire:model="address" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Complément d'adresse</label>
                            <input type="text" wire:model="address_complement" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Code postal *</label>
                                <input type="text" wire:model="postal_code" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ville *</label>
                                <input type="text" wire:model="city" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pays *</label>
                            <select wire:model="country" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="France">France</option>
                                <option value="Belgique">Belgique</option>
                                <option value="Suisse">Suisse</option>
                                <option value="Luxembourg">Luxembourg</option>
                            </select>
                            @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                            <input type="tel" wire:model="phone" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Shipping Methods -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Mode de livraison</h2>
                    <p class="text-sm text-gray-600 mb-4">Poids total du colis : <strong>{{ $cartWeight }} kg</strong></p>

                    @if ($availableRates && $availableRates->count() > 0)
                        <div class="space-y-3">
                            @foreach ($availableRates as $rate)
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $selectedRateId == $rate->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                    <input type="radio" wire:model="selectedRateId" value="{{ $rate->id }}" class="mr-3">
                                    <div class="flex-1">
                                        <div class="font-medium">{{ $rate->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $rate->carrier }}</div>
                                        @if ($rate->delivery_time)
                                            <div class="text-sm text-gray-500">Livraison en {{ $rate->delivery_time }}</div>
                                        @endif
                                    </div>
                                    <div class="text-lg font-semibold">{{ number_format($rate->price, 2, ',', ' ') }} € HT</div>
                                </label>
                            @endforeach
                        </div>
                        @error('selectedRateId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    @else
                        <p class="text-red-600">Aucun mode de livraison disponible pour ce poids.</p>
                    @endif
                </div>

                <div class="flex justify-between">
                    <a href="/cart" class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Retour au panier
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 cursor-pointer" @if(!$availableRates || $availableRates->count() == 0) disabled @endif>
                        Continuer vers le paiement
                    </button>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                <h2 class="text-xl font-semibold mb-4">Récapitulatif</h2>
                <div class="space-y-3">
                    @foreach ($cart->items as $item)
                        <div class="flex justify-between text-sm">
                            <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span>{{ number_format($item->product->getPriceTTC() * $item->quantity, 2, ',', ' ') }} €</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t mt-4 pt-4">
                    <div class="flex justify-between font-semibold text-lg">
                        <span>Total produits</span>
                        <span>{{ number_format(collect($cart->items)->sum(fn($item) => $item->product->getPriceTTC() * $item->quantity), 2, ',', ' ') }} €</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
