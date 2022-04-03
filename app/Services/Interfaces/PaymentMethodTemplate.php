<?php

namespace App\Services\Interfaces;

interface PaymentMethodTemplate
{
    public function  createPaymentRequest(array $data):array;
    public function getTransactionStatus(String $transactionId);

}
