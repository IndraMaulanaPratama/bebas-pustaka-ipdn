<?php

namespace App\Livewire\Admin\BebasPustaka;

use App\Exports\ResumeSelesaiExcel;
use App\Models\Akses;
use App\Models\BebasPustaka;
use App\Models\Menu;
use App\Models\SettingApps;
use App\Models\User;
use App\Services\PrajaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Selesai extends Component
{
    use WithPagination;

    #[Title('Resume SKBP - Selesai')]
    public $inputUrl;

    public $accessReject;

    public $accessApprove;

    public $accessExport;

    public $accessPrint;

    public $accessUpdate;

    public $accessDelete;

    public $sortUrutan;

    public $sortFakultas;

    public $angkatan;

    public $search;

    public $npp;

    public $dataPraja;

    public $prajaNama;

    public $prajaEmail;

    public $prajaTempatTanggalLahir;

    public $prajaJenisKelamin;

    public $prajaProvinsi;

    public $prajaKota;

    public $prajaTingkat;

    public $prajaAngkatan;

    public $prajaKampus;

    public $prajaWisma;

    public $prajaPropen;

    public $prajaFakultas;

    public $prajaProdi;

    public $prajaKelas;

    public $prajaPonsel;

    public function mount()
    {
        $roleLogin = Auth::user()->user_role;
        $url = Route::getCurrentRoute()->action['as']; // Maca nami route anu nuju di buka
        $menu = Menu::where('MENU_URL', $url)->first();

        $access = Akses::join('PIVOT_MENU', 'ACCESSES.ACCESS_MENU', '=', 'PIVOT_MENU.PIVOT_ID')
            ->where(['PIVOT_MENU.PIVOT_MENU' => $menu->MENU_ID, 'PIVOT_MENU.PIVOT_ROLE' => $roleLogin])
            ->first();

        $this->accessApprove = $this->generateAccess($access->ACCESS_APPROVE);
        $this->accessReject = $this->generateAccess($access->ACCESS_REJECT);
        $this->accessPrint = $this->generateAccess($access->ACCESS_PRINT);
        $this->accessExport = $this->generateAccess($access->ACCESS_EXPORT);
        $this->accessUpdate = $this->generateAccess($access->ACCESS_UPDATE);
        $this->accessDelete = $this->generateAccess($access->ACCESS_DELETE);
    }

    #[On('success')]
    public function processSuccessfully($message)
    {
        session()->reflash();
        session()->flash('success', $message);
    }

    #[On('warning')]
    public function warningProcess($message)
    {
        session()->reflash();
        session()->flash('warning', $message);
    }

    #[On('error')]
    public function failedProcess($message)
    {
        session()->reflash();
        session()->flash('error', $message);
    }

    public function generateAccess($value)
    {
        return $value == 1 ? null : 'hidden';
    }

    public function detailPraja($npp)
    {
        $detailPraja = \App\Helpers\PrajaApi::getPraja($npp, true);
        $this->dataPraja = $detailPraja['data'][0];

        $tanggalLahir = Carbon::createFromFormat('Y-m-d', $this->dataPraja['TANGGAL_LAHIR'])->format('d M Y');
        $jenisKelamin = $this->dataPraja['JENIS_KELAMIN'] == 'P' ? 'PEREMPUAN' : 'LAKI-LAKI';

        $userPraja = User::where('email', $npp.'@praja.ipdn.ac.id')->first();
        $nomorPonsel = $userPraja->nomor_ponsel;

        $this->prajaNama = $this->dataPraja['NAMA'];
        $this->prajaEmail = $this->dataPraja['EMAIL'];
        $this->prajaPonsel = $nomorPonsel;
        $this->prajaTempatTanggalLahir = $this->dataPraja['TEMPAT_LAHIR'].', '.$tanggalLahir;
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

    #[On('data-rejected'), On('failed-updating-data'), On('data-updated')]
    public function placeholder()
    {
        return view('components.admin.components.spinner.loading');
    }

    public function resetForm()
    {
        $this->reset();
    }

    public function printApprooved($id)
    {
        $data = BebasPustaka::where('BEBAS_ID', $id)->first();
        $dataPraja = \App\Helpers\PrajaApi::getPraja($data->BEBAS_PRAJA, true)['data'][0];
        $ponsel = User::where('email', $dataPraja['EMAIL'])->first('nomor_ponsel');
        $kepalaUnit = SettingApps::first();

        $dokumen = view('pdf.skbp.skbp', [
            'skbp' => $data,
            'praja' => $dataPraja,
            'ponsel' => $ponsel,
            'kepalaUnit' => $kepalaUnit,
        ])->render();

        $pdf = Pdf::loadHTML($dokumen)
            ->output();

        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf;
            },
            'SKBP-'.$dataPraja['NAMA'].'.pdf',
            ['Attachment' => false],
        );
    }

    public function deleteSkbp($id)
    {
        try {
            $data = [
                'BEBAS_NUMBER' => null,
                'deleted_at' => date('Y-m-d H:i:s', Carbon::now('Asia/Jakarta')->getTimestamp()),
            ];

            // Proses menghapus data
            BebasPustaka::where('BEBAS_ID', $id)->update($data);

            // Mengembalikan pesan sukses
            $this->processSuccessfully('Data SKBP berhasil dihapuskan');
        } catch (\Throwable $th) {
            // Mengembalikan pesan error
            $this->warningProcess('Data SKBP gagal dihapuskan');
        }
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

    public function fixPenomoranSurat(PrajaService $prajaService)
    {
        try {
            // Ambil tahun berjalan
            $tahun = Carbon::now('Asia/Jakarta')->format('Y');

            // Tarik semua data surat tahun ini
            $surats = BebasPustaka::whereNotNull('BEBAS_NUMBER')
                ->where('BEBAS_NUMBER', 'like', '%/'.$tahun)
                ->orderBy('updated_at', 'asc') // diurutkan berdasarkan waktu pembuatan
                ->get();

            $totalSurat = $surats->count();
            if ($totalSurat === 0) {
                $this->dispatch('update-progress', progress: 100);
                $this->warningProcess('Tidak ada data surat untuk dirapihkan di tahun '.$tahun);

                return;
            }

            $counter = 1;

            // Proses perbaikan format nomor & fakultas
            foreach ($surats as $surat) {
                $praja = $prajaService->getDetailPraja($surat->BEBAS_PRAJA) ?? [];
                $fakultas = $prajaService->getInisialFakultas($praja['FAKULTAS'] ?? null);

                $nomor = sprintf('%04s', $counter);
                $nomorBaru = '000.5.2.4/SKBP-'.$fakultas.'.'.$nomor.'/IPDN.18.4/'.$tahun;

                $surat->update(['BEBAS_NUMBER' => $nomorBaru]);

                // Hitung dan kirim progress ke frontend
                $progress = ($counter / $totalSurat) * 100;
                $this->dispatch('update-progress', progress: $progress);
                $counter++;
            }
        } catch (\Throwable $th) {
            $this->dispatch('update-progress', progress: 100); // Sembunyikan progress bar jika error
            $this->failedProcess('Terjadi kesalahan: '.$th->getMessage());
        }
    }

    public function render()
    {

        $data = BebasPustaka::when(
            // <!-- Pilari data pengajuan dumasar kana fakultas
            $this->sortFakultas,
            function ($query, $fakultas) {
                return $query->where('BEBAS_NUMBER', 'LIKE', '%'.$fakultas.'%');
            }
        )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->search,
                function ($query, $npp) {
                    return $query->where('BEBAS_PRAJA', 'LIKE', $npp.'%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->angkatan,
                function ($query, $angkatan) {
                    return $query->where('BEBAS_PRAJA', 'LIKE', $angkatan.'%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana urutan
                $this->sortUrutan,
                function ($query, $urutan) {
                    if ($urutan == 'nomor') {
                        return $query->orderBy('updated_at', 'ASC');
                    } elseif ($urutan == 'terbaru') {
                        return $query->orderBy('updated_at', 'DESC');
                    }
                },
                function ($query) {
                    // Ini adalah default urutan jika dropdown 'Urutan Data' tidak dipilih
                    return $query->orderBy('updated_at', 'DESC');
                }
            )
            ->where('BEBAS_NUMBER', '!=', null)
            ->paginate();

        return view('livewire.admin.bebas-pustaka.selesai', ['data' => $data]);
    }
}
