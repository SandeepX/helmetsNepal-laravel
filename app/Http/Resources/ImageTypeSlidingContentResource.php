<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageTypeSlidingContentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'image' => $this->image_path,
        ];
    }
}
