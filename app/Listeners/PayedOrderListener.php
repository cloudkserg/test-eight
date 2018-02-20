<?php

namespace App\Listeners;

use App\Events\PayedOrderEvent;
use App\Mail\PayedOrderMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayedOrderListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(PayedOrderEvent $event)
    {
        $user = $event->order->customer;
        \Mail::to($user->email)
            ->send(new PayedOrderMail($event->order));

    }
}
