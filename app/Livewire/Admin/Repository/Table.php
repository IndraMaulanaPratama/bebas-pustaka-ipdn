<?php

namespace App\Livewire\Admin\Repository;

use App\Exports\RepositoryExport;
use App\Models\Akses;
use App\Models\BebasPustaka;
use App\Models\KontenLiterasi;
use App\Models\Menu;
use App\Models\Repository;
use App\Models\SettingApps;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;


class Table extends Component
{
    use WithPagination;


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



    public function mount()
    {
        $roleLogin = Auth::user()->user_role;
        $url = Route::getCurrentRoute()->action['as']; // Maca nami route anu nuju di buka
        $menu = Menu::where("MENU_URL", $url)->first();

        $access = Akses::
            join("PIVOT_MENU", "ACCESSES.ACCESS_MENU", '=', "PIVOT_MENU.PIVOT_ID")
            ->where(['PIVOT_MENU.PIVOT_MENU' => $menu->MENU_ID, 'PIVOT_MENU.PIVOT_ROLE' => $roleLogin])
            ->first();

        $this->accessApprove = $this->generateAccess($access->ACCESS_APPROVE);
        $this->accessReject = $this->generateAccess($access->ACCESS_REJECT);
        $this->accessPrint = $this->generateAccess($access->ACCESS_PRINT);
        $this->accessExport = $this->generateAccess($access->ACCESS_EXPORT);
        $this->accessUpdate = $this->generateAccess($access->ACCESS_UPDATE);

        $this->idLogin = Auth::user()->id;

    }



    public function generateAccess($value)
    {
        return $value == 1 ? null : 'hidden';
    }



    public function detailPraja($npp)
    {
        $detailPraja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $npp), true);
        $this->dataPraja = $detailPraja["data"][0];

        $tanggalLahir = Carbon::createFromFormat("Y-m-d", $this->dataPraja["TANGGAL_LAHIR"])->format("d M Y");
        $jenisKelamin = $this->dataPraja['JENIS_KELAMIN'] == "P" ? "PEREMPUAN" : "LAKI-LAKI";

        $userPraja = User::where('email', $npp . '@praja.ipdn.ac.id')->first();
        $nomorPonsel = $userPraja->nomor_ponsel;

        $this->prajaNama = $this->dataPraja['NAMA'];
        $this->prajaEmail = $this->dataPraja['EMAIL'];
        $this->prajaPonsel = $nomorPonsel;
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
    }



    public function updateUrl()
    {
        $setting = SettingApps::first();

        try {
            SettingApps::where('SETTING_ID', $setting->SETTING_ID)->update(['SETTING_URL_REPOSITORY' => $this->inputUrl]);

            $this->dispatch("data-updated", "Alamat tamplate repository berhasil diperbaharui");
            $this->reset();

        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
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



    public function approveData($id)
    {
        try {

            // Mencari data repository berdasarkan id
            $repository = Repository::where('REPOSITORY_ID', $id)->first();

            // Inisialisasi data repository
            $data = [
                'REPOSITORY_OFFICER' => Auth::user()->id,
                'REPOSITORY_STATUS' => "Disetujui",
                'REPOSITORY_NOTES' => null,
                'REPOSITORY_APPROVED' => Carbon::now("Asia/Jakarta")->format("Y-m-d H:i:s"),
            ];


            // Inisialisasi data bebas pustaka
            $skbp = [
                'BEBAS_REPOSITORY' => true
            ];

            // Proses update data bebas pustaka
            BebasPustaka::where('BEBAS_PRAJA', $repository->REPOSITORY_PRAJA)->update($skbp);

            // Proses update data repository
            Repository::where("REPOSITORY_ID", $id)->update($data);

            $this->dispatch("data-updated", "Pengajuan unggah repository berhasil disetujui");
            $this->reset();
        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }



    public function keepData($id)
    {
        try {

            // Mencari data repository berdasarkan id
            $repository = Repository::where('REPOSITORY_ID', $id)->first();

            // Validasi statu pengajuan (meminimalisir terjadi double pemeriksaan oleh petugas)
            switch ($repository->REPOSITORY_STATUS) {
                case "Proses":

                    // Inisialisasi data repository
                    $data = [
                        'REPOSITORY_OFFICER' => $this->idLogin,
                        'REPOSITORY_STATUS' => "Assign",
                    ];

                    // Proses update data repository
                    Repository::where("REPOSITORY_ID", $id)->update($data);

                    // Mengirimkan pesan notifikasi kepada user
                    $this->dispatch("data-updated", "Pengajuan repository `$repository->REPOSITORY_PRAJA` siap untuk periksa");
                    break;

                case 'Assign':
                    // Mengirimkan pesan notifikasi kepada user
                    $this->dispatch("failed-updating-data", "Pengajuan ini sudah diperiksa oleh `$repository->user->name`, silahkan periksa pengajuan lainnya");
                    break;
            }

        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }



    /**
 * Aya sababara catetan kanggo fiture print ieu
 // TODO:: (1) Judul skripsi, (2) Nama Pembimbing
 */
    public function printApprooved($id)
    {

        $data = Repository::where("REPOSITORY_ID", $id)->first();
        $dataPraja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $data->REPOSITORY_PRAJA), true)["data"][0];
        $ponsel = User::where("email", $dataPraja["EMAIL"])->first('nomor_ponsel');

        $dokumen = view("pdf.repository.bukti-pemeriksaan", [
            'data' => $data,
            'sign' => url('tanda_tangan/' . $data->user->sign),
            'praja' => $dataPraja,
            'ponsel' => $ponsel,
        ])->render();

        $pdf = Pdf::loadHTML($dokumen)
            ->output();


        return response()->streamDownload(
            function () use ($pdf) {
                print ($pdf);
            },
            'Unggah-Repository-' . $dataPraja['NAMA'] . '.pdf',
            ["Attachment" => false],
        );

    }



    public function rejectData($id)
    {
        $data = Repository::where('REPOSITORY_ID', $id)->first();
        $this->dispatch('data-selected', $data);
    }



    public function exportData()
    {
        return (new RepositoryExport)
            ->forStatus($this->sortStatus)
            ->forAngkatan($this->angkatan)
            ->forFakultas($this->sortFakultas)
            ->forSearch($this->search)
            ->download(
                'Repository.xlsx',
                \Maatwebsite\Excel\Excel::XLSX
            );
    }



    public function resetForm()
    {
        $this->reset();
    }



    #[On("data-rejected"), On("failed-updating-data"), On("data-updated")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    private function loadData()
    {
        $data = Repository::
            when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("REPOSITORY_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("REPOSITORY_FAKULTAS", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->search,
                function ($query, $npp) {
                    return $query->where("REPOSITORY_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->angkatan,
                function ($query, $angkatan) {
                    return $query->where("REPOSITORY_PRAJA", "LIKE", $angkatan . "%");
                }
            )
            ->latest()
            ->paginate();

        return $data;
    }


    public function render()
    {
        $setting = SettingApps::latest()->first();
        $data = $this->loadData();


        return view('livewire.admin.repository.table', [
            'data' => $data,
            'setting' => $setting,
        ]);
    }
}
