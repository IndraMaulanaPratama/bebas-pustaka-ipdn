{{-- Success is as dangerous as failure. --}}
<div>

    <ol type="I">
        <li>
            <b>Bimbingan Pemustaka</b>

            <ol type="a">
                <li>
                    <b>Lokasi Verifikasi</b>

                    <p>Perpustakaan Pusat IPDN.</p>
                </li>

                <li>
                    <b>Petugas Verifikasi</b>

                    <p>
                        Lampirkan File Sprint Petugas Surat Keterangan Bebas Pustaka Tahun Akademik 2024/2025.
                    </p>
                </li>

                <li>
                    <b>Petunjuk</b>

                    <p>
                        Praja mengikuti kegiatan Bimbingan Pemustaka dengan topik Layanan SKBP, Manajemen Referensi, dan
                        Penelusuran Informasi yang diadakan oleh Unit Perpustakaan IPDN secara kolektif (per
                        wisma/kelas). Jika Praja sudah melakukan bimbingan pemustaka/sosialisasi, selanjutnya praja
                        dapat meminta verifikasi ke petugas yang melakukan bimbingan pemustaka/sosialisasi.
                    </p>
                </li>

                <li>
                    <b>Pengajuan</b>

                    <p>
                        silahkan klik tombol
                        <button wire:confirm='Anda yakin akan membuat pengajuan bimbingan pemustaka?'
                            wire:click='buatPengajuan' class="btn btn-outline-primary btn-sm" {{ $buttonCreate }}> Buat
                            Pengajuan
                        </button> untuk melakukan pengajuan pemeriksaan tahap bimbingan pemustaka.
                    </p>
                </li>
            </ol>
        </li>

    </ol>
</div>
