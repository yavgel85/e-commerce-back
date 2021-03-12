<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|AnonymousResourceCollection
     */
    public function toArray($request)
    {
        if ($this->resource instanceof Collection) {
            return self::collection($this->resource);
        }

        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'price'        => $this->formattedPrice,
            'price_varies' => $this->priceVaries(),
            'stock_count'  => (int) $this->stockCount(),
            'type'         => $this->type->name,
            'in_stock'     => $this->inStock(),
            'product'      => new ProductIndexResource($this->product),
        ];
    }
}
