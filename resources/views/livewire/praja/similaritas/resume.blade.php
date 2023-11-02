<table class="table table-hover">
    <tr>
        <td width=25%>Nomor Pokok Praja</td>
        <td width=4%>:</td>
        <td>{{ $praja->NPP }}</td>
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
        <td>Judul Skripsi</td>
        <td>:</td>
        <td>{{ $similaritas->SIMILARITAS_TITLE ?? '-' }}</td>
    </tr>

    <tr>
        <td>Kelas <i>Turnitin</i></td>
        <td>:</td>
        <td>{{ $similaritas->SIMILARITAS_CLASS ?? '-' }}</td>
    </tr>

    <tr>
        <td>Nomor Absen <i>Turnitin</i></td>
        <td>:</td>
        <td>{{ $similaritas->SIMILARITAS_ABSENT ?? '-' }}</td>
    </tr>

    <tr>
        <td width=15%>Status Pengajuan</td>
        <td>:</td>
        <td>
            <div class="position-relative">
                <div class="position-absolute start-0">
                    {{ $similaritas->SIMILARITAS_STATUS ?? '-' }}
                </div>

                <div class="position-absolute end-0">
                    <button type="button" class="btn btn-rounded-pill btn-outline-secondary btn-sm {{ $buttonAjukan }}"
                        wire:click='pengajuanUlang("{{ $similaritas->SIMILARITAS_ID ?? null }}")'
                        wire:confirm='Ajukan kembali perubahan yang sudah dilakukan di aplikasi turnitin?'>
                        <i class="bi bi-arrow-clockwise"></i>Ajukan Ulang
                    </button>

                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td width=15%>Catatan Pengajuan</td>
        <td>:</td>
        <td>{{ $similaritas->SIMILARITAS_NOTES ?? '-' }}</td>
    </tr>
</table>
