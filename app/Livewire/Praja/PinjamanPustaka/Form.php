<?php

namespace App\Livewire\Praja\PinjamanPustaka;

use App\Models\PinjamanPustaka;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Form extends Component
{
    public $praja, $npp;
    public $buttonPengajuan;

    public function mount()
    {
        // Ngadamel data npp dumasar kana email praja
        $this->npp = explode("@", Auth::user()->email)[0];

        // Nyandak data praja ka server satu praja dumasar kana npp
        $praja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $this->npp));
        $this->praja = $praja->data[0];

        $pengajuan = PinjamanPustaka::where('PUSTAKA_PRAJA', $this->npp)->first();
        $pengajuan == null ? $this->buttonPengajuan = null : $this->buttonPengajuan = "invisible";
    }



    public function generateNomorSurat($fakultas)
    {
        if ($fakultas == "POLITIK PEMERINTAHAN") {
            $fakultas = "FPP";
        } elseif ($fakultas == "MANAJEMEN PEMERINTAHAN") {
            $fakultas = "FMP";
        } elseif ($fakultas == "PERLINDUNGAN MASYARAKAT") {
            $fakultas = "FPM";
        }

        $jumlahData = PinjamanPustaka::where('SIMILARITAS_APPROVED', "Disetujui")->count();
        $nomor = sprintf("%04s", abs($jumlahData + 1));
        $tahun = Carbon::now('Asia/Jakarta')->format("Y");
        return "000.5.2.4/BBPB-" . $fakultas . ". - ". $nomor ."/IPDN.21/" . $tahun;
    }



    public function buatPengajuan()
    {

    }



    public function render()
    {
        return view('livewire.praja.pinjaman-pustaka.form', [
            'praja' => $this->praja
        ]);
    }
}
