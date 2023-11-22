<?php

namespace App\Livewire\Admin\Survey;

use App\Models\Survey;
use Livewire\Component;

class Data extends Component
{
    public $inputUrl;


    public function updateSurvey()
    {
        $survey = Survey::first();

        try {
            Survey::where('SURVEY_ID', $survey->SURVEY_ID)->update(['SURVEY_URL' => $this->inputUrl]);

            $this->dispatch("data-updated", "Alamat formulir survey berhasil diperbaharui");
            $this->reset();

        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }


    public function resetForm()
    {
        $this->reset();
    }


    public function render()
    {
        $data = Survey::latest()->first();

        return view('livewire.admin.survey.data', [
            'data' => $data,
        ]);
    }
}
