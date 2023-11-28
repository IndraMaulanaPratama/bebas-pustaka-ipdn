<?php

namespace App\Livewire\Admin\Survey;

use App\Models\Survey;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Reject extends Component
{
    public $inputNote, $survey;

    #[On("data-selected")]
    /**
     * Function kanggo maca data anu di kintun ku halaman tabel
     */
    public function getData($data)
    {
        $this->survey = $data;
    }



    /**
     * Function kanggo ngarobih data pengajuan
     */
    public function rejecting()
    {
        try {
            // Nyandak id pengajuan
            $id = $this->survey['SURVEY_ID'];

            // Inisialisasi data anu bade di robih
            $data = [
                'SURVEY_OFFICER' => Auth::user()->id,
                'SURVEY_STATUS' => "Ditolak",
                'SURVEY_NOTES' => $this->inputNote,
                'SURVEY_APPROVED' => Carbon::now('Asia/Jakarta')->format("Y-m-d H:i:s"),
            ];

            // Proses ngarobih data pengajuan
            Survey::where("SURVEY_ID", $id)->update($data);

            // Ngadamel sinyal yen perobihan data pengajuan tos rengse
            $this->dispatch("data-rejected", "Pengajuan survey perpustakaan berhasil ditolak");
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
        return view('livewire.admin.survey.reject');
    }
}
