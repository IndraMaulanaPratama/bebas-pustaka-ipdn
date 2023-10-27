<?php

namespace App\Livewire\Admin\Assign;

use App\Models\Akses;
use App\Models\Menu;
use App\Models\pivotMenu;
use App\Models\Role;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    public $selectMenu, $selectRole, $description;

    public $switchRead = true, $switchView = true;
    public $switchCreate = false, $switchUpdate = false, $switchDelete = false, $switchRestore = false, $switchDestroy = false, $switchDetail = false;


    // Fungsi kanggo mulangkeun kondisi formulir sapertos awalna
    public function resetForm()
    {
        $this->reset();
        $this->selectMenu = null;
        $this->selectRole = null;

        $this->switchRead = true;
        $this->switchView = true;
        $this->switchCreate = false;
        $this->switchUpdate = false;
        $this->switchDelete = false;
        $this->switchRestore = false;
        $this->switchDestroy = false;
        $this->switchDetail = false;
    }


    public function checkDuplicate($menu, $role)
    {
        return pivotMenu::where(["PIVOT_MENU" => $menu, "PIVOT_ROLE" => $role])->first();
    }


    // Fungsi kanggo nambihan data assign
    public function createData()
    {
        // Validasi data role
        if ($this->selectRole == null) {
            $this->dispatch('failed-creating-assign', 'Anda belum memilih role');
            return;
        }

        // Validasi data menu
        if ($this->selectMenu == null) {
            $this->dispatch('failed-creating-assign', 'Anda belum memilih menu');
            return;
        }

        // Validasi data menu
        if ($this->description == null) {
            $this->dispatch('failed-creating-assign', 'Anda belum mengisikan deskripsi assign');
            return;
        }


        // Marios bilih data pivot menu tos pernah di daptarkeun sateuacana
        $duplicate = $this->checkDuplicate($this->selectMenu, $this->selectRole);
        if (null != $duplicate) {
            $this->dispatch('failed-creating-assign', "Data assign yang anda input sudah tersimpan di aplikasi");
            return;
        }


        // Logika kanggo nyimpen data assign
        try {
            $idPivot = uuid_create(4);
            $idAccess = uuid_create(4);

            $dataPivot = [
                'PIVOT_ID' => $idPivot,
                'PIVOT_MENU' => $this->selectMenu,
                'PIVOT_ROLE' => $this->selectRole,
                'PIVOT_DESCRIPTION' => $this->description,
            ];
            pivotMenu::create($dataPivot);


            $dataAccess = [
                'ACCESS_ID' => $idAccess,
                'ACCESS_MENU' => $idPivot,
                'ACCESS_CREATE' => $this->switchCreate,
                'ACCESS_READ' => $this->switchRead,
                'ACCESS_UPDATE' => $this->switchUpdate,
                'ACCESS_DELETE' => $this->switchDelete,
                'ACCESS_RESTORE' => $this->switchRestore,
                'ACCESS_DESTROY' => $this->switchDestroy,
                'ACCESS_DETAIL' => $this->switchDetail,
                'ACCESS_VIEW' => $this->switchView,
            ];

            Akses::create($dataAccess);

            $this->resetForm();
            $this->dispatch('assign-created', 'Anda berhasil menambahkan assign');

        } catch (\Throwable $th) {
            $this->dispatch('failed-creating-assign', $th->getMessage());
        }
    }



    public function render()
    {
        $role = Role::whereNotIn("ROLE_NAME", ["Super Admin"])->get();
        $menu = Menu::get();
        return view('livewire.admin.assign.create', [
            'role' => $role,
            'menu' => $menu,
        ]);
    }
}
