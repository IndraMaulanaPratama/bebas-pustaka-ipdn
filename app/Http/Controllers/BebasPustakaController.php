<?php

namespace App\Http\Controllers;

use App\Models\BebasPustaka;
use Illuminate\Http\Request;

class BebasPustakaController extends Controller
{
    private function responseData($data)
    {
        if (count($data) != null) {
            $message = "Data bebas pustaka berhasil dibaca";
            $code = 200;
        } else {
            $message = "Data bebas pustaka tidak ditemukan";
            $code = 400;
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }

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
                ->orderBy('updated_at', 'DESC')
                ->paginate($item);

            // Mulangkeun hasil tinu logika
            return $this->responseData($data);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    public function count($status = 'all')
    {
        if ('all' != $status && 'selesai' != $status && 'proses' != $status) {
            return response()->json(['message' => 'Permintaan status tidak valid'], 400);
        }

        try {
            // Logika kanggo ngetang data
            $data = BebasPustaka::when(
                $status,
                function ($query, $status) {
                    if ('all' == $status) {
                        return $query->count('BEBAS_ID');
                    } else {
                        return $query->byStatus($status)->count('BEBAS_ID');
                    }
                }
            );

            // Mulangkeun hasil tinu logika
            return response()->json([
                'message' => 'Data bebas pustaka berhasil dibaca',
                'data' => [
                    'status' => $status,
                    'total' => $data
                ]
            ]);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
}
