<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class BrandResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */

    #[ArrayShape(['id' => "mixed", 'title' => "mixed", 'image_path' => "mixed"])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image_path' => $this->image_path,
        ];
    }
}
