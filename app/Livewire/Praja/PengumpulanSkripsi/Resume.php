<?php

namespace App\Livewire\Praja\PengumpulanSkripsi;

use App\Models\PivotSkripsi;
use App\Models\SkripsiFakultas;
use App\Models\SkripsiPerpustakaan;
use App\Models\SkripsiSoftcopy;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Resume extends Component
{
    public $praja, $npp, $data;

    public $buttonResendPustaka = 'hidden',
    $buttonResendFakultas = 'hidden',
    $buttonResendSoftcopy = 'hidden';



    #[On("failed-updating-data"), On("data-updated"), On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function resendPengajuan($table)
    {
        try {
            if ('fakultas' == $table) {
                SkripsiFakultas::where('SKRIPSI_PRAJA', $this->npp)->update(['SKRIPSI_STATUS' => 'Proses']);
            } elseif ('pustaka' == $table) {
                SkripsiPerpustakaan::where('SKRIPSI_PRAJA', $this->npp)->update(['SKRIPSI_STATUS' => 'Proses']);
            } elseif ('softcopy' == $table) {
                SkripsiSoftcopy::where('SKRIPSI_PRAJA', $this->npp)->update(['SKRIPSI_STATUS' => 'Proses']);
            }

            $this->dispatch("data-updated", "Pengajuan tahap pengumpulan skripsi anda berhasil diajukan ulang");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }
    }



    public function mount()
    {
        // Ngadamel data npp dumasar kana email praja
        $this->npp = explode("@", Auth::user()->email)[0];

        // Nyandak data praja ka server satu praja dumasar kana npp
        $praja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $this->npp));
        $this->praja = $praja->data[0];
    }



    public function render()
    {
        $this->data = PivotSkripsi::where('PIVOT_PRAJA', $this->npp)->first();

        if ($this->data != null) {
            $this->buttonResendPustaka = $this->data->skripsi_perpustakaan->SKRIPSI_STATUS != 'Ditolak' ? 'hidden' : null;
            $this->buttonResendFakultas = $this->data->skripsi_fakultas->SKRIPSI_STATUS != 'Ditolak' ? 'hidden' : null;
            $this->buttonResendSoftcopy = $this->data->skripsi_softcopy->SKRIPSI_STATUS != 'Ditolak' ? 'hidden' : null;
        }

        return view('livewire.praja.pengumpulan-skripsi.resume');
    }
}
