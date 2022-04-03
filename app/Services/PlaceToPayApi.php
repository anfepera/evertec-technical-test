<?php

namespace App\Services;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Request;

class PlaceToPayApi
{
    public  function __construct()
    {
        /**
         * create placetopay client, read parameter from .env file
         */
        $this->placetopay = new PlacetoPay([
            'login' => config('services.placetopay.login'),
            'tranKey' => config('services.placetopay.tranKey'),
            'baseUrl' => config('services.placetopay.url'),
            'timeout' => 10,
        ]);
    }

    /**
     * @param $data
     * @return array
     */
    public function  createPaymentRequest(array $data):array
    {
        /**
         * Provide information for make to pay and return url of payment
         * https://github.com/dnetix/redirection
         */
        $dataResponse = [];

        $request = [
            'buyer' => [
                'name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'mobile' => $data['customer_mobile']
            ],
            'payment' => [
                'reference' => $data['reference'],
                'description' => 'order payment test',
                'amount' => [
                    'currency' => 'COP',
                    'total' => $data['product_price'],
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => route('order.detail', $data['reference']),
            'ipAddress' => Request::ip(),
            'userAgent' => Request::userAgent()
        ];
        $response = $this->placetopay->request($request);
        if ($response->isSuccessful()) {
            $dataResponse['error'] = false;
            $dataResponse['payment_url'] = $response->processUrl();
            $dataResponse['transaction_id'] = $response->requestId();

        } else {
            $dataResponse['error'] = true;
            $dataResponse['message'] = $response->status()->message();
        }
        return $dataResponse;

    }


    public function getTransactionStatus(String $transactionId) {
        /**
         * get status of placetopay
         */
        return  $this->placetopay->query($transactionId);
    }
}
