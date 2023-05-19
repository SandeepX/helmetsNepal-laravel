<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class EmailVerificationEvent
{
    use SerializesModels;

    public $customerDetail;

    public function __construct($customerDetail)
    {
        $this->customerDetail = $customerDetail;
    }
}
