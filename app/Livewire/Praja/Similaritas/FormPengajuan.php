<?php

namespace App\Livewire\Praja\Similaritas;

use App\Models\Similaritas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormPengajuan extends Component
{
    public $inputJudul, $inputKelas, $inputAbsen;

    public function validasiForm($form, $name)
    {
        $form == null ? $this->dispatch("failed-creating-similaritas", "Data " . $name . " tidak boleh dikosongkan") : true;
        return;
    }

    public function resetForm()
    {
        $this->reset();
    }


    public function createPengajuan()
    {
        $this->validasiForm($this->inputAbsen, "Absen");
        $this->validasiForm($this->inputKelas, "Kelas");
        $this->validasiForm($this->inputJudul, "Judul");

        try {
            $id = uuid_create(4);
            $npp = explode("@", Auth::user()->email)[0];
            $data = [
                'SIMILARITAS_ID' => $id,
                'SIMILARITAS_PRAJA' => $npp,
                'SIMILARITAS_TITLE' => $this->inputJudul,
                'SIMILARITAS_CLASS' => $this->inputKelas,
                'SIMILARITAS_ABSENT' => $this->inputAbsen,
            ];

            Similaritas::create($data);

            $this->dispatch("ponsel-updated", "Pengajuan similaritas anda sudah berhasil disimpan");
            $this->reset();
        } catch (\Throwable $th) {
            $this->dispatch("failed-creating-similaritas", $th->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.praja.similaritas.form-pengajuan');
    }
}
