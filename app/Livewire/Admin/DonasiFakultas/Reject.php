<?php

namespace App\Livewire\Admin\DonasiFakultas;

use App\Models\DonasiFakultas;
use App\Services\ActivityLogger;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Reject extends Component
{
    public $inputNote, $fakultas;

    #[On("data-selected")]
    /**
     * Function kanggo maca data anu di kintun ku halaman tabel
     */
    public function getData($data)
    {
        $this->fakultas = $data;
    }



    /**
     * Function kanggo ngarobih data pengajuan
     */
    public function rejecting()
    {
        try {
            // Nyandak id pengajuan
            $id = $this->fakultas['FAKULTAS_ID'];

            // Inisialisasi data anu bade di robih
            $data = [
                'FAKULTAS_OFFICER' => Auth::user()->id,
                'FAKULTAS_STATUS' => "Ditolak",
                'FAKULTAS_NOTES' => $this->inputNote,
                'FAKULTAS_APPROVED' => Carbon::now('Asia/Jakarta')->format("Y-m-d H:i:s"),
            ];

            // Proses ngarobih data pengajuan
            DonasiFakultas::where("FAKULTAS_ID", $id)->update($data);

            // Nyandak deui data anu tos dirobih (jadi instance Model nu bener,
            // sabab $this->fakultas asalna ti event Livewire nu wangunna array)
            $donasi = DonasiFakultas::where("FAKULTAS_ID", $id)->first();

            // Nyatet aktivitas panolakan pengajuan, sakantenan alesan panolakanana
            ActivityLogger::log(
                'Donasi Buku Perpustakaan Fakultas',
                ActivityLogger::REJECT,
                "Menolak pengajuan donasi fakultas id praja {$this->fakultas['FAKULTAS_PRAJA']}. Alasan: {$this->inputNote}",
                $donasi,
                ['alasan_penolakan' => $this->inputNote]
            );

            // Ngadamel sinyal yen perobihan data pengajuan tos rengse
            $this->dispatch("data-rejected", "Pengajuan donasi buku cetak perpustakaan fakultas berhasil ditolak");
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
        return view('livewire.admin.donasi-fakultas.reject');
    }
}
