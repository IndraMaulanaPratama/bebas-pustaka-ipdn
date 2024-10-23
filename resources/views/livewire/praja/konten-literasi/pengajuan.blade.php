{{-- Stop trying to control. --}}

<div>
    <ol type="a">
        <li>
            <b>Lokasi Verifikasi</b>

            <p>Perpustakaan Pusat IPDN Jatinangor</p>
        </li>

        <li>
            <b>Petunjuk</b>

            <p>
                Praja membuat 1 (satu) buah video review buku/rekomendasi buku. Adapun ketentuan konten sebagai berikut:

            <ol type="1">

                {{-- 1 --}}
                <li>
                    <p>
                        <b>Praja wajib In Frame;</b>
                    </p>
                </li>

                {{-- 2 --}}
                <li>
                    <p>
                        Konten memuat: (1) Judul buku; (2) Nama pengarang; (3) Waktu terbit; (4) Durasi membaca buku;
                        (5) pembahasan buku (kelebihan, kekurangan); (6) Tempat mengakses buku tersebut.
                    </p>
                </li>

                {{-- 3 --}}
                <li>
                    <p>
                        Tuliskan <b>Caption</b> yang bertemakan literasi/ ajakan membaca buku/ ajakan berkunjung ke
                        Perpustakaan IPDN.
                    </p>
                </li>

                {{-- 4 --}}
                <li>
                    <p>
                        Sertakan tagar <b>#perpustakaanipdn #fomoliterasi</b>.
                    </p>
                </li>
            </ol>


            <p>
                Selanjutnya unggah video tersebut pada platform social media <b>Instagram/ Tiktok/ Youtube</b> dengan
                menggunakan fitur Reels/ Short dan pastikan sudah dilakukan tag pada akun Instagram <b>@perpustakaanipdn</b>.
            </p>

            <p>
                Kemudian kirimkan <i>softfile video</i> tersebut melalui  <a href="{{ $setting->SETTING_URL_LITERASI }}"
                    target="_blank">Google Form <sup><i class="bi bi-arrow-up-right-circle-fill"></i></sup></a> yang sudah kami
                sediakan. Jika kedua
                proses unggah sudah selesai dilakukan, maka Praja sudah dapat melakukan verifikasi kepada Petugas
                Perpustakaan Pusat IPDN.
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
