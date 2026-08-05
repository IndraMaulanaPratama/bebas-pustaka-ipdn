<?php

namespace App\Livewire\Admin\Assign;

use App\Models\Akses;
use App\Models\pivotMenu;
use App\Models\Role;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search;
    public $buttonCreate, $buttonUpdate, $buttonDelete;


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
            $pivot = pivotMenu::where('PIVOT_ID', $id)->first();
            pivotMenu::where('PIVOT_ID', $id)->delete();
            Akses::where('ACCESS_MENU', $id)->delete();

            ActivityLogger::log('Manajemen Akses', ActivityLogger::DELETE, 'Menghapus data assign: ' . ($pivot->PIVOT_DESCRIPTION ?? $id), $pivot);

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
        $superAdmin = Role::where('ROLE_NAME', 'Super Admin')->first();
        $role = Auth::user()->role;
        $role != "Super Admin" ? $this->buttonDelete = "hidden" : $this->buttonDelete = null;


        $assign = pivotMenu::
            when(
                // Limiting role
                $role,
                function ($query, $role) use ($superAdmin) {
                    if ($role->ROLE_NAME != "Super Admin") {
                        return $query->whereNotIn("PIVOT_ROLE", [$superAdmin->ROLE_ID, $role->ROLE_ID]);
                    }
                }
            )
            ->when(
                // Live search description
                $this->search,
                function ($query, $search) {
                    return $query->where("PIVOT_DESCRIPTION", "LIKE", "%" . $search . "%");
                }
            )
            ->paginate();


        return view('livewire.admin.assign.table', [
            'assign' => $assign
        ]);
    }
}
