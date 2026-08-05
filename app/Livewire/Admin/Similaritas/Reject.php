<?php

namespace App\Livewire\Admin\Similaritas;

use App\Models\Similaritas;
use App\Services\ActivityLogger;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
                'SIMILARITAS_OFFICER' => Auth::user()->id,
                'SIMILARITAS_STATUS' => "Ditolak",
                'SIMILARITAS_NOTES' => $this->inputNote,
                'SIMILARITAS_APPROVED' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
            ];

            // Proses ngarobih data pengajuan
            Similaritas::where("SIMILARITAS_ID", $id)->update($data);

            // Nyatet aktivitas panolakan pengajuan
            ActivityLogger::log('Similaritas', ActivityLogger::REJECT, "Menolak pengajuan similaritas a.n. {$this->similaritas['SIMILARITAS_PRAJA']}");

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
