<?php

namespace App\Livewire\Praja\PengumpulanSkripsi;

use App\Models\PivotSkripsi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{
    public $praja, $npp, $data;
    public $buttonCreate;



    #[On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function resetForm()
    {
        $this->reset();
    }



    public function mount()
    {
        $this->npp = explode("@", Auth::user()->email)[0];
        $this->praja = User::where("id", Auth::user()->id)->first();
        $this->data = PivotSkripsi::where('PIVOT_PRAJA', $this->npp)->first();
        $this->buttonCreate = $this->data == null ? true : 'disabled';
    }



    public function render()
    {
        return view('livewire.praja.pengumpulan-skripsi.pengajuan', [
            'data' => $this->data,
        ]);
    }
}
