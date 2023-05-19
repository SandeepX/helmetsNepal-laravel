<?php

namespace App\Http\Resources;

use App\Http\Enums\EDateFormat;
use App\Http\Repositories\CompanySettingRepository;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    public function toArray($request): array
    {
        $_companySetting = new CompanySettingRepository();
        $return_date = ($_companySetting->getReturnDays->return_days ?? 7);
        $start_date = Carbon::create($this->order_date);
        $end_date = Carbon::now();
        $different_days = $start_date->diffInDays($end_date);

        return [
            'id' => $this->order_id,
            'name' => $this->title,
            'qty' => round($this->quantity),
            'amount' => $this->total,
            'status' => $this->status,
            'date' => date(EDateFormat::Ymd->value, strtotime($this->order_date)),
            'image' => asset('/front/uploads/product_cover_image') .'/img-' . $this->cover_image,
            'return_status' => ($different_days < $return_date ),
            'order_product_id' => $this->order_product_id,
            'product_id' => $this->product_id,
        ];
    }
}
