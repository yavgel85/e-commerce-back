<?php

namespace App\Models\Traits;

use App\Cart\Money;

trait HasPrice
{
    public function getPriceAttribute($value): Money
    {
        return new Money($value);
    }

    public function getFormattedPriceAttribute(): string
    {
       return $this->price->formatted();
    }
}
