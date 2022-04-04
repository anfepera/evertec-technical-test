<?php

namespace Tests\Fakes;

use App\Services\PlaceToPayClient;

use Dnetix\Redirection\Message\RedirectResponse;
use Dnetix\Redirection\Message\RedirectInformation;

class PlaceToPayClientFake extends PlaceToPayClient
{
    public const TRANSACTION_APPROVED = 1;
    public const TRANSACTION_REJECTED = 2;
    public const TRANSACTION_PENDING = 3;

    private int $type;
    private bool $successRequest = true;

    public function request($redirectRequest): RedirectResponse
    {

        if ($this->successRequest) {
            $data = [
                'status' => [
                    'status' => 'OK',
                    'reason' => 'PC',
                    'message' => 'La petición se ha procesado correctamente',
                    'date' => '2021-11-30T15:08:27-05:00',
                ],
                'requestId' => 1,
                'processUrl' => 'https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a',
            ];

        } else {
            $data = [
                'status' => [
                    'status' => 'ERROR',
                    'reason' => 'PC',
                    'message' => 'La petición se ha procesado correctamente',
                    'date' => '2021-11-30T15:08:27-05:00',
                ]
            ];
        }
        return new RedirectResponse($data);
    }

    public function query(int $requestId): RedirectInformation
    {
        switch ($this->type) {
            case self::TRANSACTION_APPROVED:
                $data = [
                    "requestId" => 1,
                    "status"=> [
                        "status" => "APPROVED",
                        "reason" => "00",
                        "message" => "La petición ha sido aprobada exitosamente",
                        "date" => "2021-11-30T15:49:47-05:00"
                    ],
                    "request"=> [
                        "locale" => "es_CO",
                        "payer" => [
                            "document" => "1033332222",
                            "documentType" => "CC",
                            "name" => "Name",
                            "surname" => "LastName",
                            "email" => "dnetix1@app.com",
                            "mobile" => "3111111111",
                            "address"=> [
                                "postalCode" => "12345"
                            ]
                        ],
                        "payment" => [
                            "reference" => "1122334455",
                            "description" => "Prueba",
                            "amount"=> [
                                "currency"=> "USD",
                                "total"=> 1000
                            ],
                            "allowPartial"=> false,
                            "subscribe"=> false
                        ],
                        "fields"=> [
                            [
                                "keyword"=> "_processUrl_",
                                "value" => "https://test.placetopay.com/redirection/session/1/cb0f71a1f1ecdfab3ac345d3d670b097",
                                "displayOn" => "none"
                            ]
                        ],
                        "returnUrl" => "https://redirection.test/home",
                        "ipAddress" => "127.0.0.1",
                        "userAgent" => "PlacetoPay Sandbox",
                        "expiration" => "2021-12-30T00:00:00-05:00"
                    ],
                    "payment" => [
                        [
                            "status"=> [
                                "status"=> "APPROVED",
                                "reason"=> "00",
                                "message"=> "Aprobada",
                                "date" => "2021-11-30T15:49:36-05:00"
                            ],
                            "internalReference"=> 1,
                            "paymentMethod" => "visa",
                            "paymentMethodName" => "Visa",
                            "issuerName" => "JPMORGAN CHASE BANK, N.A.",
                            "amount"=> [
                                "from"=> [
                                    "currency"=> "USD",
                                    "total"=> 1000
                                ],
                                "to"=> [
                                    "currency"=> "USD",
                                    "total" => 1000
                                ],
                                "factor"=> 1
                          ],
                            "authorization"=> "000000",
                            "reference" => "1122334455",
                            "receipt" => "241516",
                            "franchise"=> "DF_VS",
                            "refunded"=> false,
                            "processorFields"=> [
                                [
                                    "keyword" => "merchantCode",
                                    "value" => "7200076413",
                                    "displayOn" => "none"
                                ],
                                [
                                    "keyword" => "terminalNumber",
                                    "value" => "PT312002",
                                    "displayOn" => "none"
                                ],
                                [
                                    "keyword" => "credit",
                                    "value"=> [
                                        "code" => "0",
                                        "type" => "00",
                                        "groupCode" => "C",
                                        "installments" => 0
                                    ],
                                    "displayOn" => "none"
                                ],
                                [
                                    "keyword" => "totalAmount",
                                    "value" => 1000,
                                    "displayOn" => "none"
                                ],
                                [
                                    "keyword"=> "iceAmount",
                                    "value" => 0,
                                    "displayOn" => "none"
                                ],
                                [
                                    "keyword" => "bin",
                                    "value" => "411111",
                                    "displayOn" => "none"
                                ],
                                [
                                    "keyword" => "expiration",
                                    "value" => "1229",
                                    "displayOn" => "none"

                                ],
                                [
                                    "keyword"=> "lastDigits",
                                    "value" => "1111",
                                    "displayOn" => "none"
                                ]
                            ]
                        ]
                    ],
                    "subscription" => null
                ];
            break;
            case self::TRANSACTION_REJECTED:
                $data = [
                    'requestId' => 1,
                    'status' => [
                        'status' => 'REJECTED',
                        'reason' => 'XN',
                        'message' => 'Se ha rechazado la petición',
                        'date' => '2021-11-30T16:44:24-05:00',
                    ],
                    'request' => [
                        'locale' => 'es_CO',
                        'payer' => [
                            'document' => '1033332222',
                            'documentType' => 'CC',
                            'name' => 'Name',
                            'surname' => 'LastName',
                            'email' => 'dnetix@app.com',
                            'mobile' => '31111111111',
                            'address' => [
                                'postalCode' => '12345',
                            ],
                        ],
                        'payment' => [
                            'reference' => '331122',
                            'description' => 'Reference',
                            'amount' => [
                                'currency' => 'USD',
                                'total' => 500,
                            ],
                            'allowPartial' => false,
                            'subscribe' => false,
                            'dispersion' => [
                                0 => [
                                    'reference' => '331122',
                                    'description' => 'Reference',
                                    'amount' => [
                                        'currency' => 'USD',
                                        'total' => 200,
                                    ],
                                    'allowPartial' => false,
                                    'subscribe' => false,
                                    'agreement' => '26',
                                    'agreementType' => 'AIRLINE',
                                ],
                                1 => [
                                    'reference' => '331122',
                                    'description' => 'Reference',
                                    'amount' => [
                                        'currency' => 'USD',
                                        'total' => 300,
                                    ],
                                    'allowPartial' => false,
                                    'subscribe' => false,
                                    'agreementType' => 'MERCHANT',
                                ],
                            ],
                        ],
                        'fields' => [
                            0 => [
                                'keyword' => '_processUrl_',
                                'value' => 'https://test.placetopay.com/redirection/session/1/1dfbaf16c76c6ee83a63a956d704a9d1',
                                'displayOn' => 'none',
                            ],
                        ],
                        'returnUrl' => 'https://redirection.test/home',
                        'ipAddress' => '127.0.0.1',
                        'userAgent' => 'PlacetoPay Sandbox',
                        'expiration' => '2021-12-30T00:00:00-05:00',
                    ],
                    'payment' => [
                        0 => [
                            'status' => [
                                'status' => 'REJECTED',
                                'reason' => '65',
                                'message' => '65',
                                'date' => '2021-11-30T16:22:19-05:00',
                            ],
                            'internalReference' => 1,
                            'paymentMethod' => 'visa',
                            'paymentMethodName' => 'Visa',
                            'issuerName' => 'CAIXA D\'ESTALVIS UNIO DE CAIXES DE MANLLEU, SABADE',
                            'amount' => [
                                'from' => [
                                    'currency' => 'USD',
                                    'total' => 500,
                                ],
                                'to' => [
                                    'currency' => 'USD',
                                    'total' => 500,
                                ],
                                'factor' => 1,
                            ],
                            'authorization' => '000000',
                            'reference' => '331122',
                            'franchise' => 'TS_VS',
                            'refunded' => false,
                            'processorFields' => [
                                0 => [
                                    'keyword' => 'totalAmount',
                                    'value' => 500,
                                    'displayOn' => 'none',
                                ],
                                1 => [
                                    'keyword' => 'lastDigits',
                                    'value' => '6853',
                                    'displayOn' => 'none',
                                ],
                            ],
                            'dispersion' => [
                                0 => [
                                    'status' => [
                                        'status' => 'REJECTED',
                                        'reason' => '65',
                                        'message' => '65',
                                        'date' => '2021-11-30T16:34:17-05:00',
                                    ],
                                    'internalReference' => 2,
                                    'amount' => [
                                        'from' => [
                                            'currency' => 'USD',
                                            'total' => 200,
                                        ],
                                        'to' => [
                                            'currency' => 'USD',
                                            'total' => 200,
                                        ],
                                        'factor' => 1,
                                    ],
                                    'authorization' => '000000',
                                    'franchise' => 'TS_VS',
                                    'refunded' => false,
                                    'agreement' => 26,
                                    'agreementType' => 'AIRLINE',
                                ],
                                1 => [
                                    'status' => [
                                        'status' => 'REJECTED',
                                        'reason' => '?C',
                                        'message' => 'Pago abortado por el usuario',
                                        'date' => '2021-11-30T16:34:17-05:00',
                                    ],
                                    'internalReference' => 3,
                                    'amount' => [
                                        'from' => [
                                            'currency' => 'USD',
                                            'total' => 300,
                                        ],
                                        'to' => [
                                            'currency' => 'USD',
                                            'total' => 300,
                                        ],
                                        'factor' => 1,
                                    ],
                                    'authorization' => '000000',
                                    'receipt' => '000000',
                                    'franchise' => 'ID_VS',
                                    'refunded' => false,
                                    'agreementType' => 'MERCHANT',
                                ],
                            ],
                        ],
                    ],
                    'subscription' => NULL,
                ];
                break;
            case self::TRANSACTION_PENDING:
                $data = [
                    'requestId' => 1,
                    'status' => [
                        'status' => 'PENDING',
                        'reason' => 'PT',
                        'message' => 'La petición se encuentra pendiente',
                        'date' => '2021-11-30T15:45:57-05:00',
                    ],
                    'request' => [
                        'locale' => 'es_CO',
                        'payer' => [
                            'document' => '1033332222',
                            'documentType' => 'CC',
                            'name' => 'Name',
                            'surname' => 'lastName',
                            'email' => 'dnetix1@app.com',
                            'mobile' => '3111111111',
                            'address' => [
                                'postalCode' => '12345',
                            ],
                        ],
                        'payment' => [
                            'reference' => '1122334455',
                            'description' => 'Prueba',
                            'amount' => [
                                'currency' => 'USD',
                                'total' => 1000,
                            ],
                            'allowPartial' => false,
                            'subscribe' => false,
                        ],
                        'fields' => [
                            0 => [
                                'keyword' => '_processUrl_',
                                'value' => 'https://test.placetopay.com/redirection/session/1/e0dfb6c7d6ab964b2377c825aef56a63',
                                'displayOn' => 'none',
                            ],
                        ],
                        'returnUrl' => 'https://dnetix.co/p2p/client',
                        'ipAddress' => '127.0.0.1',
                        'userAgent' => 'PlacetoPay Sandbox',
                        'expiration' => '2021-12-30T00:00:00-05:00',
                    ],
                    'payment' => NULL,
                    'subscription' => NULL,
                ];
                break;
            default:
                throw new \Exception('Transaction error');
        }

        return new RedirectInformation($data);

    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function setSucessRequest(bool $successRequest): void
    {
        $this->successRequest = $successRequest;
    }
}
