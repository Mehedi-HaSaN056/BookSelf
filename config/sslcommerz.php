<?php

return [
    'store' => [
        'id'       => env('SSLCOMMERZ_STORE_ID'),
        'password' => env('SSLCOMMERZ_STORE_PASSWORD'),
        'currency' => env('SSLCOMMERZ_CURRENCY', 'BDT'),
    ],
    'sandbox' => env('SSLCOMMERZ_SANDBOX', true),
    'route' => [
        'success' => 'sslcommerz.success',
        'failure' => 'sslcommerz.fail',
        'cancel'  => 'sslcommerz.cancel',
        'ipn'     => 'sslcommerz.ipn',
    ],
];