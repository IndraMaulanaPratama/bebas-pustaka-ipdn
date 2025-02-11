<?php

namespace App\Livewire\Praja\Pinjaman;

use App\Models\PinjamanFakultas;
use App\Models\PinjamanPustaka;
use App\Models\PivotPinjaman;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Pengajuan extends Component
{
    public $praja, $npp, $pinjaman;
    public $buttonCreate;


    #[On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }


    public function generateNomorSurat($npp)
    {

        $detailPraja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $npp), true);
        $dataPraja = $detailPraja["data"][0];

        if ($dataPraja['FAKULTAS'] == "POLITIK PEMERINTAHAN") {
            $fakultas = "FPP";
        } elseif ($dataPraja['FAKULTAS'] == "MANAJEMEN PEMERINTAHAN") {
            $fakultas = "FMP";
        } elseif ($dataPraja['FAKULTAS'] == "PERLINDUNGAN MASYARAKAT") {
            $fakultas = "FPM";
        }

        // $jumlahData = PinjamanPustaka::where('SIMILARITAS_APPROVED', "Disetujui")->count();
        $jumlahData = PinjamanPustaka::whereNotNull('PUSTAKA_APPROVED')->count();
        $nomor = sprintf("%04s", abs($jumlahData + 1));
        $tahun = Carbon::now('Asia/Jakarta')->format("Y");
        return "000.5.6.2/BBPB-" . $fakultas . "." . $nomor . "/IPDN.21/" . $tahun;
    }



    public function buatPengajuan()
    {
        try {
            $id = uuid_create(4);
            $nomorSurat = $this->generateNomorSurat($this->npp);

            $data_pustaka = [
                'PUSTAKA_ID' => $id,
                'PUSTAKA_PRAJA' => $this->npp,
                'PUSTAKA_NUMBER' => $nomorSurat,
                'PUSTAKA_OFFICER' => 1,
                'PUSTAKA_STATUS' => 'Proses'
            ];

            PinjamanPustaka::create($data_pustaka);

            $data_fakultas = [
                'FAKULTAS_ID' => $id,
                'FAKULTAS_PRAJA' => $this->npp,
                'FAKULTAS_NUMBER' => $nomorSurat,
                'FAKULTAS_OFFICER' => 1,
                'FAKULTAS_STATUS' => 'Proses'
            ];

            PinjamanFakultas::create($data_fakultas);

            $data_pivot = [
                'PIVOT_ID' => uuid_create(4),
                'PIVOT_PRAJA' => $this->npp,
                'PIVOT_PUSTAKA' => $data_pustaka['PUSTAKA_ID'],
                'PIVOT_FAKULTAS' => $data_fakultas['FAKULTAS_ID'],
            ];

            PivotPinjaman::create($data_pivot);

            $this->buttonCreate = 'disabled';

            $this->dispatch("data-created", "Pengajuan bebas pinjaman anda berhasil disimpan");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }
    }



    public function mount()
    {
        $this->npp = explode("@", Auth::user()->email)[0];
        $this->praja = User::where("id", Auth::user()->id)->first();
        $this->pinjaman = PivotPinjaman::where('PIVOT_PRAJA', $this->npp)->first();
        $this->buttonCreate = $this->pinjaman == null ? true : 'disabled';
    }



    public function render()
    {
        return view('livewire.praja.pinjaman.pengajuan');
    }
}
