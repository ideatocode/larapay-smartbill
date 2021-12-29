<?php

namespace IdeaToCode\LarapaySmartbill\Listeners;


use AlexEftimie\LaravelPayments\Events\InvoiceEvent;
use Exception;
use IdeaToCode\LarapaySmartbill\Facades\LarapaySmartbill;
use Illuminate\Support\Facades\Log;

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
        try {
            $invoice = $event->invoice;
            $owner = $event->owner;
            $result = LarapaySmartbill::emitInvoice($invoice, $owner);
            unset($result['pdf']);
            Log::info('result', $result);
        } catch (Exception $e) {
            Log::error('LarapaySmartbill::emitInvoice', ['error' => $e->getMessage()]);
        }
    }
}
