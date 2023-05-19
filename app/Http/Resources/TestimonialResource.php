<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'image_path' => $this->image_path,
            'designation' => $this->designation,
            'description' => $this->description,
        ];
    }
}
