<?php

namespace App\Models;

use App\Scoping\Scoper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

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

    public function scopeWithScopes(Builder $builder, $scopes = []): Builder
    {
        return (new Scoper(request()))->apply($builder, $scopes);
    }
}
