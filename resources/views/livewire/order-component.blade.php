<div class="max-w-7xl mx-auto p-6">
    @livewire('breadcrumb', ['items' => [['label' => 'Mes Commandes']]])

    <h1 class="text-3xl font-bold mb-6">Mes Commandes</h1>

    @foreach ($orders as $order)
    <div class="mb-6 p-4 border rounded-lg shadow-sm">
        <h3 class="text-lg font-semibold mb-2">Commande #{{ $order->order_number }} - {{ $order->created_at->format('d/m/Y') }}</h3>

        <div class="divide-y divide-gray-200">
            @foreach ($order->items as $item)
            <div class="py-2 flex justify-between items-center">
                <div>
                    <h4 class="font-medium">{{ $item->product->name }}</h4>
                    <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($item->price, 2) }}€ HT</p>
                </div>
                <div class="text-right">
                    <div class="text-green-600 font-bold">
                        {{ number_format($item->price * $item->quantity * 1.20, 2) }}€ TTC
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ number_format($item->price * $item->quantity, 2) }}€ HT
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 pt-4 border-t">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Total HT:</span>
                <span class="font-semibold">{{ number_format($order->total / 1.20, 2) }}€</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">TVA (20%):</span>
                <span class="font-semibold">{{ number_format($order->total - ($order->total / 1.20), 2) }}€</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xl font-semibold">Total TTC:</span>
                <span class="text-2xl font-bold text-green-600">{{ number_format($order->total, 2) }}€</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
