<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'sku',
        'category_id',
        'slug',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceHT(): float
    {
        return (float) $this->price;
    }

    public function getPriceTTC(?string $countryCode = null): float
    {
        $taxService = app(\App\Services\TaxService::class);
        return $taxService->calculatePriceWithTax($this->getPriceHT(), $countryCode);
    }

    public function getTaxAmount(?string $countryCode = null): float
    {
        $taxService = app(\App\Services\TaxService::class);
        return $taxService->calculateTaxAmount($this->getPriceHT(), $countryCode);
    }

    public function getTaxRate(?string $countryCode = null): TaxRate
    {
        $taxService = app(\App\Services\TaxService::class);
        return $taxService->getTaxRate($countryCode);
    }
}
