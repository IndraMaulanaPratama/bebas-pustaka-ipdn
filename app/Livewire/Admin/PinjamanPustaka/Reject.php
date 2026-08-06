<?php

namespace App\Livewire\Admin\PinjamanPustaka;

use App\Models\PinjamanPustaka;
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
            $id = $this->pustaka['PUSTAKA_ID'];

            // Inisialisasi data anu bade di robih
            $data = [
                'PUSTAKA_OFFICER' => Auth::user()->id,
                'PUSTAKA_STATUS' => "Ditolak",
                'PUSTAKA_NOTES' => $this->inputNote,
                'PUSTAKA_APPROVED' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ];

            // Proses ngarobih data pengajuan
            PinjamanPustaka::where("PUSTAKA_ID", $id)->update($data);

            // Nyandak deui data anu tos dirobih (jadi instance Model nu bener,
            // sabab $this->pustaka asalna ti event Livewire nu wangunna array)
            $pinjaman = PinjamanPustaka::where("PUSTAKA_ID", $id)->first();

            // Nyatet aktivitas panolakan pengajuan, sakantenan alesan panolakanana
            ActivityLogger::log(
                'Pinjaman Perpustakaan Pusat',
                ActivityLogger::REJECT,
                "Menolak pengajuan pinjaman pustaka id praja {$this->pustaka['PUSTAKA_PRAJA']}. Alasan: {$this->inputNote}",
                $pinjaman,
                ['alasan_penolakan' => $this->inputNote]
            );

            // Ngadamel sinyal yen perobihan data pengajuan tos rengse
            $this->dispatch("data-rejected", "Pengajuan Bebas Pinjaman Perpustakaan berhasil ditolak");
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
        return view('livewire.admin.pinjaman-pustaka.reject');
    }
}
