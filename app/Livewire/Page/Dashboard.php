<?php

namespace App\Livewire\Page;

use App\Models\Akses;
use App\Models\pivotMenu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Beranda - Bebas Pustaka IPDN')]
class Dashboard extends Component
{
    public $email, $user;

    public function mount()
    {
        $this->email = explode("@", Auth::user()->email)[1];
    }




    public function render()
    {
        $role = $this->email == 'ipdn.ac.id' ? 'admin' : 'praja';

        return view('livewire.page.dashboard', [
            'role' => $role,
        ]);
    }
}
