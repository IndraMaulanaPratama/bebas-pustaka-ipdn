{{-- Stop trying to control. --}}

<div>
    <ol type="a">
        <li>
            <b>Lokasi Verifikasi</b>

            <p>Perpustakaan IPDN Jatinangor</p>
        </li>

        <li>
            <b>Petunjuk</b>

            <p>
                Praja membuat 1 (satu) buah video dengan durasi minimal 1 (satu) menit dan maksimal 2 (dua) menit sesuai
                dengan tema yang sudah ditentukan. Adapun tema yang dapat Praja pilih antara lain:

            <ol type="1">
                <li>
                    <p>Review koleksi perpustakaan atau rekomendasi buku</p>
                </li>

                <li>
                    <p>Review layanan perpustakaan baik <i>onsite/ online</i></p>
                </li>

                <li>
                    <p>Tips dan Trik penulisan karya ilmiah atau penelusuran informasi</p>
                </li>

                <li>
                    <p>Ajakan untuk berkunjung ke perpustakaan dan</p>
                </li>

                <li>
                    <p>Buatkan konten yang bertemakan <b><i>Daily life as Praja IPDN</i></b></p>
                </li>
            </ol>


            <p>
                Selanjutnya unggah video tersebut pada platform
                Instagram
                dengan
                menggunakan fitur Reels dan pastikan sudah dilakukan tag pada akun <i><b>Instagram
                        @perpustakaanipdn</b></i>.
                Kemudian
                kirimkan <i>soft file</i> video tersebut melalui link <a href="{{ $setting->SETTING_URL_LITERASI }}"
                    target="_blank">Google Form <sup><i class="bi bi-arrow-up-right-circle-fill"></i></sup></a> yang
                sudah kami
                sediakan.
                Jika
                kedua proses
                unggah sudah selesai dilakukan, maka Praja sudah dapat melakukan verifikasi kepada Petugas
                Perpustakaan
                Pusat IPDN.
            </p>

        </li>


        <li>
            <b>Pengajuan</b>

            <p>
                silahkan klik tombol <button data-bs-toggle="modal" data-bs-target="#formPengajuan"
                    class="btn btn-outline-primary btn-sm" {{ $buttonCreate }}> Buat Pengajuan
                </button> untuk melakukan pengajuan pemeriksaan tahap konten litarasi
            </p>
        </li>

    </ol>


    <x-admin.components.modal.modal id='formPengajuan'>
        <x-admin.components.modal.header id='formPengajuan' title="Formulir pengajuan konten literasi" />

        <form wire:submit='buatPengajuan' method="POST">

            <div class="row g-4 p-2">
                &nbsp;

                <x-admin.components.form.input name='inputUrl' placeholder='Masukan alamat url konten anda' />

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
