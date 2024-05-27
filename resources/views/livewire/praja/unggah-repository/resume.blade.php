{{-- Stop trying to control. --}}

<div>

    <table class="table table-border">
        <tr>
            <td class="col-lg-2 col-md-4 col-sm-4 col-xs-5">Nomor Pokok Praja</td>
            <td>:</td>
            <td class="col-lg-10">{{ $praja->NPP }}</td>
        </tr>

        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $praja->NAMA }}</td>
        </tr>

        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $praja->TEMPAT_LAHIR }}, {{ $praja->TANGGAL_LAHIR }}</td>
        </tr>

        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $praja->JENIS_KELAMIN == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}</td>
        </tr>

        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $praja->AGAMA }}</td>
        </tr>

        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>

        <tr>
            <td>Petugas</td>
            <td>:</td>
            <td>{{ $data != null && $data->REPOSITORY_OFFICER != 1 ? $data->user->name : '-' }}</td>
        </tr>

        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ $data->updated_at ?? '-' }}</td>
        </tr>

        <tr {{ $data->REPOSITORY_URL ?? 'hidden' }}>
            <td>Tautan eprints</td>
            <td>:</td>
            <td>
                <a href="{{ $data->REPOSITORY_URL ?? null }}" target="blank">
                    Lihat Konten <sup><i class="bi bi-arrow-up-right-circle-fill"></i></sup>
                </a>

            </td>
        </tr>

        <tr>
            <td>Status Pengajuan</td>
            <td>:</td>
            <td>
                <div class="row">
                    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                        {{ $data->REPOSITORY_STATUS ?? '-' }}
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">

                        <button data-bs-toggle="modal" data-bs-target="#formPerbaikan"
                            class="btn btn-outline-secondary btn-sm" {{ $buttonAjukan }}>
                            <i class="bi bi-arrow-clockwise"></i>Ajukan Ulang
                        </button>

                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td>Catatan Pengajuan</td>
            <td>:</td>
            <td>{{ $data->REPOSITORY_NOTES ?? '-' }}</td>
        </tr>
    </table>


    <x-admin.components.modal.modal id='formPerbaikan'>
        <x-admin.components.modal.header id='formPerbaikan' title="Formulir pengajuan ulang" />

        <form wire:submit='pengajuanUlang' method="POST">

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
