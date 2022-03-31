<?php

namespace App\Http\API;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Request;

class PlaceToPayApi
{
    public function  __construct() {
        /**
         * Create instance of placeToPay service
         * [https://github.com/dnetix/redirection]
         */
        $this->placetopay = new PlacetoPay([
            'login' => '6dd490faf9cb87a9862245da41170ff2', // Provided by PlacetoPay
            'tranKey' => '024h1IlD', // Provided by PlacetoPay
            'baseUrl' => 'https://dev.placetopay.com/redirection/',
            'timeout' => 10, // (optional) 15 by default
        ]);
    }
    public function  create_payment_request($reference, $amount) {
        /**
         * Provide information for make to pay and return url of payment
         */
        $request = [
            'payment' => [
                'reference' => $reference,
                'description' => 'Testing payment',
                'amount' => [
                    'currency' => 'COP',
                    'total' => $amount,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            //'returnUrl' => 'http://example.com/response?reference=' . $reference,
            'ipAddress' => Request::ip(),
            'userAgent' => Request::userAgent(),
        ];

        $response = $this->placetopay->request($request);
        if ($response->isSuccessful()) {
            // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
            // Redirect the client to the processUrl or display it on the JS extension
            //$response->processUrl();
        } else {
            // There was some error so check the message and log it
            //$response->status()->message();
        }

    }

}
