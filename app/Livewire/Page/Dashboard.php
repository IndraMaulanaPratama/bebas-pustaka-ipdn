<?php

namespace App\Livewire\Page;

use App\Models\pivotMenu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    #[Title('Beranda - Perpustakaan IPDN')]

    public function render()
    {

        // Milarian data role dumasar kana akun anu lebet
        $role = Role::where('ROLE_ID', Auth::user()->user_role)->first(
            [
                'ROLE_ID AS id',
                'ROLE_NAME AS role'
            ]
        );

        // Milarian data pivot menu dumasar kana akun
        $pivot = pivotMenu::with(['menu', 'access'])->where('PIVOT_ROLE', $role->id)->get();

        // Inisialisasi akses anu tiasa di anggo ku akun login
        for ($i = 0; $i < count($pivot); $i++) {
            $akses[$pivot[$i]->menu[0]->MENU_NAME] = $pivot[$i]->access[0];
        }

        // ngalebetkeun data role sareng akses ka session login
        Auth::user()->role = $role;
        Auth::user()->akses = $akses;


        $dataUser = User::with('role')->where('email', '=', 'owulandari@example.com')->first();
        return view('livewire.page.dashboard', ['data' => $dataUser]);
    }
}
