<?php

namespace App\Services\Google;

use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User;

class CustomGoogleProvider extends GoogleProvider
{
    public function __construct($request, $clientId, $clientSecret, $redirectUrl, $guzzle = [])
    {
        parent::__construct($request, $clientId, $clientSecret, $redirectUrl, $guzzle);
    }

    // Override jika perlu custom behavior
}
