<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerDetailResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name ?? "",
            'last_name' => $this->last_name,
            'email' => $this->email,
            'profile_image' => $this->profile_image_path ?? "",
            'primary_contact_1' => $this->primary_contact_1 ?? "",
            'Secondary_contact_1' => $this->Secondary_contact_1 ?? "",
            'primary_contact_2' => $this->primary_contact_2 ?? "",
            'Secondary_contact_2' => $this->Secondary_contact_2 ?? "",
            'address_line1' => $this->address_line1 ?? "",
            'address_line2' => $this->address_line2 ?? "",
        ];
    }
}
