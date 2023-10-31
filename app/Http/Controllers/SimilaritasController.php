<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SimilaritasController extends Controller
{
    public function getPraja($npp)
    {
        $data = json_decode(file_get_contents("http://localhost:8001/api/praja?npp=". $npp), true);
        return response()->json($data['data'][0]['EMAIL']);
    }
}
