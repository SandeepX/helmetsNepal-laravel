<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class PageDetailsResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    #[ArrayShape(['title' => "mixed", 'slug' => "mixed", 'details' => "mixed", 'status' => "mixed", 'meta_title' => "mixed", 'meta_keys' => "mixed", 'meta_description' => "mixed", 'alternate_text' => "mixed"])]
    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'details' => $this->details,
            'meta_title' => $this->meta_title,
            'meta_keys' => $this->meta_keys,
            'meta_description' => $this->meta_description,
            'alternate_text' => $this->alternate_text,
        ];
    }
}
