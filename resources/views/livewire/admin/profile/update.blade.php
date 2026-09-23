<x-admin.components.modal.modal id='profilSaya'>
    <x-admin.components.modal.header id='profilSayaLabel' title="Profil Saya" />

    {{--
        Modal ieu wire:ignore (tempo catetan di Update.php::updateProfile),
        jadi teu dianggo nyieun preview foto/pesen sukses-gagal di jero
        Blade ieu — sadayana ditanganan ku JavaScript ti luar modal ieu
        (tempo admin-navbar.blade.php) nu ngadangukeun event Livewire.
    --}}
    <form wire:submit='updateProfile'>
        <div class="modal-body">

            <div class="text-center mb-3">
                <img src="{{ asset('foto_pegawai/' . (Auth::user()->photo ?? 'defaultPhoto.png')) }}"
                    alt="Foto profil" class="rounded-circle" width="90" height="90" style="object-fit: cover;">
            </div>

            <div class="row g-3">
                <x-admin.components.form.file name='photo' placeholder='Ganti Foto Profil (JPEG/PNG/WEBP, maks 2MB)' />

                <hr class="mt-2">

                <x-admin.components.form.input type='password' name='new_password' placeholder='Kata Sandi Baru' />
                <x-admin.components.form.input type='password' name='confirm_password' placeholder='Ulangi Kata Sandi Baru' />
            </div>

            <small class="text-muted d-block mt-2">
                Kosongkan kata sandi jika Anda hanya ingin mengganti foto, atau sebaliknya.
            </small>
        </div>

        <div class="modal-footer">
            <button type="button" wire:click='resetForm' class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Tutup
            </button>
            <x-admin.components.form.button type='submit' color='primary' text="Simpan Perubahan" />
        </div>
    </form>
</x-admin.components.modal.modal>
