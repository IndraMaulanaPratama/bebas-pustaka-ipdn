<?php

namespace App\Livewire\Admin\Similaritas;

use App\Models\Similaritas;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Reject extends Component
{
    public $inputNote;
    public $similaritas;

    #[On("similaritas-selected")]
    /**
     * Function kanggo maca data anu di kintun ku halaman tabel
     */
    public function getData($data)
    {
        $this->similaritas = $data;
    }


    /**
     * Function kanggo ngarobih data pengajuan
     */
    public function rejecting()
    {
        try {
            // Nyandak id pengajuan
            $id = $this->similaritas['SIMILARITAS_ID'];

            // Inisialisasi data anu bade di robih
            $data = [
                'SIMILARITAS_STATUS' => "Ditolak",
                'SIMILARITAS_NOTES' => $this->inputNote,
                'SIMILARITAS_APPROVED' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ];

            // Proses ngarobih data pengajuan
            Similaritas::where("SIMILARITAS_ID", $id)->update($data);

            // Ngadamel sinyal yen perobihan data pengajuan tos rengse
            $this->dispatch("data-rejected", "Pengajuan Similaritas berhasil ditolak");
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
        return view('livewire.admin.similaritas.reject');
    }
}
