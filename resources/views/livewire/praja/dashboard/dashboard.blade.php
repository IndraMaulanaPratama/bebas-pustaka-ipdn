<div class="row g-4">

    {{-- Bagean Kenca --}}
    <div class="col-lg-7 col-md-7 col-sm-12">
        <div class="row">
            <x-admin.components.card.card title='Progres Pengajuan' titleSpan='Bebas Pustaka'>

                <div class="table-responsive">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th class="col-9" style="min-width: 10cm">Nama Pengajuan</th>
                                <th class="col-2">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 0; ?>
                            @foreach ($data as $item)
                                @php
                                    $buttonApprove = 'hidden';
                                    $buttonReject = 'hidden';
                                    $no++;

                                    if ($item['status'] == 'Proses') {
                                        $colorStatus = 'primary';
                                        $iconStatus = 'bi-arrow-clockwise me-1';
                                        $buttonApprove = null;
                                        $buttonReject = null;
                                    } elseif ($item['status'] == 'Disetujui') {
                                        $colorStatus = 'success';
                                        $iconStatus = 'bi-check2-all me-1';
                                    } elseif ($item['status'] == 'Ditolak') {
                                        $colorStatus = 'danger';
                                        $iconStatus = 'bi-dash-circle-fill me-1';
                                    } elseif ($item['status'] == 'Belum ada pengajuan') {
                                        $colorStatus = 'secondary';
                                        $iconStatus = 'bi-info-circle me-1';
                                    }
                                @endphp

                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item['pengajuan'] }}</td>
                                    <td>
                                        <span class="badge bg-{{ $colorStatus }}"><i
                                                class="bi {{ $iconStatus }}"></i>
                                            {{ $item['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>

            </x-admin.components.card.card>
        </div>
    </div>

    {{-- Bagean Katuhu --}}
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="row">

            {{-- Penerbitas Surat Bebas Pustaka --}}
            <div {{ $resume == true ? null : 'hidden' }}>
                <x-admin.components.card.card title='Keterangan Bebas Pustaka' titleSpan='Ringkasan'>

                    {{-- Terbitkan SKBP --}}
                    <div {{ $buttonPrint == true ? 'hidden' : null }}>
                        <button class="btn btn-sm btn-info" wire:click='buatSurat'>Generate Surat Keterangan Bebas
                            Pustaka</button>
                    </div>

                    {{-- Done --}}
                    <div {{ $buttonPrint == false ? 'hidden' : null }}>
                        <p>
                            <b>Selamat, Anda sudah menyelesaikan bebas pustaka</b>
                        </p>

                        <p>
                            Silahkan cetak <b>Surat Keterangan Bebas Pustaka</b> Anda di <b>Gedung Perpustakaan Pusat
                                Lt.3</b> (Copy Center Area)
                        </p>
                    </div>

                </x-admin.components.card.card>
            </div>

            {{-- Surat Tugas Bebas Pustaka --}}
            <x-admin.components.card.card title="Surat Tugas Bebas Pustaka" titleSpan='Unduh dokumen'>

                <p>
                    Berikut adalah dokumen yang berisikan informasi terkait <b>surat tugas dan petugas di setiap
                        unit</b> untuk pelayanan bebas pustaka:
                </p>

                <a href="{{ asset('storage/dokumen/' . $sprint->SETTING_SPRINT) }}" target="_" class="btn btn-sm btn-outline-primary">Unduh
                    dokumen</a>

            </x-admin.components.card.card>

        </div>

    </div>

</div>
