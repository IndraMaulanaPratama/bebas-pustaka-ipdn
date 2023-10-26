<div class="modal fade" id="modalResetPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"> Formulir Perubahan Kata Sandi </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form wire:submit='updatePassword' method="POST">
                <div class="modal-body">

                    <div class="form row g-3">
                        <input type="hidden" wire:model.live='id' />

                        {{-- Input Password --}}
                        <x-admin.components.form.input type='password' name='password' placeholder='Kata Sandi Baru' />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" wire:click='resetForm'
                        data-bs-dismiss="modal">
                        Batalkan
                    </button>
                    <button type="submit" class="btn btn-outline-primary"data-bs-dismiss="modal">
                        Simpan
                    </button>
                </div>


            </form>

        </div>
    </div>
</div>
