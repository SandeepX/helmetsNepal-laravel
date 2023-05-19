<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSearchImageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [ $this->product_image ];
    }
}
