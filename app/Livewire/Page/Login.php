<?php

namespace App\Livewire\Page;

use App\Models\BebasPustaka;
use App\Models\Role;
use App\Models\User;
use App\Services\PrajaService;
use Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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

    public $recaptcha_token;
    protected $PrajaService;


    public function boot(PrajaService $prajaService)
    {
        // Ngaktifkeun service praja
        $this->prajaService = $prajaService;
    }


    public function login()
    {
        // Validasi reCAPTCHA manual
        $recaptchaValid = $this->validateRecaptcha($this->recaptcha_token, 'login');

        if (!$recaptchaValid) {
            throw ValidationException::withMessages([
                'recaptcha' => 'reCAPTCHA validation failed. Please try again.',
            ]);
        }


        if (!$recaptchaValid) {
            $this->dispatchBrowserEvent('recaptchaError', ['message' => 'reCAPTCHA validation failed']);
            throw ValidationException::withMessages([
                'recaptcha' => 'reCAPTCHA validation failed. Please try again.',
            ]);
        }

        // Maca sumber data login boh ti admin atanapi praja
        $domain = explode('@', $this->email)[1];
        $npp = explode('@', $this->email)[0];


        // Proses upami semah ti pangurus perpustakaan
        if ($domain === "ipdn.ac.id") {
            $credentials = $this->validate();
            if (Auth::attempt($credentials)) {
                session()->regenerate();
                return redirect()->intended('/');

            } else {
                $this->password = null;
                session()->flash('warning', 'Data pengguna tidak ditemukan');
            }
        }

        // Proses upami semah ti praja
        elseif ($domain === 'praja.ipdn.ac.id') {

            // Milari data praja dumasar kana email sareng password
            // $praja = json_decode(file_get_contents(getenv('APP_PRAJA') . 'praja?npp=' . $npp), true);

            $praja = $this->prajaService->getDetailPraja($npp) ?? [];

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



    private function validateRecaptcha($token, $action = null)
    {
        // Skip reCAPTCHA validation in local environment
        if (app()->environment('local')) {
            // \Log::info('reCAPTCHA validation skipped in local environment');
            return true;
        }

        try {
            $response = Http::timeout(10)->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('recaptcha.api_secret_key'),
                'response' => $token,
                'remoteip' => request()->ip()
            ]);

            // ... rest of the validation code
        } catch (\Exception $e) {
            \Log::error('reCAPTCHA verification error: ' . $e->getMessage());
            return false;
        }
    }




    public function render()
    {
        session()->reflash();
        return view('livewire.page.login');
    }
}
