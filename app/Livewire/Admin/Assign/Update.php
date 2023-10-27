<?php

namespace App\Livewire\Admin\Assign;

use App\Models\Akses;
use App\Models\Menu;
use App\Models\pivotMenu;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    public $selectMenu, $selectRole, $description;

    public $idAccess, $idAssign;
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


    // Fungsi kanggo ngarobih data ti database janten data boolean
    public function convertSwitchValue($value)
    {
        return $value == 1 ? true : false;
    }


    // Fungsi kanggo nyesuaikeun form dumasar id data nu aya dina database
    #[On("pivot-selected")]
    public function updatePivot($id)
    {
        // Maca data access, assign, role sareng menu dumasar kana id access
        $assign = Akses::with(['pivotMenu.menu', 'pivotMenu.role'])->where('ACCESS_MENU', $id)->first();

        // Nangtoskeun id access sareng id pivot
        $this->idAccess = $assign->ACCESS_ID;
        $this->idAssign = $assign->pivotMenu->PIVOT_ID;

        // Ngarobih form select sareng textarea
        $this->selectMenu = $assign->pivotMenu->menu[0]->MENU_ID;
        $this->selectRole = $assign->pivotMenu->role->ROLE_ID;
        $this->description = $assign->pivotMenu->PIVOT_DESCRIPTION;

        // Ngarobih form switch acess
        $this->switchCreate = $this->convertSwitchValue($assign->ACCESS_CREATE);
        $this->switchRead = $this->convertSwitchValue($assign->ACCESS_READ);
        $this->switchView = $this->convertSwitchValue($assign->ACCESS_VIEW);
        $this->switchUpdate = $this->convertSwitchValue($assign->ACCESS_UPDATE);
        $this->switchDelete = $this->convertSwitchValue($assign->ACCESS_DELETE);
        $this->switchRestore = $this->convertSwitchValue($assign->ACCESS_RESTORE);
        $this->switchDestroy = $this->convertSwitchValue($assign->ACCESS_DESTROY);
        $this->switchDetail = $this->convertSwitchValue($assign->ACCESS_DETAIL);
    }

    public function checkDuplicate($menu, $role)
    {
        $changeValue = Akses::with(['pivotMenu'])->where('ACCESS_ID', $this->idAccess)->first();
        // dd($changeValue);

        if ($changeValue->pivotMenu->PIVOT_MENU == $this->selectMenu && $changeValue->pivotMenu->PIVOT_ROLE == $this->selectRole) {
            return null;
        }

        return pivotMenu::where(["PIVOT_MENU" => $menu, "PIVOT_ROLE" => $role])->first();
    }


    // Fungsi kanggo nambihan data assign
    public function updateData()
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
            $idPivot = $this->idAssign;
            $idAccess = $this->idAccess;

            $dataPivot = [
                'PIVOT_ID' => $idPivot,
                'PIVOT_MENU' => $this->selectMenu,
                'PIVOT_ROLE' => $this->selectRole,
                'PIVOT_DESCRIPTION' => $this->description,
            ];
            pivotMenu::where('PIVOT_ID', $idPivot)->update($dataPivot);


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

            Akses::where('ACCESS_ID', $idAccess)->update($dataAccess);

            $this->resetForm();
            $this->dispatch('assign-updated', 'Anda berhasil memperbaharui data assign');

        } catch (\Throwable $th) {
            $this->dispatch('failed-updating-assign', $th->getMessage());
        }
    }



    public function render()
    {
        $role = Auth::user()->role->ROLE_NAME;
        $role !== "Super Admin" ? $dataRole = Role::whereNot("ROLE_NAME", "Super Admin")->get() : $dataRole = Role::get();

        $menu = Menu::get();

        return view('livewire.admin.assign.update', [
            'role' => $dataRole,
            'menu' => $menu
        ]);
    }
}
