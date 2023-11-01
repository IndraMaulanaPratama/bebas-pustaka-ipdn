<?php

namespace App\Livewire\Page\Praja;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Halaman Similaritas")]
class Similaritas extends Component
{

    #[On("ponsel-updated"), On("similaritas-created")]
    public function processSuccessfully($message)
    {
        session()->reflash();
        session()->flash('success', $message);
    }



    #[On('failed-updating-ponsel'), On("failed-creating-similaritas")]
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
