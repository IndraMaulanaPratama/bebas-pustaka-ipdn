<?php

namespace App\Http\Controllers;

use App\Models\Similaritas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SimilaritasController extends Controller
{
    public function index(Request $request)
    {

        try {
            $similaritas = Similaritas::
                when(
                    // <!-- Pilari data pengajuan dumasar kana status
                    $request->has('status'),
                    function ($query, $status) {
                        return $query->where("SIMILARITAS_STATUS", $status);
                    }
                )
                ->when(
                    // <!-- Pilari data pengajuan dumasar kana fakultas
                    $request->has('fakultas'),
                    function ($query, $fakultas) {
                        return $query->where("SIMILARITAS_NUMBER", "LIKE", '%' . $fakultas . '%');
                    }
                )
                ->when(
                    // <!-- Pilari data pengajuan dumasar kana npp
                    $request->has('npp'),
                    function ($query, $npp) {
                        return $query->where("SIMILARITAS_PRAJA", "LIKE", $npp . "%");
                    }
                )
                ->when(
                    // <!-- Pilari data pengajuan dumasar kana npp
                    $request->has('angkatan'),
                    function ($query, $angkatan) {
                        return $query->where("SIMILARITAS_PRAJA", "LIKE", $angkatan . "%");
                    }
                )
                ->latest()
                ->paginate();

            return response()->json([
                'message' => 'Data similaritas berhasil dimuat',
                'data' => $similaritas
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Data similaritas gagal dimuat',
                'error' => $th->getMessage()
            ], 500);
        }


    }
}
