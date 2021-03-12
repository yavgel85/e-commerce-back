<?php

namespace App\Models;

use App\Models\Traits\CanBeDefault;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    use HasFactory, CanBeDefault;

    protected $fillable = [
        'card_type',
        'last_four',
        'provider_id',
        'default',
    ];

    /*public static function boot(): void
    {
        parent::boot();

        static::creating(function ($paymentMethod) {
            if ($paymentMethod->default) {
                $paymentMethod->user->paymentMethods()->update([
                    'default' => false
                ]);
            }
        });
    }

    public function setDefaultAttribute($value): void
    {
        $this->attributes['default'] = $value === 'true' || $value;
    }*/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
