<?php

namespace App\Livewire\Praja\Similaritas;

use App\Models\Similaritas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Resume extends Component
{
    public $npp, $praja, $similaritas, $buttonAjukan = 'invisible';


    public function mount()
    {
        // Ngadamel data npp dumasar kana email praja
        $this->npp = explode("@", Auth::user()->email)[0];

        // Nyandak data praja ka server satu praja dumasar kana npp
        $praja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $this->npp));
        $this->praja = $praja->data[0];

        // Milarian data pengajuan similaritas dumasar kana npp
        $this->similaritas = Similaritas::where("SIMILARITAS_PRAJA", $this->npp)->first();

        if ($this->similaritas != null) {
            // Ngadamel aturan kanggo tombol ajukan ulang
            $this->buttonAjukan = $this->similaritas->SIMILARITAS_STATUS == "Ditolak" ? null : "invisible";
        }
    }



    #[On("similaritas-created"), On("similaritas-updated")]
    /**
     * Fungsi anu dijalankeun upami aya sinyal anu tos di tangtoskeun di atribut diluhur
     */
    public function updateDataSimilaritas()
    {
        $this->similaritas = Similaritas::where("SIMILARITAS_PRAJA", $this->npp)->first();
        $this->buttonAjukan = $this->similaritas->SIMILARITAS_STATUS == "Ditolak" ? null : "invisible";
    }



    /**
     * Fungsi kanggo ngirimkeun pengajuan ulang ti praja anu tos di tolak
     */
    public function pengajuanUlang($id)
    {
        try {
            Similaritas::where('SIMILARITAS_ID', $id)->update(['SIMILARITAS_STATUS' => 'Proses']);

            $this->dispatch('similaritas-updated', 'Pengajuan anda sudah kami terima');
        } catch (\Throwable $th) {
            $this->dispatch('similaritas-updated', 'Pengajuan anda sudah kami terima');
            $this->dispatch('failed-updating-similaritas', $th->getMessage());
        }
    }



    public function render()
    {
        return view('livewire.praja.similaritas.resume');
    }
}
