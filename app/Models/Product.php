<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'video_url',
        'stock',
        'buy_price',
        'sell_price',
        'discount_price',
        'is_active',
        'free_delivery',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'free_delivery' => 'boolean',
        'stock' => 'integer',
        'buy_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images->first()?->image_path;
    }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->sell_price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price && $this->sell_price > 0) {
            return round((($this->sell_price - $this->discount_price) / $this->sell_price) * 100);
        }
        return 0;
    }

    public function hasDiscount(): bool
    {
        return !is_null($this->discount_price) && $this->discount_price > 0 && $this->discount_price < $this->sell_price;
    }
}
