<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class AdBlockResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    #[ArrayShape(['title' => "mixed", 'sub_title' => "mixed", 'image_path' => "mixed", 'description' => "mixed"])]
    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'image_path' => $this->image_path,
            'description' => $this->description,
            'section' => $this->section,
        ];
    }
}
