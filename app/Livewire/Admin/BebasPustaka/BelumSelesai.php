<?php

namespace App\Livewire\Admin\BebasPustaka;

use App\Exports\ResumeBelumSelesaiExcel;
use App\Models\Akses;
use App\Models\BebasPustaka;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class BelumSelesai extends Component
{
    use WithPagination;

    #[Title('Resume SKBP - Belum Selesai')]


    protected $listerners = ['success', '$refresh'];
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



    /**
     * Ranahna fungsi kanggo bewara
     */

    #[On("success")]
    public function processSuccessfully($message)
    {
        session()->reflash();
        session()->flash('success', $message);
    }



    #[On("warning")]
    public function failedProcess($message)
    {
        session()->reflash();
        session()->flash('warning', $message);
    }


    #[On("error")]
    public function errorProcess($message)
    {
        session()->reflash();
        session()->flash('error', $message);
    }

    /** Tungtugng tina fungsi bewara */




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



    /**
     * Fungsi kanggo nyamikeun data (taroskeun ka kang rama)
     */

    public function syncData()
    {
        try {
            // ngadamel list data anu bade di lebetkeun
            $npp = [];

            // Ngadamel inisialisasi data sakantenan ngalebetkeun list data kana database
            for ($i = 0; $i < count($npp); $i++) {


                // Ngadamel inisialisasi data
                $data = [
                    'BEBAS_ID' => uuid_create(4),
                    'BEBAS_NUMBER' => null,
                    'BEBAS_PRAJA' => $npp[$i],
                    'BEBAS_OFFICER' => 1
                ];

                // Proses ngalebetkeun data ka database
                BebasPustaka::create($data);
            }

            // Masihan bewara yen proses singkronasi parantos rengse
            $this->dispatch('success', 'Singkronasi data selesai dijalankan');

        } catch (\Throwable $th) {
            // masihan bewara yen singkronasi data gagal
            $this->dispatch('error', 'Singkronasi data gagal di jalankan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncData */



    /**
     * Fungsi kanggo update data similaritas (taroskeun ka kang rama)
     */

    public function syncSimilaritas()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data similaritas dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_SIMILARITAS' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status similaritas berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status similaritas gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncSimilaritas */



    /**
     * Fungsi kanggo update data pinjaman perpustakaan pusat (taroskeun ka kang rama)
     */

    public function syncPinjamanPusat()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data pinjaman perpustakaan pusat dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_PINJAMAN_PUSAT' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status pinjaman perpustakaan pusat berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status pinjaman perpustakaan pusat gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncPinjamanPusat */




    /**
     * Fungsi kanggo update data pinjaman perpustakaan fakultas (taroskeun ka kang rama)
     */

    public function syncPinjamanFakultas()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data pinjaman perpustakaan fakultas dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_PINJAMAN_FAKULTAS' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status pinjaman perpustakaan fakultas berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status pinjaman perpustakaan fakultas gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncPinjamanFakultas */




    /**
     * Fungsi kanggo update data donasi perpustakaan pusat (taroskeun ka kang rama)
     */

    public function syncDonasiPusat()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data donasi perpustakaan pusat dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_DONASI_PUSAT' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status donasi perpustakaan pusat berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status donasi perpustakaan pusat gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncDonasiPusat */




    /**
     * Fungsi kanggo update data donasi perpustakaan fakultas (taroskeun ka kang rama)
     */

    public function syncDonasiFakultas()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data donasi perpustakaan fakultas dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_DONASI_FAKULTAS' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status donasi perpustakaan fakultas berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status donasi perpustakaan fakultas gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncDonasiFakultas */




    /**
     * Fungsi kanggo update data donasi point (taroskeun ka kang rama)
     */

    public function syncDonasiPoint()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data donasi point dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_DONASI_POINT' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status donasi point berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status donasi point gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncDonasiPoint */




    /**
     * Fungsi kanggo update data survei praja (taroskeun ka kang rama)
     */

    public function syncSurvei()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data survei praja dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_SURVEI' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status survei praja berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status survei praja gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncSurvei */




    /**
     * Fungsi kanggo update data konten literasi (taroskeun ka kang rama)
     */

    public function syncKontenLiterasi()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data konten literasi dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_KONTEN_LITERASI' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status konten literasi berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status konten literasi gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncKontenLiterasi */




    /**
     * Fungsi kanggo update data repository (taroskeun ka kang rama)
     */

    public function syncRepository()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data repository dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_REPOSITORY' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status repository berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status repository gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncRepository */




    /**
     * Fungsi kanggo update data hard copy skripsi perpustakaan pusat (taroskeun ka kang rama)
     */

    public function syncCopyPusat()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data hard copy skripsi perpustakaan pusat dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_HARD_COPY_PUSAT' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status hard copy skripsi perpustakaan pusat berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status hard copy skripsi perpustakaan pusat gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncCopyPusat */




    /**
     * Fungsi kanggo update data hard copy skripsi perpustakaan fakultas (taroskeun ka kang rama)
     */

    public function syncCopyFakultas()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data hard copy skripsi perpustakaan fakultas dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_HARD_COPY_FAKULTAS' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status hard copy skripsi perpustakaan fakultas berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status hard copy skripsi perpustakaan fakultas gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncCopyFakultas */




    /**
     * Fungsi kanggo update data soft copy skripsi (taroskeun ka kang rama)
     */

    public function syncSoftCopy()
    {
        try {
            // Ngadamel list npp nu bade di update
            $npp = [];

            // ngarobih data soft copy skripsi dumasar kana data npp
            for ($i = 0; $i < count($npp); $i++) {

                // Proses ngalebetkeun data ka database
                BebasPustaka::where('BEBAS_PRAJA', $npp[$i])->update(['BEBAS_SOFT_COPY' => true]);
            }

            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('success', 'Data status soft copy skripsi berhasil disingkronisasikan');
        } catch (\Throwable $th) {
            // Ngadamel bewara yen singkronisasi data parantos rengse
            $this->dispatch('error', 'Data status soft copy skripsi gagal disingkronisasikan');
            // $this->dispatch('error', $th->getMessage());
        }
    }

    /** Tungtung tina fungsi syncSoftCopy */





    public function resetForm()
    {
        $this->reset();
    }



    public function exportData()
    {
        return (new ResumeBelumSelesaiExcel)
            ->forSearch($this->search)
            ->download(
                'Resume Bebas Pustaka - Belum Selesai.xlsx',
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
            ->orderBy('updated_at', 'DESC')
            ->where('BEBAS_NUMBER', null)
            ->paginate();

        return view('livewire.admin.bebas-pustaka.belum-selesai', ['data' => $data]);
    }
}
