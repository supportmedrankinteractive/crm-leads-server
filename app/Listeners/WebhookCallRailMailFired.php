<?php

namespace App\Listeners;

use Mail;
use App\Mail\WebHookCallRailLead;
use App\Events\CallRailWebhookMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WebhookCallRailMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CallRailWebhookMail  $event
     * @return void
     */
    public function handle(CallRailWebhookMail $event)
    {
        Mail::to('valencia.dominic.29@gmail.com')->send(new WebHookCallRailLead($event->lead));
        // Mail::to('valencia.dominic.29@gmail.com')->send($event->lead);
    }
}
