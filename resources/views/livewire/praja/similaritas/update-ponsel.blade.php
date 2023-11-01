<x-admin.components.modal.modal id='formUpdatePonsel'>
    <x-admin.components.modal.header id='formUpdatePonsel' title="Formulir pembaharuan data nomor ponsel" />

    <div class="modal-body">
        <form wire:submit='setPonsel'>

            <x-admin.components.form.input name='inputNomor' placeholder='Nomor Ponsel' />

            <hr />

            <p>
                <small>Nomor ponsel anda tidak akan bisa dirubah kembali, mohon pastikan nomor yang anda inputkan sudah
                    benar.</small>
            </p>


            {{-- Tombol Reset sareng Submit --}}
            <div class="modal-footer">
                {{-- Tombol Reset / Cancel --}}
                <button type="button" wire:click='resetForm' class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batalkan
                </button>

                {{-- Tombol Simpan / Submit --}}
                <button type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-admin.components.modal.modal>
