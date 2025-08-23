<?php

namespace App\Livewire\Admin\Similaritas;

use App\Exports\SimilaritasExport;
use App\Models\Akses;
use App\Models\Menu;
use App\Models\Similaritas;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Table extends Component
{
    use WithPagination;

    public $idLogin;
    public $accessReject, $accessApprove, $accessPrint, $accessExport;
    public $colorStatus, $iconStatus;
    public $sortStatus, $sortFakultas, $sortProdi, $search, $angkatan;

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
        $this->idLogin = Auth::user()->id;
    }

    public function generateAccess($value)
    {
        return $value == 1 ? null : 'invisible';
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

            // Mencari data similaritas berdasarkan id
            $similaritas = Similaritas::where('SIMILARITAS_ID', $id)->first();

            // Validasi statu pengajuan (meminimalisir terjadi double pemeriksaan oleh petugas)
            switch ($similaritas->SIMILARITAS_STATUS) {
                case "Proses":

                    // Inisialisasi data similaritas
                    $data = [
                        'SIMILARITAS_OFFICER' => $this->idLogin,
                        'SIMILARITAS_STATUS' => "Assign",
                    ];

                    // Proses update data similaritas
                    Similaritas::where("SIMILARITAS_ID", $id)->update($data);

                    // Mengirimkan pesan notifikasi kepada user
                    $this->dispatch("data-updated", "Pengajuan similaritas `$similaritas->SIMILARITAS_PRAJA` siap untuk periksa");
                    break;

                case 'Assign':
                    // Mengirimkan pesan notifikasi kepada user
                    $this->dispatch("failed-updating-data", "Pengajuan ini sudah diperiksa oleh `$similaritas->user->name`, silahkan periksa pengajuan lainnya");
                    break;
            }

        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
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


    public function rejectData($id)
    {
        $data = Similaritas::where('SIMILARITAS_ID', $id)->first();
        $this->dispatch('similaritas-selected', $data);
    }

    #[On("data-rejected"), On("failed-updating-data"), On("data-updated")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }

    public function selectedData($id)
    {
        $this->detailPraja($id[1]);
        $this->dispatch("selected-data", [$id[0], $this->prajaFakultas]);
    }

    public function exportData()
    {
        return (new SimilaritasExport)
            ->forStatus($this->sortStatus)
            ->forAngkatan($this->angkatan)
            ->forFakultas($this->sortFakultas)
            ->forSearch($this->search)
            ->download(
                'Similaritas.xlsx',
                \Maatwebsite\Excel\Excel::XLSX
            );
    }


    public function printApprooved($id)
    {

        $data = Similaritas::where("SIMILARITAS_ID", $id)->first();
        $dataPraja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $data->SIMILARITAS_PRAJA), true)["data"][0];
        $ponsel = User::where("email", $dataPraja["EMAIL"])->first('nomor_ponsel');

        $dokumen = view("pdf.similaritas.bukti-pemeriksaan", [
            'similaritas' => $data,
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
            'SIMILARITAS-' . $dataPraja['NAMA'] . '.pdf',
            ["Attachment" => false],
        );

    }

    public function render()
    {
        $similaritas = Similaritas::
            when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("SIMILARITAS_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("SIMILARITAS_NUMBER", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->search,
                function ($query, $npp) {
                    return $query->where("SIMILARITAS_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->angkatan,
                function ($query, $npp) {
                    return $query->where("SIMILARITAS_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->latest()
            ->paginate();

        return view('livewire.admin.similaritas.table', [
            'similaritas' => $similaritas,
        ]);
    }
}
