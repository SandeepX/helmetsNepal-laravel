<?php

namespace App\Http\Resources;

use App\Http\Enums\EDateFormat;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;


class NotificationResources extends JsonResource
{
    public function toArray($request): array
    {
        $dt = Carbon::parse($this->created_at);
        return [
            'id' => $this->id,
            'details' => $this->details,
            'date' => $dt->format(EDateFormat::YmdHis->value),
        ];
    }
}
