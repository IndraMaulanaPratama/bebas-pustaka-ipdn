<?php

namespace App\Livewire\Admin\Users;

use App\Exports\UserExcel;
use App\Models\Akses;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithFileUploads;

    public $search;
    public $role, $buttonDelete, $buttonExport;
    public $update_id, $update_name, $update_email, $update_password, $update_confirm_password, $update_photo, $update_sign, $update_role;



    /***
     * Fungsi kanggo ngarefresh table
     */
    #[On('user-created'), On('user-updated'), On('user-deleted')]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }



    /***
     * Fungsi kanggo ngahapus data pengguna dumasar kana id anu dipilih
     */
    public function deleteUser($id)
    {
        try {
            User::find($id)->delete();

            $this->placeholder();
            $this->dispatch('deleted-user', 'User yang anda pilih, berhasil dihapuskan');
        } catch (\Throwable $th) {
            $this->dispatch('failed-deleting-user', $th->getMessage());
        }
    }



    /***
     * Fungsi kanggo ngaktifkeun modal kanggo ngarobih data user
     */
    public function updateUser($id)
    {
        $this->dispatch('selected-user', $id);
    }



    /***
     * Fungsi kanggo ngaktifkeun modal kanggo ngarobih password
     */
    public function resetPassword($id)
    {
        $this->dispatch('reset-password', $id);
    }



    public function mount()
    {

        // $roleLogin = Auth::user()->user_role;
        // $url = Route::getCurrentRoute()->action['as']; // Maca nami route anu nuju di buka
        // $menu = Menu::where("MENU_URL", $url)->first();

        // $access = Akses::
        //     join("PIVOT_MENU", "ACCESSES.ACCESS_MENU", '=', "PIVOT_MENU.PIVOT_ID")
        //     ->where(['PIVOT_MENU.PIVOT_MENU' => $menu->MENU_ID, 'PIVOT_MENU.PIVOT_ROLE' => $roleLogin])
        //     ->first();

        // $this->accessApprove = $this->generateAccess($access->ACCESS_APPROVE);
        // $this->accessReject = $this->generateAccess($access->ACCESS_REJECT);
        // $this->accessPrint = $this->generateAccess($access->ACCESS_PRINT);
        // $this->accessExport = $this->generateAccess($access->ACCESS_EXPORT);

        $this->role = Auth::user()->role->ROLE_NAME;
        if ($this->role != 'Super Admin') {
            $this->buttonDelete = 'hidden';
            $this->buttonExport = 'hidden';
        }
    }


    public function exportData()
    {
        return (new UserExcel)
            ->download(
                'Pengguna_Excel_Export.xlsx',
                \Maatwebsite\Excel\Excel::XLSX
            );

    }






    public function render()
    {
        $praja = Role::where("ROLE_NAME", "Praja Utama")->first();
        $user = User::with('role')->when(
            $this->search,
            function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            }
        )->when(
                $this->role,
                function ($query, $role) use ($praja) {
                    if ($role != 'Super Admin') {
                        return $query->whereNotIn('id', [1])->where('user_role', '!=', $praja->ROLE_ID);
                    }
                }
            )
            ->latest()->paginate();

        return view('livewire.admin.users.table', ['data' => $user]);
    }
}
