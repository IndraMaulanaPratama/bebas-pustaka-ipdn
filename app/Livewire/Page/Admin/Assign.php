<?php

namespace App\Livewire\Page\Admin;

use App\Models\Akses;
use App\Models\Menu;
use App\Models\pivotMenu;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title("Assign Role Manajemen")]
class Assign extends Component
{
    use WithPagination;

    /**
     * Kaca ieu ngatur akses (assign role ka menu), jadi dijaga sacara
     * eksplisit di jero component ieu — teu ngan ngandelkeun middleware
     * 'access', supados aman sanajan aya user nu coba buka URL-na
     * langsung tanpa liwat sidebar (nyoco pola nu geus dipake di
     * Riwayat Aktivitas).
     */
    public function mount()
    {
        $role = Auth::user()->role->ROLE_NAME ?? null;

        if (!in_array($role, ['Super Admin', 'Admin Pustaka'])) {
            abort(404);
        }
    }

    #[On("assign-created"), On("assign-updated"), On("assign-deleted")]
    public function processSuccessfully($message)
    {
        session()->reflash();
        session()->flash('success', $message);
    }



    #[On('failed-creating-assign'), On('failed-deleting-assign'), On('failed-updating-assign')]
    public function failedProcess($message)
    {
        session()->reflash();
        session()->flash('warning', $message);
    }

    public function render()
    {
        $access = Akses::query()->with([
            "pivotMenu.role",
            "pivotMenu.menu" => function ($query) {
                $query->whereNotIn("MENU_NAME", ["Super Admin"]);
            },
        ])->paginate();

        $menu = Menu::query()->paginate();
        $role = Role::whereNotIn("ROLE_NAME", ["Super Admin"])->paginate();

        return view(
            'livewire.page.admin.assign',
            [
                'access' => $access,
                'menu' => $menu,
                'role' => $role,
            ]
        );
    }
}
