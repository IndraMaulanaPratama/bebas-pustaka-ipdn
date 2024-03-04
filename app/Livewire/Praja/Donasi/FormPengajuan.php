<?php

namespace App\Livewire\Praja\Donasi;

use App\Models\DonasiElektronik;
use App\Models\DonasiFakultas;
use App\Models\DonasiPustaka;
use App\Models\PivotDonasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class FormPengajuan extends Component
{

    public $npp, $buttonCreate;
    public $inputOrder;





    public function resetForm()
    {
        $this->reset();
    }




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




    public function createPengajuan()
    {
        // Validasi formulir bilih teu di eusian ku semah
        if (null != $this->inputOrder):
            try {

                $fakultas = $this->fakultasPraja($this->npp);

                $data_pustaka = [
                    'PUSTAKA_ID' => uuid_create(4),
                    'PUSTAKA_PRAJA' => $this->npp,
                    'PUSTAKA_FAKULTAS' => $fakultas,
                    'PUSTAKA_OFFICER' => 1,
                    'PUSTAKA_STATUS' => 'Proses'
                ];

                DonasiPustaka::create($data_pustaka);

                $data_fakultas = [
                    'FAKULTAS_ID' => uuid_create(4),
                    'FAKULTAS_NUMBER' => 'number',
                    'FAKULTAS_PRAJA' => $this->npp,
                    'FAKULTAS_FAKULTAS' => $fakultas,
                    'FAKULTAS_OFFICER' => 1,
                    'FAKULTAS_STATUS' => 'Proses'
                ];

                DonasiFakultas::create($data_fakultas);

                $data_elektronik = [
                    'ELEKTRONIK_ID' => uuid_create(4),
                    'ELEKTRONIK_ID_PO' => trim($this->inputOrder),
                    'ELEKTRONIK_NUMBER' => 'number',
                    'ELEKTRONIK_PRAJA' => $this->npp,
                    'ELEKTRONIK_FAKULTAS' => $fakultas,
                    'ELEKTRONIK_OFFICER' => 1,
                    'ELEKTRONIK_STATUS' => 'Proses'
                ];

                DonasiElektronik::create($data_elektronik);


                $data_pivot = [
                    'PIVOT_ID' => uuid_create(4),
                    'PIVOT_PRAJA' => $this->npp,
                    'PIVOT_PUSTAKA' => $data_pustaka['PUSTAKA_ID'],
                    'PIVOT_FAKULTAS' => $data_fakultas['FAKULTAS_ID'],
                    'PIVOT_ELEKTRONIK' => $data_elektronik['ELEKTRONIK_ID'],
                ];

                PivotDonasi::create($data_pivot);

                $this->buttonCreate = 'disabled';

                $this->dispatch("data-created", "Pengajuan donasi perpustakaan anda berhasil disimpan");
            } catch (\Throwable $th) {
                $this->dispatch("failed-creating-data", $th->getMessage());
            }

        else:
            // Masihan beja error ka semah kusabab form id po teu di eusian
            $this->dispatch("failed-creating-data", 'Nomor Purches Order (PO) harus tidak boleh dikosongkan');

        endif;


    }




    public function mount()
    {
        $this->npp = explode("@", Auth::user()->email)[0];
        $this->praja = User::where("id", Auth::user()->id)->first();
        $this->donasi = PivotDonasi::where('PIVOT_PRAJA', $this->npp)->first();
        $this->buttonCreate = $this->donasi == null ? true : 'disabled';

    }



    public function render()
    {
        return view('livewire.praja.donasi.form-pengajuan');
    }
}
