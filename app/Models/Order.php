<?php

namespace App\Models;

use App\Cart\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    public const PENDING        = 'pending';
    public const PROCESSING     = 'processing';
    public const PAYMENT_FAILED = 'payment_failed';
    public const COMPLETED      = 'completed';

    protected $fillable = [
        'status',
        'address_id',
        'shipping_method_id',
        //'payment_method_id',
        'subtotal'
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($order) {
            $order->status = self::PENDING;
        });
    }

    public function getSubtotalAttribute($subtotal): Money
    {
        return new Money($subtotal);
    }

    public function total()
    {
        return $this->subtotal->add($this->shippingMethod->price);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

//    public function paymentMethod(): BelongsTo
//    {
//        return $this->belongsTo(PaymentMethod::class);
//    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_order')
            ->withPivot(['quantity'])
            ->withTimestamps();
    }
}
