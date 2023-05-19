<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GlobalProductSearchResources extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->title,
            'oldPrice' => $this->product_price,
            'newPrice' => $this->final_product_price,
            'image' => $this->product_cover_image_path,
            'slug' => $this->slug,
        ];
    }
}
