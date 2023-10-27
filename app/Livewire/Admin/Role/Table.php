<?php

namespace App\Livewire\Admin\Role;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search;

    public $buttonCreate, $buttonDelete, $buttonUpdate;
    public $title, $actionName, $textSubmit, $id, $name;

    public function deleteRole($id)
    {
        try {
            Role::where('ROLE_ID', $id)->delete();
            $this->dispatch('role-deleted', 'Data role yang anda pilih, berhasil dihapuskan');
        } catch (\Throwable $th) {
            $this->dispatch('failed-deleting-role', $th->getMessage());
        }
    }



    public function updateRole($id)
    {
        $this->title = 'Formulir ubah data role';
        $this->actionName = 'updateData';
        $this->textSubmit = "Ubah Data";

        $role = Role::find($id);
        $this->id = $role->ROLE_ID;
        $this->name = $role->ROLE_NAME;
    }




    public function updateData()
    {
        try {
            $data = ['ROLE_NAME' => $this->name];

            Role::where('ROLE_ID', $this->id)->update($data);
            $this->dispatch('role-updated', 'Data role ' . $this->name . ', berhasil diperbaharui');

        } catch (\Throwable $th) {
            $this->dispatch('failed-updating-role', $th->getMessage());
        }
    }



    public function createData()
    {
        $idRole = uuid_create(4);
        try {
            $data = ['ROLE_ID' => $idRole, 'ROLE_NAME' => $this->name];
            Role::create($data);

            $this->resetForm();
            $this->dispatch('role-created', 'Role ' . $this->name . ' berhasil ditambahkan');
        } catch (\Throwable $th) {
            $this->dispatch('failed-creating-role', $th->getMessage());
        }
    }



    public function resetForm()
    {
        $this->reset();
    }



    public function render()
    {
        $role = Auth::user()->role;
        $role !== "Super Admin" ? $this->buttonCreate = "hidden" : $this->buttonCreate = null;
        $role !== "Super Admin" ? $this->buttonUpdate = "hidden" : $this->buttonUpdate = null;
        $role !== "Super Admin" ? $this->buttonDelete = "hidden" : $this->buttonDelete = null;

        $dataRole = Role::query()->when(
            $this->search,
            function ($query, $search) {
                return $query->where('ROLE_NAME', 'like', '%' . $search . '%');
            }
        )->whereNot('ROLE_NAME', 'Super Admin')->paginate();


        return view('livewire.admin.role.table', ['role' => $dataRole]);
    }
}
