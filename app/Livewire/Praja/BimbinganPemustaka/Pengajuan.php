<?php

namespace App\Livewire\Praja\BimbinganPemustaka;

use App\Models\bimbingan_pemustaka;
use App\Models\User;
use App\Services\PrajaService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{

    public $praja, $npp, $pengajuan;
    public $buttonCreate, $inisialFakultas;
    protected $prajaService;



    #[On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function boot(PrajaService $prajaService)
    {
        // Ngadamel data npp dumasar kana email praja
        $this->npp = explode("@", Auth::user()->email)[0];

        // Ngaktifkeun service praja
        $this->prajaService = $prajaService;
    }



    public function mount()
    {
        // Milarian detail praja dumasar kana npp
        $this->praja = $this->prajaService->getDetailPraja($this->npp) ?? [];

        $this->pengajuan = bimbingan_pemustaka::where('PEMUSTAKA_PRAJA', $this->npp)->first();

        // upami tos aya pengajuan mah tombola pareuman weh lur
        $this->buttonCreate = $this->pengajuan == null ? true : 'disabled';

        // Ngadamel inisial fakultas kanggo di lebetkeun kana database
        $this->inisialFakultas = $this->prajaService->getInisialFakultas($this->praja['FAKULTAS']);

    }



    public function buatPengajuan()
    {
        try {

            $data = [
                'PEMUSTAKA_ID' => uuid_create(4),
                'PEMUSTAKA_PRAJA' => $this->npp,
                'PEMUSTAKA_FAKULTAS' => $this->inisialFakultas,
                'PEMUSTAKA_OFFICER' => 1,
                'PEMUSTAKA_STATUS' => 'Proses'
            ];

            bimbingan_pemustaka::create($data);


            $this->buttonCreate = 'disabled';

            $this->dispatch("data-created", "Pengajuan Bimbingan Pemustaka anda berhasil disimpan");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }
    }



    public function render()
    {
        return view('livewire.praja.bimbingan-pemustaka.pengajuan');
    }
}
