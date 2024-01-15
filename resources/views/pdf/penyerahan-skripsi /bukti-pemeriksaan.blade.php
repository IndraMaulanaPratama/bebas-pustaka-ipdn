@php
    use Illuminate\Support\Carbon;
    $date = Carbon::parse($data->skripsi_softcopy->SKRIPSI_APPROVED);
    $tanggal = $date->toDateString();
    $waktu = $date->toTimeString();
@endphp ?>

<!DOCTYPE html>
<html>

<head>

    <title>Penyerahan Skripsi</title>
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
    <div
        style="
                position: absolute;
                width: 100%;
                height: 48%;
                border-style: solid;
                border-width: 1px;
                margin-bottom: 3%;
            ">
        <!-- Keterangan Arsip -->
        <p
            style="
                    top: 2px;
                    right: 20px;
                    position: absolute;
                    border-style: solid;
                    border-width: 1px;
                    padding: 5px;
                ">
            Arsip Pribadi
        </p>

        <div id="Judul" style="margin-top: 40px">
            <center>
                <h3>BERITA ACARA PENYERAHAN SKRIPSI PRAJA TAHUN LULUS {{ Carbon::now('Asia/Jakarta')->format('Y') }}
                </h3>
            </center>
        </div>

        <div class="container">
            Telah diterima:

            <ol type="1">
                <li>
                    1 (satu) eksemplar hardcopy skripsi
                </li>

                <li>
                    1 (satu) dokumen softcopy (PDF) skripsi melalui email: perpustakaan@ipdn.ac.id dengan
                    Subjek Email: NPP_Nama_Kelas_Judul Skripsi
                </li>
            </ol>
        </div>

        {{-- Table Identitas --}}
        <div class="container">
            <table style="width: 100%; border-style: none; padding:0px 50px;">
                <tr>
                    <td width="120px">Nama</td>
                    <td width="2px">:</td>
                    <td>{{ $praja['NAMA'] }}</td>
                </tr>

                <tr>
                    <td>NPP</td>
                    <td>:</td>
                    <td>{{ $praja['NPP'] }}</td>
                </tr>

                <tr>
                    <td>Nomor Ponsel</td>
                    <td>:</td>
                    <td>{{ $ponsel->nomor_ponsel }}</td>
                </tr>

                <tr>
                    <td>Program Studi</td>
                    <td>:</td>
                    <td>
                        {{ $praja['PROGRAM_STUDI'] }}
                    </td>
                </tr>

                <tr>
                    <td>Judul</td>
                    <td>:</td>
                    <td>{{ $data->PIVOT_JUDUL }}</td>
                </tr>

                <tr>
                    <td>Nama Pembimbing</td>
                    <td>:</td>
                    <td>
                        <ol type="1" style="padding:0px 15px; margin:0px;">
                            <li>{{ $data->PIVOT_PEMBIMBING_SATU }}</li>
                            <li>{{ $data->PIVOT_PEMBIMBING_DUA }}</li>
                        </ol>
                    </td>
                </tr>


            </table>
        </div>

        <br />

        {{-- Table Tanda tangan --}}
        <div class="container" style="margin-top: 30px">
            <table width="100%">
                <tr>
                    <td width="40%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="40%">
                        Jatinangor, {{ Carbon::now('Asia/Jakarta')->format('d - m - Y') }}
                    </td>
                </tr>
                <tr>
                    <td><b>Praja</b></td>
                    <td>&nbsp;</td>
                    <td><b>Petugas Perpustakaan IPDN</b></td>
                </tr>
                <tr>
                    <td>
                        <div style="position: absolute; bottom: 70px;">
                            {{ $praja['NAMA'] }} <br />
                            <hr style="width:200px;text-align:left;margin-left:0" />
                            <b>NPP: {{ $praja['NPP'] }}</b>
                        </div>
                    </td>
                    <td>&nbsp;</td>
                    <td style="height: 110px;">
                        <div style="position: absolute">
                            <img src="tanda_tangan/{{ $data->skripsi_softcopy->user->sign }}"
                                alt="{{ $data->skripsi_softcopy->user->name }}" width="50%" />
                        </div>

                        <div style="position: absolute; bottom: 80px;">
                            {{ $data->skripsi_softcopy->user->name }}
                            <hr style="width:200px;text-align:left;margin-left:0" />
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Garis --}}
    <div style="width: 100%; position: absolute; top: 50%">
        <hr type="" />
    </div>

    {{-- Lembar Perpustakaan --}}
    <div
        style="
                position: absolute;
                top: 50%;
                width: 100%;
                height: 46%;
                border-style: solid;
                border-width: 1px;
                margin-top: 3%;
            ">
        <!-- Keterangan Arsip -->
        <p
            style="
                    top: 2px;
                    right: 20px;
                    position: absolute;
                    border-style: solid;
                    border-width: 1px;
                    padding: 5px;
                ">
            Arsip Perpustakaan
        </p>

        <div id="Judul" style="margin-top: 40px">
            <center>
                <h3>BERITA ACARA PENYERAHAN SKRIPSI PRAJA TAHUN LULUS {{ Carbon::now('Asia/Jakarta')->format('Y') }}
                </h3>
            </center>
        </div>

        <div class="container">
            Telah diterima:

            <ol type="1">
                <li>
                    1 (satu) eksemplar hardcopy skripsi
                </li>

                <li>
                    1 (satu) dokumen softcopy (PDF) skripsi melalui email: perpustakaan@ipdn.ac.id dengan
                    Subjek Email: NPP_Nama_Kelas_Judul Skripsi
                </li>
            </ol>
        </div>

        {{-- Table Identitas --}}
        <div class="container">
            <table style="width: 100%; border-style: none; padding:0px 50px;">
                <tr>
                    <td width="120px">Nama</td>
                    <td width="2px">:</td>
                    <td>{{ $praja['NAMA'] }}</td>
                </tr>

                <tr>
                    <td>NPP</td>
                    <td>:</td>
                    <td>{{ $praja['NPP'] }}</td>
                </tr>

                <tr>
                    <td>Nomor Ponsel</td>
                    <td>:</td>
                    <td>{{ $ponsel->nomor_ponsel }}</td>
                </tr>

                <tr>
                    <td>Program Studi</td>
                    <td>:</td>
                    <td>
                        {{ $praja['PROGRAM_STUDI'] }}
                    </td>
                </tr>

                <tr>
                    <td>Judul</td>
                    <td>:</td>
                    <td>{{ $data->PIVOT_JUDUL }}</td>
                </tr>

                <tr>
                    <td>Nama Pembimbing</td>
                    <td>:</td>
                    <td>
                        <ol type="1" style="padding:0px 15px; margin:0px;">
                            <li>{{ $data->PIVOT_PEMBIMBING_SATU }}</li>
                            <li>{{ $data->PIVOT_PEMBIMBING_DUA }}</li>
                        </ol>
                    </td>
                </tr>


            </table>
        </div>

        <br />

        {{-- Table Tanda tangan --}}
        <div class="container" style="margin-top: 30px">
            <table width="100%">
                <tr>
                    <td width="40%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="40%">
                        Jatinangor, {{ Carbon::now('Asia/Jakarta')->format('d - m - Y') }}
                    </td>
                </tr>
                <tr>
                    <td><b>Praja</b></td>
                    <td>&nbsp;</td>
                    <td><b>Petugas Perpustakaan IPDN</b></td>
                </tr>
                <tr>
                    <td>
                        <div style="position: absolute; bottom: 70px;">
                            {{ $praja['NAMA'] }} <br />
                            <hr style="width:200px;text-align:left;margin-left:0" />
                            <b>NPP: {{ $praja['NPP'] }}</b>
                        </div>
                    </td>
                    <td>&nbsp;</td>
                    <td style="height: 110px;">
                        <div style="position: absolute">
                            <img src="tanda_tangan/{{ $data->skripsi_softcopy->user->sign }}"
                                alt="{{ $data->skripsi_softcopy->user->name }}" width="50%" />
                        </div>

                        <div style="position: absolute; bottom: 80px;">
                            {{ $data->skripsi_softcopy->user->name }}
                            <hr style="width:200px;text-align:left;margin-left:0" />
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
