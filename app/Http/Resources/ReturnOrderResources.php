<?php

namespace App\Http\Resources;

use App\Http\Enums\EDateFormat;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnOrderResources extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'id' => $this->order_id,
            'name' => $this->getProduct->title,
            'qty' => round($this->quantity),
            'amount' => round(($this->quantity * $this->product_price)  , 2),
            'status' => $this->status,
            'date' => date(EDateFormat::Ymd->value, strtotime($this->return_order_date)),
            'image' => $this->getProduct->product_cover_image_path,
        ];
    }
}
