<?php

namespace App\Livewire\Page\Admin;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Manajemen Pengguna")]
class Users extends Component
{
    public $title = 'Formulir Data Pengguna';
    public $titleSpan = 'Tambah Data';
    public $actionName = 'createData';


    #[On("user-created"), On("deleted-user"), On("user-updated")]
    public function processSuccessfully($message)
    {
        session()->reflash();
        session()->flash('success', $message);
    }

    #[On('failed-creating-user'), On('failed-deleting-user'), On('failed-updating-user')]
    public function failedProcess($message)
    {
        session()->reflash();
        session()->flash('warning', $message);
    }

    public function render()
    {
        return view('livewire.page.admin.users');
    }
}
