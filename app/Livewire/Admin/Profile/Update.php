<?php

namespace App\Livewire\Admin\Profile;

use App\Services\ActivityLogger;
use App\Services\SecureImageUploader;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Formulir "Profil Saya" nu bisa diaksés ku sadaya role nu geus login
 * (Super Admin, Admin Pustaka, Praja Utama) ti dropdown navbar. Ngan
 * ngamungkinkeun user ngarobih data dirina sorangan (foto jeung kata
 * sandi) — teu meakeun parameter id ti luar, sangkan teu bisa dipaké
 * pikeun ngarobih data user sanés.
 */
class Update extends Component
{
    use WithFileUploads;

    #[Rule('nullable|image|mimes:jpeg,jpg,png,webp|max:2048')]
    public $photo;

    #[Rule('nullable|string|min:8|max:255')]
    public $new_password;

    #[Rule('required_with:new_password|same:new_password')]
    public $confirm_password;

    public $successMessage;
    public $errorMessage;

    /**
     * Modal ieu dipasang sakali di layout global, jadi kudu direset
     * unggal kali dibuka deui supados teu nyésakeun pesen/preview
     * foto ti sesi buka-tutup modal sateuacana.
     */
    public function resetForm()
    {
        $this->reset(['photo', 'new_password', 'confirm_password', 'successMessage', 'errorMessage']);
    }

    /**
     * PENTING: modal ieu (kawas sadaya modal séjén di aplikasi ieu) dibungkus
     * "wire:ignore" ku komponén Blade `x-admin.components.modal.modal`
     * (dipaké babarengan ku sakabéh modal, teu kedah dirobih di dieu wungkul).
     * "wire:ignore" nyegah Livewire nga-morph DOM di jero éta modal sacara
     * PERMANEN sanggeus render nu munggaran — kaasup $successMessage,
     * $errorMessage, jeung @error di jero form ieu, nu kusabab kitu moal
     * kungsi katémbong di browser sanaos nilai property-na leres robih di
     * server. Ku kituna feedback ka user (nutup modal, mémehanan pesen
     * sukses/gagal, ngabersihkeun <input type="file">) sengaja ditanganan
     * ku JavaScript di admin-navbar.blade.php nu ngadangukeun event
     * "profile-updated"/"profile-update-failed" nu di-dispatch di handap,
     * lain ku cara ngandelkeun Livewire nga-render ulang eusi modal ieu.
     */
    public function updateProfile()
    {
        $this->successMessage = null;
        $this->errorMessage = null;

        if (!$this->photo && !$this->new_password) {
            $this->errorMessage = 'Silakan pilih foto baru atau isi kata sandi baru terlebih dahulu.';
            $this->dispatch('profile-update-failed', message: $this->errorMessage);
            return;
        }

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Errorbag tetep dieusian manual (sanajan moal katémbong di jero
            // modal ieu) supados test/tooling nu maca error Livewire tetep jalan.
            $this->setErrorBag($e->validator->errors());
            $this->errorMessage = $e->validator->errors()->first();
            $this->dispatch('profile-update-failed', message: $this->errorMessage);
            return;
        }

        try {
            $user = Auth::user();
            $changed = [];

            if ($this->photo) {
                $filename = SecureImageUploader::store($this->photo, 'foto_pegawai', 'profile_' . $user->id);
                $user->photo = $filename;
                $changed[] = 'foto profil';
            }

            if ($this->new_password) {
                $user->password = bcrypt($this->new_password);
                $changed[] = 'kata sandi';
            }

            $user->save();

            ActivityLogger::log('Profil', ActivityLogger::UPDATE, 'Memperbaharui ' . implode(' dan ', $changed) . ' sendiri', $user);

            $this->reset(['photo', 'new_password', 'confirm_password']);
            $this->successMessage = 'Profil berhasil diperbaharui.';
            $this->dispatch('profile-updated', message: $this->successMessage);
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            $this->dispatch('profile-update-failed', message: $this->errorMessage);
        }
    }

    public function render()
    {
        return view('livewire.admin.profile.update');
    }
}
