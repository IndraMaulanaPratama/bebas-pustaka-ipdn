<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\ActivityLog;
use Illuminate\Support\Carbon;
use Livewire\Component;

/**
 * Widget "Statistik Kegiatan Aplikasi" di dashboard admin (grafik).
 * Dijieun komponen misah (teu digabung ka Dashboard.php) supados alasan
 * anu sarua jeung RecentActivity: proses polling nu ngajadikeun grafik ieu
 * dinamis teu kudu ngitung ulang sadaya statistik kartu di dashboard utama
 * (Dashboard.php ngalakukeun puluhan query pikeun eta).
 *
 * Sumber data grafik ieu nyaeta tabel activity_logs (fitur Log Activity),
 * disaring action submit/approve/reject sarta dikelompokkeun per jam
 * pikeun poe ayeuna, ti jam 00:00 nepi ka 23:00 (sanes ngan jam kerja
 * wungkul, sabab aplikasi ieu tiasa diaksés 24 jam).
 */
class StatistikKegiatan extends Component
{
    private function buildSeries(): array
    {
        $mulai = Carbon::today('Asia/Jakarta');
        $ahir = Carbon::today('Asia/Jakarta')->endOfDay();

        $logs = ActivityLog::query()
            ->whereIn('action', ['submit', 'approve', 'reject'])
            ->whereBetween('created_at', [$mulai, $ahir])
            ->get(['action', 'created_at']);

        $perJam = [
            'submit' => array_fill(0, 24, 0),
            'approve' => array_fill(0, 24, 0),
            'reject' => array_fill(0, 24, 0),
        ];

        foreach ($logs as $log) {
            $jam = (int) $log->created_at->format('G');
            $perJam[$log->action][$jam]++;
        }

        return [
            ['name' => 'Pengajuan Baru', 'data' => $perJam['submit']],
            ['name' => 'Penyetujuan', 'data' => $perJam['approve']],
            ['name' => 'Penolakan', 'data' => $perJam['reject']],
        ];
    }

    /**
     * Dipanggil ku wire:poll. Ngirim data anyar ka JS ngaliwatan event
     * (bukan ngandelkeun re-render blade), sabab ApexCharts kudu di-update
     * make method updateSeries() supados grafik anu geus aya di-refresh
     * teu kudu dijieun ulang unggal polling (nyingkahan chart numpuk/flicker).
     */
    public function pollKegiatan()
    {
        $this->dispatch('statistik-kegiatan-updated', series: $this->buildSeries());
    }

    public function render()
    {
        return view('livewire.admin.dashboard.statistik-kegiatan', [
            'series' => $this->buildSeries(),
            'categories' => collect(range(0, 23))->map(fn ($jam) => sprintf('%02d:00', $jam))->all(),
        ]);
    }
}
