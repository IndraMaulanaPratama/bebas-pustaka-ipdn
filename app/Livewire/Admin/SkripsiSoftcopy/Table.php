<?php

namespace App\Livewire\Admin\SkripsiSoftcopy;

use App\Models\Akses;
use App\Models\BebasPustaka;
use App\Models\Menu;
use App\Models\PivotSkripsi;
use App\Models\SkripsiSoftcopy;
use App\Models\User;
use App\Services\ActivityLogger;
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
    }



    public function generateAccess($value)
    {
        return $value == 1 ? null : 'hidden';
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
            $data = SkripsiSoftcopy::where('SKRIPSI_ID', $id)->first();

            switch ($data->SKRIPSI_STATUS) {
                case "Proses":
                    $updateData = [
                        'SKRIPSI_OFFICER' => Auth::id(),
                        'SKRIPSI_STATUS' => "Assign",
                    ];
                    SkripsiSoftcopy::where("SKRIPSI_ID", $id)->update($updateData);

                    // Nyatet aktivitas mariksa pengajuan
                    ActivityLogger::log('Soft Copy Skripsi', ActivityLogger::ASSIGN, "Memeriksa pengajuan soft copy skripsi a.n. {$data->SKRIPSI_PRAJA}", $data);

                    $this->dispatch("data-updated", "Pengajuan skripsi softcopy `{$data->SKRIPSI_PRAJA}` siap untuk periksa");
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
            // Mencari data pengajuan soft copy skripsi
            $skripsi = SkripsiSoftcopy::where('SKRIPSI_ID', $id)->first();

            // Inisialisasi data bebas pustaka
            $skbp = [
                'BEBAS_SOFT_COPY' => true,
            ];

            // Inisialisasi data pengajuan soft copy
            $data = [
                'SKRIPSI_OFFICER' => Auth::user()->id,
                'SKRIPSI_STATUS' => "Disetujui",
                'SKRIPSI_NOTES' => null,
                'SKRIPSI_APPROVED' => Carbon::now("Asia/Jakarta")->format("Y-m-d H:i:s"),
            ];

            // Proses update data bebas pustaka
            BebasPustaka::where('BEBAS_PRAJA', $skripsi->SKRIPSI_PRAJA)->update($skbp);

            // Proses update data pengajuan soft copy skripsi
            SkripsiSoftcopy::where("SKRIPSI_ID", $id)->update($data);

            // Nyatet aktivitas persetujuan pengajuan
            ActivityLogger::log('Soft Copy Skripsi', ActivityLogger::APPROVE, "Menyetujui pengajuan soft copy skripsi a.n. {$skripsi->SKRIPSI_PRAJA}", $skripsi);

            $this->dispatch("data-updated", "Pengajuan pengumpulan skripsi berhasil disetujui");
            $this->reset();
        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }



    public function printApprooved($id)
    {
        $data = SkripsiSoftcopy::where('SKRIPSI_ID', $id)->first();
        $dataPraja = \App\Helpers\PrajaApi::getPraja($data->SKRIPSI_PRAJA, true)["data"][0];
        $ponsel = User::where("email", $dataPraja["EMAIL"])->first('nomor_ponsel');


        $dokumen = view("pdf.penyerahan-skripsi.bukti-pemeriksaan-pusat", [
            'data' => $data,
            'praja' => $dataPraja,
            'ponsel' => $ponsel,
        ])->render();

        $pdf = Pdf::loadHTML($dokumen)
            ->output();

        // Nyatet aktivitas cetak bukti pemeriksaan
        ActivityLogger::log('Soft Copy Skripsi', ActivityLogger::PRINT, "Mencetak bukti pemeriksaan soft copy skripsi a.n. {$dataPraja['NAMA']}", $data);

        return response()->streamDownload(
            function () use ($pdf) {
                print ($pdf);
            },
            'PENYERAHAN_SKRIPSI-' . $dataPraja['NAMA'] . '.pdf',
            ["Attachment" => false],
        );

    }



    public function exportData()
    {
        // Nyatet aktivitas export data
        ActivityLogger::log('Soft Copy Skripsi', ActivityLogger::EXPORT, "Mengekspor data soft copy skripsi ke Excel");

        return Excel::download(new \App\Exports\SkripsiSoftcopy, 'Skripsi-softcopy.xlsx');
    }



    public function rejectData($id)
    {
        $data = SkripsiSoftcopy::where('SKRIPSI_ID', $id)->first();
        $this->dispatch('data-selected', $data);
    }



    public function resetForm()
    {
        $this->reset();
    }



    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }


    public function render()
    {
        $data = SkripsiSoftcopy::
            when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("SKRIPSI_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("SKRIPSI_FAKULTAS", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->search,
                function ($query, $npp) {
                    return $query->where("SKRIPSI_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->angkatan,
                function ($query, $angkatan) {
                    return $query->where("SKRIPSI_PRAJA", "LIKE", $angkatan . "%");
                }
            )
            ->orderBy('SKRIPSI_TANGGAL_PENGAJUAN', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate();

        return view('livewire.admin.skripsi-softcopy.table', [
            'data' => $data,
        ]);
    }
}
