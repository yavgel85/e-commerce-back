<?php

namespace App\Models;

use App\Models\Traits\CanBeScoped;
use App\Models\Traits\HasPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, CanBeScoped, HasPrice;

    protected $fillable = ['name', 'slug', 'description', 'price'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'asc');
    }

    public function inStock(): bool
    {
        return $this->stockCount() > 0;
    }

    public function stockCount()
    {
        return $this->variations->sum(function ($variation) {
            return $variation->stockCount();
        });
    }
}
