{{-- Be like water. --}}

<x-admin.components.modal.modal id='formReject'>
    <x-admin.components.modal.header id='formReject' title="Tolak pengajuan pengumpulan skripsi perpustakaan" />

    <form wire:submit='rejecting' method="POST">

        <div class="row g-2 p-2">
            &nbsp;

            <x-admin.components.form.textarea name='inputNote' placeholder='Tuliskan Alasan Penolakan' />

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
        </div>
    </form>

</x-admin.components.modal.modal>
