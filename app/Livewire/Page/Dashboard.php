<?php

namespace App\Livewire\Page;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    #[Title('Beranda - Perpustakaan IPDN')]

    public function render()
    {
        $dataUser = User::with('role')->where('email', '=', 'owulandari@example.com')->first();
        return view('livewire.page.dashboard', ['data' => $dataUser]);
    }
}
