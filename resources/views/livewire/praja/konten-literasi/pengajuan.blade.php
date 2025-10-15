{{-- Stop trying to control. --}}

<div>
    <ol type="a">
        <li>
            <b>Lokasi Verifikasi</b>

            <p>Perpustakaan Pusat IPDN Jatinangor</p>
        </li>

        <li>
            <b>Petunjuk</b>

            <ul type="circle">

                {{-- 1 --}}
                <li>
                    <p>
                        Konten literasi bertemakan <b>ulasan buku</b> yang ada di Perpustakaan IPDN Jatinangor.
                    </p>
                </li>

                {{-- 2 --}}
                <li>
                    <p>
                        Konten literasi berbentuk <b>desain grafis</b> (bukan video) dengan hasil akhir berformat
                        <b>JPEG/PNG</b>.
                    </p>
                </li>

                {{-- 3 --}}
                <li>
                    <p>
                        Konten literasi diproyeksikan untuk diunggah di Instagram dengan rasio ukuran <b>1:1</b> atau
                        resolusi <b>1080:1080</b> pixel.
                    </p>
                </li>

                {{-- 4 --}}
                <li>
                    <p>
                        Konten literasi minimal terdiri dari 5 slide dengan ketentuan sebagai berikut:
                    </p>

                    <ul>
                        {{-- 4.1 --}}
                        <li>
                            <p>
                                Slide 1: Sampul buku dan informasi singkat (judul buku, nama pengarang, penerbit, tahun
                                terbit, dan genre).
                            </p>
                        </li>

                        {{-- 4.2 --}}
                        <li>
                            <p>
                                Slide 2: Sinopsis/ringkasan.
                            </p>
                        </li>

                        {{-- 4.3 --}}
                        <li>
                            <p>
                                Slide 3: Kelebihan dan kekurangan.
                            </p>
                        </li>

                        {{-- 4.4 --}}
                        <li>
                            <p>
                                Slide 4: Hikmah/kata-kata bijak/kesimpulan/pelajaran yang bisa diambil.
                            </p>
                        </li>

                        {{-- 4.5 --}}
                        <li>
                            <p>
                                Slide 5: Ajakan untuk berkunjung ke Perpustakaan IPDN.
                            </p>
                        </li>
                    </ul>
                </li>

                {{-- 5 --}}
                <li>
                    <p>
                        Apabila ada informasi lain yang ingin ditambahkan, dipersilakan membuat slide tambahan tanpa ada
                        batasan jumlah maksimal, misalnya durasi membaca, jumlah halaman, fakta unik buku, dsb.
                    </p>
                </li>

                {{-- 6 --}}
                <li>
                    <p>
                        <b>Foto diri Praja Utama wajib muncul</b> minimal sekali dalam konten yang dimaksud. Foto diri
                        tersebut
                        bebas
                        diletakkan di slide berapapun sesuai kreatifitas masing-masing. Contohnya, foto berpose memegang
                        dan
                        menunjukkan buku yang ingin diulas di slide pertama.
                    </p>
                </li>


                {{-- 7 --}}
                <li>
                    <p>
                        Desain hanya diperkenankan menggunakan palet warna sesuai kode yang telah ditentukan
                        (<b>#0c3964, #0d2551, #ffffff, #ac2425, #e8ab26 dan #000000</b>).
                    </p>
                </li>

                {{-- 8 --}}
                <li>
                    <p>
                        Tidak perlu menyertakan logo apapun.
                    </p>
                </li>

                {{-- 9 --}}
                <li>
                    <p>
                        Boleh menyertakan identitas praja utama secara singkat hanya di slide pertama atau slide
                        terakhir.
                    </p>
                </li>

                {{-- 10 --}}
                <li>
                    <p>
                        Praja utama bebas menggunakan software desain grafis manapun, namun disarankan menggunakan
                        <b>Canva</b>.
                    </p>
                </li>

                {{-- 11 --}}
                <li>
                    <p>
                        Semua file dijadikan satu dan dikompress dalam bentuk ZIP/RAR dengan subjek email KONTEN
                        LITERASI dan format nama file <b>Nama Lengkap_NPP_Kelas_Prodi</b>. Contoh: Moch. Alfa
                        Alfiansyah_33.0000_A1_PIT
                    </p>
                </li>

                {{-- 12 --}}
                <li>
                    <p>
                        Konten literasi dikirimkan melalui email resmi Perpustakaan IPDN di
                        <i>kontenliterasi@ipdn.ac.id</i>
                    </p>
                </li>

                {{-- 13 --}}
                <li>
                    <p>
                        Praja utama mengajukan permohonan persetujuan konten literasi pada akun aplikasi SKBP
                        masing-masing
                    </p>
                </li>
            </ul>
        </li>

        <li>
            <b>Pengajuan</b>

            <p>
                silahkan klik tombol
                <button data-bs-toggle="modal" data-bs-target="#formPengajuan" class="btn btn-outline-primary btn-sm"
                    {{ $buttonCreate }}> Buat
                    Pengajuan
                </button> untuk melakukan pengajuan pemeriksaan tahap konten literasi
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
