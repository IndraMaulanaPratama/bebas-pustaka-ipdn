<?php

use App\Livewire\Page\Admin\Assign;
use App\Livewire\Page\Admin\Role;
use App\Livewire\Page\Admin\Similaritas;
// use App\Livewire\Page\Praja\Similaritas as PrajaSimilaritas;
use App\Livewire\Page\Admin\Users;
use App\Livewire\Page\Dashboard;
use App\Livewire\Page\Login;
use App\Livewire\Page\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Dashboard::class)->middleware('auth')->name('/');

// Ranahna nu gaduh akses
Route::middleware(['auth', 'access'])->group(function () {
    Route::get('/praja/similaritas', App\Livewire\Page\Praja\Similaritas::class)->name('praja-similaritas');

    // --- *** Admin Area *** ---
    Route::get('/similaritas', Similaritas::class)->name('admin-similaritas');


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
