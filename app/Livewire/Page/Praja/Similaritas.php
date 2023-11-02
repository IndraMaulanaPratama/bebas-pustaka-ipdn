<?php

namespace App\Livewire\Page\Praja;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Halaman Similaritas")]
class Similaritas extends Component
{
    public $npp, $statusPengajuan = "Belum Ada Pengajuan";


    public function mount()
    {
        $this->npp = explode("@", Auth::user()->email)[0];
        $status = $this->bacaStatusPengajuan();

        if ($status != null) {
            $this->statusPengajuan = $status->SIMILARITAS_STATUS;
        }
    }


    // Fungsi kanggo maca status pengajuan similaritas
    public function bacaStatusPengajuan()
    {
        return \App\Models\Similaritas::where("SIMILARITAS_PRAJA", $this->npp)->first('SIMILARITAS_STATUS');
    }



    #[On("ponsel-updated"), On("similaritas-created"), On("similaritas-updated")]
    /***
     * Fungsi anu bakal di jalankeun upami aya signal anu tos di tangtoskeun di luhur
     */
    public function processSuccessfully($message)
    {
        session()->reflash();
        session()->flash('success', $message);

        $update = $this->bacaStatusPengajuan();
        $this->statusPengajuan = $update->SIMILARITAS_STATUS;
    }



    #[On('failed-updating-ponsel'), On("failed-creating-similaritas"), On("failed-updating-similaritas")]
    /***
     * Fungsi anu bakal di jalankeun upami aya signal anu tos di tangtoskeun di luhur
     */
    public function failedProcess($message)
    {
        session()->reflash();
        session()->flash('warning', $message);
    }


    public function render()
    {
        return view('livewire.page.praja.similaritas');
    }
}
