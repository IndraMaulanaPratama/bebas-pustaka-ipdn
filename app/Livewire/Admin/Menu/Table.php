<?php

namespace App\Livewire\Admin\Menu;

use App\Models\Menu;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search = '';

    /**
     * On () -> Attribut kanggo maca pesan ti componen sanes
     * `menuCreated` pesan anu dikintun ti component lain
     *
     * fungsi placeholder nyaeta fungsi candakan livewire pikeun ngaload ulang component
     */

    #[On('menu-created'), On('menu-updated')]
    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
            <svg>...</svg>
        </div>
        HTML;
    }

    public function updateMenu($id)
    {
        $menu = Menu::find($id);

        $data = [
            'id' => $menu->MENU_ID,
            'menu' => $menu->MENU_NAME,
            'description' => $menu->MENU_DESCRIPTION,
            'url' => $menu->MENU_URL,

            'title' => 'Perbarui Data',
            'spanTitle' => ' | Menu ' . $menu->MENU_NAME,
            'actionName' => 'updateData',
        ];

        $this->dispatch('selected-menu', $data);
    }

    public function deleteMenu($id)
    {
        try {
            Menu::find($id)->delete();

            $this->placeholder();
            $this->dispatch('deleted-menu', 'Menu yang anda pilih, berhasil dihapuskan');
        } catch (\Throwable $th) {
            $this->dispatch('failed-dleted-menu', $th->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            Menu::find($id)->restore();

            $this->placeholder();
            $this->dispatch('restored-menu', 'Menu yang anda pilih, berhasil dipulihkan');
        } catch (\Throwable $th) {
            $this->dispatch('failed-restoring-menu', $th->getMessage());
        }
    }


    public function render()
    {
        $menu = Menu::when(
            $this->search, function ($query, $search) {
                return $query->where('MENU_NAME','like','%'. $search .'%');
            }
        )->latest()->paginate();
        return view('livewire.admin.menu.table', ['data' => $menu]);
    }
}
