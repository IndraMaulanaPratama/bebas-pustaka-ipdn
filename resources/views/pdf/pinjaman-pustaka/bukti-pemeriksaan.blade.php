@php
    use Illuminate\Support\Carbon;
    $date = Carbon::parse($pinjaman->PUSTAKA_APPROVED);
    $tanggal = $date->toDateString();
    $waktu = $date->toTimeString();
    $bibliografi = $pinjaman->PUSTAKA_BIBLIOGRAFI == 1 ? 'checked' : null;
    $smallWord = $pinjaman->PUSTAKA_SMALL_WORD == 1 ? 'checked' : null;
    $quote = $pinjaman->PUSTAKA_QUOTE == 1 ? 'checked' : null;
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
    {{-- Lembar Perpustakaan --}}
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
                <h3>BUKTI BEBAS PEMINJAMAN BUKU/KOLEKSI</h3>
                <h4>PERPUSTAKAAN PUSAT IPDN JATINANGOR</h4>
                <h4>NOMOR: {{ $pinjaman->PUSTAKA_NUMBER }}</h4>
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
            </table>
        </div>

        <br />

        {{-- Table Data Pinjaman --}}
        <p class="container" style="text-indent: 5px">
            Tidak mempunyai tanggungan peminjaman buku/ koleksi di Perpustakaan Pusat IPDN Jatinangor.
            Bukti ini merupakan salah satu syarat mengikuti Sidang Akhir Skripsi (Sidang Komprehensif), yang
            kemudian sebagai dasar diterbitkannya Surat Keterangan Bebas Pustaka. Demikian untuk dapat
            dipergunakan sebagaimana mestinya.
        </p>

        {{-- Table Tanda tangan --}}
        <div class="container" style="margin-top: 50px">
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
                            <img src="tanda_tangan/{{ $pinjaman->user->sign }}" alt="{{ $pinjaman->user->name }}"
                                width="50%" />
                        </div>

                        <div style="position: absolute; bottom: 80px;">
                            {{ $pinjaman->user->name }}
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

    {{-- Lembar Arsip --}}
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
                <h3>BUKTI BEBAS PEMINJAMAN BUKU/KOLEKSI</h3>
                <h4>PERPUSTAKAAN PUSAT IPDN JATINANGOR</h4>
                <h4>NOMOR: {{ $pinjaman->PUSTAKA_NUMBER }}</h4>
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
            </table>
        </div>

        <br />

        {{-- Table Data Pinjaman --}}
        <p class="container" style="text-indent: 5px">
            Tidak mempunyai tanggungan peminjaman buku/ koleksi di Perpustakaan Pusat IPDN Jatinangor.
            Bukti ini merupakan salah satu syarat mengikuti Sidang Akhir Skripsi (Sidang Komprehensif), yang
            kemudian sebagai dasar diterbitkannya Surat Keterangan Bebas Pustaka. Demikian untuk dapat
            dipergunakan sebagaimana mestinya.
        </p>

        {{-- Table Tanda tangan --}}
        <div class="container" style="margin-top: 50px">
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
                            <img src="tanda_tangan/{{ $pinjaman->user->sign }}" alt="{{ $pinjaman->user->name }}"
                                width="50%" />
                        </div>

                        <div style="position: absolute; bottom: 80px;">
                            {{ $pinjaman->user->name }}
                            <hr style="width:200px;text-align:left;margin-left:0" />
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
