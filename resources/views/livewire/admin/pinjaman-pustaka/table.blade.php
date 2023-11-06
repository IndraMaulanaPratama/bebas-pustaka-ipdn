<div class="col-12">
    <div>
        <x-admin.components.card.card size=12 title="Data Assign Role" titleSpan='Aktif'>

            {{-- Baris bagian search sareng tombol export data --}}
            <div class="row justify-content-between g-4">

                {{-- Button Export Data --}}
                <div class="col-2">
                    <div wire:confirm='Apakah data yang akan diexport sudah sesuai?' wire:click='exportData'>
                        <x-admin.components.button.icon-button text="Export Data" :access=$accessExport />
                    </div>
                </div>

                {{-- Input Pencarian Data --}}
                <div class="col-3 ">
                    <x-admin.components.form.input size=12 type='text' name='search'
                        placeholder='Cari Nomor Pokok Praja' />
                </div>
            </div>

            <hr />

            <div class="row">
                <table class="table table-responsive table-hover">
                    {{-- Select Sort By Status --}}
                    <div class="col-2">
                        <x-admin.components.form.select name='sortStatus' placeholder='Urutan status'>
                            <option value="Proses">Proses</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                        </x-admin.components.form.select>
                    </div>

                    {{-- Select ututan data dumasar kana fakultas --}}
                    <div class="col-3">
                        <x-admin.components.form.select size='12' name='sortFakultas'
                            placeholder='Urutan Fakultas'>
                            <option value="fpp">Politik Pemerintahan</option>
                            <option value="fmp">Fakultas Manajemen Pemerintahan</option>
                            <option value="fpm">Fakultas Perlindungan Masyarakat</option>
                        </x-admin.components.form.select>
                    </div>

                    {{-- Select ututan data dumasar kana prodi --}}
                    <div class="col-4">
                        <x-admin.components.form.select size='12' name='sortProdi'
                            placeholder='Urutan Program Studi'>
                            <option value="FPP">MANAJEMEN KEAMANAN DAN KESELAMATAN PUBLIK</option>
                            <option value="FMP">PRAKTIK PERPOLISIAN TATA PAMONG</option>
                            <option value="FPM">KEUANGAN PUBLIK</option>
                        </x-admin.components.form.select>
                    </div>


                    <thead>
                        <tr>
                            <th scope="col" width=3%>#</th>
                            <th scope="col">NPP</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Status</th>
                            <th scope="col" colspan="3" width=5%>Option</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pustaka as $item)
                            @php
                                $buttonApprove = 'hidden';
                                $buttonReject = 'hidden';
                                $buttonPrint = 'hidden';

                                if ($item->PUSTAKA_STATUS == 'Proses') {
                                    $colorStatus = 'primary';
                                    $iconStatus = 'bi-arrow-clockwise';
                                    $buttonApprove = null;
                                    $buttonReject = null;
                                } elseif ($item->PUSTAKA_STATUS == 'Disetujui') {
                                    $colorStatus = 'success';
                                    $iconStatus = 'bi-check2-all';
                                    $buttonPrint = null;
                                } else {
                                    $colorStatus = 'danger';
                                    $iconStatus = 'bi-dash-circle-fill';
                                }
                            @endphp

                            <tr>
                                <td width=3%> {{ $loop->index + $pustaka->firstItem() }} </td>

                                <td>
                                    <button type="button" class="btn btn-link"
                                        wire:click="detailPraja('{{ $item->PUSTAKA_PRAJA }}')" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailPraja">
                                        {{ $item->PUSTAKA_PRAJA }}
                                    </button>
                                </td>

                                <td> {{ $item->PUSTAKA_NOTES }} </td>

                                <td>
                                    <span class="badge bg-{{ $colorStatus }}">
                                        <i class="bi {{ $iconStatus }}"></i> &nbsp;
                                        {{ $item->PUSTAKA_STATUS }}
                                    </span>
                                </td>

                                <td>
                                    <button type="button" {{ $buttonApprove }}
                                        class="btn btn-sm btn-outline-success rounded-pill {{ $accessApprove }}"
                                        wire:confirm='Anda yakin akan menyetujui pengajuan ini?'
                                        wire:click='approveData("{{ $item->PUSTAKA_ID }}")'>
                                        <i class="bi bi-check2-all"></i>
                                    </button>
                                </td>

                                <td>
                                    <button type="button" {{ $buttonReject }}
                                        class="btn btn-sm btn-outline-danger rounded-pill {{ $accessReject }}"
                                        data-bs-toggle="modal" data-bs-target="#formReject"
                                        wire:click='rejectData("{{ $item->PUSTAKA_ID }}")'>
                                        <i class="bi bi-dash-circle-fill"></i>
                                    </button>
                                </td>

                                <td>
                                    <button type="button" {{ $buttonPrint }}
                                        class="btn btn-sm btn-outline-secondary rounded-pill {{ $accessPrint }}"
                                        wire:confirm='Cetak Pengajuan Similaritas {{ $item->PUSTAKA_PRAJA }} ?'
                                        wire:click='printApprooved("{{ $item->PUSTAKA_ID }}")'>
                                        <i class="bi bi-printer-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <x-admin.tamplates.paginate.paginate :item="$pustaka" />

            </div>
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </x-admin.components.modal.modal>

</div>
