<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RecaptchaService
{
    public function verify($token, $action = null)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token,
            'remoteip' => request()->ip()
        ]);

        $data = $response->json();

        if (!$data['success']) {
            return false;
        }

        // Untuk reCAPTCHA v3, validasi juga score dan action
        if ($action && $data['action'] !== $action) {
            return false;
        }

        // Score threshold (biasanya 0.5)
        if (isset($data['score']) && $data['score'] < 0.5) {
            return false;
        }

        return true;
    }
}
