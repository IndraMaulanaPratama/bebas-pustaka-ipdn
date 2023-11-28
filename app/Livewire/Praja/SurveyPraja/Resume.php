<?php

namespace App\Livewire\Praja\SurveyPraja;

use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Resume extends Component
{
    public $praja, $npp, $survey;

    public $buttonAjukan = 'hidden';



    #[On("failed-updating-data"), On("data-updated"), On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function pengajuanUlang()
    {
        try {

            Survey::where('SURVEY_PRAJA', $this->npp)->update(['SURVEY_STATUS' => 'Proses']);

            $this->dispatch("data-updated", "Pengajuan survey perpustakaan anda berhasil diajukan ulang");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }
    }



    public function mount()
    {
        // Ngadamel data npp dumasar kana email praja
        $this->npp = explode("@", Auth::user()->email)[0];

        // Nyandak data praja ka server satu praja dumasar kana npp
        $praja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $this->npp));
        $this->praja = $praja->data[0];
    }



    public function render()
    {
        $this->survey = Survey::where('SURVEY_PRAJA', $this->npp)->first();

        if ($this->survey != null) {
            $this->buttonAjukan = $this->survey->SURVEY_STATUS != 'Ditolak' ? 'hidden' : null;
        }

        return view('livewire.praja.survey-praja.resume', [
            'data' => $this->survey,
            'praja' => $this->praja,
        ]);
    }
}
