<?php

namespace App\Livewire\Admin\PinjamanPustaka;

use App\Exports\PinjamanPerpustakaanExcel;
use App\Models\Akses;
use App\Models\Menu;
use App\Models\PinjamanPustaka;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;


    public $accessReject, $accessApprove, $accessPrint, $accessExport;
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
    }



    public function generateAccess($value)
    {
        return $value == 1 ? null : 'invisible';
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
        $data = PinjamanPustaka::where('PUSTAKA_ID', $id)->first();
        $this->dispatch('data-selected', $data);
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

        $jumlahData = PinjamanPustaka::whereNotNull('PUSTAKA_APPROVED')->count();
        $nomor = sprintf("%04s", abs($jumlahData + 1));
        $tahun = Carbon::now('Asia/Jakarta')->format("Y");
        return "000.5.6.2/BBPB-" . $fakultas . "." . $nomor . "/IPDN.21/" . $tahun;
    }




    public function approveData($id)
    {
        $pinjaman = PinjamanPustaka::where("PUSTAKA_ID", $id)->first();
        $nomorSurat = $this->generateNomorSurat($pinjaman->PUSTAKA_PRAJA);

        try {
            $data = [
                'PUSTAKA_NUMBER' => $nomorSurat,
                'PUSTAKA_OFFICER' => Auth::user()->id,
                'PUSTAKA_STATUS' => "Disetujui",
                'PUSTAKA_NOTES' => null,
                'PUSTAKA_APPROVED' => Carbon::now("Asia/Jakarta")->format("Y-m-d H:i:s"),
            ];
            PinjamanPustaka::where("PUSTAKA_ID", $id)->update($data);

            $this->dispatch("data-updated", "Pengajuan bebas pustaka perpustakaan berhasil disetujui");
            $this->reset();
        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }



    public function printApprooved($id)
    {
        $data = PinjamanPustaka::where('PUSTAKA_ID', $id)->first();
        $dataPraja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $data->PUSTAKA_PRAJA), true)["data"][0];
        $ponsel = User::where("email", $dataPraja["EMAIL"])->first('nomor_ponsel');

        $dokumen = view("pdf.pinjaman-pustaka.bukti-pemeriksaan", [
            'pinjaman' => $data,
            'praja' => $dataPraja,
            'ponsel' => $ponsel,
        ])->render();

        $pdf = Pdf::loadHTML($dokumen)
            ->output();

        return response()->streamDownload(
            function () use ($pdf) {
                print ($pdf);
            },
            'PINJAMAN_PUSTAKA-' . $dataPraja['NAMA'] . '.pdf',
            ["Attachment" => false],
        );

    }



    public function exportData()
    {
        return (new PinjamanPerpustakaanExcel)
            ->forStatus($this->sortStatus)
            ->forAngkatan($this->angkatan)
            ->forSearch($this->search)
            ->forFakultas($this->sortFakultas)
            ->download(
                'Pinjaman_Perpustakaan_Export.xlsx',
                \Maatwebsite\Excel\Excel::XLSX
            );

    }




    #[On("data-rejected"), On("failed-updating-data"), On("data-updated")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    public function render()
    {
        $pustaka = PinjamanPustaka::
            when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("PUSTAKA_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("PUSTAKA_NUMBER", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->search,
                function ($query, $npp) {
                    return $query->where("PUSTAKA_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->angkatan,
                function ($query, $angkatan) {
                    return $query->where("PUSTAKA_PRAJA", "LIKE", $angkatan . "%");
                }
            )
            ->latest()
            ->paginate();


        return view('livewire.admin.pinjaman-pustaka.table', [
            'pustaka' => $pustaka,
        ]);
    }
}
