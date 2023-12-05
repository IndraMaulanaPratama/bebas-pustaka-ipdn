<div>
    <ol type="a">
        <li>
            <b>Lokasi Verifikasi</b>

            <p>Perpustakaan IPDN Jatinangor</p>
        </li>

        <li>
            <b>Petunjuk</b>

            <p>
                Praja melakukan unggah file ringkasan skripsi pada laman <a href="http://eprints.ipdn.ac.id/"
                    target="blank">eprints ipdn <sup><i class="bi bi-arrow-up-right-circle-fill"></i></sup></a>. Kemudian
                silahkan
                masuk dengan <i>username</i> dan <i>password</i> berdasarkan akun program studi masing-masing. Pastikan
                <i>file yang
                    diunggah dalam jenis Pdf dan sudah sesuai template yang ditentukan</i>. Adapun template tersebut
                dapat Praja
                unduh pada alamat <a href="https://bit.ly/46RAoeo" target="blank">Buka Tamplate <sup><i
                            class="bi bi-arrow-up-right-circle-fill"></i></sup></a>. Tutorial tips mudah
                deposit repository dapat Praja tonton pada
                laman <a href="https://www.youtube.com/watch?v=yqEX4CzYPAE" target="blank">Youtube Bayu Pambayun <sup><i
                            class="bi bi-arrow-up-right-circle-fill"></i></sup></a>.
            </p>
        </li>

        <li>
            <b>Pengajuan</b>

            <p>
                silahkan klik tombol <button data-bs-toggle="modal"
                    data-bs-target="#formPengajuan" class="btn btn-outline-primary btn-sm" {{ $buttonCreate }}> Buat
                    Pengajuan
                </button> untuk melakukan pengajuan pemeriksaan tahap unggah repository
            </p>
        </li>

        <li>
            <b>Catatan</b>

            <p>
                Jika status pengajuan verifikasi Praja dilakukan penolakan oleh petugas, maka silahkan Praja lakukan
                perbaikan pada file ringkasan skripsi sesuai dengan catatan yang diberikan petugas. Kemudian silahkan
                lakukan upload kembali pada laman Repository IPDN dan selanjutnya lakukan <b>pengajuan ulang</b> pada
                website
                Bebas Pustaka menu Repository. Status pengajuan akan berubah menjadi <b>diterima</b> jika file ringkasan
                skripsi perbaikan sudah sesuai dengan ketentuan berdasarkan verifikasi petugas.
            </p>
        </li>
    </ol>


    <x-admin.components.modal.modal id='formPengajuan'>
        <x-admin.components.modal.header id='formPengajuan' title="Formulir pengajuan unggah repository" />

        <form wire:submit='buatPengajuan' method="POST">

            <div class="row g-4 p-2">
                &nbsp;

                <x-admin.components.form.input name='inputUrl'
                    placeholder='Masukan url repository eprints anda' />

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
