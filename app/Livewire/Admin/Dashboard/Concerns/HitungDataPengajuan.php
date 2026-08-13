<?php

namespace App\Livewire\Admin\Dashboard\Concerns;

use App\Models\bimbingan_pemustaka;
use App\Models\DonasiElektronik;
use App\Models\DonasiFakultas;
use App\Models\DonasiPustaka;
use App\Models\KontenLiterasi;
use App\Models\PinjamanFakultas;
use App\Models\PinjamanPustaka;
use App\Models\Repository;
use App\Models\Similaritas;
use App\Models\SkripsiFakultas;
use App\Models\SkripsiPerpustakaan;
use App\Models\SkripsiSoftcopy;
use App\Models\Survey;

/**
 * Logika ngitung jumlah pengajuan per modul/status (dipaké ku kartu
 * Diajukan/Disetujui/Ditolak sareng tabel Ringkasan Pengajuan di dashboard).
 * Dijieun trait misah (dulu aya di jero Dashboard.php) supados tiasa
 * dianggo bareng ku dua komponen Livewire anu misah (RingkasanKartu jeung
 * RingkasanPengajuan), sarta masing-masing tiasa polling nyalira tanpa
 * ngitung ulang statistik séjén di dashboard utama.
 *
 * Catetan: data ieu ngitung sapanjang tahun ajaran ayeuna (sanes 24 jam
 * siga grafik Statistik Kegiatan), sabab mémang kanggo laporan rekap
 * tahunan, sanes laporan harian.
 */
trait HitungDataPengajuan
{
    /**
     * Nami modul anu ditembongkeun di tabel Ringkasan Pengajuan, dumasar
     * kana urutan nu sarua siga saméméhna. Ditambihan di dieu (lain di
     * jero blade) supados nambihan modul enggal ka tabel cukup ku
     * nambihan hiji baris di dieu, teu kudu nulis ulang HTML tabel-na.
     */
    public const NAMA_MODUL = [
        'similaritas' => 'Similaritas',
        'pinjaman_pustaka' => 'Pinjaman Perpustakaan Pusat',
        'pinjaman_fakultas' => 'Pinjaman Perpustakaan Fakultas',
        'donasi_pustaka' => 'Donasi Buku Perpustakaan Pusat',
        'donasi_fakultas' => 'Donasi Buku Perpustakaan Fakultas',
        'donasi_poin' => 'Donasi Poin Perpustakaan',
        'survey' => 'Survei Perpustakaan',
        'konten_literasi' => 'Konten Literasi',
        'repository' => 'Unggah Repository',
        'copy_pustaka' => 'Hard Copy Skripsi Perpustakaan Pusat',
        'copy_fakultas' => 'Hard Copy Skripsi Perpustakaan Fakultas',
        'copy_skripsi' => 'Soft Copy Skripsi',
        'kelas_literasi' => 'Kelas Literasi',
    ];

    public function automatedCount($table, $status)
    {
        if ('similaritas' == $table) {
            return Similaritas::where([
                ['SIMILARITAS_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('pinjaman_pustaka' == $table) {
            return PinjamanPustaka::where([
                ['PUSTAKA_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('pinjaman_fakultas' == $table) {
            return PinjamanFakultas::where([
                ['FAKULTAS_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('donasi_pustaka' == $table) {
            return DonasiPustaka::where([
                ['PUSTAKA_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('donasi_fakultas' == $table) {
            return DonasiFakultas::where([
                ['FAKULTAS_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('donasi_poin' == $table) {
            return DonasiElektronik::where([
                ['ELEKTRONIK_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();


        } elseif ('survey' == $table) {
            return Survey::where([
                ['SURVEY_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('konten_literasi' == $table) {
            return KontenLiterasi::where([
                ['KONTEN_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('repository' == $table) {
            return Repository::where([
                ['REPOSITORY_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('copy_pustaka' == $table) {
            return SkripsiPerpustakaan::where([
                ['SKRIPSI_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('copy_fakultas' == $table) {
            return SkripsiFakultas::where([
                ['SKRIPSI_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('copy_skripsi' == $table) {
            return SkripsiSoftcopy::where([
                ['SKRIPSI_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        } elseif ('kelas_literasi' == $table) {
            return bimbingan_pemustaka::where([
                ['PEMUSTAKA_STATUS', '=', $status],
                ['created_at', 'like', Date('Y') . '%']
            ])->count();

        }
    }

    /**
     * Total sadaya pengajuan anu geus kungsi asup ka aplikasi ieu,
     * ti sagala modul, sagala status, jeung SAGALA TAUN (sanes ngan
     * tahun ajaran ayeuna siga kartu Diajukan/Disetujui/Ditolak) —
     * dianggo pikeun widget "Total Pengajuan" nu mintonkeun volume
     * pamakean aplikasi sacara kasuluruhan.
     */
    public function hitungTotalSepanjangWaktu(): int
    {
        return Similaritas::count()
            + PinjamanPustaka::count()
            + PinjamanFakultas::count()
            + DonasiPustaka::count()
            + DonasiFakultas::count()
            + DonasiElektronik::count()
            + Survey::count()
            + KontenLiterasi::count()
            + Repository::count()
            + SkripsiPerpustakaan::count()
            + SkripsiFakultas::count()
            + SkripsiSoftcopy::count()
            + bimbingan_pemustaka::count();
    }

    public function hitungSemuaData(): array
    {
        return [
            'proses' => [
                'similaritas' => $this->automatedCount('similaritas', 'Proses'),
                'pinjaman_pustaka' => $this->automatedCount('pinjaman_pustaka', 'Proses'),
                'pinjaman_fakultas' => $this->automatedCount('pinjaman_fakultas', 'Proses'),
                'donasi_pustaka' => $this->automatedCount('donasi_pustaka', 'Proses'),
                'donasi_fakultas' => $this->automatedCount('donasi_fakultas', 'Proses'),
                'donasi_poin' => $this->automatedCount('donasi_poin', 'Proses'),
                'survey' => $this->automatedCount('survey', 'Proses'),
                'konten_literasi' => $this->automatedCount('konten_literasi', 'Proses'),
                'repository' => $this->automatedCount('repository', 'Proses'),
                'copy_pustaka' => $this->automatedCount('copy_pustaka', 'Proses'),
                'copy_fakultas' => $this->automatedCount('copy_fakultas', 'Proses'),
                'copy_skripsi' => $this->automatedCount('copy_skripsi', 'Proses'),
                'kelas_literasi' => $this->automatedCount('kelas_literasi', 'Proses'),
            ],

            'disetujui' => [
                'similaritas' => $this->automatedCount('similaritas', 'Disetujui'),
                'pinjaman_pustaka' => $this->automatedCount('pinjaman_pustaka', 'Disetujui'),
                'pinjaman_fakultas' => $this->automatedCount('pinjaman_fakultas', 'Disetujui'),
                'donasi_pustaka' => $this->automatedCount('donasi_pustaka', 'Disetujui'),
                'donasi_fakultas' => $this->automatedCount('donasi_fakultas', 'Disetujui'),
                'donasi_poin' => $this->automatedCount('donasi_poin', 'Disetujui'),
                'survey' => $this->automatedCount('survey', 'Disetujui'),
                'konten_literasi' => $this->automatedCount('konten_literasi', 'Disetujui'),
                'repository' => $this->automatedCount('repository', 'Disetujui'),
                'copy_pustaka' => $this->automatedCount('copy_pustaka', 'Disetujui'),
                'copy_fakultas' => $this->automatedCount('copy_fakultas', 'Disetujui'),
                'copy_skripsi' => $this->automatedCount('copy_skripsi', 'Disetujui'),
                'kelas_literasi' => $this->automatedCount('kelas_literasi', 'Disetujui'),
            ],

            'ditolak' => [
                'similaritas' => $this->automatedCount('similaritas', 'Ditolak'),
                'pinjaman_pustaka' => $this->automatedCount('pinjaman_pustaka', 'Ditolak'),
                'pinjaman_fakultas' => $this->automatedCount('pinjaman_fakultas', 'Ditolak'),
                'donasi_pustaka' => $this->automatedCount('donasi_pustaka', 'Ditolak'),
                'donasi_fakultas' => $this->automatedCount('donasi_fakultas', 'Ditolak'),
                'donasi_poin' => $this->automatedCount('donasi_poin', 'Ditolak'),
                'survey' => $this->automatedCount('survey', 'Ditolak'),
                'konten_literasi' => $this->automatedCount('konten_literasi', 'Ditolak'),
                'repository' => $this->automatedCount('repository', 'Ditolak'),
                'copy_pustaka' => $this->automatedCount('copy_pustaka', 'Ditolak'),
                'copy_fakultas' => $this->automatedCount('copy_fakultas', 'Ditolak'),
                'copy_skripsi' => $this->automatedCount('copy_skripsi', 'Ditolak'),
                'kelas_literasi' => $this->automatedCount('kelas_literasi', 'Ditolak'),
            ],
        ];
    }
}
