<?php

namespace App\Livewire\Page;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Manajemen Menu")]
class Menu extends Component
{
    public $title = 'Buat Data Baru';
    public $spanTitle = ' | Menu';
    public $actionName = 'createData';


    #[On("menu-created"), On("deleted-menu"), On("menu-updated")]
    public function processSuccessfully($message)
    {
        session()->reflash();
        session()->flash('success', $message);
    }

    #[On('failed-creating-menu'), On('failed-deleting-menu'), On('failed-updating-menu')]
    public function failedProcess($message)
    {
        session()->reflash();
        session()->flash('warning', $message);
    }

    #[On('selected-menu')]
    public function selectedMenu($data)
    {
        $this->title = $data['title'];
        $this->spanTitle = $data['spanTitle'];
        $this->actionName = $data['actionName'];
    }

    public function render()
    {
        return view('livewire.page.menu');
    }
}
