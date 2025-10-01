<?php

namespace App\Http\Controllers\Auth\Google;

use App\Http\Controllers\Controller;
use App\Models\BebasPustaka;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Ramsey\Uuid\Uuid;


class GoogleController extends Controller
{
    public function redirectToGoogle($domain)
    {
        // Validasi domain
        if (!in_array($domain, ['praja', 'pegawai'])) {
            abort(404, 'Domain tidak dikenali');
        }

        // Buat Google provider manual dengan config yang sesuai
        $config = config("services.google_{$domain}");

        $provider = new GoogleProvider(
            app('request'),
            $config['client_id'],
            $config['client_secret'],
            $config['redirect']
        );

        // Tambahkan scope yang diperlukan
        $provider->scopes(['openid', 'profile', 'email']);

        // Tambahkan access type untuk offline access
        $provider->with(['access_type' => 'offline', 'prompt' => 'consent']);

        return $provider->redirect();
    }

    public function handleGoogleCallback($domain)
    {
        try {
            // Validasi domain
            if (!in_array($domain, ['pegawai', 'praja'])) {
                session()->flash('warning', 'Domain tidak valid');
                return redirect()->route('login');
            }

            // Cek apakah ada error dari Google
            if (request()->has('error')) {
                session()->flash('warning', 'Error dari Google: ' . request()->get('error_description', 'Unknown error'));
                return redirect()->route('login');
            }

            // Buat Google provider manual
            $config = config("services.google_{$domain}");

            // Validasi konfigurasi
            if (!$config || !$config['client_id'] || !$config['client_secret']) {
                session()->flash('warning', 'Konfigurasi Google OAuth tidak lengkap');
                return redirect()->route('login');
            }

            $provider = new GoogleProvider(
                app('request'),
                $config['client_id'],
                $config['client_secret'],
                $config['redirect']
            );

            // Dapatkan user data dari Google
            $googleUser = $provider->user();
            $email = $googleUser->getEmail();

            // Ekstrak domain dari email
            $userDomain = substr(strrchr($email, "@"), 1);
            $npp = explode('@', $email)[0];

            // Validasi domain email
            $allowedDomains = ['ipdn.ac.id', 'praja.ipdn.ac.id'];
            if (!in_array($userDomain, $allowedDomains)) {
                session()->flash('warning', 'Domain tidak valid');
                return redirect()->route('login');
            }


            // Mekanisme login pegawai dan praja
            if ($userDomain == "ipdn.ac.id") {
                // Cari user didalam database internal
                $user = User::where('email', $email)->first();


                // Jika user sudah ada, update id google dan avatar || Kembali ke halaman login
                if ($user) {

                    // Update id google dan avatar
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);

                    // Login user
                    Auth::login($user);
                } else {
                    session()->flash('warning', 'Data pengguna tidak ditemukan');
                    return redirect()->route('login');
                }


                // Redirect berdasarkan domain
                return redirect()->intended('/');

            } else {
                // Milari data praja dumasar kana email sareng password
                $praja = json_decode(file_get_contents('https://datapraja.ipdn.ac.id/api/' . 'praja?npp=' . $npp), true);

                if ($praja) {

                    // Inisiasi data API Praja
                    $nppPraja = $praja['data'][0]['NPP'];
                    $namaPraja = $praja['data'][0]['NAMA'];
                    $emailPraja = $praja['data'][0]['EMAIL'];
                    $tanggalLahirPraja = $praja['data'][0]['TANGGAL_LAHIR'];

                    // Milarian data praja ka table user
                    if (User::where('email', $email)->first()) {
                        session()->regenerate();
                        return redirect()->route('dashboard');
                    }

                    // Ngadamel user praja kumargi teu acan ka data di user
                    else {

                        try {
                            // Milari data role PRAJA_UTAMA
                            $role = Role::where('ROLE_NAME', 'PRAJA UTAMA')->first();

                            // Inisiasi variable kanggo praja enggal
                            $data = [
                                'name' => $namaPraja,
                                'email' => $emailPraja,
                                'password' => bcrypt($tanggalLahirPraja),
                                'photo' => "defaultPraja.png",
                                'user_role' => $role->ROLE_ID,
                            ];

                            // Inisiasi variable kanggo skbp enggal
                            $skbp = [
                                'BEBAS_ID' => Uuid::uuid4(),
                                'BEBAS_PRAJA' => $nppPraja,
                                'BEBAS_OFFICER' => 1,
                            ];

                            // Ngadamel user
                            User::create($data);

                            // Ngadamel skbp
                            BebasPustaka::create($skbp);

                            // Maca data user dumasar kana email
                            $user = User::where('email', $emailPraja)->first();

                            // Ngadamel session login nganggo data user
                            Auth::login($user);
                            session()->regenerate();
                            return redirect()->route('dashboard');

                        } catch (\Throwable $th) {
                            $this->password = null;
                            session()->flash('warning', $th->getMessage());
                        }
                    }
                }
            }




        } catch (\Exception $e) {
            session()->flash('warning', $e->getMessage());
            return redirect()->route('login');
        }
    }
}
