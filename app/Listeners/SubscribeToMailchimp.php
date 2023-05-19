<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

class SubscribeToMailchimp
{
//    public $connection = 'database';

//    public $queue = 'mailchimp_listener';

    private mixed $mailchimp;

    public function __construct(\Mailchimp $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }

    public function handle($event)
    {
        $this->mailchimp->lists->subscribe(
            config('mailchimp.mailchimp_audience_key'),
            ['email' => $event->email],
            null,
            null,
            false
        );

    }
}
