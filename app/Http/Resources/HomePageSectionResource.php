<?php

namespace App\Http\Resources;

use App\Helper\Helper;
use App\Http\Enums\EStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class HomePageSectionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => Helper::getSlugSimple($this->name),
            'position' => $this->position,
            'status' => $this->status === EStatus::active->value,
        ];
    }
}
