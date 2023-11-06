<?php

use App\Livewire\Page\Admin\Assign;
use App\Livewire\Page\Admin\PinjamanFakultas;
use App\Livewire\Page\Admin\PinjamanPustaka;
use App\Livewire\Page\Admin\Role;
use App\Livewire\Page\Admin\Similaritas;
// use App\Livewire\Page\Praja\Similaritas as PrajaSimilaritas;
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
    Route::get('/praja/bebas-pinjaman', App\Livewire\Page\Praja\Similaritas::class)->name('praja-bebasPinjaman');


    // --- *** Officer Area *** --- //
    Route::get('/similaritas', Similaritas::class)->name('admin-similaritas'); // TODO: Fitur Print dan export
    Route::get('/bebas-pinjaman-perpustakaan', PinjamanPustaka::class)->name('admin-pinjaman.perpustakaan');
    Route::get('/bebas-pinjaman-fakultas', PinjamanFakultas::class)->name('admin-pinjaman.fakultas');




    // -- *** Admin Area --- //
    Route::get('/menu', Menu::class)->name('menu');
    Route::get('/users', Users::class)->name('user-manajemen');
    Route::get('/role', Role::class)->name('role-manajemen');
    Route::get('/assign', Assign::class)->name('assign-manajemen');
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
