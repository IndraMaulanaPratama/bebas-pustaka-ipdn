<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrajaApi
{
    /**
     * Mengambil data Praja secara aman menggunakan Bearer Token dari Data Praja v2
     *
     * @param string $npp
     * @param bool $asArray Jika true, mengembalikan array. Jika false, mengembalikan object.
     * @return mixed
     */
    public static function getPraja($npp, $asArray = false)
    {
        $url = env('APP_PRAJA') . 'praja';
        $token = env('PRAJA_API_TOKEN');

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->get($url, ['npp' => $npp]);

            if ($response->successful()) {
                return $asArray ? $response->json() : $response->object();
            }

            Log::error('API Praja Error: ' . $response->status(), [
                'npp' => $npp,
                'response' => $response->body()
            ]);

        } catch (\Exception $e) {
            Log::error('Koneksi API Praja Gagal: ' . $e->getMessage());
        }

        return null;
    }
}
