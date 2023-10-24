<?php

namespace App\Livewire\Page\Admin;

use Livewire\Attributes\On;
use Livewire\Component;

class Role extends Component
{
    #[On("role-created"), On("role-updated"), On("role-deleted")]
    public function processSuccessfully($message)
    {
        session()->reflash();
        session()->flash('success', $message);
    }



    #[On('failed-creating-role'), On('failed-deleting-role'), On('failed-updating-role')]
    public function failedProcess($message)
    {
        session()->reflash();
        session()->flash('warning', $message);
    }




    public function render()
    {
        return view('livewire.page.admin.role');
    }
}
