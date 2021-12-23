<?php

namespace IdeaToCode\LarapaySmartbill\Listeners;


use Carbon\Carbon;
use AlexEftimie\LaravelPayments\Events\InvoiceEvent;


// use App\Models\ProxyServer;
// use AlexEftimie\ProxyPanel\ProxyPanel;
// use AlexEftimie\LaravelPayments\Events\SubscriptionEvent;
// use AlexEftimie\LaravelPayments\Models\Subscription;

class EmitSmartbillInvoice
{
    /**
     * Extends the expiration date.
     *
     * @param  InvoiceEvent  $event
     * @return void
     */
    public function handle(InvoiceEvent $event)
    {
        // $sub = $event->subscription;
        // if (!is_null($sub->price->product->skumodel)) {
        //     $app = app($sub->price->product->skumodel);
        //     $query = $app->where([
        //         ['owner_id', '=', $sub->getKey()],
        //         ['owner_type', '=', Subscription::class],
        //     ]);

        //     $query->update([
        //         'owner_id' => null,
        //         'owner_type' => null,
        //     ]);
        // }
    }
}
