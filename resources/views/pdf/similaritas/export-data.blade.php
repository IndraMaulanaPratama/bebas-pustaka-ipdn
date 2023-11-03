<!DOCTYPE html>
<html>

<head>
    <title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>


    <table class="table table-responsive table-hover">
        <thead>
            <tr>
                {{-- <th scope="col" width=3%>#</th> --}}
                <th scope="col">NPM</th>
                <th scope="col" width=50%>Judul Skripsi</th>
                <th scope="col">Nama Kelas</th>
                <th scope="col">Nomor Absen</th>
                <th scope="col">Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($similaritas as $item)
                <tr>
                    {{-- <th scope="row"> {{ $loop->index + 1 }} </th> --}}
                    <td>{{ $item->SIMILARITAS_PRAJA }}</td>
                    <td> {{ $item->SIMILARITAS_TITLE }} </td>
                    <td> {{ $item->SIMILARITAS_CLASS }} </td>
                    <td> {{ $item->SIMILARITAS_ABSENT }} </td>
                    <td>{{ $item->SIMILARITAS_STATUS }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
