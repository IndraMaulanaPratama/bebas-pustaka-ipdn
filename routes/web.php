<?php

use App\Livewire\Page\Admin\Role;
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
Route::middleware(['auth', 'access'])->prefix('')->group(function () {
    Route::get('/menu', Menu::class)->name('menu');
    Route::get('/menu/asign', Menu::class)->name('menu-asign'); // TODO: Selesaikan dong module ini say
    Route::get('/users', Users::class)->name('user-manajemen');
    Route::get('/role', Role::class)->name('role-manajemen');
});

// Ranahna gapura
Route::get('/login', Login::class)->middleware('guest')->name('login');
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('login');
})->middleware('auth')->name('logout');
