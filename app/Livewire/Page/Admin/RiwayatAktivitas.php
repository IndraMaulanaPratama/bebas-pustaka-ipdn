<?php

namespace App\Livewire\Page\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Riwayat Aktivitas")]
class RiwayatAktivitas extends Component
{
    public function render()
    {
        return view('livewire.page.admin.riwayat-aktivitas');
    }
}
