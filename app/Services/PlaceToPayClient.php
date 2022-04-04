<?php

namespace App\Services;

use Dnetix\Redirection\PlacetoPay;

class PlaceToPayClient extends PlacetoPay
{
    public function __construct()
    {
        parent::__construct([
            'login' => config('services.placetopay.login'),
            'tranKey' => config('services.placetopay.tranKey'),
            'baseUrl' => config('services.placetopay.url'),
            'timeout' => 10,
        ]);
    }
}
