<?php

namespace App\Livewire\Admin\DonasiFakultas;

use App\Exports\DonasiFakultasExcel;
use App\Models\Akses;
use App\Models\BebasPustaka;
use App\Models\DonasiFakultas;
use App\Models\Menu;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class Table extends Component
{

    use WithPagination;

    public $accessReject, $accessApprove, $accessExport, $accessPrint, $accessDetail;
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
        $this->accessDetail = $this->generateAccess($access->ACCESS_DETAIL);
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

                if ($officerId == auth()->id()) {
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
            $data = DonasiFakultas::where('FAKULTAS_ID', $id)->first();

            switch ($data->FAKULTAS_STATUS) {
                case "Proses":
                    $updateData = [
                        'FAKULTAS_OFFICER' => Auth::id(),
                        'FAKULTAS_STATUS' => "Assign",
                    ];
                    DonasiFakultas::where("FAKULTAS_ID", $id)->update($updateData);
                    ActivityLogger::log('Donasi Buku Perpustakaan Fakultas', ActivityLogger::ASSIGN, "Memeriksa pengajuan donasi fakultas a.n. {$data->FAKULTAS_PRAJA}", $data);
                    $this->dispatch("data-updated", "Pengajuan donasi fakultas `{$data->FAKULTAS_PRAJA}` siap untuk periksa");
                    break;

                case 'Assign':
                    $officerName = $data->user->name ?? 'Petugas';
                    $this->dispatch("failed-updating-data", "Pengajuan ini sudah diperiksa oleh `{$officerName}`, silahkan periksa pengajuan lainnya");
                    break;
            }
        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }



    public function detailPraja($npp)
    {
        $detailPraja = \App\Helpers\PrajaApi::getPraja($npp, true);
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



    public function approveData($id)
    {
        try {
            // Mencari data donasi fakultas berdasarkan id
            $donasi = DonasiFakultas::where('FAKULTAS_ID', $id)->first();

            // Inisialisasi data donasi fakultas
            $data = [
                'FAKULTAS_OFFICER' => Auth::user()->id,
                'FAKULTAS_STATUS' => "Disetujui",
                'FAKULTAS_NOTES' => null,
                'FAKULTAS_APPROVED' => Carbon::now("Asia/Jakarta")->format("Y-m-d H:i:s"),
            ];

            // Inisialisasi data bebas pustaka
            $skbp = [
                'BEBAS_PRAJA' => $donasi->FAKULTAS_PRAJA,
                'BEBAS_DONASI_FAKULTAS' => true,
            ];

            // Proses update data bebas pustaka
            BebasPustaka::where('BEBAS_PRAJA', $donasi->FAKULTAS_PRAJA)->update($skbp);

            // Proses update data table donasi fakultas
            DonasiFakultas::where("FAKULTAS_ID", $id)->update($data);

            ActivityLogger::log('Donasi Buku Perpustakaan Fakultas', ActivityLogger::APPROVE, "Menyetujui pengajuan donasi fakultas a.n. {$donasi->FAKULTAS_PRAJA}", $donasi);

            $this->dispatch("data-updated", "Pengajuan donasi buku cetak perpustakaan fakultas berhasil disetujui");
            $this->reset();
        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }



    /**
    * Aya sababara catetan kanggo fiture print ieu
    // TODO:: (1) nomor surat, (2) Data Donasi Cetak
    */

    public function printApprooved($id)
    {

        $data = DonasiFakultas::where("FAKULTAS_ID", $id)->first();
        $dataPraja = \App\Helpers\PrajaApi::getPraja($data->FAKULTAS_PRAJA, true)["data"][0];
        $ponsel = User::where("email", $dataPraja["EMAIL"])->first('nomor_ponsel');

        // Generate kode fakultas
        $fakultas = null;
        if ($dataPraja['FAKULTAS'] == 'POLITIK PEMERINTAHAN') {
            $fakultas = 'FPP';
        } elseif ($dataPraja['FAKULTAS'] == 'MANAJEMEN PEMERINTAHAN') {
            $fakultas = 'FMP';
        } elseif ($dataPraja['FAKULTAS'] == 'PERLINDUNGAN MASYARAKAT') {
            $fakultas = 'FPM';
        } else {
            $fakultas = null;
        }

        ActivityLogger::log('Donasi Buku Perpustakaan Fakultas', ActivityLogger::PRINT, "Mencetak bukti donasi fakultas a.n. {$data->FAKULTAS_PRAJA}", $data);

        $dokumen = view("pdf.donasi.cetak.perpustakaan-fakultas", [
            'data' => $data,
            'sign' => url('tanda_tangan/' . $data->user->sign),
            'praja' => $dataPraja,
            'fakultas' => $fakultas,
            'ponsel' => $ponsel,
            'tahun' => date('Y')
        ])->render();

        $pdf = Pdf::loadHTML($dokumen)
            ->output();


        return response()->streamDownload(
            function () use ($pdf) {
                print ($pdf);
            },
            'Donasi_Cetak-Fakultas-' . $dataPraja['NAMA'] . '.pdf',
            ["Attachment" => false],
        );

    }



    public function exportData()
    {
        ActivityLogger::log('Donasi Buku Perpustakaan Fakultas', ActivityLogger::EXPORT, "Mengekspor data donasi fakultas ke Excel");

        return (new DonasiFakultasExcel)
            ->forStatus($this->sortStatus)
            ->forAngkatan($this->angkatan)
            ->forSearch($this->search)
            ->forFakultas($this->sortFakultas)
            ->download(
                'Donasi_Fakultas_Export.xlsx',
                \Maatwebsite\Excel\Excel::XLSX
            );

    }



    public function rejectData($id)
    {
        $data = DonasiFakultas::where('FAKULTAS_ID', $id)->first();
        $this->dispatch('data-selected', $data);
    }



    public function showDetail($id)
    {
        dd([
            'id_pengajuan' => $id,
            'bukti_pengajuan' => 'nanti keluar gambar disini',
        ]);
    }



    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function render()
    {
        $fakultas = DonasiFakultas::
            when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("FAKULTAS_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("FAKULTAS_FAKULTAS", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->search,
                function ($query, $npp) {
                    return $query->where("FAKULTAS_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->angkatan,
                function ($query, $angkatan) {
                    return $query->where("FAKULTAS_PRAJA", "LIKE", $angkatan . "%");
                }
            )
            ->orderBy('FAKULTAS_TANGGAL_PENGAJUAN', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate();
        return view('livewire.admin.donasi-fakultas.table', [
            'fakultas' => $fakultas
        ]);
    }
}
