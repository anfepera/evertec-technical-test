<?php

namespace App\Services;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Request;

class PlaceToPayApi
{
    public  function __construct()
    {
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
        $data_response = [];

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
            $data_response['error'] = false;
            $data_response['payment_url'] = $response->processUrl();
            $data_response['transaction_id'] = $response->requestId();

        } else {
            // There was some error so check the message and log it
            $data_response['error'] = true;
            $data_response['message'] = $response->status()->message();
        }
        return $data_response;

    }


    public function getTransactionStatus(String $transactionId) {
        $response = $this->placetopay->query($transactionId);

        if ($response->isSuccessful()) {
            // In order to use the functions please refer to the Dnetix\Redirection\Message\RedirectInformation class

            if ($response->status()->isApproved()) {
                $status = "PAYED";
                // The payment has been approved
            } else {
                $status = "REJECTED";

            }
        }
        return $response;

    }
}
