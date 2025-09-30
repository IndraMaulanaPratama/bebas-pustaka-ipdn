<?php

namespace App\Livewire\Praja\BimbinganPemustaka;

use App\Models\bimbingan_pemustaka;
use App\Services\PrajaService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;


class Resume extends Component
{

    public $praja, $npp, $pengajuan;
    public $buttonResendPustaka = 'hidden', $buttonResendFakultas = 'hidden';
    protected $prajaService;


    #[On("failed-updating-data"), On("data-updated"), On("data-created"), On("failed-creating-data")]
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
    }



    public function resendPengajuan($id)
    {
        try {
            //code...
            $data = ['PEMUSTAKA_STATUS' => "Proses"];
            bimbingan_pemustaka::where('PEMUSTAKA_ID', $id)->update($data);

            $this->dispatch('data-updated', 'Pengajuan anda sudah kami terima');

        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('failed-updating-data', 'Pengajuan anda gagal dibuat, silahkan hubungi pihak pengembang aplikasi');
        }
    }



    public function render()
    {

        // Milarian data bimbingan_pemustaka dumasar kana npp
        $this->pengajuan = bimbingan_pemustaka::where('PEMUSTAKA_PRAJA', $this->npp)->first();


        // aturan kanggo tombol pengajuan ulang upami tos di tolak ku petugas
        if ($this->pengajuan != null) {
            $this->buttonResendPustaka = $this->pengajuan->PEMUSTAKA_STATUS != 'Ditolak' ? 'hidden' : null;
        }


        return view('livewire.praja.bimbingan-pemustaka.resume', [
            'praja' => $this->praja,
            'data' => $this->pengajuan
        ]);
    }
}
