<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductColorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            $this->color_1_color_value,
        ];
    }
}
