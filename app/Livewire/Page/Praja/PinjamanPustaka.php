<?php

namespace App\Livewire\Page\Praja;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Bebas Pinjaman Perpustakaan")]
class PinjamanPustaka extends Component
{
    public function render()
    {
        return view('livewire.page.praja.pinjaman-pustaka');
    }
}
