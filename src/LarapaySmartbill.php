<?php

namespace IdeaToCode\LarapaySmartbill;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use AlexEftimie\LaravelPayments\Models\Invoice;
use AlexEftimie\LaravelPayments\Models\Payment;
use Necenzurat\SmartBill\SmartBillCloudRestClient;
use AlexEftimie\LaravelPayments\Contracts\Billable;
use AlexEftimie\LaravelPayments\Contracts\InvoiceManager;

class LarapaySmartbill implements InvoiceManager
{
    public function downloadRoute()
    {
        return 'larapay-sb.download';
    }
    public function isBillingSetUp()
    {
        return optional(auth()->user()->currentTeam)->hasSetUpBilling();
    }
    public function emitInvoice(Invoice $invoice, Billable $client)
    {
        if (!$client->hasSetUpBilling()) {
            throw new \Exception("Billing setup not finished");
        }

        $data = [
            'companyVatCode' => config('larapay-smartbill.vatCode'),
            'client'         => [
                'name'             => $client->getBillingName(),
                'vatCode'         => $client->getBillingCode(),
                'regCom'         => "",
                'address'         => $client->getBillingAddress(),
                'isTaxPayer'     => false,
                // 'name'             => "Intelligent IT",
                // 'vatCode'         => "RO12345678",
                // 'address'         => "str. Sperantei, nr. 5",
                // 'city'             => "Sibiu",
                'country'         => $client->getBillingCountry(),
                // 'email'         => "office@intelligent.ro",
            ],
            'language' => 'EN',
            'currency'             => config('larapay.currency_code'),
            'issueDate'      => $invoice->created_at->format('Y-m-d'),
            'seriesName'     => config('larapay-smartbill.invoiceSeries'),
            'isDraft'        => false,
            'dueDate'        => $invoice->payment->created_at->format('Y-m-d'),
            'mentions'        => '',
            'observations'   => '',
            'precision'      => 2,
            'products'        => $this->getProductArray($invoice),
            'payment' => $this->getPaymentArray($invoice->payment),
        ];

        try {
            $smartbill = new SmartBillCloudRestClient(config('larapay-smartbill.username'), config('larapay-smartbill.token'));

            $output = $smartbill->createInvoice($data); //see docs for response
            $invoiceNumber = $output['number'];
            $invoiceSeries = $output['series'];
            $output['pdf'] = $smartbill->PDFInvoice(config('larapay-smartbill.vatCode'), $invoiceSeries, $invoiceNumber);
            $output['filename'] = $output['series'] . $output['number'] . '.pdf';
            $this->storePDF($output);
            $invoice->addOrUpdateMeta('invoice::pdf', [
                'series' => $output['series'],
                'number' => $output['number'],
                'path' => $output['path'],
            ]);

            return $output;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function PDF($series, $number)
    {
        $smartbill = new SmartBillCloudRestClient(config('larapay-smartbill.username'), config('larapay-smartbill.token'));
        $output = [
            'series' => $series,
            'number' => $number,
        ];
        $output['pdf'] = $smartbill->PDFInvoice(config('larapay-smartbill.vatCode'), $output['series'], $output['number']);
        $output['filename'] = $output['series'] . $output['number'] . '.pdf';
        $this->storePDF($output);
        return $output;
    }

    protected function getProductArray(Invoice $invoice)
    {
        if (!$invoice->subscription) {
            throw new \Exception("Only Subscription Products implemented");
        }
        $price = $invoice->subscription->price;
        $product = $price->product;
        // 'isTaxIncluded'     => true,
        // 'taxName'             => "Redusa",
        // 'taxPercentage'     => 9,

        // by default we have only one unit
        $q = 1;
        $ppu = $invoice->payment->amount / 100;

        // if we have a count in the payload then we have multiple units
        // and the unit price is total price / unit count
        if ($price->payload->Count ?? null) {
            $q = $price->payload->Count;
            $ppu = $ppu / $q;
        }

        return [
            [
                'name'                 => $product->name,
                'code'                 => $product->slug,
                'isDiscount'           => false,
                'measuringUnitName'    => "buc",
                'currency'             => config('larapay.currency_code'),
                'quantity'             => $q,
                'price'                => $ppu,
                'isService'            => true,
                'saveToDb'             => false,
            ],
        ];
    }
    protected function getPaymentArray(Payment $payment)
    {
        switch ($payment->gateway->Name) {
            case 'stripe':
                $type = SmartBillCloudRestClient::PaymentType_Card;

            default:
                $type = SmartBillCloudRestClient::PaymentType_Other;
                break;
        }
        // 'type' => SmartBillCloudRestClient::PaymentType_Other,
        // 'type' => SmartBillCloudRestClient::PaymentType_OrdinPlata,
        // 'type' => SmartBillCloudRestClient::PaymentType_Card,
        return [
            'type' => $type,
            'value' => $payment->amount / 100,
            'isCash' => false,
        ];
    }
    protected function storePDF(&$output)
    {
        $name = date('Y_m_') . Str::random(32);
        $output['path'] = $name . '.pdf';
        Storage::disk('local')->put($output['path'], $output['pdf']);
    }
}
