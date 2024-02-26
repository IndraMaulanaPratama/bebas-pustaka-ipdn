{{-- Success is as dangerous as failure. --}}

<div class="col-12">

    {{-- Data Table Konten Literasi --}}
    <div>
        <x-admin.components.card.card size=12 title="Data Pengajuan" titleSpan='Aktif'>

            {{-- Baris bagian search sareng tombol export data --}}
            <div class="row d-flex bd-highlight g-4">

                {{-- Button Export Data --}}
                <div class="w-auto bd-highlight invisible">
                    <div wire:confirm='Apakah data yang akan diexport sudah sesuai?' wire:click='exportData'>
                        <x-admin.components.button.icon-button text="Export Data" :access=$accessExport />
                    </div>
                </div>


                {{-- Input Pencarian Data --}}
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 ms-auto bd-highlight">
                    <x-admin.components.form.input size=12 type='text' name='search'
                        placeholder='Cari Nomor Pokok Praja' />
                </div>


            </div>

            <hr />

            {{-- Opsi Pencarian --}}
            <div class="row g-2 mb-4">
                {{-- Select Sort By Urutan --}}
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <x-admin.components.form.select name='sortUrutan' placeholder='Urutan Data'>
                        <option value="nomor">Nomor Surat</option>
                        <option value="terbaru">Data Terbaru</option>
                    </x-admin.components.form.select>
                </div>

                {{-- Select ututan data dumasar kana angkatan --}}
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                    <x-admin.components.form.input size=12 type='text' name='angkatan' maxlength=2
                        placeholder='Angkatan' />
                </div>

                {{-- Select ututan data dumasar kana fakultas --}}
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <x-admin.components.form.select size='12' name='sortFakultas' placeholder='Urutan Fakultas'>
                        <option value="fpp">Politik Pemerintahan</option>
                        <option value="fmp">Fakultas Manajemen Pemerintahan</option>
                        <option value="fpm">Fakultas Perlindungan Masyarakat</option>
                    </x-admin.components.form.select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-responsive table-hover">

                    <thead>
                        <tr>
                            <th scope="row">#</th>
                            <th style="min-width: 8cm">Nomor Surat</th>
                            <th style="min-width: 2cm">NPP</th>
                            <th style="min-width: 6cm">Petugas</th>
                            <th style="min-width: 5cm">Tanggal Terbit</th>
                            <th colspan="3">Option</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td> {{ $loop->index + $data->firstItem() }} </td>

                                <td> {{ $item->BEBAS_NUMBER }} </td>

                                <td>
                                    <button type="button" class="btn btn-link"
                                        wire:click="detailPraja('{{ $item->BEBAS_PRAJA }}')" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailPraja">
                                        {{ $item->BEBAS_PRAJA }}
                                    </button>
                                </td>

                                <td> {{ $item->BEBAS_OFFICER === 1 ? null : $item->user->name }} </td>
                                <td> {{ $item->created_at }} </td>

                                {{-- Button Print --}}
                                <td {{ $accessPrint }}>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill"
                                        wire:confirm='Cetak Surat Keterangan Bebas Pustaka {{ $item->BEBAS_PRAJA }} ?'
                                        wire:click='printApprooved("{{ $item->BEBAS_ID }}")'>
                                        <i class="bi bi-printer-fill"></i>
                                    </button>
                                </td>

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
                    <x-admin.components.form.input name='prajaPonsel' placeholder='Nomor Ponsel' disabled='disabled' />

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
                    <x-admin.components.form.input name='prajaTempatTanggalLahir' placeholder='Tempat dan Tanggal Lahir'
                        disabled='disabled' />

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
                    <x-admin.components.form.input name='prajaKampus' placeholder='Alamat Kampus' disabled='disabled' />

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
