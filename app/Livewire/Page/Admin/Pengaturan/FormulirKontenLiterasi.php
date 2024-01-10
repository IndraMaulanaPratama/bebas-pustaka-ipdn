<?php

namespace App\Livewire\Page\Admin\Pengaturan;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Pengaturan Konten Literasi")]
class FormulirKontenLiterasi extends Component
{
    public function render()
    {
        return view('livewire.page.admin.pengaturan.formulir-konten-literasi');
    }
}
