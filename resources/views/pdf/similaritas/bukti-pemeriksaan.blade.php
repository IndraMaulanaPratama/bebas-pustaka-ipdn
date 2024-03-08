@php
    use Illuminate\Support\Carbon;
    $date = Carbon::parse($similaritas->SIMILARITAS_APPROVED);
    $tanggal = $date->toDateString();
    $waktu = $date->toTimeString();
    $bibliografi = $similaritas->SIMILARITAS_BIBLIOGRAFI == 1 ? 'checked' : null;
    $smallWord = $similaritas->SIMILARITAS_SMALL_WORD == 1 ? 'checked' : null;
    $quote = $similaritas->SIMILARITAS_QUOTE == 1 ? 'checked' : null;
@endphp ?>

<!DOCTYPE html>
<html>

<head>

    <title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
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
                <h3>BUKTI PEMERIKSAAN SIMILARITAS</h3>
                <h4>PERPUSTAKAAN PUSAT IPDN JATINANGOR</h4>
                <h4>NOMOR: {{ $similaritas->SIMILARITAS_NUMBER }} </h4>
            </center>
        </div>

        {{-- Table Identitas --}}
        <div class="container">
            <table style="width: 100%; border-style: none">
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
                <tr>
                    <td><i>Class Name</i> dan No. Absen</td>
                    <td>:</td>
                    <td>
                        {{ $similaritas->SIMILARITAS_CLASS }} - {{ $similaritas->SIMILARITAS_ABSENT }}
                    </td>
                </tr>
            </table>
        </div>

        <br />
        {{-- Table Data Similaritas --}}
        <div class="container">
            <table width="100%" class="table">
                {{-- THEAD --}}
                <tr class="tr">
                    <th class="th">TANGGAL UPLOAD</th>
                    <th class="th">PUKUL</th>
                    <th class="th">EXCLUDE</th>
                    <th class="th">SIMILARITAS</th>
                </tr>

                {{-- TBODY --}}
                <tr>
                    <th class="th" rowspan="3">
                        <h3>{{ $tanggal }}</h3>
                    </th>
                    <th class="th" rowspan="3">
                        <h3>{{ $waktu }}</h3>
                    </th>
                    <td class="td">
                        <input type="checkbox" {{ $bibliografi }} /> &nbsp;
                        DATA BIBLIOGRAFI
                    </td>
                    <th class="th" rowspan="3">
                        <h3>{{ $similaritas->SIMILARITAS_VALUE }} %</h3>
                    </th>
                </tr>

                <tr class="tr">
                    <td
                        style="
                                line-height: 5%;
                                display: inline-block;
                                vertical-align: middle;
                            ">
                        <input type="checkbox" {{ $smallWord }} /> &nbsp;
                        <label for="smallWord"> SMALL WORD</label> &nbsp;
                        <b>( {{ $similaritas->SIMILARITAS_SMALL_WORD_COUNT }}
                            )</b>
                    </td>
                </tr>
                <tr class="tr">
                    <td class="td">
                        <input type="checkbox" {{ $quote }} /> &nbsp; QUOTE
                        MATERIALS
                    </td>
                </tr>
            </table>
        </div>

        {{-- Table Tanda tangan --}}
        <div class="container" style="margin-top: 5px">
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
                    <td height="200px">
                        {{ $praja['NAMA'] }} <br />
                        <hr style="width:200px;text-align:left;margin-left:0" />
                        <b>NPP: {{ $praja['NPP'] }}</b>
                    </td>
                    <td>&nbsp;</td>
                    <td style="height: 110px;">
                        <div style="position: absolute">
                            <img src="storage/tanda_tangan/{{ $similaritas->user->sign }}"
                                alt="{{ $similaritas->user->name }}" width="50%" />
                        </div>

                        <div style="position: absolute; bottom: 30px;">
                            {{ $similaritas->user->name }}
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
                <h3>BUKTI PEMERIKSAAN SIMILARITAS</h3>
                <h4>PERPUSTAKAAN PUSAT IPDN JATINANGOR</h4>
                <h4>NOMOR: {{ $similaritas->SIMILARITAS_NUMBER }} </h4>
            </center>
        </div>

        {{-- Table Identitas --}}
        <div class="container">
            <table style="width: 100%; border-style: none">
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
                <tr>
                    <td><i>Class Name</i> dan No. Absen</td>
                    <td>:</td>
                    <td>
                        {{ $similaritas->SIMILARITAS_CLASS }} - {{ $similaritas->SIMILARITAS_ABSENT }}
                    </td>
                </tr>
            </table>
        </div>

        <br />
        {{-- Table Data Similaritas --}}
        <div class="container">
            <table width="100%" class="table">
                {{-- THEAD --}}
                <tr class="tr">
                    <th class="th">TANGGAL UPLOAD</th>
                    <th class="th">PUKUL</th>
                    <th class="th">EXCLUDE</th>
                    <th class="th">SIMILARITAS</th>
                </tr>

                {{-- TBODY --}}
                <tr>
                    <th class="th" rowspan="3">
                        <h3>{{ $tanggal }}</h3>
                    </th>
                    <th class="th" rowspan="3">
                        <h3>{{ $waktu }}</h3>
                    </th>
                    <td class="td">
                        <input type="checkbox" {{ $bibliografi }} /> &nbsp;
                        DATA BIBLIOGRAFI
                    </td>
                    <th class="th" rowspan="3">
                        <h3>{{ $similaritas->SIMILARITAS_VALUE }} %</h3>
                    </th>
                </tr>

                <tr class="tr">
                    <td
                        style="
                                line-height: 5%;
                                display: inline-block;
                                vertical-align: middle;
                            ">
                        <input type="checkbox" {{ $smallWord }} /> &nbsp;
                        <label for="smallWord"> SMALL WORD</label> &nbsp;
                        <b>( {{ $similaritas->SIMILARITAS_SMALL_WORD_COUNT }}
                            )</b>
                    </td>
                </tr>
                <tr class="tr">
                    <td class="td">
                        <input type="checkbox" {{ $quote }} /> &nbsp; QUOTE
                        MATERIALS
                    </td>
                </tr>
            </table>
        </div>

        {{-- Table Tanda tangan --}}
        <div class="container" style="margin-top: 5px">
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

                        <div style="position: absolute; bottom: 20px;">
                            {{ $praja['NAMA'] }} <br />
                            <hr style="width:200px;text-align:left;margin-left:0" />
                            <b>NPP: {{ $praja['NPP'] }}</b>
                        </div>
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td style="height: 110px;">
                        <div style="position: absolute">
                            <img src="storage/tanda_tangan/{{ $similaritas->user->sign }}"
                                alt="{{ $similaritas->user->name }}" width="50%" />
                        </div>

                        <div style="position: absolute; bottom: 30px;">
                            {{ $similaritas->user->name }}
                            <hr style="width:200px;text-align:left;margin-left:0" />
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
