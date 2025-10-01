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



    // Google Auth //
    'google_pegawai' => [
        'client_id' => env('GOOGLE_PEGAWAI_ID'),
        'client_secret' => env('GOOGLE_PEGAWAI_SECRET'),
        'redirect' => env('GOOGLE_PEGAWAI_URI'),
        'scopes' => ['openid', 'profile', 'email'],
        'access_type' => 'offline',
        'approval_prompt' => 'force',
    ],

    'google_praja' => [
        'client_id' => env('GOOGLE_PRAJA_ID'),
        'client_secret' => env('GOOGLE_PRAJA_SECRET'),
        'redirect' => env('GOOGLE_PRAJA_URI'),
        'scopes' => ['openid', 'profile', 'email'],
        'access_type' => 'offline',
        'approval_prompt' => 'force',
    ],



    // API Praja
    'praja_api' => [
        'url' => env('APP_PRAJA'),
        'token' => env('PRAJA_API_TOKEN'),
    ],
];
