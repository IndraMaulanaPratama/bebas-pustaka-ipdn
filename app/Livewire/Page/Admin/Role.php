<?php

namespace App\Livewire\Page\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Manajemen Role")]
class Role extends Component
{
    /**
     * Kaca ieu ngatur role sadaya pangguna, jadi dijaga sacara eksplisit
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
