<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
}
