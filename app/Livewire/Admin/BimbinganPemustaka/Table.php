<?php

namespace App\Livewire\Admin\BimbinganPemustaka;

use App\Models\Akses;
use App\Models\BebasPustaka;
use App\Models\bimbingan_pemustaka;
use App\Models\Menu;
use App\Services\PrajaService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Route;


class Table extends Component
{
    public $idLogin;
    public $inputUrl;
    public $accessReject, $accessApprove, $accessExport, $accessPrint, $accessUpdate;
    public $sortStatus, $sortFakultas, $angkatan, $search;
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


    protected $prajaService;


    #[On("data-rejected"), On("failed-updating-data"), On("data-updated")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function detailPraja(PrajaService $prajaService, $npp)
    {
        // Ngaktifkeun service praja
        $this->prajaService = $prajaService;


        // Milarian detail praja dumasar kana npp
        $praja = $this->prajaService->getModalDetailPraja($npp) ?? [];

        // Lebetkeun data praja kanu modal detail praja di view
        $this->prajaNama = $praja['NAMA'];
        $this->prajaEmail = $praja['EMAIL'];
        $this->prajaPonsel = $praja['NOMOR_PONSEL'];
        $this->prajaTempatTanggalLahir = $praja['TEMPAT_LAHIR'];
        $this->prajaJenisKelamin = $praja['JENIS_KELAMIN'];
        $this->prajaProvinsi = $praja['PROVINSI'];
        $this->prajaKota = $praja['KOTA'];
        $this->prajaTingkat = $praja['TINGKAT'];
        $this->prajaAngkatan = $praja['ANGKATAN'];
        $this->prajaKampus = $praja['KAMPUS'];
        $this->prajaWisma = $praja['WISMA'];
        $this->prajaPropen = $praja['PROGRAM_PENDIDIKAN'];
        $this->prajaFakultas = $praja['FAKULTAS'];
        $this->prajaProdi = $praja['PROGRAM_STUDI'];
        $this->prajaKelas = $praja['KELAS'];
    }



    public function resetForm()
    {
        $this->reset();
    }



    public function getButtonStatus($status, $officerId)
    {
        $classes = [
            'print' => 'hidden',
            'keep' => 'hidden',
            'approve' => 'hidden',
            'reject' => 'hidden',
            'colorStatus' => null,
            'iconStatus' => null,
        ];

        switch ($status) {
            case 'Proses':
                $classes['keep'] = '';
                $classes['colorStatus'] = 'primary';
                $classes['iconStatus'] = 'bi-arrow-clockwise';
                break;

            case 'Disetujui':
                $classes['print'] = '';
                $classes['colorStatus'] = 'success';
                $classes['iconStatus'] = 'bi-check2-all';
                break;

            case 'Assign':
                $classes['colorStatus'] = 'warning';
                $classes['iconStatus'] = 'bi-hourglass-split';

                if ($officerId == auth()->id()) { // Ganti dengan cara auth Anda
                    $classes['approve'] = '';
                    $classes['reject'] = '';
                }
                break;

            case 'Ditolak':
                $classes['colorStatus'] = 'danger';
                $classes['iconStatus'] = 'bi-dash-circle-fill';
                break;

            default:
                break;
        }

        return $classes;
    }




    public function keepData($id)
    {
        try {

            // Mencari data pengajuan berdasarkan id
            $pengajuan = bimbingan_pemustaka::where('PEMUSTAKA_ID', $id)->first();

            // Validasi statu pengajuan (meminimalisir terjadi double pemeriksaan oleh petugas)
            switch ($pengajuan->PEMUSTAKA_STATUS) {
                case "Proses":

                    // Inisialisasi data pengajuan
                    $data = [
                        'PEMUSTAKA_OFFICER' => $this->idLogin,
                        'PEMUSTAKA_STATUS' => "Assign",
                    ];

                    // Proses update data pengajuan
                    bimbingan_pemustaka::where("PEMUSTAKA_ID", $id)->update($data);

                    // Mengirimkan pesan notifikasi kepada user
                    $this->dispatch("data-updated", "Pengajuan Bimbingan Pemustaka `$pengajuan->PEMUSTAKA_PRAJA` siap untuk periksa");
                    break;

                case 'Assign':
                    // Mengirimkan pesan notifikasi kepada user
                    $this->dispatch("failed-updating-data", "Pengajuan ini sudah diperiksa oleh `$pengajuan->user->name`, silahkan periksa pengajuan lainnya");
                    break;
            }

        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }



    public function approveData($id)
    {
        try {

            // Mencari data pengajuan bimbingan pemustaka berdasarkan id
            $pengajuan = bimbingan_pemustaka::where('PEMUSTAKA_ID', $id)->first();

            // Inisialisasi data bebas pustaka
            $skbp = [
                'BEBAS_BIMBINGAN_PEMUSTAKA' => true
            ];

            // Inisialisasi Data Skripsi Perpustakaan
            $data = [
                'PEMUSTAKA_OFFICER' => Auth::user()->id,
                'PEMUSTAKA_STATUS' => "Disetujui",
                'PEMUSTAKA_NOTES' => null,
                'PEMUSTAKA_APPROVED' => Carbon::now("Asia/Jakarta")->format("Y-m-d H:i:s"),
            ];

            // Proses update data bebas pustaka
            BebasPustaka::where('BEBAS_PRAJA', $pengajuan->PEMUSTAKA_PRAJA)->update($skbp);

            // Proses update data bimbingan pemustaka
            bimbingan_pemustaka::where("PEMUSTAKA_ID", $id)->update($data);

            $this->dispatch("data-updated", "Pengajuan bimbingan pemustaka berhasil disetujui");
            $this->reset();
        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }



    public function rejectData($id)
    {
        $data = bimbingan_pemustaka::where('PEMUSTAKA_ID', $id)->first();
        $this->dispatch('data-selected', $data);
    }




    public function mount()
    {
        $this->idLogin = Auth::user()->id;
        $roleLogin = Auth::user()->user_role;
        $url = Route::getCurrentRoute()->action['as']; // Maca nami route anu nuju di buka


        $menu = Menu::where("MENU_URL", $url)->first();

        $access = Akses::
            join("PIVOT_MENU", "ACCESSES.ACCESS_MENU", '=', "PIVOT_MENU.PIVOT_ID")
            ->where(['PIVOT_MENU.PIVOT_MENU' => $menu->MENU_ID, 'PIVOT_MENU.PIVOT_ROLE' => $roleLogin])
            ->first();
    }




    public function render()
    {

        $data = bimbingan_pemustaka::
            when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("PEMUSTAKA_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("PEMUSTAKA_FAKULTAS", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->search,
                function ($query, $npp) {
                    return $query->where("PEMUSTAKA_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->angkatan,
                function ($query, $angkatan) {
                    return $query->where("PEMUSTAKA_PRAJA", "LIKE", $angkatan . "%");
                }
            )
            ->latest()
            ->paginate();


        return view('livewire.admin.bimbingan-pemustaka.table', [
            'data' => $data,
        ]);
    }
}
