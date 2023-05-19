<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscribeBySendInBlue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public mixed $email;

    public function __construct(mixed $email)
    {
        $this->email = $email;
    }
}
