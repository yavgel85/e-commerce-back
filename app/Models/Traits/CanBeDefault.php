<?php

namespace App\Models\Traits;

trait CanBeDefault
{
    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($address) {
            if ($address->default) {
                $address->newQuery()->where('user_id', $address->user->id)->update([
                    'default' => false
                ]);
            }
        });
    }

    public function setDefaultAttribute($value): void
    {
        $this->attributes['default'] = $value === 'true' || $value;
    }
}
