<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * Respond JSON token
     * 
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $ttl = config('jwt.ttl'); // Ngakses langsung tina konfigurasi

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl
        ]);
    }

    /**
     * Proses Login Aplikasi
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rawData = $request->getContent(); // Nyandak data input raw ti semah
        $data = json_decode($rawData, true); // Ngajadikeun JSON jadi array

        if (!$token = JWTAuth::attempt($data)) {
            return response()->json(['errors' => 'User dan Password tidak sesuai'], 401);
        } else {
            return $this->respondWithToken($token);
        }

    }


    /**
     * Fungsi kanggo Refresh Token
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken()
    {
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                return response()->json(['errors' => 'Token tidak terbaca'], 400);
            }

            $newToken = JWTAuth::parseToken()->refresh();
            return $this->respondWithToken($newToken);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Fungsi kanggo Logout
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                return response()->json(['errors' => 'Token tidak ditemukan'], 400);
            }
    
            JWTAuth::invalidate($token);
            return response()->json(['message' => 'Logout berhasil'], 200);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}


