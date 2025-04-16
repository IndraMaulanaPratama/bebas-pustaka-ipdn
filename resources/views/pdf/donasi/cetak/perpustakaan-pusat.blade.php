@php
    use Illuminate\Support\Carbon;
    $date = Carbon::parse($donasi->PUSTAKA_APPROVED);
    $tanggal = $date->toDateString();
    $waktu = $date->toTimeString();
@endphp ?>

<!DOCTYPE html>
<html>

<head>

    <title>Donasi Cetak Perpustakaan Pusat</title>
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
    {{-- Lembar Praja --}}
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

        {{-- Judul Surat --}}
        <div id="Judul" style="margin-top: 40px; margin-bottom: 40px;">
            <center>
                <h3>BUKTI DONASI KOLEKSI CETAK</h3>
                <h4>PERPUSTAKAAN PUSAT IPDN JATINANGOR</h4>
                <h4>NOMOR: 000.5.6.2/BDKC-............../IPDN.18.4/2025</h4>
                {{-- <h4>NOMOR: {{ $donasi->PUSTAKA_NUMBER }} </h4> --}}
            </center>
        </div>

        {{-- Identitas --}}
        <div class="container">
            Saya yang bertandatangan dibawah ini:

            <table style="width: 100%; border-style: none; padding:0px 0px;">
                <tr>
                    <td width="120px">Nama</td>
                    <td>:</td>
                    <td>{{ $praja['NAMA'] }}</td>
                </tr>
                <tr>
                    <td>NPP</td>
                    <td>:</td>
                    <td>{{ $praja['NPP'] }}</td>
                </tr>
                <tr>
                    <td>Nomor Ponsel (WhatsApp)</td>
                    <td>:</td>
                    <td>{{ $ponsel->nomor_ponsel }}</td>
                </tr>
            </table>
        </div>

        <br />

        {{-- Data Donasi --}}
        <div class="container">
            Telah melakukan donasi buku cetak dengan identitas sebagai berikut:

            <table style="width: 100%; border-style: none; padding:0px 0px;">
                <tr>
                    <td width="120px">Judul</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Pengarang</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Penerbit</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tahun Terbit</td>
                    <td>:</td>
                    <td></td>
                </tr>
            </table>
        </div>

        {{-- Table Tanda tangan --}}
        <div class="container" style="margin-top: 20px">
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
                            <img src="{{ public_path('tanda_tangan/' . $donasi->user->sign) }}"
                                alt="{{ $donasi->user->sign }}" width="50%" />

                        </div>

                        <div style="position: absolute; bottom: 80px;">
                            {{ $donasi->user->name }}
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
                top: 52%;
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
            Arsip Perpustakaan
        </p>

        {{-- Judul Surat --}}
        <div id="Judul" style="margin-top: 40px; margin-bottom: 40px;">
            <center>
                <h3>BUKTI DONASI KOLEKSI CETAK</h3>
                <h4>PERPUSTAKAAN PUSAT IPDN JATINANGOR</h4>
                <h4>NOMOR: 000.5.6.2/BDKC-............../IPDN.18.4/2025</h4>
                {{-- <h4>NOMOR: {{ $donasi->PUSTAKA_NUMBER }} </h4> --}}
            </center>
        </div>

        {{-- Identitas --}}
        <div class="container">
            Saya yang bertandatangan dibawah ini:

            <table style="width: 100%; border-style: none; padding:0px 0px;">
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
                    <td>Nomor Ponsel (WhatsApp)</td>
                    <td>:</td>
                    <td>{{ $ponsel->nomor_ponsel }}</td>
                </tr>
            </table>
        </div>

        <br />
        {{-- Data Donasi --}}
        <div class="container" style="margin-top: 5px">
            Telah melakukan donasi buku cetak dengan identitas sebagai berikut:

            <table style="width: 100%; border-style: none; padding:0px 0px;">
                <tr>
                    <td width="120px">Judul</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Pengarang</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Penerbit</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tahun Terbit</td>
                    <td>:</td>
                    <td></td>
                </tr>
            </table>
        </div>

        {{-- Table Tanda tangan --}}
        <div class="container" style="margin-top: 20px">
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
                            <img src="{{ public_path('tanda_tangan/' . $donasi->user->sign) }}"
                                alt="{{ $donasi->user->sign }}" width="50%" />

                        </div>

                        <div style="position: absolute; bottom: 80px;">
                            {{ $donasi->user->name }}
                            <hr style="width:200px;text-align:left;margin-left:0" />
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
