{{-- In work, do what you enjoy. --}}

<div class="row justify-content-between">
    <div class="col-6">
        <x-admin.components.card.card title='Formulir data sprint surat keputusan bebas pustaka' titleSpan='Perubahan'>

            <form wire:submit='updateSkbp' method="POST">
                <div class="row g-4">

                    {{-- Sprint SKBP --}}
                    <x-admin.components.form.file name="sprint" placeholder="File Dokumen" required='required' />

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
                <li>Mohon untuk diperiksa secara berkala sesuai dengan pergantian surat perintah petugas SKBP</li>
                <li>Surat perintah yang di unggah akan diakses oleh praja tingkat utama</li>
            </ol>
        </x-admin.components.card.card>
    </div>
</div>
