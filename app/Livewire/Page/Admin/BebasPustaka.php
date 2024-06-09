<?php

namespace App\Livewire\Page\Admin;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Resume pengajuan bebas pustaka")]
class BebasPustaka extends Component
{

    #[On("success")]
    public function processSuccessfully($message)
    {
        session()->reflash();
        session()->flash('success', $message);
    }



    #[On("warning")]
    public function warningProcess($message)
    {
        session()->reflash();
        session()->flash('warning', $message);
    }


    #[On("error")]
    public function failedProcess($message)
    {
        session()->reflash();
        session()->flash('error', $message);
    }


    public function render()
    {
        return view('livewire.page.admin.bebas-pustaka');
    }
}
