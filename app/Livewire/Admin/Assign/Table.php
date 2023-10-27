<?php

namespace App\Livewire\Admin\Assign;

use App\Models\Akses;
use App\Models\pivotMenu;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search;
    public $superAdmin, $role, $buttonCreate, $buttonUpdate, $buttonDelete;


    public function resetForm()
    {
        $this->reset();
    }



    // Fungsi kanggo update data table
    #[On("assign-created"), On("assign-updated"), On("assign-deleted")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    // Fungsi kanggo ngahapus data assign dumasar kana id
    public function deletePivot($id)
    {
        try {
            pivotMenu::where('PIVOT_ID', $id)->delete();
            Akses::where('ACCESS_MENU', $id)->delete();

            $this->reset();
            $this->dispatch("assign-deleted", "Data Assign berhasil dihapus");
        } catch (\Throwable $th) {
            $this->dispatch("failed-deleting-assign", $th->getMessage());
        }
    }


    // Fungsi kanggo muka modal kanggo ngarobih data assign
    public function updatePivot($id)
    {
        $this->dispatch("pivot-selected", $id);
    }


    public function mount()
    {
    }


    public function render()
    {
        $this->superAdmin = Role::where('ROLE_NAME', 'Super Admin')->first();
        $this->role = Auth::user()->role->ROLE_NAME;
        $this->role != "Super Admin" ? $this->buttonDelete = "hidden" : $this->buttonDelete = null;
        // $this->role != "Super Admin" ? $this->buttonUpdate = "hidden" : $this->buttonUpdate = null;
        // $this->role != "Super Admin" ? $this->buttonCreate = "hidden" : $this->buttonCreate = null;


        if ($this->role != "Super Admin") {
            $assign = pivotMenu::with(["menu", "role"])->when(
                $this->search,
                function ($query, $search) {
                    return $query->where("PIVOT_DESCRIPTION", "like", "%" . $search . "%");
                }
            )->whereNotIn("PIVOT_ROLE", [$this->superAdmin->ROLE_ID])->latest()->paginate();

        } else {
            $assign = pivotMenu::with(["menu", "role"])->when(
                $this->search,
                function ($query, $search) {
                    return $query->where("PIVOT_DESCRIPTION", "like", "%" . $search . "%");
                }
            )->latest()->paginate();
        }


        return view('livewire.admin.assign.table', [
            'assign' => $assign
        ]);
    }
}
