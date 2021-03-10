<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Collections\ProductVariationCollection;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariation extends Model
{
    use HasFactory, HasPrice;

    public function type(): HasOne
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id')->orderBy('name');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceAttribute($value): Money
    {
        if ($value === null) {
            return $this->product->price;
        }

        return new Money($value);
    }

    public function priceVaries(): bool
    {
        return $this->price->amount() !== $this->product->price->amount();
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function stock(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'product_variation_stock_view')
        ->withPivot([
            'stock',
            'in_stock'
        ]);
    }

    public function inStock(): bool
    {
        return $this->stockCount() > 0;
    }

    public function stockCount()
    {
        return $this->stock->sum('pivot.stock');
    }

    public function minStock($count)
    {
        return min($this->stockCount(), $count);
    }

    public function newCollection(array $models = []): ProductVariationCollection
    {
        return new ProductVariationCollection($models);
    }
}
