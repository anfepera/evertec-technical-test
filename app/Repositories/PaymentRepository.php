<?php

namespace App\Repositories;

use App\Exceptions\PaymentException;
use App\Models\Order;
use App\Services\Interfaces\PaymentMethodTemplate;
use Illuminate\Support\Facades\Log;

class PaymentRepository
{
    private PaymentMethodTemplate $paymentMethod;

    public function __construct(PaymentMethodTemplate $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @throws PaymentException
     */
    public function create(array $data): string
    {
        $data['reference'] = uniqid("ref-");
        $response = $this->sendPaymentRequest($data);

        $order = new Order([
            "reference" => $data['reference'],
            "product_id" => $data['product_id'],
            "customer_name" => $data['customer_name'],
            "customer_email" => $data['customer_email'],
            "customer_mobile" => $data['customer_mobile'],
            "status" => Order::STATUS_CREATED,
            "transaction_id" => $response['transaction_id'],
            "payment_url" =>  $response['payment_url']
        ]);

        $order->save();

        return $response['payment_url'];
    }

    public function resolve(Order $order): void
    {
        if (!$order->requireUpdateStatus()) {
            Log::info('Status is different to CREATED or PENDING', $order->toArray());
            return;
        }
        $response = $this->paymentMethod->getTransactionStatus($order->transaction_id);
        if ($response['error'] === true) {
            Log::info('Error in get transaction status of request payment method', $response);
            return;
        }
        $statusTransaction = $response['status'];
        $orderStatus = $statusTransaction == 'APPROVED' ? Order::STATUS_PAYED : $statusTransaction;
        $order->updateStatus($orderStatus);
    }

    public function retry(Order $order): string
    {
        if (!$order->isRejected()) {
            Log::error('Order cannot retry because status is diffent to  REJECTED', $order->toArray());
            throw  new PaymentException("Can't retry pay order");
        }
        $data = [
            "reference" => $order->reference,
            "customer_name" => $order->customer_name,
            "customer_email" => $order->customer_email,
            "customer_mobile" => $order->customer_mobile,
            "product_price" => $order->product->price
        ];

        $response = $this->sendPaymentRequest($data);

        $order->transaction_id = $response['transaction_id'];
        $order->payment_url = $response['payment_url'];
        $order->save();

        return $response['payment_url'];
    }

    private function sendPaymentRequest(array $data)
    {
        $response = $this->paymentMethod->createPaymentRequest($data);
        if ($response['error'] === true) {
            Log::error('Error to pay order', $data);
            throw new PaymentException('Error to pay order');
        }
        return $response;
    }
}
