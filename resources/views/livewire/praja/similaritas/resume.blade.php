<table class="table table-borderless">
    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Nomor Pokok Praja</td>
        <td>:</td>
        <td>{{ $praja->NPP }}</td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Nama Lengkap</td>
        <td>:</td>
        <td>{{ $praja->NAMA }}</td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Tempat, Tanggal Lahir</td>
        <td>:</td>
        <td>{{ $praja->TEMPAT_LAHIR }}, {{ $praja->TANGGAL_LAHIR }}</td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Jenis Kelamin</td>
        <td>:</td>
        <td>{{ $praja->JENIS_KELAMIN == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}</td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Agama</td>
        <td>:</td>
        <td>{{ $praja->AGAMA }}</td>
    </tr>

    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Judul Skripsi</td>
        <td>:</td>
        <td>{{ $similaritas->SIMILARITAS_TITLE ?? '-' }}</td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Kelas <i>Turnitin</i></td>
        <td>:</td>
        <td>{{ $similaritas->SIMILARITAS_CLASS ?? '-' }}</td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Nomor Absen <i>Turnitin</i></td>
        <td>:</td>
        <td>{{ $similaritas->SIMILARITAS_ABSENT ?? '-' }}</td>
    </tr>

    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Petugas</td>
        <td>:</td>
        <td>{{ $similaritas != null && $similaritas->SIMILARITAS_OFFICER != 1 ? $similaritas->user->name : '-'}}</td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Tanggal Pelayanan</td>
        <td>:</td>
        <td>{{ $similaritas->updated_at ?? '-' }}</td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Status Pengajuan</td>
        <td>:</td>
        <td>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    {{ $similaritas->SIMILARITAS_STATUS ?? '-' }}
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <button type="button"
                        class="btn btn-rounded-pill btn-outline-secondary btn-sm {{ $buttonAjukan }}"
                        wire:click='pengajuanUlang("{{ $similaritas->SIMILARITAS_ID ?? null }}")'
                        wire:confirm='Ajukan kembali perubahan yang sudah dilakukan di aplikasi turnitin?'>
                        <i class="bi bi-arrow-clockwise"></i>Ajukan Ulang
                    </button>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td class="col-lg-4 col-md-4 col-sm-4 col-xs-5">Catatan Pengajuan</td>
        <td>:</td>
        <td>{{ $similaritas->SIMILARITAS_NOTES ?? '-' }}</td>
    </tr>
</table>
