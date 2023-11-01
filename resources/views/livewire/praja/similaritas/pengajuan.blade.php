<div>
    <h5>{{ __('Langkah-langkah untuk mengunggah skripsi ke aplikasi turnitin') }} </h5>

    <ul>
        <li> {{ __('Persiapkan informasi terkait nama kelas dan nomor absen yang akan digunakan dalam aplikasi turnitin') }}
        </li>
        <li>
            {{ __('File skripsi yang diunggah kedalam aplikasi turnitin harus berformat .docx') }}
        </li>
        <li> {{ __('Upload skripsi kedalam aplikasi turnit in sesuai dengan kelas dan nomor absen yang sudah ditentukan') }}
        </li>
        <li> {{ __('Submit Formulir yang sudah anda isikan didalam aplikasi turnitin') }} </li>
        <li> {{ __('Kembali ke aplikasi bebas pustaka.') }} </li>
    </ul>

    <br />
    <h5> {{ __('Langkah-langkah untuk membuat pengajuan validasi similaritas') }} </h5>
    <ul>
        {{-- Update Nomor Ponsel --}}
        <li>
            <p>
                Silahkan perbaharui data nomor ponsel anda dengan cara click <button type="button"
                    class="btn btn-link {{ $buttonPonsel }}" data-bs-toggle="modal" data-bs-target="#formUpdatePonsel">
                    Nomor Ponsel</button>
                guna
                mempermudah komunikasi antara admin similaritas dengan anda <b>*</b> <small>Data Nomor Ponsel anda akan
                    kami
                    rahasiakan dan tidak akan bisa diakses oleh publik</small> <b>*</b>
            </p>
        </li>

        {{-- Persiapan Data --}}
        <li>
            <p>Silahkan siapkan data-data berikut:</p>

            <ol type=1>
                <li>Nama Kelas Turnitin</li>
                <li>Nomor Absen Turnitin</li>
                <li>Judul Skripsi</li>
            </ol>
        </li>

        {{-- Form Pengajuan Similaritas --}}
        <li>
            <p>
                Setelah data-data diatas sudah anda dikumpulkan, silahkan click tautan <button type="button"
                    class="btn btn-light btn-sm {{ $buttonPengajuan }}" data-bs-toggle="modal"
                    data-bs-target="#formPengajuan">Buat Pengajuan
                    Similaritas</button>. Jika formulir pengajuan tidak
                muncul diperangkat anda, silahkan update terlebih dahulu nomor ponsel anda.
            </p>
        </li>

        {{-- Whats Next --}}
        <li>
            <p>Jika sudah berhasil membuat pengajuan, aplikasi bebas pustaka akan mengirimkan email pemberitahuan kepada
                admin agar segera memeriksa tingkat similaritas dari data pengajuan yang anda buat.</p>
        </li>

        <li>
            Data Skripsi yang memiliki tingkat similaritas dibawah 30%, akan di berikan approval oleh admin dan anda
            akan dihubungi oleh pihak admin atau aplikasi akan mengirimkan pemberitahuan atas approval tersebut kepada
            akun email praja anda.
        </li>

    </ul>

</div>
