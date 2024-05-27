<?php

namespace App\Livewire\Praja\UnggahRepository;

use App\Models\Repository;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Resume extends Component
{
    public $praja, $npp, $data, $inputUrl;

    public $buttonAjukan = 'hidden';



    #[On("failed-updating-data"), On("data-updated"), On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function pengajuanUlang()
    {
        try {

            Repository::where('REPOSITORY_PRAJA', $this->npp)->update([
                'REPOSITORY_URL' => $this->inputUrl,
                'REPOSITORY_STATUS' => 'Proses'
            ]);

            $this->dispatch("data-updated", "Pengajuan tahap unggah repository anda berhasil diajukan ulang");
            $this->buttonAjukan = 'hidden';
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
        $this->data = Repository::where('REPOSITORY_PRAJA', $this->npp)->first();

        if ($this->data != null) {
            $this->buttonAjukan = $this->data->REPOSITORY_STATUS != 'Ditolak' ? 'hidden' : null;
        }

        return view('livewire.praja.unggah-repository.resume', [
            'data' => $this->data,
            'praja' => $this->praja,
        ]);
    }
}
