<?php

namespace App\Livewire\Praja\Pinjaman;

use App\Models\PinjamanPustaka;
use App\Models\PivotPinjaman;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Resume extends Component
{
    public $praja, $npp, $dataPinjaman;
    public $buttonPengajuan;

    public function mount()
    {
        // Ngadamel data npp dumasar kana email praja
        $this->npp = explode("@", Auth::user()->email)[0];

        // Nyandak data praja ka server satu praja dumasar kana npp
        $praja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $this->npp));
        $this->praja = $praja->data[0];

        $this->dataPinjaman = PivotPinjaman::where('PIVOT_PRAJA', $this->npp)->first();
        $this->dataPinjaman == null ? $this->buttonPengajuan = null : $this->buttonPengajuan = 'hidden';
    }



    public function render()
    {
        return view('livewire.praja.pinjaman.resume', [

            'praja' => $this->praja
        ]);
    }
}
