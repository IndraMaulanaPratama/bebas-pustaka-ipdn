<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\ActivityLog;
use Livewire\Component;

/**
 * Widget "Aktivitas Terbaru" di dashboard admin.
 * Dijieun komponen misah (teu digabung ka Dashboard.php) supados
 * proses polling nu ngajadikeun eusi widget ieu dinamis/live,
 * teu kudu ngitung ulang sadaya statistik kartu di dashboard utama.
 */
class RecentActivity extends Component
{
    public int $limit = 10;

    public function render()
    {
        // Diurut ku created_at heula, teras ku id (tie-breaker) supados
        // aktivitas nu lumangsung dina detik nu sarua tetep kaurut bener
        // ti nu panganyarna (kolom created_at ngan presisi per detik).
        $activities = ActivityLog::with('user')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit($this->limit)
            ->get();

        return view('livewire.admin.dashboard.recent-activity', [
            'activities' => $activities,
        ]);
    }
}
