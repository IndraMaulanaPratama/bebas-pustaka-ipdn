<?php

namespace App\Livewire\Page;

use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    #[Title('Test-title')]

    public function render()
    {
        return view('livewire.page.dashboard');
    }
}
