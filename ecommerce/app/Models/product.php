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
        'sku',
        'category',
        'price',
        'original_price',
        'description',
        'image',
        'status',
        'status_label',
        'rating',
        'stock',
        'is_featured',
        'is_new_drop',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'stock' => 'integer',
        'is_featured' => 'boolean',
        'is_new_drop' => 'boolean',
    ];

    /**
     * Get all cart items for this product.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include new drop products.
     */
    public function scopeNewDrops($query)
    {
        return $query->where('is_new_drop', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->whereRaw('LOWER(category) = ?', [strtolower($category)]);
    }

    /**
     * Check if the product has a discount.
     */
    public function hasDiscount(): bool
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /**
     * Get the discount percentage (accessor for discount_percent).
     */
    public function getDiscountPercentAttribute(): int
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    public function getDiscountPercentValueAttribute(): int
    {
        return $this->discount_percent;
    }
}