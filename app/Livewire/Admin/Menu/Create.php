<?php

namespace App\Livewire\Admin\Menu;

use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use illuminate\Support\Str;

class Create extends Component
{
    public $title = '';
    public $spanTitle = '';
    public $actionName = '';

    public $id = '';

    // Ngadamel sareng marios input data menu ti client
    #[Rule(['required', 'string', 'max:50', 'unique:MENUS,MENU_NAME'])]
    public $menu = '';

    // Ngadamel sareng marios input data icon ti client
    #[Rule(['string', 'max:50'])]
    public $icon = '';

    // Ngadamel sareng marios input data description ti client
    #[Rule(['string'])]
    public $description = '';

    // Ngadamel sareng marios input data url ti client
    #[Rule(['required', 'string', 'max:20', 'unique:MENUS,MENU_URL'])]
    public $url = '';

    #[Rule(['string', 'required'])]
    public $position = '';



    public function mount($title = '', $actionName = '', $spanTitle = '')
    {
        $this->title = $title;
        $this->actionName = $actionName;
        $this->spanTitle = $spanTitle;
    }



    /**
     * Fungsi kanggo ngadamel slug url menu
     */
    public function updatedMenu()
    {
        $this->url = str::slug($this->menu);
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
                'MENU_URL' => str::slug($this->menu),
                'MENU_POSITION' => $this->position,
            ];

            // proses nyimpen data ka database
            \App\Models\Menu::create($data);

            // ngadamel pengumuman kanggo component nu sanes
            $this->dispatch('menu-created', 'Menu baru berhasil ditambahkan');

            // mulihkeun kondisi form ka posisi default
            $this->resetForm();

        } catch (\Throwable $th) {
            $this->dispatch('failed-creating-menu', $th->getMessage());
        }
    }



    /**
     * Fungsi kanggo ngarobih form nalika aya menu anu bade di ubah
     */
    #[On('selected-menu')]
    public function editData($data)
    {
        // Data Menu
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->spanTitle = $data['spanTitle'];
        $this->actionName = $data['actionName'];

        // Data Card form create-update menu
        $this->menu = $data['menu'];
        $this->description = $data['description'];
        $this->url = $data['url'];
    }



    /**
     * Fungsi kanggo ngarobih data anu tos disimpen di database
     */
    public function updateData()
    {
        $this->validate();

        try {
            // Inisialisasi data nu bade di eksekusi
            $data = [
                'MENU_NAME' => $this->menu,
                'MENU_DESCRIPTION' => $this->description,
                'MENU_URL' => $this->url,
            ];

            // proses nyimpen data ka database
            \App\Models\Menu::find($this->id)->update($data);

            // mulihkeun kondisi form ka posisi default
            $this->resetForm();

            // ngadamel pengumuman kanggo component nu sanes
            $this->dispatch('menu-updated', 'Menu yang anda pilih, berhasil diperbaharui');

        } catch (\Throwable $th) {
            $this->dispatch('failed-updating-menu', 'Terjadi kesalahan pada saat memperbaharui data menu');
        }
    }



    public function render()
    {
        return view('livewire.admin.menu.create');
    }
}
