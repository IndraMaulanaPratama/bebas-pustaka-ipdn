<x-admin.components.modal.modal id='formPengajuan'>
    <x-admin.components.modal.header id='formPengajuan' title="Formulir Pengajuan Validasi Similaritas" />

    <div class="modal-body">
        <form wire:submit='createPengajuan'>
            <div class="row g-4">

                <x-admin.components.form.input name='inputJudul' placeholder='Judul Skripsi' />
                <x-admin.components.form.input name='inputKelas' placeholder='Nama Kelas Turnitin' />
                <x-admin.components.form.input name='inputAbsen' placeholder='Nomor Absen' />


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
