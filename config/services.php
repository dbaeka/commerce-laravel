<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'ycode' => [
        'base_url' => env('YCODE_BASE_URL', 'https://app.ycode.com/api/v1'),
        'token' => env('YCODE_TOKEN'),
        'collections' => [
            'products_id' => env('YCODE_COLLECTIONS_PRODUCTS_ID'),
            'orders_id' => env('YCODE_COLLECTIONS_ORDERS_ID'),
            'order_items_id' => env('YCODE_COLLECTIONS_ORDER_ITEMS_ID')
        ],
        'default_currency' => env('YCODE_DEFAULT_CURRENCY', 'USD'),
        'default_max_quantity' => env('YCODE_DEFAULT_MAX_QTY', 8),
        'default_shipping_cost' => env('YCODE_DEFAULT_SHIPPING_COST', 5)
    ]

];
