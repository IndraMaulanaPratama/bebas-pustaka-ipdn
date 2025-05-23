<?php

namespace App\Livewire\Page;

use App\Models\BebasPustaka;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Ramsey\Uuid\Uuid;

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
        $npp = explode('@', $this->email)[0];


        // Proses upami semah ti pangurus perpustakaan
        if ($domain === "ipdn.ac.id") {
            $credentials = $this->validate();
            if (Auth::attempt($credentials)) {
                session()->regenerate();
                return redirect()->route('dashboard');

            } else {
                $this->password = null;
                session()->flash('warning', 'Data pengguna tidak ditemukan');
            }
        }

        // Proses upami semah ti praja
        elseif ($domain === 'praja.ipdn.ac.id') {

            // Milari data praja dumasar kana email sareng password
            $praja = json_decode(file_get_contents(getenv('APP_PRAJA') . 'praja?npp=' . $npp), true);

            if ($praja) {
                $credentials = $this->validate();

                // Milarian data praja ka table user
                if (Auth::attempt($credentials)) {
                    session()->regenerate();
                    return redirect()->route('dashboard');
                }

                // Ngadamel user praja kumargi teu acan ka data di user
                elseif ($praja['data'][0]['TANGGAL_LAHIR'] == $this->password) {

                    try {
                        $role = Role::where('ROLE_NAME', 'PRAJA UTAMA')->first();

                        $data = [
                            'name' => $praja['data'][0]['NAMA'],
                            'email' => $praja['data'][0]['EMAIL'],
                            'password' => bcrypt($praja['data'][0]['TANGGAL_LAHIR']),
                            'photo' => "defaultPraja.png",
                            'user_role' => $role->ROLE_ID,
                        ];

                        $skbp = [
                            'BEBAS_ID' => Uuid::uuid4(),
                            'BEBAS_PRAJA' => $praja['data'][0]['NPP'],
                            'BEBAS_OFFICER' => 1,
                        ];

                        User::create($data);
                        BebasPustaka::create($skbp);

                        $credentials = $this->validate();
                        Auth::attempt($credentials);
                        session()->regenerate();
                        return redirect()->route('dashboard');

                    } catch (\Throwable $th) {
                        $this->password = null;
                        session()->flash('warning', 'Data pengguna tidak ditemukan');
                    }
                }

                //  Masihkeun pesan error kumargi data password teu sami sareng data tanggal lahir praja
                else {
                    session()->flash('warning', 'Data pengguna tidak ditemukan');
                    return;
                }
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
