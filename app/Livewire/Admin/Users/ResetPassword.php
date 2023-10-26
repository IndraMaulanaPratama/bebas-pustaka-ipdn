<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ResetPassword extends Component
{
    public $id;

    #[Rule(["required", "string", "min:8"])]
    public $password;

    /**
     * Fungsi kanggo ngabersihkeun data formulir
     */
    public function resetForm()
    {
        $this->reset();
        $this->photo = null;
        $this->sign = null;
    }



    /**
     * Fungsi kanggo nyandak id user
     */
    #[On("reset-password")]
    public function getUserId($id)
    {
        $this->id = $id;
    }



    /***
     * Fungsi kanggo ngarobih kata sandi user
     */
    public function updatePassword()
    {
        if ($this->password === null) {
            $this->dispatch('failed-updating-user', 'Anda belum memasukan kata sandi baru');
        }

        try {
            $user = User::where('id', $this->id)->first();
            User::where('id', $this->id)->update(['password' => bcrypt($this->password)]);

            $this->reset();
            $this->dispatch('user-updated', 'Kata sandi untuk pengguna ' . $user->name . ' berhasil diperbaharui');
        } catch (\Throwable $th) {
            $this->dispatch('failed-updating-user', $th->getMessage());
        }
    }




    public function render()
    {
        return view('livewire.admin.users.reset-password');
    }
}
