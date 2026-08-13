<div>

    {{-- Bagean Resume, Aktivitas sareng Data Statistik --}}
    <div class="row">

        <!-- Bagean Kolom Katuhu -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Kartu Diajukan / Disetujui / Ditolak -->
                <livewire:admin.dashboard.ringkasan-kartu />

                <!-- Laporan Padamelan -->
                <div class="col-12">
                    <div class="card">

                        <div class="card-body" id="statistik-kegiatan">
                            <h5 class="card-title">Statistik Kegiatan Aplikasi <span>| {{ Date('d M Y') }} </span></h5>

                            <!-- Line Chart -->
                            <livewire:admin.dashboard.statistik-kegiatan />
                            <!-- End Line Chart -->

                        </div>

                    </div>
                </div><!-- End Laporan Padamelan -->

            </div>
        </div><!-- End Bagean Kolom Katuhu -->

        <!-- Bagean Kolom Kenca -->
        <div class="col-lg-4">

            <!-- Aktivitas Terbaru -->
            <div class="card" id="recent-activity">

                <div class="card-body">
                    <h5 class="card-title">Aktivitas Terbaru <span>| {{ $date }}</span></h5>

                    <div class="activity">
                        <livewire:admin.dashboard.recent-activity />
                    </div>

                </div>
            </div><!-- End Recent Activity -->

        </div><!-- End Bagean Kolom Kenca -->

    </div>

    {{-- Bagean Ringkasan Pengajuan --}}
    <div class="row">
        <livewire:admin.dashboard.ringkasan-pengajuan />
    </div>

</div>
