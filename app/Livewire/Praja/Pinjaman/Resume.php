<?php

namespace App\Livewire\Praja\Pinjaman;

use App\Models\PinjamanFakultas;
use App\Models\PinjamanPustaka;
use App\Models\PivotPinjaman;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Resume extends Component
{
    public $praja, $npp, $dataPinjaman;
    public $buttonResendPustaka = 'hidden', $buttonResendFakultas = 'hidden';



    #[On("failed-updating-data"), On("data-updated"), On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function resendPengajuan($table)
    {
        try {
            if ('fakultas' == $table) {
                PinjamanFakultas::where('FAKULTAS_PRAJA', $this->npp)->update(['FAKULTAS_STATUS' => 'Proses']);
            } elseif ('pustaka' == $table) {
                PinjamanPustaka::where('PUSTAKA_PRAJA', $this->npp)->update(['PUSTAKA_STATUS' => 'Proses']);
            }

            $this->dispatch("data-updated", "Pengajuan bebas pinjaman anda berhasil diajukan ulang");
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
        $this->dataPinjaman = PivotPinjaman::where('PIVOT_PRAJA', $this->npp)->first();

        if ($this->dataPinjaman != null) {
            $this->buttonResendPustaka = $this->dataPinjaman->pinjaman_pustaka->PUSTAKA_STATUS != 'Ditolak' ? 'hidden' : null;
            $this->buttonResendFakultas = $this->dataPinjaman->pinjaman_fakultas->FAKULTAS_STATUS != 'Ditolak' ? 'hidden' : null;
        }

        return view('livewire.praja.pinjaman.resume', [
            'data' => $this->dataPinjaman,
            'praja' => $this->praja
        ]);
    }
}
