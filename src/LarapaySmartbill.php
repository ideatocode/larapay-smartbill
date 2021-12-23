<?php

namespace IdeaToCode\LarapaySmartbill;

use Necenzurat\SmartBill\SmartBill;

class LarapaySmartbill
{
    public function emitInvoice()
    {
        $data = [
            'companyVatCode' => config('larapay-smartbill.vatCode'),
            'client'         => [
                'name'             => "Intelligent IT",
                'vatCode'         => "RO12345678",
                'regCom'         => "",
                'address'         => "str. Sperantei, nr. 5",
                'isTaxPayer'     => false,
                'city'             => "Sibiu",
                'country'         => "Romania",
                'email'         => "office@intelligent.ro",
            ],
            'issueDate'      => date('Y-m-d'),
            'seriesName'     => config('larapay-smartbill.invoiceSeries'),
            'isDraft'        => false,
            'dueDate'        => date('Y-m-d', time() + 3600 * 24 * 30),
            'mentions'        => '',
            'observations'   => '',
            'deliveryDate'   => date('Y-m-d', time() + 3600 * 24 * 10),
            'precision'      => 2,
            'products'        => [
                [
                    'name'                 => "Produs 1",
                    'code'                 => "ccd1",
                    'isDiscount'         => false,
                    'measuringUnitName' => "buc",
                    'currency'             => "RON",
                    'quantity'             => 2,
                    'price'             => 10,
                    'isTaxIncluded'     => true,
                    'taxName'             => "Redusa",
                    'taxPercentage'     => 9,
                    'isService'         => false,
                    'saveToDb'          => false,
                ],
            ],
        ];
        try {
            $smartbill = new SmartBill();
            $output = $smartbill->createInvoice($data); //see docs for response
            $invoiceNumber = $output['number'];
            $invoiceSeries = $output['series'];
            echo $invoiceSeries . $invoiceNumber;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
