<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->title,
            'qty' => $this->quantity,
            'amount' => $this->final_product_price,
            'status' => '',
            'image' => $this->product_cover_image_path,
        ];
    }
}
