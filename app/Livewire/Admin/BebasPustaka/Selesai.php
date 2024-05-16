<?php

namespace App\Livewire\Admin\BebasPustaka;

use App\Exports\ResumeSelesaiExcel;
use App\Models\Akses;
use App\Models\BebasPustaka;
use App\Models\Menu;
use App\Models\SettingApps;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Selesai extends Component
{

    #[Title('Resume SKBP - Selesai')]

    public $inputUrl;
    public $accessReject, $accessApprove, $accessExport, $accessPrint, $accessUpdate;
    public $sortUrutan, $sortFakultas, $angkatan, $search;
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




    #[On("data-rejected"), On("failed-updating-data"), On("data-updated")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }




    public function resetForm()
    {
        $this->reset();
    }




    public function printApprooved($id)
    {
        $data = BebasPustaka::where('BEBAS_ID', $id)->first();
        $dataPraja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $data->FAKULTAS_PRAJA), true)["data"][0];
        $ponsel = User::where("email", $dataPraja["EMAIL"])->first('nomor_ponsel');
        $kepalaUnit = SettingApps::first();

        $dokumen = view("pdf.skbp.skbp", [
            'skbp' => $data,
            'praja' => $dataPraja,
            'ponsel' => $ponsel,
            'kepalaUnit' => $kepalaUnit,
        ])->render();

        $pdf = Pdf::loadHTML($dokumen)
            ->output();

        return response()->streamDownload(
            function () use ($pdf) {
                print ($pdf);
            },
            'SKBP-' . $dataPraja['NAMA'] . '.pdf',
            ["Attachment" => false],
        );
    }



    public function exportData()
    {
        return (new ResumeSelesaiExcel)
            ->forData($this->sortUrutan)
            ->forAngkatan($this->angkatan)
            ->forFakultas($this->sortFakultas)
            ->forSearch($this->search)
            ->download(
                'Resume Bebas Pustaka - Selesai.xlsx',
                \Maatwebsite\Excel\Excel::XLSX
            );
    }

    public function render()
    {

        $data = BebasPustaka::
            when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("BEBAS_NUMBER", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->search,
                function ($query, $npp) {
                    return $query->where("BEBAS_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->angkatan,
                function ($query, $angkatan) {
                    return $query->where("BEBAS_PRAJA", "LIKE", $angkatan . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana urutan
                $this->sortUrutan,
                function ($query, $urutan) {
                    if ("nomor" == $urutan) {
                        return $query->orderBy('created_at', 'ASC');
                    } elseif ("terbaru" == $urutan) {
                        return $query->latest();
                    }
                }
            )

            ->paginate();

        return view('livewire.admin.bebas-pustaka.selesai', ['data' => $data]);
    }
}
