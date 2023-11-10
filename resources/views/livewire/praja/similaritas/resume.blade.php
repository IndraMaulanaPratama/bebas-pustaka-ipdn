<div class="table-responsive">
    <table class="table table-borderless">
        <tr class="d-flex">
            <td class="col-sm-4">Nomor Pokok Praja</td>
            <td>:</td>
            <td>{{ $praja->NPP }}</td>
        </tr>

        <tr class="d-flex">
            <td class="col-sm-4">Nama Lengkap</td>
            <td>:</td>
            <td>{{ $praja->NAMA }}</td>
        </tr>

        <tr class="d-flex">
            <td class="col-sm-4">Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $praja->TEMPAT_LAHIR }}, {{ $praja->TANGGAL_LAHIR }}</td>
        </tr>

        <tr class="d-flex">
            <td class="col-sm-4">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $praja->JENIS_KELAMIN == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}</td>
        </tr>

        <tr class="d-flex">
            <td class="col-sm-4">Agama</td>
            <td>:</td>
            <td>{{ $praja->AGAMA }}</td>
        </tr>

        <tr class="d-flex">
            <td colspan="3">&nbsp;</td>
        </tr>

        <tr class="d-flex">
            <td class="col-sm-4">Judul Skripsi</td>
            <td>:</td>
            <td>{{ $similaritas->SIMILARITAS_TITLE ?? '-' }}</td>
        </tr>

        <tr class="d-flex">
            <td class="col-sm-4">Kelas <i>Turnitin</i></td>
            <td>:</td>
            <td>{{ $similaritas->SIMILARITAS_CLASS ?? '-' }}</td>
        </tr>

        <tr class="d-flex">
            <td class="col-sm-4">Nomor Absen <i>Turnitin</i></td>
            <td>:</td>
            <td>{{ $similaritas->SIMILARITAS_ABSENT ?? '-' }}</td>
        </tr>

        <tr class="d-flex">
            <td class="col-sm-4">Status Pengajuan</td>
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

        <tr class="d-flex">
            <td class="col-sm-4">Catatan Pengajuan</td>
            <td>:</td>
            <td>{{ $similaritas->SIMILARITAS_NOTES ?? '-' }}</td>
        </tr>
    </table>
</div>
