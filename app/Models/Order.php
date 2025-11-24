<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total',
        'status',
        'shipping_cost',
        'shipping_rate_id',
        'shipping_address',
        'total_weight',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'shipping_cost' => 'decimal:2',
        'total_weight' => 'decimal:3',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingRate(): BelongsTo
    {
        return $this->belongsTo(ShippingRate::class);
    }

    /**
     * Get total including shipping
     */
    public function getTotalWithShippingAttribute(): float
    {
        return $this->total + $this->shipping_cost;
    }

    public static function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(uniqid());
    }
}
