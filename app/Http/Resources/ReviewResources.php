<?php

namespace App\Http\Resources;

use App\Http\Enums\EDateFormat;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResources extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'reviewer_name' => $this->getCustomer->full_name,
            'reviewer_profile' => $this->getCustomer->profile_image_path,
            'description' => $this->review,
            'review_date' => date(EDateFormat::Ymd->value, strtotime($this->created_at)),
            'review_star' => $this->review_star,
        ];
    }
}
