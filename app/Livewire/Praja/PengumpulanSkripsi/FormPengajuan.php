<?php

namespace App\Livewire\Praja\PengumpulanSkripsi;

use App\Models\PivotSkripsi;
use App\Models\SkripsiFakultas;
use App\Models\SkripsiPerpustakaan;
use App\Models\SkripsiSoftcopy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormPengajuan extends Component
{
    public $praja, $npp, $data, $judul, $pembimbingSatu, $pembimbingDua;
    public $buttonCreate;



    public function detailPraja($npp)
    {
        $detailPraja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $npp), true);
        $this->dataPraja = $detailPraja["data"][0];

        // $tanggalLahir = Carbon::createFromFormat("Y-m-d", $this->dataPraja["TANGGAL_LAHIR"])->format("d M Y");
        // $jenisKelamin = $this->dataPraja['JENIS_KELAMIN'] == "P" ? "PEREMPUAN" : "LAKI-LAKI";

        // $userPraja = User::where('email', $npp . '@praja.ipdn.ac.id')->first();
        // $nomorPonsel = $userPraja->nomor_ponsel;

        // $this->prajaNama = $this->dataPraja['NAMA'];
        // $this->prajaEmail = $this->dataPraja['EMAIL'];
        // $this->prajaPonsel = $nomorPonsel;
        // $this->prajaTempatTanggalLahir = $this->dataPraja['TEMPAT_LAHIR'] . ', ' . $tanggalLahir;
        // $this->prajaJenisKelamin = $jenisKelamin;
        // $this->prajaProvinsi = $this->dataPraja['PROVINSI'];
        // $this->prajaKota = $this->dataPraja['KOTA'];
        // $this->prajaTingkat = $this->dataPraja['TINGKAT'];
        // $this->prajaAngkatan = $this->dataPraja['ANGKATAN'];
        // $this->prajaKampus = $this->dataPraja['KAMPUS'];
        // $this->prajaWisma = $this->dataPraja['WISMA'];

        // $this->prajaPropen = $this->dataPraja['PROGRAM_PENDIDIKAN'];
        $this->prajaFakultas = $this->dataPraja['FAKULTAS'];
        // $this->prajaProdi = $this->dataPraja['PROGRAM_STUDI'];
        // $this->prajaKelas = $this->dataPraja['KELAS'];
    }



    public function fakultasPraja($npp)
    {
        $this->detailPraja($npp);

        if ($this->prajaFakultas == "POLITIK PEMERINTAHAN") {
            return "FPP";
        } elseif ($this->prajaFakultas == "MANAJEMEN PEMERINTAHAN") {
            return "FMP";
        } elseif ($this->prajaFakultas == "PERLINDUNGAN MASYARAKAT") {
            return "FPM";
        }
    }



    public function buatPengajuan()
    {
        try {
            $fakultas = $this->fakultasPraja($this->npp);

            $data_skripsi = [
                'SKRIPSI_ID' => uuid_create(4),
                'SKRIPSI_PRAJA' => $this->npp,
                'SKRIPSI_FAKULTAS' => $fakultas,
                'SKRIPSI_OFFICER' => 1,
                'SKRIPSI_STATUS' => 'Proses'
            ];

            SkripsiPerpustakaan::create($data_skripsi);
            SkripsiFakultas::create($data_skripsi);
            SkripsiSoftcopy::create($data_skripsi);

            $data_pivot = [
                'PIVOT_ID' => uuid_create(4),
                'PIVOT_PRAJA' => $this->npp,
                'PIVOT_PUSTAKA' => $data_skripsi['SKRIPSI_ID'],
                'PIVOT_FAKULTAS' => $data_skripsi['SKRIPSI_ID'],
                'PIVOT_SOFTCOPY' => $data_skripsi['SKRIPSI_ID'],
                'PIVOT_JUDUL' => $this->judul,
                'PIVOT_PEMBIMBING_SATU' => $this->pembimbingSatu,
                'PIVOT_PEMBIMBING_DUA' => $this->pembimbingDua,
            ];

            PivotSkripsi::create($data_pivot);

            $this->buttonCreate = 'disabled';
            $this->reset();

            $this->dispatch("data-created", "Pengajuan tahap unggah repository anda berhasil disimpan");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }
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
    }

    public function render()
    {
        return view('livewire.praja.pengumpulan-skripsi.form-pengajuan');
    }
}
