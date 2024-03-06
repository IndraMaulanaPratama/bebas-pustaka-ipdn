<?php

namespace App\Livewire\Praja\Donasi;

use App\Models\PivotDonasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{
    public $praja, $npp, $donasi, $prajaFakultas;
    public $buttonCreate;



    #[On("data-created")]
    public function setButtonCreated()
    {
        $this->buttonCreate = "disabled";
    }


    public function mount()
    {
        $this->npp = explode("@", Auth::user()->email)[0];
        $this->praja = User::where("id", Auth::user()->id)->first();
        $this->donasi = PivotDonasi::where('PIVOT_PRAJA', $this->npp)->first();
        $this->buttonCreate = $this->donasi == null ? true : 'disabled';
    }



    public function render()
    {
        return view('livewire.praja.donasi.pengajuan');
    }
}
