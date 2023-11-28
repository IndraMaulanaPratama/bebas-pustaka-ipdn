<?php

namespace App\Livewire\Admin\Repository;

use App\Models\Repository;
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
            $id = $this->data['REPOSITORY_ID'];

            // Inisialisasi data anu bade di robih
            $data = [
                'REPOSITORY_OFFICER' => Auth::user()->id,
                'REPOSITORY_STATUS' => "Ditolak",
                'REPOSITORY_NOTES' => $this->inputNote,
                'REPOSITORY_APPROVED' => Carbon::now('Asia/Jakarta')->format("Y-m-d H:i:s"),
            ];

            // Proses ngarobih data pengajuan
            Repository::where("REPOSITORY_ID", $id)->update($data);

            // Ngadamel sinyal yen perobihan data pengajuan tos rengse
            $this->dispatch("data-rejected", "Pengajuan unggah repository berhasil ditolak");
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
        return view('livewire.admin.repository.reject');
    }
}
