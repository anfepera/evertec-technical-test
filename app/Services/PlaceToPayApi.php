<?php

namespace App\Services;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Request;

class PlaceToPayApi
{
    public function  __construct() {
        /**
         * Create instance of placeToPay service
         * [https://github.com/dnetix/redirection]
         */

    }

    /**
     * @param $data
     * @return void
     */
    public function  createPaymentRequest($data){
        /**
         * Provide information for make to pay and return url of payment
         */
        $data_response = [];
        $placetopay = new PlacetoPay([
            'login' => '6dd490faf9cb87a9862245da41170ff2', // Provided by PlacetoPay
            'tranKey' => '024h1IlD', // Provided by PlacetoPay
            'baseUrl' => 'https://dev.placetopay.com/redirection/',
            'timeout' => 10, // (optional) 15 by default
        ]);
        $request = [
            'buyer' => [
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'mobile' => $data['customer_mobile']
            ],
            'payment' => [
                'reference' => $data['reference'],
                'description' => 'Testing payment',
                'amount' => [
                    'currency' => 'COP',
                    'total' => $data['product_price'],
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://evertec-technical-test.loc:8000/order/detail/' . $data['reference'],
            'ipAddress' => Request::ip(),
            'userAgent' => Request::userAgent()
        ];
        $response = $placetopay->request($request);
        if ($response->isSuccessful()) {
            // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
            // Redirect the client to the processUrl or display it on the JS extension
            $data_response['url'] = $response->processUrl();
            $data_response['id_transaction'] = $response->requestId();

        } else {
            // There was some error so check the message and log it
            $response->status()->message();
        }
        return $data_response;

    }

}
