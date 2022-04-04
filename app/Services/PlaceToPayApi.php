<?php

namespace App\Services;

use App\Exceptions\PaymentException;
use App\Services\Interfaces\PaymentMethodTemplate;
use Illuminate\Support\Facades\Request;

class PlaceToPayApi implements PaymentMethodTemplate
{
    private PlaceToPayClient $client;

    public  function __construct(PlaceToPayClient $client)
    {
        $this->client = $client;
    }

    public function createPaymentRequest(array $data): array
    {
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

        $response = $this->client->request($request);
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

    public function getTransactionStatus(String $transactionId): array
    {
        $response = $this->client->query($transactionId);
        return [
            'error' => !$response->isSuccessful(),
            'status' => $response->status()->status(),
            'transaction' => $response->payment(),
        ];
    }
}
