<?php

namespace App\Livewire\Admin\Dashboard;

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
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $date, $dateTime;



    public function mount()
    {
        $this->date = Carbon::now('Asia/Jakarta')->format('d M Y');
        $this->dateTime = Carbon::now('Asia/Jakarta');
    }



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

        }
    }

    public function render()
    {
        $data = [
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
            ],
        ];

        $totalProses = array_sum($data['proses']);
        $totalDisetujui = array_sum($data['disetujui']);
        $totalDitolak = array_sum($data['ditolak']);

        // dd($data);

        return view('livewire.admin.dashboard.dashboard', [
            'data' => $data,
            'total' => [
                'proses' => $totalProses,
                'disetujui' => $totalDisetujui,
                'ditolak' => $totalDitolak,
            ]
        ]);
    }
}
