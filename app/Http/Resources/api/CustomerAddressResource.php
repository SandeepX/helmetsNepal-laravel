<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class CustomerAddressResource extends JsonResource
{

    /**
     * @param $request
     * @return array
     */
    #[ArrayShape(["address_line1" => "mixed", "address_line2" => "mixed", "address_line3" => "mixed", "address_line4" => "mixed"])]
    public function toArray($request): array
    {
        return [
            "address_line1" => $this->address_line1,
            "address_line2" => $this->address_line2,
            "address_line3" => $this->address_line3,
            "address_line4" => $this->address_line4,
        ];
    }
}
