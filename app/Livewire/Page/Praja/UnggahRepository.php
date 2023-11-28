<?php

namespace App\Livewire\Page\Praja;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Unggah Repository")]
class UnggahRepository extends Component
{



    #[On("data-rejected"), On("data-updated"), On("data-created")]
    public function processSuccessfully($message)
    {
        session()->reflash();
        session()->flash('success', $message);
    }



    #[On("failed-rejecting-data"), On("failed-updating-data"), On("failed-creating-data")]
    public function failedProcess($message)
    {
        session()->reflash();
        session()->flash('warning', $message);
    }



    public function render()
    {
        return view('livewire.page.praja.unggah-repository');
    }
}
