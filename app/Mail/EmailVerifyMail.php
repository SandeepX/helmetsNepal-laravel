<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class EmailVerifyMail extends Mailable
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
            subject: 'Email Verify Mail',
            tags: ['verification'],
            metadata: [
                'customer_id' => $this->mailData->id,
            ],
        );
    }

    public function build()
    {
        $url =  URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addHour(24),
            [
                'id' => $this->mailData->id,
                'hash' => sha1($this->mailData->email),
            ]
        );
        return
            $this->markdown('notification.email')
                ->with([
                    'url' => $url,
                    'customerName' => $this->mailData->first_name.' ' .$this->mailData->last_name,
                    'count' => 24
                ]);
    }
}
