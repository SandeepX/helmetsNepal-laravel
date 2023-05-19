<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class PagesNameResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    #[ArrayShape(['title' => "mixed", 'slug' => "mixed"])]
    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
        ];
    }
}
