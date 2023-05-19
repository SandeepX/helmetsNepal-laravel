<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopSelectCommonResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'key' => $this->id,
            'name' => ($this->title ?? $this->name),
        ];
    }
}
