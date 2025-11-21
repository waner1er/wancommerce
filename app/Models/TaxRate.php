<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    protected $fillable = [
        'country_code',
        'country_name',
        'rate',
        'is_default',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'is_default' => 'boolean',
    ];

    public static function getDefault(): ?self
    {
        return self::where('is_default', true)->first() ?? self::first();
    }

    public static function getByCountryCode(string $countryCode): ?self
    {
        return self::where('country_code', strtoupper($countryCode))->first();
    }

    public function calculateTaxAmount(float $priceHT): float
    {
        return round($priceHT * ($this->rate / 100), 2);
    }

    public function calculatePriceWithTax(float $priceHT): float
    {
        return round($priceHT * (1 + $this->rate / 100), 2);
    }
}
