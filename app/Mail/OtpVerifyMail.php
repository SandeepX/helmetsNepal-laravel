<?php

namespace App\Mail;

use App\Models\Admin\User;
use App\Models\Notification\Notification;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class OtpVerifyMail extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'OTP Verify Mail',
            tags: ['verification'],
            metadata: [
                'customer_id' => $this->mailData->id,
            ],
        );
    }

    public function build()
    {
        return
            $this->markdown('notification.otp_verify')
                ->with([
                    'username' => $this->mailData->name,
                    'otp_code' => $this->mailData->two_factor_code
                ]);
    }



}
