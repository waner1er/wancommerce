<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <!-- Success Icon -->
        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">Commande confirmée !</h1>
        <p class="text-gray-600 mb-8">Merci pour votre commande. Un email de confirmation vous a été envoyé.</p>

        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <div class="text-sm text-gray-600 mb-2">Numéro de commande</div>
            <div class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</div>
        </div>

        <!-- Order Details -->
        <div class="text-left mb-8">
            <h2 class="text-xl font-semibold mb-4">Détails de la commande</h2>

            <!-- Products -->
            <div class="border rounded-lg p-4 mb-4">
                <h3 class="font-medium mb-3">Produits</h3>
                <div class="space-y-2">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span>{{ number_format($item->product->getPriceTTC() * $item->quantity, 2, ',', ' ') }} €</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="border rounded-lg p-4 mb-4">
                <h3 class="font-medium mb-3">Adresse de livraison</h3>
                <div class="text-sm text-gray-700">
                    <p class="font-medium">{{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                    @if (!empty($order->shipping_address['address_complement']))
                        <p>{{ $order->shipping_address['address_complement'] }}</p>
                    @endif
                    <p>{{ $order->shipping_address['postal_code'] ?? '' }} {{ $order->shipping_address['city'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['country'] ?? '' }}</p>
                    <p class="mt-2">Tél : {{ $order->shipping_address['phone'] ?? '' }}</p>
                </div>
            </div>

            <!-- Shipping Method -->
            <div class="border rounded-lg p-4 mb-4">
                <h3 class="font-medium mb-3">Mode de livraison</h3>
                <div class="flex justify-between items-start text-sm">
                    <div>
                        <p class="font-medium">{{ $order->shippingRate->name }}</p>
                        <p class="text-gray-600">{{ $order->shippingRate->carrier }}</p>
                        @if ($order->shippingRate->delivery_time)
                            <p class="text-gray-500">Livraison en {{ $order->shippingRate->delivery_time }}</p>
                        @endif
                    </div>
                    <p>{{ number_format($order->shipping_cost, 2, ',', ' ') }} € HT</p>
                </div>
            </div>

            <!-- Total -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span>Sous-total</span>
                        <span>{{ number_format($order->total, 2, ',', ' ') }} €</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Frais de port HT</span>
                        <span>{{ number_format($order->shipping_cost, 2, ',', ' ') }} €</span>
                    </div>
                    <div class="flex justify-between font-semibold text-lg border-t pt-2">
                        <span>Total</span>
                        <span>{{ number_format($order->total_with_shipping, 2, ',', ' ') }} €</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/orders" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 cursor-pointer">
                Voir mes commandes
            </a>
            <a href="/" class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
