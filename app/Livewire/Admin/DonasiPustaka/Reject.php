<?php

namespace App\Livewire\Admin\DonasiPustaka;

use App\Models\DonasiPustaka;
use Livewire\Attributes\On;
use Livewire\Component;

class Reject extends Component
{
    public $inputNote, $pustaka;

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
                'PUSTAKA_STATUS' => "Ditolak",
                'PUSTAKA_NOTES' => $this->inputNote,
            ];

            // Proses ngarobih data pengajuan
            DonasiPustaka::where("PUSTAKA_ID", $id)->update($data);

            // Ngadamel sinyal yen perobihan data pengajuan tos rengse
            $this->dispatch("data-rejected", "Pengajuan donasi buku cetak perpustakaan berhasil ditolak");
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
        return view('livewire.admin.donasi-pustaka.reject');
    }
}