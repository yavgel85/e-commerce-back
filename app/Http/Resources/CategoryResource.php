<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name'     => $this->name,
            'slug'     => $this->slug,
            'order'    => $this->order,
            'children' => self::collection($this->whenLoaded('children')),
        ];
    }
}
