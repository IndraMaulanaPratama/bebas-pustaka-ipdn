<?php

namespace App\Livewire\Praja\Donasi;

use App\Models\DonasiElektronik;
use App\Models\DonasiFakultas;
use App\Models\DonasiPustaka;
use App\Models\PivotDonasi;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{
    public $praja, $npp, $donasi, $prajaFakultas;
    public $buttonCreate;




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
