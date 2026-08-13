<?php

namespace App\Livewire\Admin\Dashboard;

use App\Livewire\Admin\Dashboard\Concerns\HitungDataPengajuan;
use Livewire\Component;

/**
 * Widget tabel "Ringkasan Pengajuan" (rekap per modul) di dashboard admin.
 * Dijieun komponen misah (teu digabung ka Dashboard.php) supados alesan
 * anu sarua jeung RecentActivity/StatistikKegiatan/RingkasanKartu: tiasa
 * polling nyalira tanpa ngitung ulang widget dashboard séjén.
 *
 * Data ieu ngitung sapanjang tahun ajaran ayeuna (sanes 24 jam).
 */
class RingkasanPengajuan extends Component
{
    use HitungDataPengajuan;

    public function render()
    {
        return view('livewire.admin.dashboard.ringkasan-pengajuan', [
            'data' => $this->hitungSemuaData(),
            'modules' => self::NAMA_MODUL,
        ]);
    }
}
