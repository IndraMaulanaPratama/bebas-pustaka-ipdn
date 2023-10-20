<?php

namespace App\Livewire\Page;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('layouts.login')]
class Login extends Component
{

    #[Rule(['required', 'string',])]
    public $email;

    #[Rule(['required', 'string',])]
    public $password;

    public function login()
    {
        session()->forget('warning');
        $credentials = $this->validate();

        if (Auth::attempt($credentials)) {
            $user = User::with(['role.pivotMenu'])->where('email', '=', $this->email)->first();

            session()->regenerate();
            Auth::login($user);

            $this->redirect('/');
        } else {
            $this->password = null;
            session()->flash('warning', 'Data pengguna tidak ditemukan');
        }
    }

    public function render()
    {
        return view('livewire.page.login');
    }
}
