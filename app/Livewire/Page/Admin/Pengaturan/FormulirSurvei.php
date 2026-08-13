<?php

namespace App\Livewire\Page\Admin\Pengaturan;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Pengaturan Formulir Survei")]
class FormulirSurvei extends Component
{
    /**
     * Kaca pengaturan ieu dijaga sacara eksplisit di jero component —
     * teu ngan ngandelkeun middleware 'access', supados aman sanajan
     * aya user nu coba buka URL-na langsung tanpa liwat sidebar
     * (nyoco pola nu geus dipake di Riwayat Aktivitas).
     */
    public function mount()
    {
        $role = Auth::user()->role->ROLE_NAME ?? null;

        if (!in_array($role, ['Super Admin', 'Admin Pustaka'])) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.page.admin.pengaturan.formulir-survei');
    }
}
