<?php

namespace Tests\Feature;

use App\Livewire\Admin\Dashboard\RingkasanKartu;
use App\Livewire\Admin\Dashboard\RingkasanPengajuan;
use App\Models\bimbingan_pemustaka;
use App\Models\PinjamanPustaka;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Test pikeun widget "Diajukan/Disetujui/Ditolak" (RingkasanKartu) sareng
 * tabel "Ringkasan Pengajuan" (RingkasanPengajuan) di dashboard admin.
 *
 * Kadua widget ieu dijieun komponen misah (dulu ngahiji di Dashboard.php,
 * teu bisa auto-refresh) supados tiasa polling nyalira siga widget
 * dashboard séjén (Aktivitas Terbaru, Statistik Kegiatan). Datana ngitung
 * sapanjang TAHUN AJARAN ayeuna (sanes 24 jam siga grafik statistik).
 */
class RingkasanDashboardTest extends TestCase
{
    use DatabaseTransactions;

    private function petugasId(): int
    {
        $petugas = User::query()->value('id');

        if ($petugas) {
            return $petugas;
        }

        $roleId = (string) Str::uuid();
        Role::create(['ROLE_ID' => $roleId, 'ROLE_NAME' => 'Test Role Ringkasan']);

        return User::create([
            'name' => 'Petugas Uji Coba',
            'email' => 'petugas.' . Str::random(8) . '@ipdn.ac.id',
            'password' => bcrypt('rahasia'),
            'user_role' => $roleId,
        ])->id;
    }

    private function buatPengajuan(string $status, ?Carbon $tanggal = null): PinjamanPustaka
    {
        $nomor = 'TEST/' . Str::random(10);

        PinjamanPustaka::create([
            'PUSTAKA_ID' => (string) Str::uuid(),
            'PUSTAKA_NUMBER' => $nomor,
            'PUSTAKA_PRAJA' => '30.' . rand(1000, 9999),
            'PUSTAKA_OFFICER' => $this->petugasId(),
            'PUSTAKA_STATUS' => $status,
        ]);

        // Nyandak deui data ti database (lain ngandelkeun instance hasil
        // create() sacara langsung) sabab model PinjamanPustaka teu nyetel
        // $incrementing = false sanajan PUSTAKA_ID-na string/UUID — bug
        // pra-aya nu sarua siga nu kapendak di model Role saméméhna, ku
        // kituna instance hasil create() teu bisa diandelkeun keur di-save()
        // deui (PUSTAKA_ID-na bakal salah/0 di jero memory).
        $pinjaman = PinjamanPustaka::where('PUSTAKA_NUMBER', $nomor)->firstOrFail();

        if ($tanggal) {
            PinjamanPustaka::where('PUSTAKA_NUMBER', $nomor)->update(['created_at' => $tanggal]);
        }

        return $pinjaman;
    }

    private function buatKelasLiterasi(string $status, ?Carbon $tanggal = null): bimbingan_pemustaka
    {
        $npp = '30.' . rand(1000, 9999);

        bimbingan_pemustaka::create([
            'PEMUSTAKA_ID' => (string) Str::uuid(),
            'PEMUSTAKA_PRAJA' => $npp,
            'PEMUSTAKA_FAKULTAS' => 'FPP',
            'PEMUSTAKA_OFFICER' => $this->petugasId(),
            'PEMUSTAKA_STATUS' => $status,
        ]);

        $pengajuan = bimbingan_pemustaka::where('PEMUSTAKA_PRAJA', $npp)->firstOrFail();

        if ($tanggal) {
            bimbingan_pemustaka::where('PEMUSTAKA_PRAJA', $npp)->update(['created_at' => $tanggal]);
        }

        return $pengajuan;
    }

    public function test_ringkasan_kartu_shows_correct_totals_for_current_year(): void
    {
        $sebelum = (new RingkasanKartu)->hitungSemuaData();
        $totalProsesSebelum = array_sum($sebelum['proses']);
        $totalDisetujuiSebelum = array_sum($sebelum['disetujui']);
        $totalDitolakSebelum = array_sum($sebelum['ditolak']);

        $this->buatPengajuan('Proses');
        $this->buatPengajuan('Disetujui');
        $this->buatPengajuan('Disetujui');
        $this->buatPengajuan('Ditolak');

        $total = (new RingkasanKartu)->render()->getData()['total'];

        $this->assertSame($totalProsesSebelum + 1, $total['proses']);
        $this->assertSame($totalDisetujuiSebelum + 2, $total['disetujui']);
        $this->assertSame($totalDitolakSebelum + 1, $total['ditolak']);
    }

    public function test_ringkasan_kartu_ignores_data_outside_the_current_year(): void
    {
        $sebelumHitung = (new RingkasanKartu)->hitungSemuaData();
        $totalProsesSebelum = array_sum($sebelumHitung['proses']);

        // Data taun kamari teu kudu kahitung (automatedCount nyaring "created_at LIKE tahun ayeuna").
        $this->buatPengajuan('Proses', Carbon::now()->subYear());

        $sesudahHitung = (new RingkasanKartu)->hitungSemuaData();
        $totalProsesSasudah = array_sum($sesudahHitung['proses']);

        $this->assertSame($totalProsesSebelum, $totalProsesSasudah);
    }

    public function test_ringkasan_kartu_reflects_new_data_on_the_next_poll(): void
    {
        // Simulasi wire:poll: unggal render() dipanggil deui, angka na kudu
        // anyar (teu di-cache), supados widget bener-bener "hirup".
        $totalAwal = (new RingkasanKartu)->hitungSemuaData()['proses'];
        $totalAwal = array_sum($totalAwal);

        $this->buatPengajuan('Proses');

        $totalAnyar = (new RingkasanKartu)->hitungSemuaData()['proses'];
        $totalAnyar = array_sum($totalAnyar);

        $this->assertSame($totalAwal + 1, $totalAnyar);
    }

    public function test_ringkasan_pengajuan_table_shows_correct_counts_per_module(): void
    {
        $sebelum = (new RingkasanPengajuan)->hitungSemuaData();
        $prosesSebelum = $sebelum['proses']['pinjaman_pustaka'];
        $disetujuiSebelum = $sebelum['disetujui']['pinjaman_pustaka'];

        $this->buatPengajuan('Proses');
        $this->buatPengajuan('Disetujui');

        $data = (new RingkasanPengajuan)->render()->getData()['data'];

        $this->assertSame($prosesSebelum + 1, $data['proses']['pinjaman_pustaka']);
        $this->assertSame($disetujuiSebelum + 1, $data['disetujui']['pinjaman_pustaka']);
    }

    public function test_ringkasan_pengajuan_reflects_new_data_on_the_next_poll(): void
    {
        $awal = (new RingkasanPengajuan)->hitungSemuaData()['ditolak']['pinjaman_pustaka'];

        $this->buatPengajuan('Ditolak');

        $anyar = (new RingkasanPengajuan)->hitungSemuaData()['ditolak']['pinjaman_pustaka'];

        $this->assertSame($awal + 1, $anyar);
    }

    /**
     * Regresi: modul "Kelas Literasi" (Bimbingan Pemustaka) saméméhna kaliwat
     * teu asup kana itungan kartu/tabel ringkasan ieu, padahal éta modul
     * pangenggalna di aplikasi. Ayeuna kudu geus asup.
     */
    public function test_kelas_literasi_module_is_now_included_in_the_summary_data(): void
    {
        $sebelum = (new RingkasanKartu)->hitungSemuaData()['disetujui']['kelas_literasi'];

        $this->buatKelasLiterasi('Disetujui');

        $sasudah = (new RingkasanKartu)->hitungSemuaData()['disetujui']['kelas_literasi'];

        $this->assertSame($sebelum + 1, $sasudah);
    }

    public function test_ringkasan_pengajuan_table_lists_all_13_modules_including_kelas_literasi(): void
    {
        $modules = (new RingkasanPengajuan)->render()->getData()['modules'];

        $this->assertCount(13, $modules);
        $this->assertArrayHasKey('kelas_literasi', $modules);
        $this->assertSame('Kelas Literasi', $modules['kelas_literasi']);
    }

    /**
     * Kartu "Total Pengajuan" beda ti kartu Diajukan/Disetujui/Ditolak:
     * ngitung SAGALA TAUN (sanes ngan tahun ajaran ayeuna), sabab
     * ngagambarkeun total volume pamakean aplikasi sacara kasuluruhan.
     */
    public function test_total_pengajuan_sepanjang_waktu_counts_data_from_any_year(): void
    {
        $sebelum = (new RingkasanKartu)->hitungTotalSepanjangWaktu();

        $this->buatPengajuan('Disetujui', Carbon::now()->subYears(2));

        $sasudah = (new RingkasanKartu)->hitungTotalSepanjangWaktu();

        $this->assertSame($sebelum + 1, $sasudah);
    }
}
