{{--
    Root component ieu SENGAJA mangrupa <div class="row"> anu bener (lain
    wrapper display:contents siga saméméhna) — sabab display:contents
    ngan nyingkahan wrapper-na ti KOTAK tampilan (box model), tapi TETEP
    ninggalkeun wrapper-na di jero DOM. Éta ngabalukarkeun sababaraha
    mékanisme CSS grid (utamana `gap`) teu ngahasilkeun jarak antar kartu
    sacara bener, sabab kartu-kartu di jerona teu dianggap "tetangga
    langsung" ku CSS gap sanajan sacara visual katingalina nempel jadi
    hiji baris. Ku kituna ayeuna dijieun genuine <div class="row"> supados
    gutter/jarak antar kartu jalan normal siga grid Bootstrap biasa.
--}}
<div class="row" wire:poll.5s="$refresh">

    {{--
        <style> ieu SENGAJA ditulis di jero root div (lain jadi sibling
        SAMEMEH-na) — Livewire ngan ngidinan HIJI root element per
        component. Upami <style> jadi elemen kadua di luar root div,
        Livewire bakal salah nangtukeun mana root-na nu bener, sarta
        éta ngabalukarkeun eusi component ieu bisa "leungit" sanggeus
        sababaraha kali polling (kapendak pas real testing).
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
        }

        .dashboard .total-card .card-icon {
            color: #6f42c1;
            background: #efe6fb;
        }
    </style>

    <!-- Card Total Pengajuan -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card total-card">

            <div class="card-body">
                <h5 class="card-title">Total Pengajuan <span>| Sepanjang Waktu</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-collection-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 wire:key="total-sepanjang-waktu-{{ $totalSepanjangWaktu }}" class="angka-live">
                            {{ number_format($totalSepanjangWaktu, 0, 0, '.') }}
                        </h6>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- End Total Card -->

    <!-- Card Diajukan -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">

            <div class="card-body">
                <h5 class="card-title">Diajukan <span>| Tahun Ajaran Ini</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-clockwise"></i>
                    </div>
                    <div class="ps-3">
                        <h6 wire:key="total-proses-{{ $total['proses'] }}" class="angka-live">
                            {{ number_format($total['proses'], 0, 0, '.') }}
                        </h6>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- End Sales Card -->

    <!-- Card Disetujui -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card revenue-card">

            <div class="card-body">
                <h5 class="card-title">Disetujui <span>| Tahun Ajaran Ini</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-check2-all"></i>
                    </div>
                    <div class="ps-3">
                        <h6 wire:key="total-disetujui-{{ $total['disetujui'] }}" class="angka-live">
                            {{ number_format($total['disetujui'], 0, 0, '.') }}
                        </h6>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- End Revenue Card -->

    <!-- Card Ditolak -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card customers-card">

            <div class="card-body">
                <h5 class="card-title">Ditolak <span>| Tahun Ajaran Ini</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-dash-circle"></i>
                    </div>
                    <div class="ps-3">
                        <h6 wire:key="total-ditolak-{{ $total['ditolak'] }}" class="angka-live">
                            {{ number_format($total['ditolak'], 0, 0, '.') }}
                        </h6>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- End Customers Card -->

</div>
