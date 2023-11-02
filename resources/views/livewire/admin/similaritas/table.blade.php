<div>
    <x-admin.components.card.card size=12 title="Tabel data similaritas" titleSpan='Praja utama'>

        {{-- Baris bagian search sareng tombol tambih data --}}
        <div class="row justify-content-between g-4">

            {{-- Select ututan data dumasar kana status --}}
            <div class="col-2">
                <x-admin.components.form.select name='sortStatus' placeholder='Urutan status'>
                    <option value="process">Proses</option>
                    <option value="approve">Disetujui</option>
                </x-admin.components.form.select>
            </div>

            {{-- Select ututan data dumasar kana fakultas --}}
            <div class="col-3">
                <x-admin.components.form.select size='12' name='sortFakultas' placeholder='Urutan Fakultas'>
                    <option value="fpp">Politik Pemerintahan</option>
                    <option value="fmp">Fakultas Manajemen Pemerintahan</option>
                    <option value="fpm">Fakultas Perlindungan Masyarakat</option>
                </x-admin.components.form.select>
            </div>

            {{-- Select ututan data dumasar kana prodi --}}
            <div class="col-4">
                <x-admin.components.form.select size='12' name='sortProdi' placeholder='Urutan Program Studi'>
                    <option value="fpp">MANAJEMEN KEAMANAN DAN KESELAMATAN PUBLIK</option>
                    <option value="fmp">PRAKTIK PERPOLISIAN TATA PAMONG</option>
                    <option value="fpm">KEUANGAN PUBLIK</option>
                </x-admin.components.form.select>
            </div>



            {{-- Input Pencarian Data --}}
            <div class="col-3 ">
                <x-admin.components.form.input size=12 type='text' name='search'
                    placeholder='Cari Nomor Pokok Praja' />
            </div>
        </div>

        <hr />

        {{-- Table data similaritas --}}
        <div class="row">
            <table class="table table-responsive table-hover">

                <thead>
                    <tr>
                        <th scope="col" width=3%>#</th>
                        <th scope="col">NPM</th>
                        <th scope="col" width=50%>Judul Skripsi</th>
                        <th scope="col">Nama Kelas</th>
                        <th scope="col">Nomor Absen</th>
                        <th scope="col">Status</th>
                        <th scope="col" colspan="3" width=5%>Option</th>
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
                            <td>
                                <button type="button" class="btn btn-link" wire:click="detailPraja('{{$item->SIMILARITAS_PRAJA}}')"
                                    data-bs-toggle="modal" data-bs-target="#modalDetailPraja">
                                    {{ $item->SIMILARITAS_PRAJA }}
                                </button>
                            </td>
                            <td> {{ $item->SIMILARITAS_TITLE }} </td>
                            <td> {{ $item->SIMILARITAS_CLASS }} </td>
                            <td> {{ $item->SIMILARITAS_ABSENT }} </td>
                            <td>
                                <span class="badge bg-{{ $colorStatus }}">
                                    <i class="bi {{ $iconStatus }}"></i> &nbsp;
                                    {{ $item->SIMILARITAS_STATUS }}
                                </span>
                            </td>
                            <td>
                                <button type="button" {{ $buttonApprove }}
                                    class="btn btn-sm btn-outline-success rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#formApprove">
                                    <i class="bi bi-check2-all"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" {{ $buttonReject }}
                                    class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#formReject"
                                    wire:click='rejectData("{{$item->SIMILARITAS_ID}}")'>
                                    <i class="bi bi-dash-circle-fill"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" {{ $buttonPrint }}
                                    class="btn btn-sm btn-outline-secondary rounded-pill">
                                    <i class="bi bi-printer-fill"></i>
                                </button>
                            </td>

                        </tr>

                    @endforeach
                </tbody>
            </table>
            <x-admin.tamplates.paginate.paginate :item="$similaritas" />

        </div>

    </x-admin.components.card.card>


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
