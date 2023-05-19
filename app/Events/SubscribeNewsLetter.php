<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class SubscribeNewsLetter
{
    use SerializesModels;

    public mixed $email;

    public function __construct(mixed $email)
    {
        $this->email = $email;
    }
}
