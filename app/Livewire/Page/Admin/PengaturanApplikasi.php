<?php

namespace App\Livewire\Page\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Pengaturan Website")]
class PengaturanApplikasi extends Component
{
    public function render()
    {
        return view('livewire.page.admin.pengaturan-applikasi');
    }
}
