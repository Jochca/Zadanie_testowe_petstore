<?php

return [
    'host' => env('PETSTOREAPI_HOST', 'http://petstore.swagger.io/v2/'),
    'endpoints' => [
        'pets' => [
            'index' => 'pet/findByStatus',
            'store' => 'pet',
            'update' => 'pet',
            'destroy' => 'pet',
        ],
    ],
];
