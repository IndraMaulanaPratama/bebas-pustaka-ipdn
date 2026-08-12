<?php

namespace Tests\Feature;

use App\Livewire\Admin\Dashboard\StatistikKegiatan;
use App\Models\ActivityLog;
use App\Services\ActivityLogger;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Test pikeun widget grafik "Statistik Kegiatan Aplikasi" di dashboard admin.
 * Sumber datana tabel activity_logs, disaring action submit/assign/approve/reject
 * pikeun poe ayeuna, dikelompokkeun per jam (00:00-23:00, sabab aplikasi
 * ieu tiasa diaksés 24 jam, sanes ngan jam kerja 08:00-16:00 wungkul).
 */
class StatistikKegiatanTest extends TestCase
{
    use DatabaseTransactions;

    private function logAtHour(string $action, int $hour): void
    {
        $log = ActivityLogger::log('Contoh Modul', $action, "Contoh aktivitas jam {$hour}");
        $log->created_at = Carbon::today('Asia/Jakarta')->setTime($hour, 0);
        $log->save();
    }

    private function renderedData(): array
    {
        return (new StatistikKegiatan)->render()->getData();
    }

    public function test_categories_span_the_full_24_hours_not_just_office_hours(): void
    {
        $categories = $this->renderedData()['categories'];

        $this->assertSame(array_map(fn ($h) => sprintf('%02d:00', $h), range(0, 23)), $categories);
    }

    public function test_series_buckets_activities_by_hour_and_action_type(): void
    {
        $this->logAtHour(ActivityLogger::SUBMIT, 7);
        $this->logAtHour(ActivityLogger::SUBMIT, 7);
        $this->logAtHour(ActivityLogger::ASSIGN, 9);
        $this->logAtHour(ActivityLogger::APPROVE, 20);
        $this->logAtHour(ActivityLogger::REJECT, 23);

        $series = $this->renderedData()['series'];

        $submit = collect($series)->firstWhere('name', 'Pengajuan Baru')['data'];
        $assign = collect($series)->firstWhere('name', 'Mulai Periksa Pengajuan')['data'];
        $approve = collect($series)->firstWhere('name', 'Penyetujuan')['data'];
        $reject = collect($series)->firstWhere('name', 'Penolakan')['data'];

        $this->assertSame(2, $submit[7]);
        $this->assertSame(1, $assign[9]);
        $this->assertSame(1, $approve[20]);
        $this->assertSame(1, $reject[23]);
    }

    public function test_it_ignores_activities_outside_today_and_non_transactional_actions(): void
    {
        // Log kamari (kaluar rentang "poe ayeuna") teu meunang kahitung.
        $this->logAtHour(ActivityLogger::SUBMIT, 10);
        $kamari = ActivityLog::latest()->first();
        $kamari->created_at = Carbon::yesterday('Asia/Jakarta')->setTime(10, 0);
        $kamari->save();

        // Action login/logout lain transaksi pengajuan, teu kudu katembong di grafik ieu.
        ActivityLogger::log('Autentikasi', ActivityLogger::LOGIN, 'Login ke aplikasi');

        $series = $this->renderedData()['series'];
        $totalSemuaAksi = collect($series)->sum(fn ($s) => array_sum($s['data']));

        $this->assertSame(0, $totalSemuaAksi);
    }

    public function test_polling_dispatches_updated_series_without_recreating_the_chart(): void
    {
        $this->logAtHour(ActivityLogger::APPROVE, 14);

        Livewire::test(StatistikKegiatan::class)
            ->call('pollKegiatan')
            ->assertDispatched('statistik-kegiatan-updated');
    }
}
