<?php

namespace IdeaToCode\LarapaySmartbill;

use AlexEftimie\LaravelPayments\Events\InvoicePaid;
use IdeaToCode\LarapaySmartbill\Listeners\EmitSmartbillInvoice;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        InvoicePaid::class => [
            EmitSmartbillInvoice::class,
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    public function register()
    {
        parent::register();
    }
}
