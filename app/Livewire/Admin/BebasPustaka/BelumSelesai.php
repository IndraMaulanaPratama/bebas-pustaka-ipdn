<?php

namespace App\Livewire\Admin\BebasPustaka;

use Livewire\Attributes\Title;
use Livewire\Component;

class BelumSelesai extends Component
{
    #[Title('Resume SKBP - Belum Selesai')]


    public function render()
    {
        return view('livewire.admin.bebas-pustaka.belum-selesai');
    }
}
