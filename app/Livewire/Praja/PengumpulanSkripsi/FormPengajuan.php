<?php

namespace App\Livewire\Praja\PengumpulanSkripsi;

use App\Models\PivotSkripsi;
use App\Models\SkripsiFakultas;
use App\Models\SkripsiPerpustakaan;
use App\Models\SkripsiSoftcopy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormPengajuan extends Component
{
    public $praja, $npp, $data, $judul, $pembimbingSatu, $pembimbingDua;
    public $buttonCreate;

    public function buatPengajuan()
    {
        try {

            $data_skripsi = [
                'SKRIPSI_ID' => uuid_create(4),
                'SKRIPSI_PRAJA' => $this->npp,
                'SKRIPSI_OFFICER' => 1,
                'SKRIPSI_STATUS' => 'Proses'
            ];

            SkripsiPerpustakaan::create($data_skripsi);
            SkripsiFakultas::create($data_skripsi);
            SkripsiSoftcopy::create($data_skripsi);

            $data_pivot = [
                'PIVOT_ID' => uuid_create(4),
                'PIVOT_PRAJA' => $this->npp,
                'PIVOT_PUSTAKA' => $data_skripsi['SKRIPSI_ID'],
                'PIVOT_FAKULTAS' => $data_skripsi['SKRIPSI_ID'],
                'PIVOT_SOFTCOPY' => $data_skripsi['SKRIPSI_ID'],
                'PIVOT_JUDUL' => $this->judul,
                'PIVOT_PEMBIMBING_SATU' => $this->pembimbingSatu,
                'PIVOT_PEMBIMBING_DUA' => $this->pembimbingDua,
            ];

            PivotSkripsi::create($data_pivot);

            $this->buttonCreate = 'disabled';
            $this->reset();

            $this->dispatch("data-created", "Pengajuan tahap unggah repository anda berhasil disimpan");
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-data", $th->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset();
    }


    public function mount()
    {
        $this->npp = explode("@", Auth::user()->email)[0];
        $this->praja = User::where("id", Auth::user()->id)->first();
        $this->data = PivotSkripsi::where('PIVOT_PRAJA', $this->npp)->first();
    }

    public function render()
    {
        return view('livewire.praja.pengumpulan-skripsi.form-pengajuan');
    }
}
