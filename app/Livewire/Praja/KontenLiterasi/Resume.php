<?php

namespace App\Livewire\Praja\KontenLiterasi;

use App\Models\KontenLiterasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Resume extends Component
{
    public $praja, $npp, $konten, $inputUrl;

    public $buttonAjukan = 'hidden', $buttonContent = 'hidden';
    public $buttonCreate;



    #[On("failed-updating-data"), On("data-updated"), On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function pengajuanUlang()
    {
        if (null != $this->inputUrl):
            try {
                $data = [
                    'KONTEN_STATUS' => 'Proses',
                    'KONTEN_URL' => $this->inputUrl,
                ];

                KontenLiterasi::where('KONTEN_PRAJA', $this->npp)->update($data);

                $this->dispatch("data-updated", "Pengajuan tahap konten literasi anda berhasil diajukan ulang");
            } catch (\Throwable $th) {
                $this->dispatch("failed-creating-data", $th->getMessage());
            }

        else:
            $this->dispatch("failed-creating-data", "Data Tautan URL tidak boleh dikosongkan");
            return;
        endif;
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
        $this->konten = KontenLiterasi::where('KONTEN_PRAJA', $this->npp)->first();

        if ($this->konten != null) {
            $this->buttonAjukan = $this->konten->KONTEN_STATUS != 'Ditolak' ? 'hidden' : null;
            $this->buttonContent = null;
            $this->konten != null ? $this->buttonCreate = 'hidden' : $this->buttonCreate = true;
        }

        return view('livewire.praja.konten-literasi.resume', [
            'data' => $this->konten,
        ]);
    }
}
