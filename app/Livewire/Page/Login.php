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

        // Maca sumber data login boh ti admin atanapi praja
        $domain = explode('@', $this->email)[1];


        // Proses upami semah ti pangurus perpustakaan
        if ($domain === "ipdn.ac.id") {
            $credentials = $this->validate();
            if (Auth::attempt($credentials)) {
                session()->regenerate();
                // Auth::guard('web')->login($credentials);
                $this->redirect('/');

            } else {
                $this->password = null;
                session()->flash('warning', 'Data pengguna tidak ditemukan');
            }
        }

        // Proses upami semah ti praja
        elseif ($domain === 'praja.ipdn.ac.id') {

            // Milari data praja dumasar kana email sareng password
            $user = User::where(['email' => $this->email])->first();

            // ngadaptarkeun data login ka session auth
            if ($user != null) {
                session()->flash('success', 'Anda berhasil login kedalam aplikasi');

                Auth::login($user);
                $this->redirect('/');
                return;
            }

            // masihkeun pesan error ka semah kumargi data login teu kapendak di system
            session()->flash('warning', 'Data pengguna tidak ditemukan');
            return;
        }

        // Proses Upami domain duka timanten
        else {
            session()->flash('warning', 'Data pengguna tidak ditemukan');
        }
    }

    public function render()
    {
        session()->reflash();
        return view('livewire.page.login');
    }
}
