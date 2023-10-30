<?php

namespace App\Livewire\Admin\Similaritas;

use Livewire\Component;

class Approve extends Component
{
    public $similaritas, $smallWord;
    public $nomorSurat = "000.5.2.4/BPS-0001/IPDN.21/2023"; // Jadikeun dinamis bos
    public $switchBibliografi, $switchSmallWord, $switchQuotes;

    public function resetForm(){
        $this->reset();
    }

    public function approveData() {
        dd([
            $this->similaritas, $this->smallWord, $this->switchBibliografi, $this->switchSmallWord, $this->switchQuotes
        ]);
    }

    public function render()
    {
        return view('livewire.admin.similaritas.approve');
    }
}
