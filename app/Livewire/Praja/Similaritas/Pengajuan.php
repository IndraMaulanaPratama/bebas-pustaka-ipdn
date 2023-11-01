<?php

namespace App\Livewire\Praja\Similaritas;

use App\Models\Similaritas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{
    public $buttonPengajuan, $buttonPonsel;

    #[On("ponsel-updated")]
    public function enableButtonPengajuan()
    {
        $this->buttonPengajuan = null;
    }

    #[On("similaritas-created")]
    public function disableButtonPengajuan()
    {
        $this->buttonPengajuan = "disabled";
    }


    public function mount()
    {
        $npp = explode("@", Auth::user()->email)[0];
        $praja = User::where("id", Auth::user()->id)->first();
        $similaritas = Similaritas::where('SIMILARITAS_PRAJA', $npp)->first();

        $praja->nomor_ponsel != null ? $this->buttonPonsel == 'disabled' : null;
        $praja->nomor_ponsel != null && $similaritas == null ? $this->buttonPengajuan = null : $this->buttonPengajuan = 'disabled';
    }


    public function render()
    {
        return view('livewire.praja.similaritas.pengajuan');
    }
}
