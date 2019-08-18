<?php

namespace App\Listeners;

use App\Notifications\OrderRefundNotification;
use App\Events\OrderRefundSuccess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRefundSuccessMail implements ShouldQueue
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
     * @param  OrderRefundSuccess  $event
     * @return void
     */
    public function handle(OrderRefundSuccess $event)
    {
        $order = $event->getOrder();
        $order->user->notify(new OrderRefundNotification($order));
    }
}
