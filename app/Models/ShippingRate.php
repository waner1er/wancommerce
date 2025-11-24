<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = [
        'name',
        'carrier',
        'weight_min',
        'weight_max',
        'price',
        'zone',
        'delivery_days_min',
        'delivery_days_max',
        'is_active',
    ];

    protected $casts = [
        'weight_min' => 'decimal:3',
        'weight_max' => 'decimal:3',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Check if this rate can handle the given weight
     */
    public function canHandleWeight(float $weight): bool
    {
        return $weight >= $this->weight_min && $weight <= $this->weight_max;
    }

    /**
     * Get formatted delivery time
     */
    public function getDeliveryTimeAttribute(): ?string
    {
        if (!$this->delivery_days_min || !$this->delivery_days_max) {
            return null;
        }

        if ($this->delivery_days_min === $this->delivery_days_max) {
            return "{$this->delivery_days_min} jour" . ($this->delivery_days_min > 1 ? 's' : '');
        }

        return "{$this->delivery_days_min}-{$this->delivery_days_max} jours";
    }
}
