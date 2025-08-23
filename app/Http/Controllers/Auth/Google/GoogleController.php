<?php

namespace App\Http\Controllers\Auth\Google;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;


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

            // Buat Google provider manual
            $config = config("services.google_{$domain}");

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

            // Validasi domain email
            $allowedDomains = ['ipdn.ac.id', 'praja.ipdn.ac.id'];
            if (!in_array($userDomain, $allowedDomains)) {
                session()->flash('warning', 'Domain tidak valid');
                return redirect()->route('login');
            }


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

        } catch (\Exception $e) {
            session()->flash('warning', 'Data pengguna tidak ditemukan');
            return redirect()->route('login');
        }
    }
}
