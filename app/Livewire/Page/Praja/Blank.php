<?php

namespace App\Livewire\Page\Praja;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Blank Page")]
class Blank extends Component
{
    public function render()
    {
        return view('livewire.page.praja.blank');
    }
}
