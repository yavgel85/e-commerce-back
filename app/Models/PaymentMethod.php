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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
