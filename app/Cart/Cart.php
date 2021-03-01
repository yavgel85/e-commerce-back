<?php

namespace App\Cart;

use App\Models\User;

class Cart
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function add($products): void
    {
        $this->user->cart()->syncWithoutDetaching(
            $this->getStorePayload($products)
        );
    }

    protected function getStorePayload($products): array
    {
        return collect($products)->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id'])
            ];
        })->toArray();
    }

    protected function getCurrentQuantity($productId): int
    {
        if ($product = $this->user->cart->where('id', $productId)->first()) {
            return $product->pivot->quantity;
        }

        return 0;
    }
}
