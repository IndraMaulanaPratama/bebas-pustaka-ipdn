<?php

namespace App\Livewire\Admin\Dashboard;

use App\Livewire\Admin\Dashboard\Concerns\HitungDataPengajuan;
use Livewire\Component;

/**
 * Widget kartu "Total Pengajuan / Diajukan / Disetujui / Ditolak" di
 * dashboard admin. Dijieun komponen misah (teu digabung ka Dashboard.php)
 * supados alesan anu sarua jeung RecentActivity/StatistikKegiatan: tiasa
 * polling nyalira tanpa ngitung ulang widget dashboard séjén.
 *
 * Kartu Diajukan/Disetujui/Ditolak ngitung sapanjang TAHUN AJARAN AYEUNA.
 * Kartu Total Pengajuan mah ngitung SAGALA TAUN (sadaya waktu), sabab
 * mangrupa angka "total pengajuan anu geus di-handle aplikasi ieu" —
 * beda ambisina jeung 3 kartu séjén, ku kituna label subtitle-na dibédakeun
 * sacara jelas ("Sepanjang Waktu" vs "Tahun Ajaran Ini") sangkan teu matak
 * bingung.
 */
class RingkasanKartu extends Component
{
    use HitungDataPengajuan;

    public function render()
    {
        $data = $this->hitungSemuaData();

        return view('livewire.admin.dashboard.ringkasan-kartu', [
            'totalSepanjangWaktu' => $this->hitungTotalSepanjangWaktu(),
            'total' => [
                'proses' => array_sum($data['proses']),
                'disetujui' => array_sum($data['disetujui']),
                'ditolak' => array_sum($data['ditolak']),
            ],
        ]);
    }
}
