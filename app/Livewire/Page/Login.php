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

        // Proses Authentication
        try {
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
                    return redirect()->route('login');
                }
            }

            // Proses upami semah ti praja
            elseif ($domain === 'praja.ipdn.ac.id') {

                // Milari data praja dumasar kana email sareng password
                // $praja = \App\Helpers\PrajaApi::getPraja($npp, true);

                $praja = $this->prajaService->getDetailPraja($npp) ?? [];

                if ($praja) {
                    $credentials = $this->validate();

                    // Milarian data praja ka table user
                    if (Auth::attempt($credentials)) {
                        session()->regenerate();
                        return redirect()->route('dashboard');
                    }

                    // Ngadamel user praja kumargi teu acan ka data di user ATAU sinkronisasi password
                    elseif ($praja['TANGGAL_LAHIR'] == $this->password) {

                        try {
                            $user = User::where('email', $this->email)->first();
                            
                            if ($user) {
                                // Update password karena user sudah ada tapi password berbeda/lama
                                $user->update(['password' => bcrypt($this->password)]);
                            } else {
                                $role = Role::where('ROLE_NAME', 'PRAJA UTAMA')->first();

                                $data = [
                                    'id' => Uuid::uuid4()->toString(),
                                    'name' => $praja['NAMA'],
                                    'email' => $praja['EMAIL'],
                                    'password' => bcrypt($praja['TANGGAL_LAHIR']),
                                    'photo' => "defaultPraja.png",
                                    'user_role' => $role->ROLE_ID,
                                ];

                                $skbp = [
                                    'BEBAS_ID' => Uuid::uuid4()->toString(),
                                    'BEBAS_PRAJA' => $praja['NPP'],
                                    'BEBAS_OFFICER' => 1,
                                ];

                                $user = User::create($data);
                                BebasPustaka::create($skbp);
                            }

                            Auth::login($user);
                            session()->regenerate();
                            return redirect()->route('dashboard');

                        } catch (\Throwable $th) {
                            logger()->error("Praja Login Error: " . $th->getMessage() . " at " . $th->getFile() . ":" . $th->getLine());
                            $this->password = null;
                            session()->flash('warning', 'Data pengguna tidak ditemukan (' . $th->getMessage() . ')');
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
        } catch (\Throwable $th) {
            session()->flash('warning', $th->getMessage());
            return redirect()->route('login');
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
