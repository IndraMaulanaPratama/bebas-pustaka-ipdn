<?php

namespace App\Livewire\Praja\Donasi;

use App\Models\DonasiElektronik;
use App\Models\DonasiFakultas;
use App\Models\DonasiPustaka;
use App\Models\PivotDonasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Resume extends Component
{
    public $praja, $npp, $dataDonasi, $inputOrder, $inputID;

    public $buttonResendPustaka = 'hidden',
    $buttonResendFakultas = 'hidden',
    $buttonResendElektronik = 'hidden';



    #[On("failed-updating-data"), On("data-updated"), On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function resetForm()
    {
        $this->inputOrder = null;
    }



    public function resendPengajuan($table)
    {
        try {
            if ('fakultas' == $table) {
                DonasiFakultas::where('FAKULTAS_PRAJA', $this->npp)->update(['FAKULTAS_STATUS' => 'Proses']);
            } elseif ('pustaka' == $table) {
                DonasiPustaka::where('PUSTAKA_PRAJA', $this->npp)->update(['PUSTAKA_STATUS' => 'Proses']);
            }

            $this->dispatch("data-updated", "Pengajuan donasi perpustakaan anda berhasil diajukan ulang");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }
    }




    // Pengajuan ulang donasi poin
    public function createPengajuanUlang()
    {
        if (null != $this->inputOrder):
            try {
                $data = [
                    'ELEKTRONIK_STATUS' => 'Proses',
                    'ELEKTRONIK_ID_PO' => trim($this->inputOrder),
                ];

                DonasiElektronik::where('ELEKTRONIK_ID', $this->inputID)->update($data);

                $this->dispatch("data-updated", "Pengajuan donasi perpustakaan anda berhasil diajukan ulang");
            } catch (\Throwable $th) {
                $this->dispatch("failed-creating-data", $th->getMessage());
            }

        else:
            $this->dispatch("failed-creating-data", 'Data ID Purchase Order (PO) tidak boleh dikosongkan');
        endif;
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
        $this->dataDonasi = PivotDonasi::where('PIVOT_PRAJA', $this->npp)->first();

        if ($this->dataDonasi != null) {
            $this->inputID = $this->dataDonasi->donasi_elektronik->ELEKTRONIK_ID;
            $this->buttonResendPustaka = $this->dataDonasi->donasi_pustaka->PUSTAKA_STATUS != 'Ditolak' ? 'hidden' : null;
            $this->buttonResendFakultas = $this->dataDonasi->donasi_fakultas->FAKULTAS_STATUS != 'Ditolak' ? 'hidden' : null;
            $this->buttonResendElektronik = $this->dataDonasi->donasi_elektronik->ELEKTRONIK_STATUS != 'Ditolak' ? 'hidden' : null;
        }

        return view('livewire.praja.donasi.resume', [
            'data' => $this->dataDonasi,
            'praja' => $this->praja
        ]);
    }
}
