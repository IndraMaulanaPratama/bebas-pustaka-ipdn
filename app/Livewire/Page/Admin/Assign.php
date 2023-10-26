<?php

namespace App\Livewire\Page\Admin;

use App\Models\Akses;
use App\Models\Menu;
use App\Models\pivotMenu;
use App\Models\Role;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title("Assign Role Manajemen")]
class Assign extends Component
{
    use WithPagination;

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
