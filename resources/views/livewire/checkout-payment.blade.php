<div class="max-w-4xl mx-auto px-4 py-8">
    <livewire:breadcrumb :items="[
        ['label' => 'Panier', 'url' => '/cart'],
        ['label' => 'Livraison', 'url' => '/checkout/shipping'],
        ['label' => 'Paiement', 'url' => null]
    ]" />

    <h1 class="text-3xl font-bold text-gray-900 mb-8">Paiement</h1>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Payment Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Shipping Address Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Adresse de livraison</h2>
                <div class="text-gray-700">
                    <p class="font-medium">{{ $shippingAddress['first_name'] }} {{ $shippingAddress['last_name'] }}</p>
                    <p>{{ $shippingAddress['address'] }}</p>
                    @if ($shippingAddress['address_complement'])
                        <p>{{ $shippingAddress['address_complement'] }}</p>
                    @endif
                    <p>{{ $shippingAddress['postal_code'] }} {{ $shippingAddress['city'] }}</p>
                    <p>{{ $shippingAddress['country'] }}</p>
                    <p class="mt-2">Tél : {{ $shippingAddress['phone'] }}</p>
                </div>
                <a href="/checkout/shipping" class="text-blue-600 hover:underline text-sm mt-3 inline-block">Modifier</a>
            </div>

            <!-- Shipping Method Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Mode de livraison</h2>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium">{{ $shippingRate->name }}</p>
                        <p class="text-sm text-gray-600">{{ $shippingRate->carrier }}</p>
                        @if ($shippingRate->delivery_time)
                            <p class="text-sm text-gray-500">Livraison en {{ $shippingRate->delivery_time }}</p>
                        @endif
                    </div>
                    <p class="font-semibold">{{ number_format($this->shippingCostTTC, 2, ',', ' ') }} € TTC</p>
                </div>
                <a href="/checkout/shipping" class="text-blue-600 hover:underline text-sm mt-3 inline-block">Modifier</a>
            </div>

            <!-- Payment Method -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Mode de paiement</h2>
                <div class="space-y-3">
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $paymentMethod == 'card' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                        <input type="radio" wire:model="paymentMethod" value="card" class="mr-3">
                        <div class="flex-1">
                            <div class="font-medium">Carte bancaire</div>
                            <div class="text-sm text-gray-600">Paiement sécurisé par carte</div>
                        </div>
                        <div class="flex gap-2">
                            <svg class="h-8" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="32" rx="4" fill="#1434CB"/><circle cx="18" cy="16" r="8" fill="#EB001B"/><circle cx="30" cy="16" r="8" fill="#F79E1B"/><path d="M24 10.5c1.5 1.3 2.5 3.2 2.5 5.5s-1 4.2-2.5 5.5c-1.5-1.3-2.5-3.2-2.5-5.5s1-4.2 2.5-5.5z" fill="#FF5F00"/></svg>
                            <svg class="h-8" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="32" rx="4" fill="#0066B2"/><rect x="8" y="12" width="32" height="8" fill="white"/><path d="M8 8h32v4H8V8z" fill="#F7B600"/></svg>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $paymentMethod == 'paypal' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                        <input type="radio" wire:model="paymentMethod" value="paypal" class="mr-3">
                        <div class="flex-1">
                            <div class="font-medium">PayPal</div>
                            <div class="text-sm text-gray-600">Paiement via PayPal</div>
                        </div>
                        <svg class="h-8" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="32" rx="4" fill="#0070BA"/><path d="M18.5 9h6c2.5 0 4.5 2 4.5 4.5 0 2.5-2 4.5-4.5 4.5h-3l-1 5h-2l3-14zm8 4.5c0-1.4-1.1-2.5-2.5-2.5h-4l-1.5 7h2c1.4 0 2.5-1.1 2.5-2.5v-2z" fill="white"/></svg>
                    </label>
                </div>

                <div :class="$wire.paymentMethod !== 'card' ? 'hidden' : ''" class="mt-6 p-4 bg-gray-50 rounded border border-gray-200">
                    <p class="text-sm text-gray-600 mb-4">
                        <strong>Note :</strong> Ceci est une démo. Aucun paiement réel ne sera effectué.
                        Dans un environnement de production, vous intégreriez Stripe ou un autre processeur de paiement ici.
                    </p>
                </div>

                <div :class="$wire.paymentMethod !== 'paypal' ? 'hidden' : ''" class="mt-6">
                    <!-- PayPal Button -->
                    <button
                        wire:click="redirectToPayPal"
                        wire:loading.attr="disabled"
                        class="w-full bg-[#0070ba] hover:bg-[#005ea6] text-white font-semibold py-4 px-6 rounded-lg flex items-center justify-center gap-3 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l1.048-6.645c.082-.518.526-.9 1.05-.9h2.19c4.298 0 7.664-1.747 8.647-6.797.03-.149.054-.294.077-.437.161-1.031.161-1.782-.013-2.25a2.564 2.564 0 0 0-.774-.891z"/>
                        </svg>
                        <span wire:loading.remove wire:target="redirectToPayPal">
                            Payer avec PayPal
                        </span>
                        <span wire:loading wire:target="redirectToPayPal">
                            Chargement...
                        </span>
                    </button>

                    <!-- Messages -->
                    <div id="paypal-error" class="hidden mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded"></div>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="/checkout/shipping" class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Retour
                </a>
                <button
                    x-show="$wire.paymentMethod !== 'paypal'"
                    wire:click="processPayment"
                    class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 cursor-pointer font-semibold">
                    Valider et payer {{ number_format($this->totalWithShipping, 2, ',', ' ') }} €
                </button>
            </div>
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
                <div class="border-t mt-4 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span>Sous-total</span>
                        <span>{{ number_format($this->cartTotal, 2, ',', ' ') }} €</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Frais de port</span>
                        <span>{{ number_format($this->shippingCostTTC, 2, ',', ' ') }} €</span>
                    </div>
                    <div class="flex justify-between font-semibold text-lg border-t pt-2">
                        <span>Total</span>
                        <span>{{ number_format($this->totalWithShipping, 2, ',', ' ') }} €</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@php
    $paypalClientId = \App\Services\PayPalService::getClientId();
@endphp

@if(!$paypalClientId)
<script>
    // PayPal not configured - disable PayPal payment option
    document.addEventListener('livewire:initialized', () => {
        const paypalRadio = document.querySelector('input[value="paypal"]');
        if (paypalRadio) {
            paypalRadio.disabled = true;
            paypalRadio.closest('label').style.opacity = '0.5';
            paypalRadio.closest('label').style.cursor = 'not-allowed';

            const paypalLabel = paypalRadio.closest('label');
            const description = paypalLabel.querySelector('.text-sm.text-gray-600');
            if (description) {
                description.textContent = 'PayPal non configuré (ajoutez PAYPAL_CLIENT_ID dans .env)';
            }
        }
    });
</script>
@endif
@endpush
