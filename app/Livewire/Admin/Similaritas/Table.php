<?php

namespace App\Livewire\Admin\Similaritas;

use App\Http\Controllers\SimilaritasController;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Table extends Component
{
    // protected $prajaApi = SimilaritasController::class;
    public $buttonCreate, $buttonApprove;
    public $sortStatus, $sortKelas, $search;
    public $npp,
    $dataPraja,
    $prajaNama,
    $prajaEmail,
    $prajaTempatTanggalLahir,
    $prajaJenisKelamin,
    $prajaProvinsi,
    $prajaKota,
    $prajaTingkat,
    $prajaAngkatan,
    $prajaKampus,
    $prajaWisma,
    $prajaPropen,
    $prajaFakultas,
    $prajaProdi,
    $prajaKelas,
    $prajaPonsel;

    public function detailPraja($npp)
    {
        $detailPraja = json_decode(file_get_contents("http://localhost:8001/api/praja?npp=" . $npp), true);
        $this->dataPraja = $detailPraja["data"][0];
        $tanggalLahir = Carbon::createFromFormat("Y-m-d", $this->dataPraja["TANGGAL_LAHIR"])->format("d M Y");
        $jenisKelamin = $this->dataPraja['JENIS_KELAMIN'] == "P" ? "PEREMPUAN" : "LAKI-LAKI";

        $this->prajaNama = $this->dataPraja['NAMA'];
        $this->prajaEmail = $this->dataPraja['EMAIL'];
        $this->prajaTempatTanggalLahir = $this->dataPraja['TEMPAT_LAHIR'] . ', ' . $tanggalLahir;
        $this->prajaJenisKelamin = $jenisKelamin;
        $this->prajaProvinsi = $this->dataPraja['PROVINSI'];
        $this->prajaKota = $this->dataPraja['KOTA'];
        $this->prajaTingkat = $this->dataPraja['TINGKAT'];
        $this->prajaAngkatan = $this->dataPraja['ANGKATAN'];
        $this->prajaKampus = $this->dataPraja['KAMPUS'];
        $this->prajaWisma = $this->dataPraja['WISMA'];

        $this->prajaPropen = $this->dataPraja['PROGRAM_PENDIDIKAN'];
        $this->prajaFakultas = $this->dataPraja['FAKULTAS'];
        $this->prajaProdi = $this->dataPraja['PROGRAM_STUDI'];
        $this->prajaKelas = $this->dataPraja['KELAS'];
        $this->prajaPonsel = $this->dataPraja['NOMOR_PONSEL'];

    }


    public function render()
    {
        $similaritas = User::latest()->paginate();
        return view('livewire.admin.similaritas.table', [
            'similaritas' => $similaritas
        ]);
    }
}
