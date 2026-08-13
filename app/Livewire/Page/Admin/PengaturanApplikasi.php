<?php

namespace App\Livewire\Page\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Pengaturan Website")]
class PengaturanApplikasi extends Component
{
    /**
     * Kaca ieu ngatur setting sakabeh website, jadi dijaga sacara
     * eksplisit di jero component ieu — teu ngan ngandelkeun middleware
     * 'access', supados aman sanajan aya user nu coba buka URL-na
     * langsung tanpa liwat sidebar (nyoco pola nu geus dipake di
     * Riwayat Aktivitas).
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
        return view('livewire.page.admin.pengaturan-applikasi');
    }
}
