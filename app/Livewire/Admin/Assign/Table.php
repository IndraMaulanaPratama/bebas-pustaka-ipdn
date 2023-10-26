<?php

namespace App\Livewire\Admin\Assign;

use App\Models\Akses;
use App\Models\pivotMenu;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search;


    public function resetForm()
    {
        $this->reset();
    }



    #[On("assign-created"), On("assign-updated"), On("assign-deleted")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



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


    public function updatePivot($id)
    {
        $this->dispatch("pivot-selected", $id);
    }


    public function render()
    {
        $assign = pivotMenu::with([
            "menu",
            "role" => function ($query) {
                $query->whereNotIn("ROLE_NAME", ["Super Admin"]);
            }
        ])->when(
                $this->search,
                function ($query, $search) {
                    return $query->where("PIVOT_DESCRIPTION", "like", "%" . $search . "%");
                }
            )->latest()->paginate();

        return view('livewire.admin.assign.table', [
            'assign' => $assign
        ]);
    }
}
