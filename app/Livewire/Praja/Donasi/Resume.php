<?php

namespace App\Livewire\Praja\Donasi;

use App\Models\PivotDonasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Resume extends Component
{
    public $praja, $npp, $dataDonasi;
    public $buttonPengajuan;

    public function mount()
    {
        // Ngadamel data npp dumasar kana email praja
        $this->npp = explode("@", Auth::user()->email)[0];

        // Nyandak data praja ka server satu praja dumasar kana npp
        $praja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $this->npp));
        $this->praja = $praja->data[0];

        $this->dataDonasi = PivotDonasi::where('PIVOT_PRAJA', $this->npp)->first();
        $this->dataDonasi == null ? $this->buttonPengajuan = null : $this->buttonPengajuan = 'hidden';
    }

    public function render()
    {
        return view('livewire.praja.donasi.resume', [
            'praja' => $this->praja
        ]);
    }
}
