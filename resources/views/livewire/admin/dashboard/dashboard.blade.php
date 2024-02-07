<div>

    {{-- Bagean Resume, Aktivitas sareng Data Statistik --}}
    <div class="row">

        <!-- Bagean Kolom Katuhu -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Card Diajukan -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Diajukan <span>| Status Pengajuan</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ number_format($total['proses'], 0, 0, '.') }}</h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Card Disetujui -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Disetujui <span>| Status Pengajuan</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-check2-all"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ number_format($total['disetujui'], 0, 0, '.') }}</h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Card Ditolak -->
                <div class="col-xxl-4 col-xl-12">

                    <div class="card info-card customers-card">

                        <div class="card-body">
                            <h5 class="card-title">Ditolak <span>| Status Pengajuan</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-dash-circle"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ number_format($total['ditolak'], 0, 0, '.') }}</h6>
                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- End Customers Card -->

                <!-- Laporan Padamelan -->
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">Statistik Kegiatan Aplikasi <span>| {{ Date('d M Y') }} </span></h5>

                            <!-- Line Chart -->
                            <div id="reportsChart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#reportsChart"), {
                                        series: [{
                                            name: 'Pengajuan Baru',
                                            data: [31, 40, 28, 51, 42, 82, 56, 82, null, null, null, null, null, null, null,
                                                null, null, null
                                            ],
                                        }, {
                                            name: 'Penyetujuan',
                                            data: [11, 32, 45, 32, 34, 52, 41, 10, null, null, null, null, null, null, null,
                                                null, null, null
                                            ]
                                        }, {
                                            name: 'Penolakan',
                                            data: [15, 11, 32, 18, 9, 24, 11, 40, null, null, null, null, null, null, null,
                                                null, null, null
                                            ]
                                        }],
                                        chart: {
                                            height: 350,
                                            type: 'area',
                                            toolbar: {
                                                show: false
                                            },
                                        },
                                        markers: {
                                            size: 4
                                        },
                                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                        fill: {
                                            type: "gradient",
                                            gradient: {
                                                shadeIntensity: 1,
                                                opacityFrom: 0.3,
                                                opacityTo: 0.4,
                                                stops: [0, 90, 500]
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            curve: 'smooth',
                                            width: 3
                                        },
                                        xaxis: {
                                            type: 'datetime',
                                            categories: [
                                                "{{ Date('Y-m-d') }}T08:00:00.000Z", "{{ Date('Y-m-d') }}T08:30:00.000Z",
                                                "{{ Date('Y-m-d') }}T09:00:00.000Z", "{{ Date('Y-m-d') }}T09:30:00.000Z",
                                                "{{ Date('Y-m-d') }}T10:00:00.000Z", "{{ Date('Y-m-d') }}T10:30:00.000Z",
                                                "{{ Date('Y-m-d') }}T11:00:00.000Z", "{{ Date('Y-m-d') }}T11:30:00.000Z",
                                                "{{ Date('Y-m-d') }}T12:00:00.000Z", "{{ Date('Y-m-d') }}T12:30:00.000Z",
                                                "{{ Date('Y-m-d') }}T13:00:00.000Z", "{{ Date('Y-m-d') }}T13:30:00.000Z",
                                                "{{ Date('Y-m-d') }}T14:00:00.000Z", "{{ Date('Y-m-d') }}T14:30:00.000Z",
                                                "{{ Date('Y-m-d') }}T15:00:00.000Z", "{{ Date('Y-m-d') }}T15:30:00.000Z",
                                                "{{ Date('Y-m-d') }}T16:00:00.000Z", "{{ Date('Y-m-d') }}T16:30:00.000Z",
                                            ]
                                        },
                                        tooltip: {
                                            x: {
                                                format: 'd-M-yyyy HH:mm'
                                            },
                                        }
                                    }).render();
                                });
                            </script>
                            <!-- End Line Chart -->

                        </div>

                    </div>
                </div><!-- End Laporan Padamelan -->

            </div>
        </div><!-- End Bagean Kolom Katuhu -->

        <!-- Bagean Kolom Kenca -->
        <div class="col-lg-4">

            <!-- Aktivitas Terbaru -->
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">Aktivitas Terbaru <span>| {{ $date }}</span></h5>

                    <div class="activity">

                        <div class="activity-item d-flex">
                            <div class="activite-label" style="min-width: 0%"></div>
                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                            <div class="activity-content">
                                <b class="fw-bold text-dark">Rama Wirahma</b> Memperbarui dashboard
                                pada tampilan admin
                                - <small>{{ $dateTime->diffForHumans() }}</small>
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label" style="min-width: 0%"></div>
                            <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                            <div class="activity-content">
                                <b class="fw-bold text-dark">Rama Wirahma</b> Memperbarui dashboard
                                pada tampilan admin
                                - <small>{{ $dateTime->diffForHumans() }}</small>
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label" style="min-width: 0%"></div>
                            <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                            <div class="activity-content">
                                <b class="fw-bold text-dark">Rama Wirahma</b> Memperbarui dashboard
                                pada tampilan admin
                                - <small>{{ $dateTime->diffForHumans() }}</small>
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label" style="min-width: 0%"></div>
                            <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                            <div class="activity-content">
                                <b class="fw-bold text-dark">Rama Wirahma</b> Memperbarui dashboard
                                pada tampilan admin
                                - <small>{{ $dateTime->diffForHumans() }}</small>
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label" style="min-width: 0%"></div>
                            <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                            <div class="activity-content">
                                <b class="fw-bold text-dark">Rama Wirahma</b> Memperbarui dashboard
                                pada tampilan admin
                                - <small>{{ $dateTime->diffForHumans() }}</small>
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label" style="min-width: 0%"></div>
                            <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                            <div class="activity-content">
                                <b class="fw-bold text-dark">Rama Wirahma</b> Memperbarui dashboard
                                pada tampilan admin
                                - <small>{{ $dateTime->diffForHumans() }}</small>
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label" style="min-width: 0%"></div>
                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                            <div class="activity-content">
                                <b class="fw-bold text-dark">Rama Wirahma</b> Memperbarui dashboard
                                pada tampilan admin
                                - <small>{{ $dateTime->diffForHumans() }}</small>
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label" style="min-width: 0%"></div>
                            <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                            <div class="activity-content">
                                <b class="fw-bold text-dark">Rama Wirahma</b> Memperbarui dashboard
                                pada tampilan admin
                                - <small>{{ $dateTime->diffForHumans() }}</small>
                            </div>
                        </div><!-- End activity item-->

                        <div class="activity-item d-flex">
                            <div class="activite-label" style="min-width: 0%"></div>
                            <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                            <div class="activity-content">
                                <b class="fw-bold text-dark">Rama Wirahma</b> Memperbarui dashboard
                                pada tampilan admin
                                - <small>{{ $dateTime->diffForHumans() }}</small>
                            </div>
                        </div><!-- End activity item-->

                    </div>

                </div>
            </div><!-- End Recent Activity -->

        </div><!-- End Bagean Kolom Kenca -->

    </div>

    {{-- Bagean Ringkasan Pengajuan --}}
    <div class="row">

        <!-- Ringkasan Pengajuan -->
        <div class="col-12">
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
                            {{-- Similaritas --}}
                            <tr>
                                <td>1</td>
                                <td>Similaritas</td>
                                <td> {{ number_format($data['proses']['similaritas'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['similaritas'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['similaritas'], 0, 0, '.') }} </td>

                            </tr>

                            {{-- Pinjaman Pustaka --}}
                            <tr>
                                <td>2</td>
                                <td>Pinjaman Perpustakaan Pusat</td>
                                <td> {{ number_format($data['proses']['pinjaman_pustaka'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['pinjaman_pustaka'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['pinjaman_pustaka'], 0, 0, '.') }} </td>

                            </tr>

                            {{-- Pinjaman Fakultas --}}
                            <tr>
                                <td>3</td>
                                <td>Pinjaman Perpustakaan Fakultas</td>
                                <td> {{ number_format($data['proses']['pinjaman_fakultas'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['pinjaman_fakultas'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['pinjaman_fakultas'], 0, 0, '.') }} </td>

                            </tr>

                            {{-- Donasi Buku Perpustakaan Pusat --}}
                            <tr>
                                <td>4</td>
                                <td>Donasi Buku Perpustakaan Pusat</td>
                                <td> {{ number_format($data['proses']['donasi_pustaka'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['donasi_pustaka'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['donasi_pustaka'], 0, 0, '.') }} </td>

                            </tr>

                            {{-- Donasi Buku Perpustakaan Fakultas --}}
                            <tr>
                                <td>5</td>
                                <td>Donasi Buku Perpustakaan Fakultas</td>
                                <td> {{ number_format($data['proses']['donasi_fakultas'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['donasi_fakultas'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['donasi_fakultas'], 0, 0, '.') }} </td>

                            </tr>

                            {{-- Donasi poin Perpustakaan --}}
                            <tr>
                                <td>6</td>
                                <td>Donasi Poin Perpustakaan</td>
                                <td> {{ number_format($data['proses']['donasi_poin'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['donasi_poin'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['donasi_poin'], 0, 0, '.') }} </td>

                            </tr>


                            {{-- Pengisian Survei Praja --}}
                            <tr>
                                <td>7</td>
                                <td>Survei Perpustakaan</td>
                                <td> {{ number_format($data['proses']['survey'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['survey'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['survey'], 0, 0, '.') }} </td>

                            </tr>

                            {{-- Konten Literasi --}}
                            <tr>
                                <td>8</td>
                                <td>Konten Literasi</td>
                                <td> {{ number_format($data['proses']['konten_literasi'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['konten_literasi'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['konten_literasi'], 0, 0, '.') }} </td>

                            </tr>

                            {{-- Unggah Repository --}}
                            <tr>
                                <td>9</td>
                                <td>Unggah Repository</td>
                                <td> {{ number_format($data['proses']['repository'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['repository'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['repository'], 0, 0, '.') }} </td>

                            </tr>

                            {{-- Copy Pustaka --}}
                            <tr>
                                <td>10</td>
                                <td>Hard Copy Skripsi Perpustakaan Pusat</td>
                                <td> {{ number_format($data['proses']['copy_pustaka'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['copy_pustaka'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['copy_pustaka'], 0, 0, '.') }} </td>

                            </tr>

                            {{-- Copy Fakultas --}}
                            <tr>
                                <td>11</td>
                                <td>Hard Copy Skripsi Perpustakaan Fakultas</td>
                                <td> {{ number_format($data['proses']['copy_fakultas'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['copy_fakultas'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['copy_fakultas'], 0, 0, '.') }} </td>

                            </tr>

                            {{-- Copy Fakultas --}}
                            <tr>
                                <td>12</td>
                                <td>Soft Copy Skripsi</td>
                                <td> {{ number_format($data['proses']['copy_skripsi'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['disetujui']['copy_skripsi'], 0, 0, '.') }} </td>
                                <td> {{ number_format($data['ditolak']['copy_skripsi'], 0, 0, '.') }} </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>
        </div><!-- End Top Selling -->

    </div>

</div>
