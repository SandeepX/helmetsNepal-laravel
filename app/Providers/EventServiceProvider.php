<?php

namespace App\Providers;

use App\Events\EmailVerificationEvent;
use App\Events\SubscribeBySendInBlue;
use App\Events\SubscribeNewsLetter;
use App\Listeners\EmailVerificationListener;
use App\Listeners\SubscribeBySandInBlueListener;
use App\Listeners\SubscribeToMailchimp;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        SubscribeNewsletter::class => [
            SubscribeToMailchimp::class
        ],

        EmailVerificationEvent::class => [
            EmailVerificationListener::class
        ],

        SubscribeBySendInBlue::class => [
            SubscribeBySandInBlueListener::class
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
