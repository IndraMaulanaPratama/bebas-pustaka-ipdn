<x-admin.components.modal.modal id='formPengajuan'>
    <x-admin.components.modal.header id='formPengajuan' title="Formulir Pengajuan Donasi Perpustakaan" />

    <div class="modal-body">
        <form wire:submit='createPengajuan'>
            <div class="row g-4">

                <x-admin.components.form.input name='inputOrder' placeholder='Nomor Purches Order (PO) Donasi Poin' />


                {{-- Tombol Reset sareng Submit --}}
                <div class="modal-footer">
                    {{-- Tombol Reset / Cancel --}}
                    <button type="button" wire:click='resetForm' class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        Batalkan
                    </button>

                    {{-- Tombol Simpan / Submit --}}
                    <button type="submit" class="btn btn-outline-primary" {{$buttonCreate}} data-bs-dismiss="modal">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin.components.modal.modal>
