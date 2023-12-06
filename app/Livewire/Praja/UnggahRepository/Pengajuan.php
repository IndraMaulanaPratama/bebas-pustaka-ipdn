<?php

namespace App\Livewire\Praja\UnggahRepository;

use App\Models\Repository;
use App\Models\SettingApps;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{
    public $praja, $npp, $data, $inputUrl;
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
                'REPOSITORY_ID' => uuid_create(4),
                'REPOSITORY_URL' => $this->inputUrl,
                'REPOSITORY_PRAJA' => $this->npp,
                'REPOSITORY_OFFICER' => 1,
                'REPOSITORY_STATUS' => 'Proses'
            ];

            Repository::create($data);

            $this->buttonCreate = 'disabled';

            $this->dispatch("data-created", "Pengajuan tahap unggah repository anda berhasil disimpan");
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
        $this->data = Repository::where('REPOSITORY_PRAJA', $this->npp)->first();
        $this->buttonCreate = $this->data == null ? true : 'disabled';
    }



    public function render()
    {
        $setting = SettingApps::first();
        return view('livewire.praja.unggah-repository.pengajuan', [
            'data' => $this->data,
            'setting' => $setting,
        ]);
    }
}
