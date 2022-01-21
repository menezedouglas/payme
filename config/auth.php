<?php

return [
    'defaults' => [
        'guard' => 'cliente',
        'passwords' => 'users',
    ],

    'guards' => [
        'cliente' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        'lojista' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ]
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\Models\User::class
        ]
    ]
];
