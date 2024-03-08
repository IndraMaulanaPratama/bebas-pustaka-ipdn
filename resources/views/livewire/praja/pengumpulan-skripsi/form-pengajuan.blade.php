{{-- Care about people's approval and you will be their prisoner. --}}

<x-admin.components.modal.modal id='formPengajuan'>
    <x-admin.components.modal.header id='formPengajuan' title="Formulir Pengajuan Pengumpulan Skripsi" />

    <div class="modal-body">
        <form wire:submit='buatPengajuan'>
            <div class="row g-4">

                <x-admin.components.form.input name='judul' placeholder='Judul Skripsi' />
                <x-admin.components.form.input name='pembimbingSatu' placeholder='Nama Pembimbing Satu' />
                <x-admin.components.form.input name='pembimbingDua' placeholder='Nama Pembimbing Dua' />


                {{-- Tombol Reset sareng Submit --}}
                <div class="modal-footer">
                    {{-- Tombol Reset / Cancel --}}
                    <button type="button" wire:click='resetForm' class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        Batalkan
                    </button>

                    {{-- Tombol Simpan / Submit --}}
                    <button type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin.components.modal.modal>
