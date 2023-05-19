<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class CustomerProfileResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    #[ArrayShape(["first_name" => "mixed", "middle_name" => "mixed", "last_name" => "mixed", "dob" => "mixed", "gender" => "mixed", "phone_1" => "mixed", "phone_2" => "mixed"])]
    public function toArray($request): array
    {
        return [
            "first_name" => $this->first_name,
            "middle_name" => $this->middle_name,
            "last_name" => $this->last_name,
            "dob" => $this->dob,
            "gender" => $this->gender,
            "phone_1" => $this->phone_1,
            "phone_2" => $this->phonve_2,
        ];
    }
}
