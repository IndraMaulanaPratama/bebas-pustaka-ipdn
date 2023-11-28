<?php

namespace App\Livewire\Praja\SurveyPraja;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{
    public $praja, $npp, $survey;
    public $buttonCreate;



    #[On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function buatPengajuan()
    {
        try {

            $data = [
                'SURVEY_ID' => uuid_create(4),
                'SURVEY_PRAJA' => $this->npp,
                'SURVEY_OFFICER' => 1,
                'SURVEY_STATUS' => 'Proses'
            ];

            Survey::create($data);


            $this->buttonCreate = 'disabled';

            $this->dispatch("data-created", "Pengajuan donasi perpustakaan anda berhasil disimpan");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }
    }



    public function mount()
    {
        $this->npp = explode("@", Auth::user()->email)[0];
        $this->praja = User::where("id", Auth::user()->id)->first();
        $this->survey = Survey::where('SURVEY_PRAJA', $this->npp)->first();
        $this->buttonCreate = $this->survey == null ? true : 'disabled';
    }



    public function render()
    {
        return view('livewire.praja.survey-praja.pengajuan');
    }
}
