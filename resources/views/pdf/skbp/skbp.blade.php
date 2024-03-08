@php
    use Illuminate\Support\Carbon;
    $date = Carbon::parse($skbp->created_at);
    $tanggal = $date->toDateString();
    $waktu = $date->toTimeString();
@endphp ?>

<!DOCTYPE html>
<html>

<head>

    <title>Laporan Surat Keterangan Bebas Pustaka</title>
    <link href="bootstrap.css" rel="stylesheet" />

    <style>
        body {
            font-size: 10px;
        }

        .container {
            padding-left: 50px;
            padding-right: 50px;
        }

        .bottomright {
            position: absolute;
            top: 8px;
            right: 20px;
            font-size: 18px;
        }

        p {
            font-size: 10px;
        }

        h3 {
            line-height: 1px;
            font-size: 14px;
        }

        h4 {
            line-height: 2px;
            font-size: 12px;
        }

        .table,
        .tr,
        .th,
        .td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>

    {{-- Kop Surat --}}
    <div id="Judul" class="container" style="">
        <center>
            <table width='100%'>
                <tr>
                    <th>
                        <img src="foto_pegawai/logo-ipdn.jpg" alt="Logo ipdn" width="90px" />
                    </th>

                    <td>
                        <center>
                            <div style="font-size: 16px; line-height: 20px">
                                KEMENTERIAN DALAM NEGERI <br />
                                REPUBLIK INDONESIA
                            </div>
                            <div style="font-size: 18px; font-weight: bold;">
                                INSTITUT PEMERINTAHAN DALAM NEGERI
                            </div>
                            <div class="">
                                Jl. Ir. Soekarno Km. 20 Jatinangor-Sumedang Kode Pos 45363 <br />
                                Telp. (022) 7798252-7798253 fax (022) 7798256, Website http://www.ipdn.ac.id
                            </div>
                        </center>
                    </td>
                </tr>
            </table>

            <hr height="5px" size="4" />
            <hr />
        </center>
    </div>

    {{-- Judul Surat --}}
    <div class="container" style="margin-top: 20px; margin-bottom:25px;">
        <center>
            <div style="font-size: 16px; font-weight: bold; text-decoration: underline; margin-bottom: 8px;">
                SURAT KETERANGAN BEBAS PUSTAKA
            </div>

            <div style="font-size: 16px; font-weight: bold;">
                Nomor: {{ $skbp->BEBAS_NUMBER }}
            </div>

        </center>
    </div>

    {{-- Pembuka --}}
    <div class="container" style="margin-bottom: 20px;">
        <div style="text-indent: 0px; font-size: 14px">
            Bertanda tangan dibawah ini Kepala Unit Perpustakaan IPDN Jatinangor,
            menerangkan bahwa:
        </div>
    </div>

    {{-- Table Data Praja --}}
    <div class="container" style="padding-left:80px; font-size: 12px; margin-bottom:20px;">
        <center>
            <table width='100%'>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $praja['NAMA'] }}</td>
                </tr>
                <tr>
                    <td>NPP</td>
                    <td>:</td>
                    <td>{{ $praja['NPP'] }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td>{{ $praja['KELAS'] }}</td>
                </tr>
                <tr>
                    <td>Prodi/Fakultas</td>
                    <td>:</td>
                    <td>
                        {{ $praja['PROGRAM_STUDI'] }} / {{ $praja['FAKULTAS'] }}
                    </td>
                </tr>
                <tr>
                    <td>Nomor Ponsel</td>
                    <td>:</td>
                    <td>{{ $ponsel->nomor_ponsel }}</td>
                </tr>
            </table>
        </center>
    </div>

    {{-- Penutup --}}
    <div class="container" style="margin-bottom: 20px; font-size: 14px">
        <div style="text-indent: 0px;">
            Tidak mempunyai tanggungan berkaitan dengan hak/ tanggung jawab urusan
            perpustakaan meliputi:
        </div>

        <ol type="1">
            <li>Pemeriksaan Similaritas</li>
            <li>Bebas Pinjaman Buku Perpustakaan Pusat</li>
            <li>Bebas Pinjaman Buku Perpustakaan Fakultas</li>
            <li>Donasi Buku Perpustakaan Pusat</li>
            <li>Donasi Buku Perpustakaan Fakultas</li>
            <li>Donasi Poin Perpustakaan Pusat</li>
            <li>Pengisian Survey</li>
            <li>Konten Literasi</li>
            <li>Unggah Repository</li>
            <li>Pengumpulan Hard Copy Skripsi di Perpustakaan Pusat</li>
            <li>Pengumpulan Hard Copy Skripsi di Perpustakaan Fakultas</li>
            <li>Pengumpulan Soft Copy Skripsi</li>
        </ol>
    </div>

    {{-- Table Tanda tangan --}}
    <div class="container" style="margin-top: 50px; font-size:14px;">
        <table width="100%">
            <tr>
                <td width="40%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
                <td width="45%">
                    Jatinangor, {{ Carbon::now('Asia/Jakarta')->format('d - m - Y') }}
                </td>
            </tr>
            <tr>
                <td><b>&nbsp;</b></td>
                <td>&nbsp;</td>
                <td>
                    <b>Kepala Unit Perpustakaan IPDN Jatinangor</b>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="position: absolute; bottom: 70px;">
                        &nbsp;
                    </div>
                </td>
                <td>&nbsp;</td>
                <td style="height: 110px;">
                    <div style="position: absolute">
                        <img src="storage/tanda_tangan/{{ $kepalaUnit->SETTING_HEAD_OFFICE_SIGN }}"
                            alt="{{ $kepalaUnit->SETTING_HEAD_OFFICE_NAME }}" width="50%" />
                    </div>

                    <div style="position: absolute; bottom: 220px;">
                        <b>
                            {{ $kepalaUnit->SETTING_HEAD_OFFICE_NAME }}
                        </b>

                        <hr style="width:200px;text-align:left;margin-left:0" />
                        <b>
                            NIP. {{ $kepalaUnit->SETTING_HEAD_OFFICE_ID }}
                        </b>
                    </div>
                </td>
            </tr>
        </table>
    </div>


</body>

</html>
