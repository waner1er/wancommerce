<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\ShippingRate;
use Illuminate\Support\Collection;

class ShippingService
{
    /**
     * Calculate the total weight of a cart
     */
    public function calculateCartWeight(Cart $cart): float
    {
        $totalWeight = 0;

        foreach ($cart->items as $item) {
            $totalWeight += ($item->product->weight ?? 0) * $item->quantity;
        }

        return round($totalWeight, 3);
    }

    /**
     * Get available shipping rates for a given weight
     */
    public function getAvailableRates(float $weight, string $zone = 'France'): Collection
    {
        return ShippingRate::where('is_active', true)
            ->where('zone', $zone)
            ->where('weight_min', '<=', $weight)
            ->where('weight_max', '>=', $weight)
            ->orderBy('price', 'asc')
            ->get();
    }

    /**
     * Get the cheapest shipping rate for a weight
     */
    public function getCheapestRate(float $weight, string $zone = 'France'): ?ShippingRate
    {
        return $this->getAvailableRates($weight, $zone)->first();
    }

    /**
     * Calculate shipping cost with tax
     */
    public function calculateShippingCostTTC(ShippingRate $shippingRate): float
    {
        $taxService = app(TaxService::class);
        return $taxService->calculatePriceWithTax($shippingRate->price);
    }

    /**
     * Validate if a shipping address is complete
     */
    public function validateAddress(array $address): array
    {
        $required = ['first_name', 'last_name', 'address', 'city', 'postal_code', 'country'];
        $errors = [];

        foreach ($required as $field) {
            if (empty($address[$field])) {
                $errors[$field] = "Le champ " . $this->translateField($field) . " est requis.";
            }
        }

        return $errors;
    }

    private function translateField(string $field): string
    {
        return match($field) {
            'first_name' => 'prénom',
            'last_name' => 'nom',
            'address' => 'adresse',
            'city' => 'ville',
            'postal_code' => 'code postal',
            'country' => 'pays',
            'phone' => 'téléphone',
            default => $field,
        };
    }
}
