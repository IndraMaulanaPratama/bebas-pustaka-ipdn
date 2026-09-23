<?php

namespace App\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use App\Services\ActivityLogger;
use App\Services\SecureImageUploader;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $id, $name, $email, $password, $role;

    #[Rule('nullable|image|mimes:jpeg,jpg,png,webp|max:2048')]
    public $photo, $sign;


    /**
     * Fungsi kanggo ngabersihkeun data formulir
     */
    public function resetForm()
    {
        $this->reset();
        $this->photo = null;
        $this->sign = null;
    }



    // Fungsi kanggo ngarubah eusi data form dumasar kana id user anu dipilih
    #[On("selected-user")]
    public function updateForm($id)
    {
        $user = User::with('role')->where('id', $id)->first();

        $this->id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->user_role;
    }



    // Fungsi kanggo nangtoskeun nami file
    public function fileName($file)
    {
        if (null != $file) {
            return Carbon::now()->timestamp . '-' . $this->photo->getClientOriginalName();
        } else {
            return null;
        }
    }



    // Fungsi kanggo ngarobih data user dumasar kana form anu tos dirobih
    public function updateData()
    {

        try {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'user_role' => $this->role,
            ];

            if (null == $this->role) {
                unset($data['user_role']);
            }

            // Foto/tanda tangan disimpen ku SecureImageUploader: isi filena
            // dibaca ulang tur digambar ulang jadi PNG anyar (teu percaya
            // kana nami/ekstensi file asli ti client) sateuacan disimpen
            // kalayan nami deterministik dumasar id user (1 file per user).
            if ($this->photo != null) {
                $data['photo'] = SecureImageUploader::store($this->photo, 'foto_pegawai', 'profile_' . $this->id);
            }
            if ($this->sign != null) {
                $data['sign'] = SecureImageUploader::store($this->sign, 'tanda_tangan', 'sign_' . $this->id);
            }

            User::where('id', $this->id)->update($data);

            $user = User::find($this->id);
            ActivityLogger::log('Pengguna', ActivityLogger::UPDATE, 'Memperbaharui data pengguna: ' . $data['name'], $user);

            $this->dispatch('user-updated', 'Data ' . $data['name'] . ' berhasil diperbaharui');

        } catch (\Throwable $th) {
            $this->dispatch('failed-updating-user', '' . $th->getMessage());
        }

    }


    public function render()
    {
        $roles = Role::query()->whereNot('ROLE_NAME', '=', 'Super Admin')->get([
            'ROLE_ID AS id',
            'ROLE_NAME AS name'
        ]);

        return view('livewire.admin.users.update', [
            'data_role' => $roles,
        ]);
    }
}
