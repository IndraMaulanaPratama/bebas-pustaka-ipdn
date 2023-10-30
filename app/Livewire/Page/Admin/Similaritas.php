<?php

namespace App\Livewire\Page\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Data Similaritas")]
class Similaritas extends Component
{

    public $title = 'Formulir Data Pengguna';
    public function render()
    {
        return view('livewire.page.admin.similaritas');
    }
}
