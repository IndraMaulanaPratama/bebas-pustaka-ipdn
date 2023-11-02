<?php

namespace App\Livewire\Praja\Similaritas;

use App\Models\Similaritas;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormPengajuan extends Component
{
    public $inputJudul, $inputKelas, $inputAbsen;
    public $praja, $npp;

    public function validasiForm($form, $name)
    {
        $form == null ? $this->dispatch("failed-creating-similaritas", "Data " . $name . " tidak boleh dikosongkan") : true;
        return;
    }



    public function resetForm()
    {
        $this->reset();
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

        $jumlahData = Similaritas::whereNotNull('SIMILARITAS_APPROVED')->count();
        $nomor = sprintf("%04s", abs($jumlahData + 1));
        $tahun = Carbon::now('Asia/Jakarta')->format("Y");
        return "000.5.2.4/BPS-" . $fakultas . ". - /IPDN.21/" . $tahun;
    }



    public function createPengajuan()
    {
        $this->validasiForm($this->inputAbsen, "Absen");
        $this->validasiForm($this->inputKelas, "Kelas");
        $this->validasiForm($this->inputJudul, "Judul");

        try {
            $id = uuid_create(4);
            $officer = Auth::user()->id;
            $kodeSurat = $this->generateNomorSurat($this->praja['FAKULTAS']);


            $data = [
                'SIMILARITAS_ID' => $id,
                'SIMILARITAS_NUMBER' => $kodeSurat,
                'SIMILARITAS_PRAJA' => $this->npp,
                'SIMILARITAS_OFFICER' => $officer,
                'SIMILARITAS_TITLE' => $this->inputJudul,
                'SIMILARITAS_CLASS' => $this->inputKelas,
                'SIMILARITAS_ABSENT' => $this->inputAbsen,
            ];

            Similaritas::create($data);

            $this->dispatch("similaritas-created", "Pengajuan similaritas anda sudah berhasil disimpan");
            $this->reset();
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-similaritas", $th->getMessage());
        }
    }


    public function mount()
    {
        $this->npp = explode("@", Auth::user()->email)[0];
        $this->praja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $this->npp), true)["data"][0];
    }



    public function render()
    {
        return view('livewire.praja.similaritas.form-pengajuan');
    }
}
