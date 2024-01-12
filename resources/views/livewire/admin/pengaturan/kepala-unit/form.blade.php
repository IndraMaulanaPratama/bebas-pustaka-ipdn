{{-- The whole world belongs to you. --}}

<div class="row justify-content-between">
    <div class="col-6">
        <x-admin.components.card.card title='Formulir data kepala unit' titleSpan='Perubahan'>

            <form wire:submit='updateKepalaUnit' method="POST">
                <div class="row g-4">
                    {{-- Nama Lengkap --}}
                    <x-admin.components.form.input type="text" name="nama_lengkap"
                        placeholder="Nama Lengkap Kepala Unit" required='required' />

                    {{-- Nomor Induk Pegawai --}}
                    <x-admin.components.form.input type="text" name="nip" placeholder="Nomor Induk Pegawai"
                        required='required' />


                    {{-- Tanda Tangan --}}
                    <x-admin.components.form.file name="sign" placeholder="Tanda Tangan Kepala Unit"
                        required='required' />

                    {{-- Button Submit --}}
                    <div class="col-4">
                        <x-admin.components.form.button text='Simpan Perubahan' color='primary' size='md'
                            type='submit' />
                    </div>
                </div>
            </form>
        </x-admin.components.card.card>
    </div>

    <div class="col-5">
        <x-admin.components.card.card title='Informasi Tambahan' titleSpan=''>
            <ol type="1">
                <li>Mohon untuk diperiksa secara berkala sesuai dengan pergantian kepala unit</li>
                <li>Data Kepala Unit yang tersimpan di system, akan menjadi data untuk penandatanganan Surat Keterangan
                    Bebas Pustaka (SKBP)</li>
            </ol>
        </x-admin.components.card.card>
    </div>
</div>
