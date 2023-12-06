<?php

namespace App\Livewire\Praja\KontenLiterasi;

use App\Models\KontenLiterasi;
use App\Models\SettingApps;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{
    public $praja, $npp, $survey;
    public $inputUrl;
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
                'KONTEN_ID' => uuid_create(4),
                'KONTEN_URL' => $this->inputUrl,
                'KONTEN_PRAJA' => $this->npp,
                'KONTEN_OFFICER' => 1,
                'KONTEN_STATUS' => 'Proses'
            ];

            KontenLiterasi::create($data);

            $this->buttonCreate = 'disabled';

            $this->dispatch("data-created", "Pengajuan tahap konten literasi anda berhasil disimpan");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }
    }



    public function resetForm()
    {
        $this->reset();
    }



    public function mount()
    {
        $this->npp = explode("@", Auth::user()->email)[0];
        $this->praja = User::where("id", Auth::user()->id)->first();
        $this->survey = KontenLiterasi::where('KONTEN_PRAJA', $this->npp)->first();
        $this->buttonCreate = $this->survey == null ? true : 'disabled';
    }



    public function render()
    {
        $setting = SettingApps::first();

        return view('livewire.praja.konten-literasi.pengajuan', [
            'setting' => $setting,
        ]);
    }
}
