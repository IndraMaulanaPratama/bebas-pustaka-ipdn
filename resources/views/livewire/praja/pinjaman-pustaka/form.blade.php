<div class="row g-4">

    {{-- Pengajuan bebas pinjaman fakultas --}}
    <div class="col-lg-12 col-md-12 col-sm-12">
        <x-admin.components.card.card small=12 medium=12 size=12 title='Informasi Praja' titleSpan='Status Aktif'>


            {{-- Data Pengajuan --}}
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <td class="col-lg-5 col-md-4 col-sm-4">Nama Lengkap</td>
                        <td>:</td>
                        <td>{{ $praja->NAMA }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Pokok Praja</td>
                        <td>:</td>
                        <td>{{ $praja->NPP }}</td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>{{ $praja->KELAS }}</td>
                    </tr>
                    <tr>
                        <td>Program studi</td>
                        <td>:</td>
                        <td>{{ $praja->PROGRAM_STUDI }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Ponsel</td>
                        <td>:</td>
                        <td>{{ Auth::user()->nomor_ponsel }}</td>
                    </tr>
                    <tr>
                        <td><i>Class Name</i> dan No. Absen</td>
                        <td>:</td>
                        <td> ?? </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>

                            {{-- Button Litah Data Praja --}}
                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
                                data-bs-target=".multi-collapse" aria-expanded="false"
                                aria-controls="multiCollapseExample1 multiCollapseExample2">
                                Lihat Status Pengajuan
                            </button>

                            {{-- Button Pengajuan --}}
                            <button class="btn btn-outline-secondary"
                            wire:confirm='Apakah anda akan membuat pengajuan bebas pinjaman?'
                            wire:click='buatPengajuan'
                            >
                                Buat Pengajuan
                            </button>

                        </td>
                    </tr>

                </table>

            </div>


            <p class="d-inline-flex gap-1">
            </p>

        </x-admin.components.card.card>

    </div>


    {{-- Pengajuan Bebas pinjaman perpustakaan --}}
    <div class="col-lg-6 col-md-12 col-sm-12 collapse multi-collapse" id="multiCollapseExample1">
        <x-admin.components.card.card small=12 medium=12 size=12 title='Pinjaman Perpustakaan'>

            {{-- Data pengajuan --}}
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <td class="col-1">Status</td>
                        <td>:</td>
                        <td>Sedang dalam proses</td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td>:</td>
                        <td>Semua alasan yang kau katakan membuatku tersenyum karena ini semua hanyalah bualanmu belaka
                        </td>
                    </tr>
                </table>
            </div>

        </x-admin.components.card.card>
    </div>


    {{-- Pengajuan bebas pinjaman fakultas --}}
    <div class="col-lg-6 col-md-12 col-sm-12 collapse multi-collapse" id="multiCollapseExample2">
        <x-admin.components.card.card small=12 medium=12 size=12 title='Pinjaman Fakultas'>

            {{-- Data pengajuan --}}
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <td class="col-1">Status</td>
                        <td>:</td>
                        <td>Sedang dalam proses</td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td>:</td>
                        <td>Semua alasan yang kau katakan membuatku tersenyum karena ini semua hanyalah bualanmu belaka
                        </td>
                    </tr>
                </table>
            </div>

        </x-admin.components.card.card>
    </div>

</div>
