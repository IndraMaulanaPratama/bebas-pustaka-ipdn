<?php

namespace App\Livewire\Admin\KontenLiterasi;

use App\Models\Akses;
use App\Models\BebasPustaka;
use App\Models\KontenLiterasi;
use App\Models\Menu;
use App\Models\SettingApps;
use App\Models\User;
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



    public function updateUrl()
    {
        $setting = SettingApps::first();

        try {
            SettingApps::where('SETTING_ID', $setting->SETTING_ID)->update(['SETTING_URL_LITERASI' => $this->inputUrl]);

            $this->dispatch("data-updated", "Alamat formulir literasi berhasil diperbaharui");
            $this->reset();

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



    public function approveData($id)
    {
        try {
            // mencari data konten literasi berdasarkan id
            $literasi = KontenLiterasi::where('KONTEN_ID', $id)->first();


            // Inisialisasi data konten literasi
            $data = [
                'KONTEN_OFFICER' => Auth::user()->id,
                'KONTEN_STATUS' => "Disetujui",
                'KONTEN_NOTES' => null,
                'KONTEN_APPROVED' => Carbon::now("Asia/Jakarta")->format("Y-m-d H:i:s"),
            ];

            // Inisialisasi data bebas pustaka
            $skbp = [
                'BEBAS_KONTEN_LITERASI' => true,
            ];

            // Proses update data bebas pustaka
            BebasPustaka::where('BEBAS_PRAJA', $literasi->KONTEN_PRAJA)->update($skbp);

            // Proses update data konten literasi
            KontenLiterasi::where("KONTEN_ID", $id)->update($data);

            $this->dispatch("data-updated", "Pengajuan konten literasi berhasil disetujui");
            $this->reset();
        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }


    public function printApprooved($id)
    {

        $data = KontenLiterasi::where("KONTEN_ID", $id)->first();
        $dataPraja = json_decode(file_get_contents(env("APP_PRAJA") . "praja?npp=" . $data->KONTEN_PRAJA), true)["data"][0];
        $ponsel = User::where("email", $dataPraja["EMAIL"])->first('nomor_ponsel');

        // dd($dataPraja);

        $dokumen = view("pdf.konten-literasi.bukti-pemeriksaan", [
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
            'Konten-literasi-' . $dataPraja['NAMA'] . '.pdf',
            ["Attachment" => false],
        );

    }



    public function exportData()
    {
        return Excel::download(new \App\Exports\KontenLiterasi, 'Konten-literasi.xlsx');
    }




    public function rejectData($id)
    {
        $data = KontenLiterasi::where('KONTEN_ID', $id)->first();
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
        $setting = SettingApps::latest()->first();
        $konten = KontenLiterasi::
            when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("KONTEN_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("KONTEN_FAKULTAS", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->search,
                function ($query, $npp) {
                    return $query->where("KONTEN_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->angkatan,
                function ($query, $angkatan) {
                    return $query->where("KONTEN_PRAJA", "LIKE", $angkatan . "%");
                }
            )
            ->latest()
            ->paginate();


        return view('livewire.admin.konten-literasi.table', [
            'konten' => $konten,
            'setting' => $setting,
        ]);
    }
}
