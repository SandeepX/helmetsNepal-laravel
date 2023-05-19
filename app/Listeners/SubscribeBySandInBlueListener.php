<?php

namespace App\Listeners;

use App\Helper\SendInBlueMail;


class SubscribeBySandInBlueListener
{
    private  $sendInBlue;

    public function __construct()
    {
        $this->sendInBlue = new SendInBlueMail();
    }

    public function handle($event)
    {
       $this->sendInBlue->sendSendInBlueMail($event->email);
    }
}
