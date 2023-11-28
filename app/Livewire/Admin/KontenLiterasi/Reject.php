<?php

namespace App\Livewire\Admin\KontenLiterasi;

use App\Models\KontenLiterasi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Reject extends Component
{
    public $inputNote, $konten;

    #[On("data-selected")]
    /**
     * Function kanggo maca data anu di kintun ku halaman tabel
     */
    public function getData($data)
    {
        $this->konten = $data;
    }



    /**
     * Function kanggo ngarobih data pengajuan
     */
    public function rejecting()
    {
        try {
            // Nyandak id pengajuan
            $id = $this->konten['KONTEN_ID'];

            // Inisialisasi data anu bade di robih
            $data = [
                'KONTEN_OFFICER' => Auth::user()->id,
                'KONTEN_STATUS' => "Ditolak",
                'KONTEN_NOTES' => $this->inputNote,
                'KONTEN_APPROVED' => Carbon::now('Asia/Jakarta')->format("Y-m-d H:i:s"),
            ];

            // Proses ngarobih data pengajuan
            KontenLiterasi::where("KONTEN_ID", $id)->update($data);

            // Ngadamel sinyal yen perobihan data pengajuan tos rengse
            $this->dispatch("data-rejected", "Pengajuan konten literasi berhasil ditolak");
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
        return view('livewire.admin.konten-literasi.reject');
    }
}
