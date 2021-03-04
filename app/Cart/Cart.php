<?php

namespace App\Cart;

use App\Models\User;

class Cart
{
    protected User $user;
    protected bool $changed = false;
    protected $shipping;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function products()
    {
        return $this->user->cart;
    }

    public function add($products): void
    {
        $this->user->cart()->syncWithoutDetaching(
            $this->getStorePayload($products)
        );
    }

    public function update($productId, $quantity): void
    {
        $this->user->cart()->updateExistingPivot($productId, [
            'quantity' => $quantity
        ]);
    }

    public function delete($productId): void
    {
        $this->user->cart()->detach($productId);
    }

    public function sync(): void
    {
        $this->user->cart->each(function ($product) {
            $quantity = $product->minStock($product->pivot->quantity);

            if ($quantity != $product->pivot->quantity) {
                $this->changed = true;
            }

            $product->pivot->update([
                'quantity' => $quantity
            ]);
        });
    }

    public function hasChanged(): bool
    {
        return $this->changed;
    }

    public function empty(): void
    {
        $this->user->cart()->detach();
    }

    public function isEmpty(): bool
    {
        return $this->user->cart->sum('pivot.quantity') <= 0;
    }

    public function subtotal(): Money
    {
        $subtotal = $this->user->cart->sum(function ($product) {
            return $product->price->amount() * $product->pivot->quantity;
        });

        return new Money($subtotal);
    }

    public function total(): Money
    {
        if ($this->shipping) {
            return $this->subtotal()->add($this->shipping->price);
        }

        return $this->subtotal();
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
