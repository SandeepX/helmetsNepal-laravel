<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowroomResources extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'google_map_link' => $this->google_map_link,
            'youtube_link' => $this->youtube_link,
            'email' => $this->email,
            'contact_no' => $this->contact_no,
            'contact_person' => $this->contact_person,
            'showroom_image' => $this->showroom_image,
            'image_path' => $this->image_path
        ];
    }
}
