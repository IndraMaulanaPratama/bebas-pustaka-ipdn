<div class="col-12">
    <div>
        <x-admin.components.card.card size=12 title="Riwayat Aktivitas" titleSpan='Jejak Audit Aplikasi'>

            {{-- Baris tombol export data --}}
            <div class="row justify-content-between g-2">

                <div class="w-auto d-flex gap-2">
                    {{-- Button Export Excel --}}
                    <div wire:confirm='Apakah data riwayat aktivitas yang akan diexport (sesuai filter yang aktif) sudah sesuai?'
                        wire:click='exportExcel'>
                        <x-admin.components.button.icon-button text="Export Excel" icon="bi-file-earmark-excel-fill"
                            color="success" />
                    </div>

                    {{-- Button Export PDF --}}
                    <div wire:confirm='Apakah data riwayat aktivitas yang akan diexport (sesuai filter yang aktif) sudah sesuai?'
                        wire:click='exportPdf'>
                        <x-admin.components.button.icon-button text="Export PDF" icon="bi-file-earmark-pdf-fill"
                            color="danger" />
                    </div>

                    {{-- Button Reset Filter --}}
                    <div wire:click='resetFilter'>
                        <x-admin.components.button.icon-button text="Reset Filter" icon="bi-arrow-counterclockwise"
                            color="outline-secondary" />
                    </div>
                </div>

                {{-- Input Pencarian Bebas --}}
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-admin.components.form.input size=12 type='text' name='search'
                        placeholder='Cari deskripsi / nama petugas / NPP' />
                </div>
            </div>

            <hr />

            {{-- Opsi Filter --}}
            <div class="row g-2 mb-4">

                {{-- Tanggal Mulai --}}
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                    <x-admin.components.form.input size=12 type='date' name='filterDateStart'
                        placeholder='Dari Tanggal' />
                </div>

                {{-- Tanggal Akhir --}}
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                    <x-admin.components.form.input size=12 type='date' name='filterDateEnd'
                        placeholder='Sampai Tanggal' />
                </div>

                {{-- Filter Modul --}}
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <x-admin.components.form.select size='12' name='filterModule' placeholder='Semua Modul'>
                        @foreach ($modules as $module)
                            <option value="{{ $module }}">{{ $module }}</option>
                        @endforeach
                    </x-admin.components.form.select>
                </div>

                {{-- Filter Jenis Kegiatan --}}
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                    <x-admin.components.form.select size='12' name='filterAction' placeholder='Semua Kegiatan'>
                        @foreach ($actionOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-admin.components.form.select>
                </div>

                {{-- Filter Petugas --}}
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <x-admin.components.form.select size='12' name='filterUser' placeholder='Semua Petugas/Pengguna'>
                        @foreach ($users as $user)
                            <option value="{{ $user }}">{{ $user }}</option>
                        @endforeach
                    </x-admin.components.form.select>
                </div>

                {{-- Jumlah Data per Halaman --}}
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                    <x-admin.components.form.select size='12' name='perPage' placeholder='Data per Halaman'>
                        <option value="10">10 data</option>
                        <option value="20" selected>20 data</option>
                        <option value="50">50 data</option>
                        <option value="100">100 data</option>
                    </x-admin.components.form.select>
                </div>

            </div>

            {{-- Data Table Riwayat Aktivitas --}}
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="min-width: 3.5cm">Waktu</th>
                            <th style="min-width: 6cm">Petugas</th>
                            <th style="min-width: 3cm">Modul</th>
                            <th style="min-width: 3cm">Jenis Kegiatan</th>
                            <th style="min-width: 8cm">Deskripsi</th>
                            <th>Detail</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td scope="row"> {{ $loop->index + $logs->firstItem() }} </td>
                                <td>
                                    {{ $log->created_at->locale('id')->translatedFormat('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $log->created_at->locale('id')->translatedFormat('H:i:s') }}</small>
                                </td>
                                <td>
                                    {{ $log->user_name ?? 'Sistem' }}
                                    @if ($log->user_role)
                                        <br><small class="text-muted">{{ $log->user_role }}</small>
                                    @endif
                                </td>
                                <td>{{ $log->module }}</td>
                                <td>
                                    <span class="badge bg-{{ $log->action_color }}">
                                        <i class="bi {{ $log->action_icon }}"></i> &nbsp;{{ $log->action_label }}
                                    </span>
                                </td>
                                <td>{{ $log->description }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#modalDetailLog-{{ $log->id }}">
                                        <i class="bi bi-info-circle"></i>
                                    </button>

                                    <x-admin.components.modal.modal id="modalDetailLog-{{ $log->id }}" size='lg'>
                                        <x-admin.components.modal.header id="modalDetailLog-{{ $log->id }}"
                                            title="Detail Aktivitas" />
                                        <div class="modal-body">

                                            @if (!empty($log->properties))
                                                <h6 class="text-muted text-uppercase small mb-2">Detail Tambahan</h6>
                                                <ul class="list-group mb-3">
                                                    @foreach ($log->properties as $key => $value)
                                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                                            <span class="fw-bold">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                                            <span class="text-end">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                            <h6 class="text-muted text-uppercase small mb-2">Informasi Teknis</h6>
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <span class="fw-bold">Alamat IP</span>
                                                    <span class="text-end">{{ $log->ip_address ?? '-' }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                                    <span class="fw-bold">Perangkat/Browser</span>
                                                    <span class="text-end">{{ $log->perangkat_label }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </x-admin.components.modal.modal>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Tidak ada aktivitas yang sesuai dengan filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination data table --}}
            @if ($logs->total() > 0)
                <x-admin.tamplates.paginate.paginate :item="$logs" />
            @endif

        </x-admin.components.card.card>
    </div>
</div>
