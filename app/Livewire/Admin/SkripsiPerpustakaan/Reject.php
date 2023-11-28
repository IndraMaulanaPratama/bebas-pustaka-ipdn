<?php

namespace App\Livewire\Admin\SkripsiPerpustakaan;

use App\Models\SkripsiPerpustakaan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Reject extends Component
{

    public $inputNote, $data;

    #[On("data-selected")]
    /**
     * Function kanggo maca data anu di kintun ku halaman tabel
     */
    public function getData($data)
    {
        $this->data = $data;
    }



    /**
     * Function kanggo ngarobih data pengajuan
     */
    public function rejecting()
    {
        try {
            // Nyandak id pengajuan
            $id = $this->data['SKRIPSI_ID'];

            // Inisialisasi data anu bade di robih
            $data = [
                'SKRIPSI_OFFICER' => Auth::user()->id,
                'SKRIPSI_STATUS' => "Ditolak",
                'SKRIPSI_NOTES' => $this->inputNote,
                'SKRIPSI_APPROVED' => Carbon::now('Asia/Jakarta')->format("Y-m-d H:i:s"),
            ];

            // Proses ngarobih data pengajuan
            SkripsiPerpustakaan::where("SKRIPSI_ID", $id)->update($data);

            // Ngadamel sinyal yen perobihan data pengajuan tos rengse
            $this->dispatch("data-rejected", "Pengajuan pengumpulan hard copy skripsi berhasil ditolak");
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
        return view('livewire.admin.skripsi-perpustakaan.reject');
    }
}
