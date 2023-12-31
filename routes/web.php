<?php

use App\Livewire\Page\Admin\Assign;
use App\Livewire\Page\Admin\BebasPustaka;
use App\Livewire\Page\Admin\DonasiElektronik;
use App\Livewire\Page\Admin\DonasiFakultas;
use App\Livewire\Page\Admin\DonasiPustaka;
use App\Livewire\Page\Admin\KontenLiterasi;
use App\Livewire\Page\Admin\PengaturanApplikasi;
use App\Livewire\Page\Admin\PinjamanFakultas;
use App\Livewire\Page\Admin\PinjamanPustaka;
use App\Livewire\Page\Admin\Role;
use App\Livewire\Page\Admin\Similaritas;
use App\Livewire\Page\Admin\SkripsiFakultas;
use App\Livewire\Page\Admin\SkripsiPerpustakaan;
use App\Livewire\Page\Admin\SkripsiSoftCopy;
use App\Livewire\Page\Admin\Survey;
use App\Livewire\Page\Admin\UnggahRepository;
use App\Livewire\Page\Admin\Users;
use App\Livewire\Page\Dashboard;
use App\Livewire\Page\Login;
use App\Livewire\Page\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', Dashboard::class)->middleware('auth')->name('/');



// Ranahna nu gaduh akses
Route::middleware(['auth', 'access'])->group(function () {
    // --- *** Praja Area *** --- //
    Route::get('/praja/similaritas', App\Livewire\Page\Praja\Similaritas::class)->name('praja-similaritas');
    Route::get('/praja/bebas-pinjaman', \App\Livewire\Page\Praja\Pinjaman::class)->name('praja-pinjaman');
    //
    Route::get('/praja/donasi', \App\Livewire\Page\Praja\Donasi::class)->name('praja-donasi');
    Route::get('praja/survey', \App\Livewire\Page\Praja\SurveyPustaka::class)->name('praja-survey');
    Route::get('praja/konten-literasi', \App\Livewire\Page\Praja\KontenLiterasi::class)->name('praja-konten.literasi');
    Route::get('praja/unggah-repository', \App\Livewire\Page\Praja\UnggahRepository::class)->name('praja-unggah.repository');
    Route::get('praja/copy-skripsi', \App\Livewire\Page\Praja\PengumpulanSkripsi::class)->name('praja-skripsi');


    // --- *** Officer Area *** --- //
    Route::get('/similaritas', Similaritas::class)->name('admin-similaritas'); // TODO: Fitur Print dan export
    Route::get('/bebas-pinjaman-perpustakaan', PinjamanPustaka::class)->name('admin-pinjaman.perpustakaan');
    Route::get('/bebas-pinjaman-fakultas', PinjamanFakultas::class)->name('admin-pinjaman.fakultas'); // TODO:: Fitur Print dan export
    Route::get('/donasi-buku-perpustakaan', DonasiPustaka::class)->name('admin-donasi.perpustakaan');
    Route::get('/donasi-buku-fakultas', DonasiFakultas::class)->name('admin-donasi.fakultas');
    Route::get('/donasi-buku-elektronik', DonasiElektronik::class)->name('admin-donasi.elektronik');
    Route::get('/survey', Survey::class)->name('admin-survey');
    Route::get('/konten-literasi', KontenLiterasi::class)->name('admin-konten.literasi');
    Route::get('/unggah-repository', UnggahRepository::class)->name('admin-unggah.repository');
    Route::get('/hard-copy-fakultas', SkripsiFakultas::class)->name('admin-hard.fakultas');
    Route::get('/hard-copy-perpustakaan', SkripsiPerpustakaan::class)->name('admin-hard.perpustakaan');
    Route::get('/soft-copy-skripsi', SkripsiSoftCopy::class)->name('admin-soft.skripsi');
    //
    Route::get('/bebas-pustaka', BebasPustaka::class)->name('admin-pustaka'); // TODO:: Export SKBP




    // -- *** Admin Area --- //
    Route::get('/menu', Menu::class)->name('menu');
    Route::get('/users', Users::class)->name('user-manajemen');
    Route::get('/role', Role::class)->name('role-manajemen');
    Route::get('/assign', Assign::class)->name('assign-manajemen');
    Route::get('/setting', PengaturanApplikasi::class)->name('settings-web');
    // <!-- End Of Admin area !--->
});



// Ranahna gapura
Route::get('/login', Login::class)->middleware('guest')->name('login');
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('login');
})->middleware('auth')->name('logout');
