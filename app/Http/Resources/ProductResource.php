<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ProductResource extends ProductIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'variations' => ProductVariationResource::collection(
                $this->variations/*->groupBy('type.name')*/
            )
        ]);
    }
}
