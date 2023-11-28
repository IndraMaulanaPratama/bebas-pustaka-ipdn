<?php

namespace App\Livewire\Praja\Donasi;

use App\Models\DonasiElektronik;
use App\Models\DonasiFakultas;
use App\Models\DonasiPustaka;
use App\Models\PivotDonasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{
    public $praja, $npp, $donasi;
    public $buttonCreate;



    #[On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function buatPengajuan()
    {
        try {

            $data_pustaka = [
                'PUSTAKA_ID' => uuid_create(4),
                'PUSTAKA_PRAJA' => $this->npp,
                'PUSTAKA_OFFICER' => 1,
                'PUSTAKA_STATUS' => 'Proses'
            ];

            DonasiPustaka::create($data_pustaka);

            $data_fakultas = [
                'FAKULTAS_ID' => uuid_create(4),
                'FAKULTAS_NUMBER' => 'number',
                'FAKULTAS_PRAJA' => $this->npp,
                'FAKULTAS_OFFICER' => 1,
                'FAKULTAS_STATUS' => 'Proses'
            ];

            DonasiFakultas::create($data_fakultas);

            $data_elektronik = [
                'ELEKTRONIK_ID' => uuid_create(4),
                'ELEKTRONIK_NUMBER' => 'number',
                'ELEKTRONIK_PRAJA' => $this->npp,
                'ELEKTRONIK_OFFICER' => 1,
                'ELEKTRONIK_STATUS' => 'Proses'
            ];

            DonasiElektronik::create($data_elektronik);


            $data_pivot = [
                'PIVOT_ID' => uuid_create(4),
                'PIVOT_PRAJA' => $this->npp,
                'PIVOT_PUSTAKA' => $data_pustaka['PUSTAKA_ID'],
                'PIVOT_FAKULTAS' => $data_fakultas['FAKULTAS_ID'],
                'PIVOT_ELEKTRONIK' => $data_elektronik['ELEKTRONIK_ID'],
            ];

            PivotDonasi::create($data_pivot);

            $this->buttonCreate = 'disabled';

            $this->dispatch("data-created", "Pengajuan donasi perpustakaan anda berhasil disimpan");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }
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
