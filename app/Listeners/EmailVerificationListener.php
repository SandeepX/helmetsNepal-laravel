<?php

namespace App\Listeners;

use App\Events\EmailVerificationEvent;
use App\Mail\EmailVerifyMail;
use Illuminate\Support\Facades\Mail;

class EmailVerificationListener
{
    public function handle(EmailVerificationEvent $event)
    {
        Mail::to($event->customerDetail->email)->send(new EmailVerifyMail($event->customerDetail));
    }
}
