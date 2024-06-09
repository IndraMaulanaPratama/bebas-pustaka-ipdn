{{-- Close your eyes. Count to one. That is how long forever feels. --}}

<div class="col-12">

    @if (session('success'))
        <x-admin.components.alert.success text="{{ session('success') }}" />
    @endif

    @if (session('warning'))
        <x-admin.components.alert.warning text="{{ session('warning') }}" />
    @endif

    @if (session('error'))
        <x-admin.components.alert.error text="{{ session('error') }}" />
    @endif

    {{-- Data Table Konten Literasi --}}
    <div>
        <x-admin.components.card.card size=12 title="Data Pengajuan" titleSpan='Aktif'>

            {{-- Baris bagian search sareng tombol export data --}}
            <div class="row d-flex bd-highlight g-4">

                {{-- Button Export Data --}}
                <div class="w-auto bd-highlight {{ $accessExport }}">
                    <div wire:confirm='Apakah data yang akan diexport sudah sesuai?' wire:click='exportData'>
                        <x-admin.components.button.icon-button text="Export Data" :access=$accessExport
                            icon='bi-filetype-pdf' />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi?' wire:click='syncData'>
                        <x-admin.components.button.icon-button text="Singkronasi Data" :access=$accessUpdate
                            icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Similaritas --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi similaritas data?'
                        wire:click='syncSimilaritas'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Similaritas" :access=$accessUpdate
                            icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Pinjaman Perpustakaan --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi data?'
                        wire:click='syncPinjamanPusat'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Pinjaman Perpustakaan"
                            :access=$accessUpdate icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Pinjaman Fakultas --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi data?'
                        wire:click='syncPinjamanFakultas'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Pinjaman Fakultas"
                            :access=$accessUpdate icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Donasi Perpustakaan --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi data?'
                        wire:click='syncDonasiPusat'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Donasi Perpustakaan"
                            :access=$accessUpdate icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Donasi Fakultas --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi data?'
                        wire:click='syncDonasiFakultas'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Donasi Fakultas"
                            :access=$accessUpdate icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi?' wire:click='syncDonasiPoint'>
                        <x-admin.components.button.icon-button text="Singkronasi Data" :access=$accessUpdate
                            icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Survei Praja --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi data?' wire:click='syncSurvei'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Survei Praja"
                            :access=$accessUpdate icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Konten Literasi --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi data?'
                        wire:click='syncKontenLiterasi'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Konten Literasi"
                            :access=$accessUpdate icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Repositroy --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi data?' wire:click='syncRepository'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Repositroy" :access=$accessUpdate
                            icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Hard Copy Skripsi Perpustakaan --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi data?' wire:click='syncCopyPusat'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Hard Copy Skripsi Perpustakaan"
                            :access=$accessUpdate icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Hard Copy Skripsi Fakultas --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi data?'
                        wire:click='syncCopyFakultas'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Hard Copy Skripsi Fakultas"
                            :access=$accessUpdate icon="bi-arrow-repeat" />
                    </div>
                </div>

                {{-- Button Singkronasisasi Data Soft Copy --}}
                <div class="w-auto bd-highlight" {{ $accessUpdate }}>
                    <div wire:confirm='Apakah anda yakin ingin melakukan singkronasi data ?' wire:click='syncSoftCopy'>
                        <x-admin.components.button.icon-button text="Singkronasi Data Soft Copy" :access=$accessUpdate
                            icon="bi-arrow-repeat" />
                    </div>
                </div>

            </div>


            <div class="row justify-content-between g-4 mt-4">

                <div class="col-auto">&nbsp;</div>

                <div class="col-lg-3 col-md-4 col-sm-12">
                    {{-- Input Pencarian Data --}}
                    <div class="ms-auto bd-highlight">
                        <x-admin.components.form.input size=12 type='text' name='search'
                            placeholder='Cari Nomor Pokok Praja' />
                    </div>
                </div>

            </div>

            <hr />

            <div class="table-responsive">
                <table class="table table-responsive table-hover">

                    <thead>
                        <tr style="text-align: center">
                            <th rowspan="2" scope="row">#</th>
                            <th rowspan="2" style="min-width: 6cm">Nomor Pokok Praja</th>
                            <th colspan="12" style="min-width: 2cm; text-align: center">Status Pengajuan</th>
                        </tr>

                        <tr style="text-align: center">
                            <th style="min-width: 5cm">Similaritas</th>
                            <th style="min-width: 5cm">Pinjaman Pusat</th>
                            <th style="min-width: 5cm">Pinjaman Fakultas</th>
                            <th style="min-width: 5cm">Donasi Pusat</th>
                            <th style="min-width: 5cm">Donasi Fakultas</th>
                            <th style="min-width: 5cm">Donasi Poin</th>
                            <th style="min-width: 5cm">Survei Praja</th>
                            <th style="min-width: 5cm">Konten Literasi</th>
                            <th style="min-width: 5cm">Repository</th>
                            <th style="min-width: 5cm">Hard Copy Pusat</th>
                            <th style="min-width: 5cm">Hard Copy Fakultas</th>
                            <th style="min-width: 5cm">Soft Copy</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $item)
                            <tr style="text-align: center">
                                <td> {{ $loop->index + $data->firstItem() }} </td>

                                <td>
                                    <button type="button" class="btn btn-link"
                                        wire:click="detailPraja('{{ $item->BEBAS_PRAJA }}')" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailPraja">
                                        {{ $item->BEBAS_PRAJA }}
                                    </button>
                                </td>

                                <td> {{ $item->BEBAS_SIMILARITAS != 0 ? '✅' : '❌' }} </td>
                                <td> {{ $item->BEBAS_PINJAMAN_PUSAT != 0 ? '✅' : '❌' }}</td>
                                <td> {{ $item->BEBAS_PINJAMAN_FAKULTAS != 0 ? '✅' : '❌' }}</td>
                                <td> {{ $item->BEBAS_DONASI_PUSAT != 0 ? '✅' : '❌' }}</td>
                                <td> {{ $item->BEBAS_DONASI_FAKULTAS != 0 ? '✅' : '❌' }}</td>
                                <td> {{ $item->BEBAS_DONASI_POIN != 0 ? '✅' : '❌' }}</td>
                                <td> {{ $item->BEBAS_SURVEI != 0 ? '✅' : '❌' }}</td>
                                <td> {{ $item->BEBAS_KONTEN_LITERASI != 0 ? '✅' : '❌' }}</td>
                                <td> {{ $item->BEBAS_REPOSITORY != 0 ? '✅' : '❌' }}</td>
                                <td> {{ $item->BEBAS_HARD_COPY_PUSAT != 0 ? '✅' : '❌' }}</td>
                                <td> {{ $item->BEBAS_HARD_COPY_FAKULTAS != 0 ? '✅' : '❌' }}</td>
                                <td> {{ $item->BEBAS_SOFT_COPY != 0 ? '✅' : '❌' }}</td>

                                {{-- Button Print --}}

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

            <x-admin.tamplates.paginate.paginate :item="$data" />

        </x-admin.components.card.card>
    </div>

    {{-- Modal Detail Praja --}}
    <x-admin.components.modal.modal id='modalDetailPraja' size='xl'>
        <x-admin.components.modal.header id='modalDetailPraja' title="Data Detail Praja" />

        <div class="modal-body">
            <div class="row g-2 p-2">
                &nbsp;

                <x-admin.components.form.input name='prajaNama' placeholder='Nama Lengkap' disabled='disabled' />

                {{-- Email dan Nomor Ponsel --}}
                <div class="col-6">
                    <x-admin.components.form.input name='prajaEmail' placeholder='Surat Elektronik'
                        disabled='disabled' />
                </div>
                <div class="col-6">
                    <x-admin.components.form.input name='prajaPonsel' placeholder='Nomor Ponsel'
                        disabled='disabled' />

                </div>

                <hr />

                {{-- Provinsi dan Kota --}}
                <div class="col-6">
                    <x-admin.components.form.input name='prajaProvinsi' placeholder='Asal Provinsi'
                        disabled='disabled' />

                </div>
                <div class="col-6">
                    <x-admin.components.form.input name='prajaKota' placeholder='Asal Kota' disabled='disabled' />

                </div>

                {{-- Tempat Tanggal Lahir dan Jenis Kelamin --}}
                <div class="col-6">
                    <x-admin.components.form.input name='prajaTempatTanggalLahir'
                        placeholder='Tempat dan Tanggal Lahir' disabled='disabled' />

                </div>
                <div class="col-6">
                    <x-admin.components.form.input name='prajaJenisKelamin' placeholder='Jenis Kelamin'
                        disabled='disabled' />

                </div>

                <hr />

                {{-- Tingkat dan Angkatan --}}
                <div class="col-6">
                    <x-admin.components.form.input name='prajaTingkat' placeholder='Tingkat' disabled='disabled' />

                </div>
                <div class="col-6">
                    <x-admin.components.form.input name='prajaAngkatan' placeholder='Angkatan' disabled='disabled' />

                </div>

                {{-- Kampus dan Wisma --}}
                <div class="col-6">
                    <x-admin.components.form.input name='prajaKampus' placeholder='Alamat Kampus'
                        disabled='disabled' />

                </div>

                <div class="col-6">
                    <x-admin.components.form.input name='prajaWisma' placeholder='Nama Wisma' disabled='disabled' />

                </div>

                <hr />

                {{-- Program Pendidikan dan Fakultas --}}
                <div class="col-6">
                    <x-admin.components.form.input name='prajaPropen' placeholder='Program Pendidikan'
                        disabled='disabled' />

                </div>
                <div class="col-6">
                    <x-admin.components.form.input name='prajaFakultas' placeholder='Fakultas' disabled='disabled' />

                </div>

                {{-- Program Studi dan Kelas --}}
                <div class="col-6">
                    <x-admin.components.form.input name='prajaProdi' placeholder='Program Studi'
                        disabled='disabled' />

                </div>
                <div class="col-6">
                    <x-admin.components.form.input name='prajaKelas' placeholder='Kelas' disabled='disabled' />

                </div>

                <hr />

                {{-- Tombol Reset sareng Submit --}}
                <div class="modal-footer">
                    {{-- Tombol Reset / Cancel --}}
                    <button type="button" wire:click='resetForm' class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </x-admin.components.modal.modal>

</div>
