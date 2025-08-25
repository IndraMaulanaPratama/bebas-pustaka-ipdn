<?php

namespace App\Livewire\Page\Praja;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Bimbingan Pemustaka")]
class BimbinganPemustaka extends Component
{

    #[On("failed-updating-data"), On("data-updated"), On("data-created"), On("failed-creating-data")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



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
        return view('livewire.page.praja.bimbingan-pemustaka');
    }
}
