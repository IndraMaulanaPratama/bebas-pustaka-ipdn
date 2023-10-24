<?php

namespace App\Livewire\Admin\Users;

use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, WithFileUploads;

    public $search;
    public $update_id, $update_name, $update_email, $update_password, $update_confirm_password, $update_photo, $update_sign, $update_role;



    /***
     * Fungsi kanggo ngarefresh table
     */
    #[On('user-created'), On('user-updated')]
    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
            <svg>...</svg>
        </div>
        HTML;
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
        $user = User::with('role')->where('id', $id)->first();

        $data = [
            'id' => $id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'photo' => $user->photo,
            'sign' => $user->sign,
        ];

        $this->update_id = $id;
        $this->update_name = $data['name'];
        $this->update_email = $data['email'];
        // dd($data);
    }



    /***
     * Fungsi kanggo ngarobih data user
     */
    public function updateData()
    {
        try {
            null != $this->update_photo ? $photoName = Carbon::now()->timestamp . '-' . $this->update_photo->getClientOriginalName() : $photoName = null;
            null != $this->update_sign ? $signName = Carbon::now()->timestamp . '-' . $this->update_sign->getClientOriginalName() : $signName = null;


            $data = [
                'id' => $this->update_id,
                'name' => $this->update_name,
                'email' => $this->update_email,
                'password' => bcrypt($this->update_password),
                'photo' => str_replace(" ", "", $photoName),
                'sign' => str_replace(" ", "", $signName),
                'user_role' => $this->update_role,
            ];

            if (null == $this->update_password) {
                unset($data['password']);
            }
            if (null == $this->update_photo) {
                unset($data['photo']);
            }
            if (null == $this->update_sign) {
                unset($data['sign']);
            }
            if (null == $this->update_password) {
                unset($data['user_role']);
            }

            // Miwarang livewire kanggo nyimpen data dumasar kana katangtosan nu tos di damel
            $this->update_photo != null ? $this->update_photo->storeAs('foto_pegawai', str_replace(" ", "", $photoName), 'public') : null;
            $this->update_sign != null ? $this->update_sign->storeAs('tanda_tangan', str_replace(" ", "", $signName), 'public') : null;

            User::query()->find($this->update_id)->update($data);
            $this->dispatch('user-updated', 'Data ' . $data['name'] . ' berhasil diperbaharui');
        } catch (\Throwable $th) {
            dd('' . $th->getMessage());
        }



    }



    /***
     * Percobaan kanggo ngosongkeun input file
     */
    public function clearFile()
    {
        $this->update_photo = rand();
        $this->update_sign = rand();
    }



    /**
     * Fungsi kanggo ngabersihkeun data formulir
     */
    public function resetForm()
    {
        $this->clearFile();
        $this->reset();
    }



    public function render()
    {
        $user = User::with('role')->when(
            $this->search,
            function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            }
        )->latest()->paginate();

        $role = Role::query()->whereNot('ROLE_NAME', '=', 'Super Admin')->get([
            'ROLE_ID AS id',
            'ROLE_NAME AS name'
        ]);


        return view('livewire.admin.users.table', ['data' => $user, 'data_role' => $role]);
    }
}
