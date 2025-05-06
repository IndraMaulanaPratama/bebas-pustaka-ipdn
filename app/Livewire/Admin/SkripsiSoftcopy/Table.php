<?php

namespace App\Livewire\Admin\SkripsiSoftcopy;

use App\Models\Akses;
use App\Models\BebasPustaka;
use App\Models\Menu;
use App\Models\PivotSkripsi;
use App\Models\SkripsiSoftcopy;
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

            $this->dispatch("data-updated", "Pengajuan pengumpulan skripsi berhasil disetujui");
            $this->reset();
        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }



    public function printApprooved($id)
    {
        $data = SkripsiSoftcopy::where('SKRIPSI_ID', $id)->first();
        $dataPraja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $data->SKRIPSI_PRAJA), true)["data"][0];
        $ponsel = User::where("email", $dataPraja["EMAIL"])->first('nomor_ponsel');


        $dokumen = view("pdf.penyerahan-skripsi.bukti-pemeriksaan-pusat", [
            'data' => $data,
            'praja' => $dataPraja,
            'ponsel' => $ponsel,
        ])->render();

        $pdf = Pdf::loadHTML($dokumen)
            ->output();

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



    #[On("data-rejected"), On("failed-updating-data"), On("data-updated")]
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
            ->latest()
            ->paginate();

        return view('livewire.admin.skripsi-softcopy.table', [
            'data' => $data,
        ]);
    }
}
