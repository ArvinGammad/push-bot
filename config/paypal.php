<?php

return [
    'mode' => env('PAYPAL_MODE', 'sandbox'),

    'sandbox' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
    ],

    'live' => [
        'client_id' => env('PAYPAL_CLIENT_ID_LIVE'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET_LIVE'),
    ],

    'settings' => [
        'http.CURLOPT_TIMEOUT' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path('logs/paypal.log'),
        'log.LogLevel' => 'FINE', // Available options: 'FINE', 'INFO', 'WARN', 'ERROR', 'CRITICAL'
    ],
];