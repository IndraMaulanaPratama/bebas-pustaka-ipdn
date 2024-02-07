<?php

namespace App\Livewire\Praja\SurveyPraja;

use App\Models\SettingApps;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{
    public $praja, $npp, $survey;
    public $buttonCreate;



    #[On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



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

            $data = [
                'SURVEY_ID' => uuid_create(4),
                'SURVEY_PRAJA' => $this->npp,
                'SURVEY_FAKULTAS' => $fakultas,
                'SURVEY_OFFICER' => 1,
                'SURVEY_STATUS' => 'Proses'
            ];

            Survey::create($data);


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
        $this->survey = Survey::where('SURVEY_PRAJA', $this->npp)->first();
        $this->buttonCreate = $this->survey == null ? true : 'disabled';
    }



    public function render()
    {
        $setting = SettingApps::first();

        return view('livewire.praja.survey-praja.pengajuan', [
            'setting' => $setting,
        ]);
    }
}
