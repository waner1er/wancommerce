<?php

namespace App\Services;

use App\Models\TaxRate;
use Illuminate\Support\Facades\Session;

class TaxService
{
    public function getUserCountryCode(): string
    {
        if (Session::has('user_country')) {
            return Session::get('user_country');
        }

        return 'FR';
    }

    public function setUserCountry(string $countryCode): void
    {
        Session::put('user_country', strtoupper($countryCode));
    }

    public function getTaxRate(?string $countryCode = null): TaxRate
    {
        $countryCode = $countryCode ?? $this->getUserCountryCode();

        $taxRate = TaxRate::getByCountryCode($countryCode);

        if (!$taxRate) {
            $taxRate = TaxRate::getDefault();
        }

        return $taxRate ?? $this->createDefaultTaxRate();
    }

    public function calculatePriceWithTax(float $priceHT, ?string $countryCode = null): float
    {
        $taxRate = $this->getTaxRate($countryCode);
        return $taxRate->calculatePriceWithTax($priceHT);
    }

    public function calculateTaxAmount(float $priceHT, ?string $countryCode = null): float
    {
        $taxRate = $this->getTaxRate($countryCode);
        return $taxRate->calculateTaxAmount($priceHT);
    }

    private function createDefaultTaxRate(): TaxRate
    {
        return TaxRate::create([
            'country_code' => 'FR',
            'country_name' => 'France',
            'rate' => 20.00,
            'is_default' => true,
        ]);
    }
}
