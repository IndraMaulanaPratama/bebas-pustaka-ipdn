<?php

namespace App\Livewire\Admin\Menu;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use illuminate\Support\Str;

class Table extends Component
{
    use WithPagination;

    public $buttonCreate, $buttonUpdate, $buttonDelete;


    public $search = '';
    public $id = '';

    // Ngadamel sareng marios input data menu ti client
    #[Rule(['required', 'string', 'max:150'])]
    public $menu = '';

    // Ngadamel sareng marios input data icon ti client
    #[Rule(['string', 'max:50'])]
    public $icon = '';

    // Ngadamel sareng marios input data description ti client
    #[Rule(['string'])]
    public $description = '';

    // Ngadamel sareng marios input data url ti client
    #[Rule(['required', 'max:150', 'unique:MENUS,MENU_URL'])]
    public $url = '';

    #[Rule(['string', 'required'])]
    public $position = '';




    /**
     * On () -> Attribut kanggo maca pesan ti componen sanes
     * `menuCreated` pesan anu dikintun ti component lain
     *
     * fungsi placeholder nyaeta fungsi candakan livewire pikeun ngaload ulang component
     */


    /**
     * Fungsi kanggo ngadamel slug url menu
     */
    // public function updatedMenu()
    // {
    //     $this->url = str::slug($this->menu);
    // }


    /**
     * Fungsi kanggo nyimpen data menu enggal
     */

    public function createData()
    {
        // Ngajalankeun validasi data
        $this->validate();

        try {
            // Inisialisasi data nu bade di eksekusi
            $data = [
                'MENU_ID' => uuid_create(4),
                'MENU_NAME' => $this->menu,
                'MENU_DESCRIPTION' => $this->description,
                'MENU_ICON' => $this->icon != null ? $this->icon : null,
                'MENU_URL' => $this->url,
                'MENU_POSITION' => $this->position,
            ];

            // proses nyimpen data ka database
            Menu::create($data);

            // ngadamel pengumuman kanggo component nu sanes
            $this->dispatch('menu-created', 'Menu baru berhasil ditambahkan');

            // mulihkeun kondisi form ka posisi default
            $this->resetForm();

        } catch (\Throwable $th) {
            $this->dispatch('failed-creating-menu', $th->getMessage());
        }
    }


    #[On('menu-created'), On('menu-updated')]
    public function placeholder()
    {
        return view('components.admin.components.spinner.loading');
    }


    public function updateMenu($id)
    {
        $this->reset();

        $menu = Menu::find($id);

        $this->id = $menu->MENU_ID;
        $this->menu = $menu->MENU_NAME;
        $this->icon = $menu->MENU_ICON;
        $this->url = $menu->MENU_URL;
        $this->description = $menu->MENU_DESCRIPTION;
        $this->position = $menu->MENU_POSITION;
        // $this->dispatch('selected-menu', $data);
    }

    /**
     * Fungsi kanggo ngarobih data anu tos disimpen di database
     */
    public function updateData()
    {

        try {
            // Inisialisasi data nu bade di eksekusi
            $data = [
                'MENU_NAME' => $this->menu,
                'MENU_DESCRIPTION' => $this->description,
                'MENU_URL' => $this->url,
                'MENU_ICON' => $this->icon,
                'MENU_POSITION' => $this->position,
            ];

            // proses nyimpen data ka database
            Menu::find($this->id)->update($data);

            // mulihkeun kondisi form ka posisi default
            $this->resetForm();

            // ngadamel pengumuman kanggo component nu sanes
            $this->dispatch('menu-updated', 'Menu yang anda pilih, berhasil diperbaharui');

        } catch (\Throwable $th) {
            $this->dispatch('failed-updating-menu', 'Terjadi kesalahan pada saat memperbaharui data menu');
        }
    }

    public function deleteMenu($id)
    {
        try {
            Menu::find($id)->delete();

            $this->placeholder();
            $this->dispatch('deleted-menu', 'Menu yang anda pilih, berhasil dihapuskan');
        } catch (\Throwable $th) {
            $this->dispatch('failed-deleting-menu', $th->getMessage());
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


    /**
     * Fungsi pikeun mulangkeun kondisi form ka awal
     */

    public function resetForm()
    {
        // Mulangkeun kondisi form sapertos awalna
        $this->reset();

        // Settingan card form-update menu
        $this->title = 'Buat Data Baru';
        $this->spanTitle = ' | Menu';
        $this->actionName = 'createData';
    }


    public function render()
    {
        $role = Auth::user()->role->ROLE_NAME;
        $role !== "Super Admin" ? $this->buttonCreate = "hidden" : $this->buttonCreate = null;
        $role !== "Super Admin" ? $this->buttonUpdate = "hidden" : $this->buttonCreate = null;
        $role !== "Super Admin" ? $this->buttonDelete = "hidden" : $this->buttonCreate = null;

        $menu = Menu::when(
            $this->search,
            function ($query, $search) {
                return $query->where('MENU_NAME', 'like', '%' . $search . '%');
            }
        )->latest()->paginate();


        return view('livewire.admin.menu.table', ['data' => $menu]);
    }
}
