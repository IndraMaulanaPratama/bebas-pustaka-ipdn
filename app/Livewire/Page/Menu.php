<?php

namespace App\Livewire\Page;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Manajemen Menu")]
class Menu extends Component
{
    public $title = 'Buat Data Baru';
    public $spanTitle = 'Menu';
    public $actionName = 'createData';

    /**
     * Kaca ieu ngatur menu sadaya pangguna, jadi dijaga sacara eksplisit
     * di jero component ieu — teu ngan ngandelkeun middleware 'access',
     * supados aman sanajan aya user nu coba buka URL-na langsung tanpa
     * liwat sidebar (nyoco pola nu geus dipake di Riwayat Aktivitas).
     */
    public function mount()
    {
        $role = Auth::user()->role->ROLE_NAME ?? null;

        if (!in_array($role, ['Super Admin', 'Admin Pustaka'])) {
            abort(404);
        }
    }

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
