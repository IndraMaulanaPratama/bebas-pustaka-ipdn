{{-- Stop trying to control. --}}
<div>

    {{-- Data Pengajuan --}}
    <div class="row mb-4">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tr>
                    <td class="col-lg-2 col-md-4 col-sm-4">Nama Lengkap</td>
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
                    <td>Fakultas</td>
                    <td>:</td>
                    <td>{{ $praja->FAKULTAS }}</td>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>

                        {{-- Button Lihat Data Praja --}}
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target=".multi-collapse" aria-expanded="false"
                            aria-controls="multiCollapseExample1 multiCollapseExample2 multiCollapseExample3">
                            Lihat Status Pengajuan
                        </button>

                    </td>
                </tr>

            </table>
        </div>
    </div>


    {{-- Resume donasi perpustakaan pusat dan fakultas --}}
    <div class="row">
        {{-- Pengajuan donasi perpustakaan --}}
        <div class="col-lg-6 col-md-12 col-sm-12 collapse multi-collapse" id="multiCollapseExample1">
            <x-admin.components.card.card small=12 medium=12 size=12 title='Donasi Cetak Perpustakaan Pusat'>

                {{-- Data pengajuan --}}
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td>Petugas</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data != null && $data->donasi_pustaka->PUSTAKA_OFFICER != 1 ? $data->donasi_pustaka->user->name : '-'}}
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data == null ? '-' : $data->donasi_pustaka->updated_at }}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-1">Status</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data == null ? 'Belum Ada Pengajuan' : $data->donasi_pustaka->PUSTAKA_STATUS }}
                            </td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data == null ? '-' : $data->donasi_pustaka->PUSTAKA_NOTES }}
                            </td>
                        </tr>
                    </table>

                    <button wire:confirm='Anda yakin akan membuat pengajuan ulang?'
                        wire:click='resendPengajuan("pustaka")' class="btn btn-sm btn-outline-secondary"
                        {{ $buttonResendPustaka }}>
                        Ajukan Ulang
                    </button>

                </div>

            </x-admin.components.card.card>
        </div>


        {{-- Pengajuan donasi fakultas --}}
        <div class="col-lg-6 col-md-12 col-sm-12 collapse multi-collapse" id="multiCollapseExample2">
            <x-admin.components.card.card small=12 medium=12 size=12 title='Donasi Cetak Perpustakaan Fakultas'>

                {{-- Data pengajuan --}}
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td>Petugas</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data != null && $data->donasi_fakultas->FAKULTAS_OFFICER != 1 ? $data->donasi_fakultas->user->name : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data == null ? '-' : $data->donasi_fakultas->updated_at }}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-1">Status</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data == null ? 'Belum Ada Pengajuan' : $data->donasi_fakultas->FAKULTAS_STATUS }}
                            </td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data == null ? '-' : $data->donasi_fakultas->FAKULTAS_NOTES }}
                            </td>
                        </tr>
                    </table>

                    <button wire:confirm='Anda yakin akan membuat pengajuan ulang?'
                        wire:click='resendPengajuan("fakultas")' class="btn btn-sm btn-outline-secondary"
                        {{ $buttonResendFakultas }}>
                        Ajukan Ulang
                    </button>

                </div>

            </x-admin.components.card.card>
        </div>

        {{-- Pengajuan donasi fakultas --}}
        <div class="col-lg-6 col-md-12 col-sm-12 collapse multi-collapse" id="multiCollapseExample3">
            <x-admin.components.card.card small=12 medium=12 size=12 title='Donasi Poin Perpustakaan Pusat'>

                {{-- Data pengajuan --}}
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td>Petugas</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data != null && $data->donasi_elektronik->ELEKTRONIK_OFFICER != 1 ? $data->donasi_elektronik->user->name : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data == null ? '-' : $data->donasi_elektronik->updated_at }}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-1">Status</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data == null ? 'Belum Ada Pengajuan' : $data->donasi_elektronik->ELEKTRONIK_STATUS }}
                            </td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td>:</td>
                            <td class="col-11">
                                {{ $data == null ? '-' : $data->donasi_elektronik->ELEKTRONIK_NOTES }}
                            </td>
                        </tr>
                    </table>

                    <button wire:confirm='Anda yakin akan membuat pengajuan ulang?'
                        wire:click='resendPengajuan("elektronik")' class="btn btn-sm btn-outline-secondary"
                        {{ $buttonResendElektronik }}>
                        Ajukan Ulang
                    </button>

                </div>

            </x-admin.components.card.card>
        </div>

    </div>
</div>
