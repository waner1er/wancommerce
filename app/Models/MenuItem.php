<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class MenuItem extends Model
{
    protected $fillable = [
        'parent_id',
        'title',
        'type',
        'category_id',
        'url',
        'order',
        'is_visible',
        'icon',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    public function scopeRootItems(Builder $query): Builder
    {
        return $query->whereNull('parent_id')->orderBy('order');
    }

    public function getUrlAttribute($value): ?string
    {
        // Si c'est un lien personnalisé stocké en base
        if ($this->type === 'custom_link' && $value) {
            return $value;
        }

        // Si c'est un lien de catégorie
        if ($this->type === 'category' && $this->category) {
            return route('shop.category', ['path' => $this->category->slug_path]);
        }

        // Par défaut retourner l'URL stockée ou #
        return $value ?? '#';
    }
}
