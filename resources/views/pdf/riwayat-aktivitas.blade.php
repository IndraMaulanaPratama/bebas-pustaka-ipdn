<!DOCTYPE html>
<html>

<head>
    <title>Laporan Riwayat Aktivitas</title>
    <style type="text/css">
        body {
            font-family: sans-serif;
            font-size: 9pt;
            color: #1a1a1a;
        }

        h2 {
            margin-bottom: 2px;
        }

        .subtitle {
            font-size: 9pt;
            color: #555;
            margin-bottom: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 4px 6px;
            text-align: left;
            vertical-align: top;
        }

        table th {
            background-color: #f1f1f1;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            color: #fff;
            font-size: 8pt;
        }

        .bg-success {
            background-color: #2eca6a;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .bg-primary {
            background-color: #4154f1;
        }

        .bg-info {
            background-color: #17a2b8;
        }

        .bg-warning {
            background-color: #ff771d;
        }

        .bg-secondary {
            background-color: #6c757d;
        }

        .bg-muted {
            background-color: #adb5bd;
        }
    </style>
</head>

<body>
    <h2>Laporan Riwayat Aktivitas</h2>
    <div class="subtitle">
        Dicetak pada {{ $tanggalCetak }}
        @if ($ringkasanFilter)
            &mdash; Filter: {{ $ringkasanFilter }}
        @endif
        &mdash; Total {{ $logs->count() }} aktivitas
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No.</th>
                <th width="10%">Waktu</th>
                <th width="12%">Petugas</th>
                <th width="12%">Modul</th>
                <th width="10%">Jenis Kegiatan</th>
                <th width="33%">Deskripsi</th>
                <th width="20%">Catatan/Alasan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ optional($log->created_at)->locale('id')->translatedFormat('d M Y H:i') }}</td>
                    <td>{{ $log->user_name ?? 'Sistem' }}</td>
                    <td>{{ $log->module }}</td>
                    <td>
                        <span class="badge bg-{{ $log->action_color }}">{{ $log->action_label }}</span>
                    </td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->properties['alasan_penolakan'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada aktivitas yang sesuai dengan filter yang dipilih.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
