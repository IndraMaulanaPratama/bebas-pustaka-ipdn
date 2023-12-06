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
                Praja akan mendapatkan link <a href="{{ $setting->SETTING_URL_SURVEY }}" target="_blank">Google Form
                    <sup><i class="bi bi-arrow-up-right-circle-fill"></i></sup></a> yang sudah dibagikan ke ketua kelas,
                kemudian
                silahkan lakukan
                pengisian hingga seluruh item kuisoner terisi. Kami sarankan untuk menggunakan <b><i>laptop</i></b> agar
                lebih
                efektif. Kemudian jika sudah dilakukan pengisian survei tersebut silahkan lakukan verifikasi kepada
                petugas.
            </p>
        </li>

        <li>
            <b>Pengajuan</b>

            <p>
                silahkan klik tombol <button wire:confirm='Anda yakin akan membuat pengajuan survey perpustakaan?'
                    wire:click='buatPengajuan' class="btn btn-outline-primary btn-sm" {{ $buttonCreate }}> Buat Pengajuan
                </button> untuk melakukan pengajuan pemeriksaan survey perpustakaan
            </p>
        </li>

    </ol>
</div>
