<?php

namespace App\Http\Controllers;

use App\Models\BebasPustaka;
use Illuminate\Http\Request;

class BebasPustakaController extends Controller
{
    public function index(Request $request)
    {

        // Inisialisasi parameter
        $id = $request['id'];
        $number = $request['nomor'];
        $angkatan = $request['angkatan'];
        $npp = $request['npp'];
        $status = $request['status'];
        $item = $request['item'];

        try {
            // Filter request status
            if (null != $status) {
                if ('proses' != $status && 'selesai' != $status) {
                    return response()->json(['message' => 'Permintaan status tidak valid'], 400);
                }
            }

            // Logika kanggo milarian data
            $data = BebasPustaka::generalData()
                ->byId($id)
                ->byNpp($npp)
                ->byAngkatan($angkatan)
                ->byNumber($number)
                ->byStatus($status)
                ->without('user')
                ->orderBy('updated_at')
                ->paginate($item);

            // Mulangkeun hasil tinu logika
            if (count($data) != null) {
                $message = "Data bebas pustaka berhasil dibaca";
                $statusCode = 200;
            } else {
                $message = "Data bebas pustaka tidak ditemukan";
                $statusCode = 400;
            }

            return response()->json([
                'message' => $message,
                'data' => $data
            ], $statusCode);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }
}
