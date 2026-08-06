<?php

namespace App\Livewire\Admin\PinjamanFakultas;

use App\Models\PinjamanFakultas;
use App\Services\ActivityLogger;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Reject extends Component
{

    public $inputNote;
    public $pustaka;


    #[On("data-selected")]
    /**
     * Function kanggo maca data anu di kintun ku halaman tabel
     */
    public function getData($data)
    {
        $this->pustaka = $data;
    }


    /**
     * Function kanggo ngarobih data pengajuan
     */
    public function rejecting()
    {
        try {
            // Nyandak id pengajuan
            $id = $this->pustaka['FAKULTAS_ID'];

            // Inisialisasi data anu bade di robih
            $data = [
                'FAKULTAS_OFFICER' => Auth::user()->id,
                'FAKULTAS_STATUS' => "Ditolak",
                'FAKULTAS_NOTES' => $this->inputNote,
                'FAKULTAS_APPROVED' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ];

            // Proses ngarobih data pengajuan
            PinjamanFakultas::where("FAKULTAS_ID", $id)->update($data);

            // Nyandak deui data anu tos dirobih (jadi instance Model nu bener,
            // sabab $this->pustaka asalna ti event Livewire nu wangunna array)
            $pinjaman = PinjamanFakultas::where("FAKULTAS_ID", $id)->first();

            // Nyatet aktivitas panolakan pengajuan, sakantenan alesan panolakanana
            ActivityLogger::log(
                'Pinjaman Perpustakaan Fakultas',
                ActivityLogger::REJECT,
                "Menolak pengajuan pinjaman fakultas id praja {$this->pustaka['FAKULTAS_PRAJA']}. Alasan: {$this->inputNote}",
                $pinjaman,
                ['alasan_penolakan' => $this->inputNote]
            );

            // Ngadamel sinyal yen perobihan data pengajuan tos rengse
            $this->dispatch("data-rejected", "Pengajuan Bebas Pinjaman Fakultas Berhasil Ditolak");
            $this->reset();

        } catch (\Throwable $th) {
            $this->dispatch("failed-rejecting-data", $th->getMessage());
        }

    }



    /**
     * Function kanggo mulangkeun kondisi formulir
     */
    public function resetForm()
    {
        $this->reset();
    }




    public function render()
    {
        return view('livewire.admin.pinjaman-fakultas.reject');
    }
}
