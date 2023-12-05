{{-- Stop trying to control. --}}

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

    <tr>
        <td>Status Pengajuan</td>
        <td>:</td>
        <td>
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    {{ $data->REPOSITORY_STATUS ?? '-' }}
                </div>

                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <button type="button" class="btn btn-rounded-pill btn-outline-secondary btn-sm" {{ $buttonAjukan }}
                        wire:click='pengajuanUlang("{{ $data->REPOSITORY_ID ?? null }}")'
                        wire:confirm='Ajukan kembali perubahan yang sudah dilakukan di unggah repository?'>
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
