<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class CalloutResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */

    #[ArrayShape(['title' => "mixed", 'image_path' => "mixed", 'description' => "mixed"])]
    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'image_path' => $this->image_path,
            'description' => $this->description,
        ];
    }
}
