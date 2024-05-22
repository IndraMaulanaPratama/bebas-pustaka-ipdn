<?php

namespace App\Livewire\Praja\Dashboard;

use App\Models\BebasPustaka;
use App\Models\DonasiElektronik;
use App\Models\DonasiFakultas;
use App\Models\DonasiPustaka;
use App\Models\KontenLiterasi;
use App\Models\PinjamanFakultas;
use App\Models\PinjamanPustaka;
use App\Models\Repository;
use App\Models\SettingApps;
use App\Models\Similaritas;
use App\Models\SkripsiFakultas;
use App\Models\SkripsiPerpustakaan;
use App\Models\SkripsiSoftcopy;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{
    public $npp, $praja, $fakultas, $bebasPustaka;
    public $buttonPrint, $resume, $data, $sprint;



    #[On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function generateSurat()
    {
        $jumlahData = BebasPustaka::count();
        $nomor = sprintf("%04s", abs($jumlahData + 1));
        $tahun = Carbon::now('Asia/Jakarta')->format("Y");
        return "000.5.2.4/SKBP-" . $this->fakultas . "." . $nomor . "/IPDN.18.4/" . $tahun;
    }



    public function buatSurat()
    {
        $nomorSurat = $this->generateSurat();

        try {
            $data = [
                'BEBAS_ID' => uuid_create(4),
                'BEBAS_NUMBER' => $nomorSurat,
                'BEBAS_PRAJA' => $this->npp,
                'BEBAS_OFFICER' => 1,
            ];

            BebasPustaka::create($data);
            $this->bebasPustaka = false;

            $this->dispatch("data-created", "Selamat, Surat Keterangan Bebas Pustaka anda sudah siap diterbitkan");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }

    }



    public function mount()
    {
        $this->npp = explode("@", Auth::user()->email)[0];
        $this->praja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $this->npp), true)['data'][0];
        $this->praja['NOMOR_PONSEL'] = User::where('email', Auth::user()->email)->first()->nomor_ponsel;

        if ('PERLINDUNGAN MASYARAKAT' == $this->praja['FAKULTAS']) {
            $this->fakultas = 'FPM';
        } elseif ('POLITIK PEMERINTAHAN' == $this->praja['FAKULTAS']) {
            $this->fakultas = 'FPP';
        } elseif ('Manajemen Pemerintahan' == $this->praja['FAKULTAS']) {
            $this->fakultas = 'FMP';
        }
    }



    public function render()
    {

        $this->sprint = SettingApps::where('SETTING_ID', 1)->first();

        $this->bebasPustaka = BebasPustaka::where('BEBAS_PRAJA', $this->npp)->first() != null ? true : false;

        $similaritas = Similaritas::where('SIMILARITAS_PRAJA', $this->npp)->first()->SIMILARITAS_STATUS ?? 'Belum ada pengajuan';
        $pinjamanPustaka = PinjamanPustaka::where('PUSTAKA_PRAJA', $this->npp)->first()->PUSTAKA_STATUS ?? 'Belum ada pengajuan';
        $pinjamanFakultas = PinjamanFakultas::where('FAKULTAS_PRAJA', $this->npp)->first()->FAKULTAS_STATUS ?? 'Belum ada pengajuan';
        $donasiPustaka = DonasiPustaka::where('PUSTAKA_PRAJA', $this->npp)->first()->PUSTAKA_STATUS ?? 'Belum ada pengajuan';
        $donasiFakultas = DonasiFakultas::where('FAKULTAS_PRAJA', $this->npp)->first()->FAKULTAS_STATUS ?? 'Belum ada pengajuan';
        $donasiElektronik = DonasiElektronik::where('ELEKTRONIK_PRAJA', $this->npp)->first()->ELEKTRONIK_STATUS ?? 'Belum ada pengajuan';
        $survey = Survey::where('SURVEY_PRAJA', $this->npp)->first()->SURVEY_STATUS ?? 'Belum ada pengajuan';
        $kontenLiterasi = KontenLiterasi::where('KONTEN_PRAJA', $this->npp)->first()->KONTEN_STATUS ?? 'Belum ada pengajuan';
        $repository = Repository::where('REPOSITORY_PRAJA', $this->npp)->first()->REPOSITORY_STATUS ?? 'Belum ada pengajuan';
        $skripsiPustaka = SkripsiPerpustakaan::where('SKRIPSI_PRAJA', $this->npp)->first()->SKRIPSI_STATUS ?? 'Belum ada pengajuan';
        $skripsiFakultas = SkripsiFakultas::where('SKRIPSI_PRAJA', $this->npp)->first()->SKRIPSI_STATUS ?? 'Belum ada pengajuan';
        $skripsiSoftcopy = SkripsiSoftcopy::where('SKRIPSI_PRAJA', $this->npp)->first()->SKRIPSI_STATUS ?? 'Belum ada pengajuan';

        if (
            'Disetujui' == $similaritas &&
            'Disetujui' == $pinjamanPustaka &&
            'Disetujui' == $pinjamanFakultas &&
            'Disetujui' == $donasiPustaka &&
            'Disetujui' == $donasiFakultas &&
            'Disetujui' == $donasiElektronik &&
            'Disetujui' == $survey &&
            'Disetujui' == $kontenLiterasi &&
            'Disetujui' == $repository &&
            'Disetujui' == $skripsiPustaka &&
            'Disetujui' == $skripsiFakultas &&
            'Disetujui' == $skripsiSoftcopy
        ) {
            $this->resume = true;
        } else {
            $this->resume = false;
        }

        $this->buttonPrint = $this->resume == true && $this->bebasPustaka == false ? null : 'hidden';


        // dd(Similaritas::get());

        $this->data = [
            [
                'pengajuan' => 'Pemeriksaan Similaritas',
                'status' => $similaritas
            ],
            [
                'pengajuan' => 'Bebas Pinjaman Buku Perpustakaan Pusat',
                'status' => $pinjamanPustaka
            ],
            [
                'pengajuan' => 'Bebas Pinjaman Buku Perpustakaan Fakultas',
                'status' => $pinjamanFakultas
            ],
            [
                'pengajuan' => 'Donasi Buku Perpustakaan Pusat',
                'status' => $donasiPustaka
            ],
            [
                'pengajuan' => 'Donasi Buku Perpustakaan Fakultas',
                'status' => $donasiFakultas
            ],
            [
                'pengajuan' => 'Donasi Poin Perpustakaan Pusat',
                'status' => $donasiElektronik
            ],
            [
                'pengajuan' => 'Pengisian Survey',
                'status' => $survey
            ],
            [
                'pengajuan' => 'Konten Literasi',
                'status' => $kontenLiterasi
            ],
            [
                'pengajuan' => 'Unggah Repository',
                'status' => $repository
            ],
            [
                'pengajuan' => 'Pengumpulan Hard Copy Skripsi di Perpustakaan Pusat',
                'status' => $skripsiPustaka
            ],
            [
                'pengajuan' => 'Pengumpulan Hard Copy Skripsi di Perpustakaan Fakultas',
                'status' => $skripsiFakultas
            ],
            [
                'pengajuan' => 'Pengumpulan Soft Copy Skripsi',
                'status' => $skripsiSoftcopy
            ],

        ];

        return view('livewire.praja.dashboard.dashboard');
    }



}
