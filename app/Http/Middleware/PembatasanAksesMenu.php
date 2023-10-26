<?php

namespace App\Http\Middleware;

use App\Models\pivotMenu;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Route;

class PembatasanAksesMenu
{
    private function checkMenuDatabase()
    {
        $address = Route::currentRouteName(); // <-- Maca halaman anu bade di tuju ku semah
        $role = Auth::user()->role->ROLE_ID; // <-- Maca role anu di candak ku semah

        // Logic kanggo milarian menu anu tiasa diakses ku semah
        $pivot = pivotMenu::with(
            [
                'menu' => function ($query) use ($address) { // <-- Fungsi kanggo milarian menu anu bade di akses ku semah
                    $query->where('MENU_URL', $address);
                }
            ]
        )->where('PIVOT_ROLE', $role)->first();


        // Upami menu anu di maksad teu kapendak dinu database mangka pulangkeun hasil false
        if (false == count($pivot->menu)) {
            return false;
        }

        return true; // <-- pulangkeun hasil true nalika menu kapendak di database
    }

    private function checkMenuManual()
    {
        $address = Route::currentRouteName();
        $role = Auth::user()->role->ROLE_NAME;


        $menuAdmin = collect(['assign-manajemen', 'user-manajemen']);
        $menuSuperAdmin = collect(['menu', 'role-manajemen']);

        if ($role == "Super Admin") {
            $data = $menuSuperAdmin->merge($menuAdmin);
        } elseif ($role == "Admin Pustaka") {
            $data = $menuAdmin;
        }

        return $result = $data->search($address);
    }

    public function handle(Request $request, Closure $next): Response
    {

        $checkDatabase = $this->checkMenuDatabase();
        $checkManual = $this->checkMenuManual();


        if ($checkDatabase == true || $checkManual !== false) {
            return $next($request); // <-- Salam pangabaktos, mangga dihaturanan linggih pangersa 😈
        } else {
            return abort(404);
        }
    }
}
