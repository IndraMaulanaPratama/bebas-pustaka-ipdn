<?php

namespace App\Livewire\Admin\RiwayatAktivitas;

use App\Exports\RiwayatAktivitasExport;
use App\Models\ActivityLog;
use App\Services\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $filterDateStart, $filterDateEnd, $filterModule, $filterAction, $filterUser, $search;
    public $perPage = 20;

    /**
     * Kaca ieu nyimpen data sensitif (jejak audit, alesan panolakan, alamat IP)
     * jadi dijaga sacara eksplisit di jero component ieu — teu ngan ngandelkeun
     * middleware 'access', supados aman sanajan aya user nu coba buka URL-na
     * langsung tanpa liwat sidebar.
     */
    public function mount()
    {
        $role = Auth::user()->role->ROLE_NAME ?? null;

        if (!in_array($role, ['Super Admin', 'Admin Pustaka'])) {
            abort(404);
        }
    }

    /**
     * Reset kaca pagination unggal kali filter robih, supados teu
     * ngajogo di kaca anu kosong.
     */
    public function updating($property)
    {
        if (in_array($property, ['filterDateStart', 'filterDateEnd', 'filterModule', 'filterAction', 'filterUser', 'search', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function resetFilter()
    {
        $this->reset(['filterDateStart', 'filterDateEnd', 'filterModule', 'filterAction', 'filterUser', 'search']);
    }

    /**
     * Nyieun ringkesan filter anu keur aktif, dianggo pikeun kaperluan
     * label di laporan PDF/Excel jeung log activity.
     */
    private function ringkasanFilter(): string
    {
        $ringkasan = [];

        if ($this->filterDateStart) {
            $ringkasan[] = 'dari ' . $this->filterDateStart;
        }
        if ($this->filterDateEnd) {
            $ringkasan[] = 'sampai ' . $this->filterDateEnd;
        }
        if ($this->filterModule) {
            $ringkasan[] = 'modul ' . $this->filterModule;
        }
        if ($this->filterAction) {
            $ringkasan[] = 'aksi ' . (ActivityLog::ACTION_LABELS[$this->filterAction] ?? $this->filterAction);
        }
        if ($this->filterUser) {
            $ringkasan[] = 'petugas ' . $this->filterUser;
        }
        if ($this->search) {
            $ringkasan[] = 'kata kunci "' . $this->search . '"';
        }

        return implode(', ', $ringkasan) ?: 'Tidak ada filter (semua data)';
    }

    private function filteredQuery()
    {
        return ActivityLog::query()
            ->when($this->filterDateStart, function ($query, $date) {
                return $query->whereDate('created_at', '>=', $date);
            })
            ->when($this->filterDateEnd, function ($query, $date) {
                return $query->whereDate('created_at', '<=', $date);
            })
            ->when($this->filterModule, function ($query, $module) {
                return $query->where('module', $module);
            })
            ->when($this->filterAction, function ($query, $action) {
                return $query->where('action', $action);
            })
            ->when($this->filterUser, function ($query, $user) {
                return $query->where('user_name', $user);
            })
            ->when($this->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('description', 'LIKE', '%' . $search . '%')
                        ->orWhere('user_name', 'LIKE', '%' . $search . '%');
                });
            });
    }

    public function exportExcel()
    {
        ActivityLogger::log('Riwayat Aktivitas', ActivityLogger::EXPORT, 'Mengekspor riwayat aktivitas ke Excel (' . $this->ringkasanFilter() . ')');

        return (new RiwayatAktivitasExport)
            ->forDateStart($this->filterDateStart)
            ->forDateEnd($this->filterDateEnd)
            ->forModule($this->filterModule)
            ->forAction($this->filterAction)
            ->forUser($this->filterUser)
            ->forSearch($this->search)
            ->download(
                'Riwayat_Aktivitas_' . now()->format('Y-m-d_His') . '.xlsx',
                \Maatwebsite\Excel\Excel::XLSX
            );
    }

    public function exportPdf()
    {
        ActivityLogger::log('Riwayat Aktivitas', ActivityLogger::EXPORT, 'Mengekspor riwayat aktivitas ke PDF (' . $this->ringkasanFilter() . ')');

        $logs = $this->filteredQuery()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $pdf = Pdf::loadView('pdf.riwayat-aktivitas', [
            'logs' => $logs,
            'tanggalCetak' => Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i'),
            'ringkasanFilter' => $this->ringkasanFilter(),
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(
            function () use ($pdf) {
                print($pdf->output());
            },
            'Riwayat_Aktivitas_' . now()->format('Y-m-d_His') . '.pdf'
        );
    }

    public function placeholder()
    {
        return view('components.admin.components.spinner.loading');
    }

    public function render()
    {
        $logs = $this->filteredQuery()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($this->perPage);

        $modules = ActivityLog::query()
            ->whereNotNull('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        $users = ActivityLog::query()
            ->whereNotNull('user_name')
            ->distinct()
            ->orderBy('user_name')
            ->pluck('user_name');

        return view('livewire.admin.riwayat-aktivitas.table', [
            'logs' => $logs,
            'modules' => $modules,
            'actionOptions' => ActivityLog::ACTION_LABELS,
            'users' => $users,
        ]);
    }
}
