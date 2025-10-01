<div>
    <ol type="a">
        <li>
            <b>Lokasi Verifikasi</b>

            <p>Perpustakaan Pusat IPDN.</p>
        </li>

        <li>
            <b>Petunjuk</b>

            <p>
                Praja melakukan unggah file ringkasan skripsi pada laman <a href="http://eprints.ipdn.ac.id/"
                    target="_blank">http://eprints.ipdn.ac.id/</a>. Kemudian silahkan
                masuk dengan <i>username</i> dan <i>password</i> berdasarkan akun program studi masing-masing. Pastikan
                file yang
                diunggah dalam jenis <b>Pdf</b> dan sudah sesuai template yang ditentukan. Adapun <i>template</i>
                tersebut
                dapat Praja
                unduh pada alamat <a href="https://bit.ly/46RAoeo" target="_blank">https://bit.ly/46RAoeo</a>. Tutorial
                tips mudah deposit repository dapat Praja tonton pada
                laman <a href="https://bit.ly/tutorrepo" target="_blank">https://bit.ly/tutorrepo</a>.
            </p>
        </li>

        <li>
            <b>Catatan</b>

            <p>
                Jika status pengajuan verifikasi Praja dilakukan penolakan oleh petugas, maka silahkan Praja lakukan
                perbaikan pada file ringkasan skripsi sesuai dengan catatan yang diberikan petugas. Kemudian silahkan
                lakukan <i>upload</i> kembali pada laman <i>Repository</i> IPDN dan selanjutnya lakukan <b>pengajuan
                    ulang</b> pada
                website Bebas Pustaka menu <i>Repository</i>. Status pengajuan akan berubah menjadi <b>diterima</b> jika
                file
                ringkasan skripsi perbaikan sudah sesuai dengan ketentuan berdasarkan verifikasi petugas.
            </p>
        </li>

    </ol>


    <x-admin.components.modal.modal id='formPengajuan'>
        <x-admin.components.modal.header id='formPengajuan' title="Formulir pengajuan unggah repository" />

        <form wire:submit='buatPengajuan' method="POST">

            <div class="row g-4 p-2">
                &nbsp;

                <x-admin.components.form.input name='inputUrl' placeholder='Masukan url repository eprints anda' />

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

    </x-admin.components.modal.modal>
</div>
