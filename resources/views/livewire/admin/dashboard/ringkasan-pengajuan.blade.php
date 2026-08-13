<div class="col-12" wire:poll.5s="$refresh">

    {{--
        <style> ieu SENGAJA ditulis di jero root div (lain jadi sibling
        SAMEMEH-na) — Livewire ngan ngidinan HIJI root element per
        component. Upami <style> jadi elemen kadua di luar root div,
        component ieu bisa "leungit" sanggeus sababaraha kali polling
        (kapendak pas real testing, sarua siga kajadian di RingkasanKartu).
    --}}
    <style>
        @keyframes angka-live-flash {
            0% {
                background-color: rgba(65, 84, 241, 0.18);
            }

            100% {
                background-color: transparent;
            }
        }

        .angka-live {
            display: inline-block;
            border-radius: 6px;
            animation: angka-live-flash 1s ease-out;
            padding: 0 4px;
        }
    </style>
    <div class="card top-selling overflow-auto">

        <div class="card-body pb-0">
            <h5 class="card-title">Ringkasan Pengajuan <span>| Periode tahun {{ Date('Y') }}</span></h5>

            <table class="table table-borderless table-hover">

                <thead>
                    <tr>
                        <th scope="col" style="max-width: 10ch">No.</th>
                        <th scope="col" style="min-width: 10cm">Nama Pengajuan</th>

                        <th scope="col">
                            <span class="badge bg-primary">
                                <i class="bi bi-arrow-clockwise me-1"></i>
                                Dalam Proses
                            </span>
                        </th>

                        <th scope="col">
                            <span class="badge bg-success">
                                <i class="bi bi-check2-all me-1"></i>
                                Disetujui
                            </span>
                        </th>

                        <th scope="col">
                            <span class="badge bg-danger">
                                <i class="bi bi-dash-circle me-1"></i>
                                Ditolak
                            </span>
                        </th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($modules as $key => $label)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $label }}</td>
                            <td>
                                <span wire:key="proses-{{ $key }}-{{ $data['proses'][$key] }}" class="angka-live">
                                    {{ number_format($data['proses'][$key], 0, 0, '.') }}
                                </span>
                            </td>
                            <td>
                                <span wire:key="disetujui-{{ $key }}-{{ $data['disetujui'][$key] }}" class="angka-live">
                                    {{ number_format($data['disetujui'][$key], 0, 0, '.') }}
                                </span>
                            </td>
                            <td>
                                <span wire:key="ditolak-{{ $key }}-{{ $data['ditolak'][$key] }}" class="angka-live">
                                    {{ number_format($data['ditolak'][$key], 0, 0, '.') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>
</div>
