<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductColorImageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id ?? "",
            'color_name' => $this->color_1_name ?? "",
            'color' => $this->color_1_color_value ?? "",
            'image' => ($this->product_image_color) ? $this->product_image_color_path : asset('front/default_img.png'),
        ];
    }
}
