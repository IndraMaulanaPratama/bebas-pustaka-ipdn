<?php

namespace App\Livewire\Admin\Similaritas;

use App\Http\Controllers\SimilaritasController;
use App\Models\Akses;
use App\Models\Menu;
use App\Models\pivotMenu;
use App\Models\Similaritas;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $access;
    public $buttonReject, $buttonApprove, $buttonPrint, $colorStatus, $iconStatus;
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

        $this->access = Akses::with([
            'pivotMenu' => function ($query) use ($menu, $roleLogin) {
                return $query->where(['PIVOT_MENU' => $menu->id, 'PIVOT_ROLE' => $roleLogin]);
            }
        ])->first();
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

    #[On("data-rejected")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }

    public function render()
    {
        $similaritas = Similaritas::latest()->paginate();
        return view('livewire.admin.similaritas.table', [
            'similaritas' => $similaritas,
        ]);
    }
}
