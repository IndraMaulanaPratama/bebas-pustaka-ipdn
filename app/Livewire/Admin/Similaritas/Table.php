<?php

namespace App\Livewire\Admin\Similaritas;

use App\Http\Controllers\SimilaritasController;
use App\Models\Akses;
use App\Models\Menu;
use App\Models\pivotMenu;
use App\Models\Similaritas;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
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
    public $colorStatus, $iconStatus;
    public $sortStatus, $sortFakultas, $sortProdi, $search;

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
        $detailPraja = json_decode(file_get_contents("http://localhost:8001/api/praja?npp=" . $npp), true);
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

    #[On("selected-data")]
    public function selectedData($id)
    {
        $this->dispatch("selected-data", $id);
    }

    public function exportData()
    {
        // dd([
        //     "search" => $this->search,
        //     "status" => $this->sortStatus,
        //     "fakultas" => $this->sortFakultas,
        //     "prodi" => $this->sortProdi,
        // ]);

        $data = Similaritas::
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
            ->get();

        // dd($data);

        $pdf = Pdf::loadView("pdf.similaritas.export-data", ['similaritas' => $data])->output();
        // return $pdf->stream('filename.pdf');

        return response()->streamDownload(
            fn() => print($pdf),
            "filename.pdf"
        );
    }

    public function printApprooved($id)
    {
        $data = Similaritas::where("SIMILARITAS_ID", $id)->first();
        $dataPraja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $data->SIMILARITAS_PRAJA), true)["data"][0];
        $ponsel = User::where("email", $dataPraja["EMAIL"])->first('nomor_ponsel');

        $pdf = Pdf::loadView("pdf.similaritas.bukti-pemeriksaan", [
            'similaritas' => $data,
            'praja' => $dataPraja,
            'ponsel' => $ponsel,
        ])->output();

        return response()->streamDownload(
            fn() => print($pdf),
            "filename.pdf"
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
            ->latest()
            ->paginate();



        return view('livewire.admin.similaritas.table', [
            'similaritas' => $similaritas,
        ]);
    }
}
