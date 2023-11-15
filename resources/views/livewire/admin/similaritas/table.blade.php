<div>
    <x-admin.components.card.card size=12 title="Tabel data similaritas" titleSpan='Praja utama'>

        {{-- Baris bagian search sareng tombol export data --}}
        <div class="row justify-content-between g-2">

            {{-- Button Export Data --}}
            <div class="col-lg-2 col-md-4 col-sm-4">
                <div wire:confirm='Apakah data yang akan diexport sudah sesuai?' wire:click='exportData'>
                    <x-admin.components.button.icon-button text="Export Data" :access=$accessExport />
                </div>
            </div>

            {{-- Input Pencarian Data --}}
            <div class="col-lg-3 col-md-6 col-sm-6 ">
                <x-admin.components.form.input size=12 type='text' name='search'
                    placeholder='Cari Nomor Pokok Praja' />
            </div>
        </div>

        <hr />

        {{-- Opsi Pencarian --}}
        <div class="row g-2">
            {{-- Select Sort By Status --}}
            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                <x-admin.components.form.select name='sortStatus' placeholder='Urutan status'>
                    <option value="Proses">Proses</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
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

        {{-- Table data similaritas --}}
        <div class="table-responsive">
            <table class="table table-hover w-auto">
                <thead>
                    <tr>
                        <th width=3%>#</th>
                        <th>NPM</th>
                        <th>Judul Skripsi</th>
                        <th>Nama Kelas</th>
                        <th>Nomor Absen</th>
                        <th>Status</th>
                        <th>Petugas</th>
                        <th>Tanggal Validasi</th>
                        <th>Keterangan</th>
                        <th colspan="3" width=5%>Option</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($similaritas as $item)
                        @php
                            $buttonApprove = 'hidden';
                            $buttonReject = 'hidden';
                            $buttonPrint = 'hidden';

                            if ($item->SIMILARITAS_STATUS == 'Proses') {
                                $colorStatus = 'primary';
                                $iconStatus = 'bi-arrow-clockwise';
                                $buttonApprove = null;
                                $buttonReject = null;
                            } elseif ($item->SIMILARITAS_STATUS == 'Disetujui') {
                                $colorStatus = 'success';
                                $iconStatus = 'bi-check2-all';
                                $buttonPrint = null;
                            } else {
                                $colorStatus = 'danger';
                                $iconStatus = 'bi-dash-circle-fill';
                            }
                        @endphp

                        <tr>
                            <th scope="row"> {{ $loop->index + $similaritas->firstItem() }} </th>

                            <td> {{-- NPP Praja --}}
                                <button type="button" class="btn btn-link"
                                    wire:click="detailPraja('{{ $item->SIMILARITAS_PRAJA }}')" data-bs-toggle="modal"
                                    data-bs-target="#modalDetailPraja">
                                    {{ $item->SIMILARITAS_PRAJA }}
                                </button>
                            </td>

                            <td> {{ $item->SIMILARITAS_TITLE }} </td>
                            <td> {{ $item->SIMILARITAS_CLASS }} </td>
                            <td> {{ $item->SIMILARITAS_ABSENT }} </td>

                            <td> {{-- Status Pengajuan --}}
                                <span class="badge bg-{{ $colorStatus }}">
                                    <i class="bi {{ $iconStatus }}"></i> &nbsp;
                                    {{ $item->SIMILARITAS_STATUS }}
                                </span>
                            </td>

                            <td> {{ $item->SIMILARITAS_OFFICER === 1 ? null : $item->user->name }} </td>
                            <td> {{ $item->SIMILARITAS_APPROVED }} </td>
                            <td> {{ $item->SIMILARITAS_NOTES }} </td>

                            {{-- Button Approve --}}
                            <td>
                                <button type="button" {{ $buttonApprove }}
                                    class="btn btn-sm btn-outline-success rounded-pill {{ $accessApprove }}"
                                    data-bs-toggle="modal" data-bs-target="#formApprove"
                                    wire:click='selectedData(["{{ $item->SIMILARITAS_ID }}", "{{ $item->SIMILARITAS_PRAJA }}"])'>
                                    <i class="bi bi-check2-all"></i>
                                </button>
                            </td>

                            {{-- Button Reject --}}
                            <td>
                                <button type="button" {{ $buttonReject }}
                                    class="btn btn-sm btn-outline-danger rounded-pill {{ $accessReject }}"
                                    data-bs-toggle="modal" data-bs-target="#formReject"
                                    wire:click='rejectData("{{ $item->SIMILARITAS_ID }}")'>
                                    <i class="bi bi-dash-circle-fill"></i>
                                </button>
                            </td>

                            {{-- Button Print --}}
                            <td>
                                <button type="button" {{ $buttonPrint }}
                                    class="btn btn-sm btn-outline-secondary rounded-pill {{ $accessPrint }}"
                                    wire:confirm='Cetak Pengajuan Similaritas {{ $item->SIMILARITAS_PRAJA }} ?'
                                    wire:click='printApprooved("{{ $item->SIMILARITAS_ID }}")'>
                                    <i class="bi bi-printer-fill"></i>
                                </button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginate Data Table --}}
        <x-admin.tamplates.paginate.paginate :item="$similaritas" />

    </x-admin.components.card.card>


    {{-- Modal Detail Praja --}}
    <x-admin.components.modal.modal id='modalDetailPraja' size='xl'>
        <x-admin.components.modal.header id='modalDetailPraja' title="Data Detail Praja" />

        <div class="modal-body">
            <div class="row g-2 p-2">
                &nbsp;

                <x-admin.components.form.input name='prajaNama' placeholder='Nama Lengkap' disabled='disabled' />

                {{-- Email dan Nomor Ponsel --}}
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaEmail' placeholder='Surat Elektronik'
                        disabled='disabled' />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaPonsel' placeholder='Nomor Ponsel' disabled='disabled' />

                </div>

                <hr />

                {{-- Provinsi dan Kota --}}
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaProvinsi' placeholder='Asal Provinsi'
                        disabled='disabled' />

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaKota' placeholder='Asal Kota' disabled='disabled' />

                </div>

                {{-- Tempat Tanggal Lahir dan Jenis Kelamin --}}
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaTempatTanggalLahir' placeholder='Tempat dan Tanggal Lahir'
                        disabled='disabled' />

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaJenisKelamin' placeholder='Jenis Kelamin'
                        disabled='disabled' />

                </div>

                <hr />

                {{-- Tingkat dan Angkatan --}}
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaTingkat' placeholder='Tingkat' disabled='disabled' />

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaAngkatan' placeholder='Angkatan' disabled='disabled' />

                </div>

                {{-- Kampus dan Wisma --}}
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaKampus' placeholder='Alamat Kampus'
                        disabled='disabled' />

                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaWisma' placeholder='Nama Wisma' disabled='disabled' />

                </div>

                <hr />

                {{-- Program Pendidikan dan Fakultas --}}
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaPropen' placeholder='Program Pendidikan'
                        disabled='disabled' />

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaFakultas' placeholder='Fakultas' disabled='disabled' />

                </div>

                {{-- Program Studi dan Kelas --}}
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaProdi' placeholder='Program Studi'
                        disabled='disabled' />

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <x-admin.components.form.input name='prajaKelas' placeholder='Kelas' disabled='disabled' />

                </div>

                <hr />

                {{-- Tombol Reset sareng Submit --}}
                <div class="modal-footer">
                    {{-- Tombol Reset / Cancel --}}
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </x-admin.components.modal.modal>

</div>
