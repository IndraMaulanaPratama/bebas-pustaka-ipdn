<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RiwayatAktivitasExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public $filterDateStart, $filterDateEnd, $filterModule, $filterAction, $filterUser, $filterSearch;

    public function forDateStart($date)
    {
        $this->filterDateStart = $date;
        return $this;
    }

    public function forDateEnd($date)
    {
        $this->filterDateEnd = $date;
        return $this;
    }

    public function forModule($module)
    {
        $this->filterModule = $module;
        return $this;
    }

    public function forAction($action)
    {
        $this->filterAction = $action;
        return $this;
    }

    public function forUser($user)
    {
        $this->filterUser = $user;
        return $this;
    }

    public function forSearch($search)
    {
        $this->filterSearch = $search;
        return $this;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Waktu',
            'Petugas/Pengguna',
            'Role',
            'Modul',
            'Jenis Kegiatan',
            'Deskripsi',
            'Catatan/Alasan',
            'Alamat IP',
        ];
    }

    public function map($log): array
    {
        static $number = 0;
        $number++;

        return [
            $number,
            optional($log->created_at)->locale('id')->translatedFormat('d M Y H:i:s'),
            $log->user_name ?? 'Sistem',
            $log->user_role ?? '-',
            $log->module,
            $log->action_label,
            $log->description,
            $log->properties['alasan_penolakan'] ?? '-',
            $log->ip_address ?? '-',
        ];
    }

    public function query()
    {
        return ActivityLog::query()
            ->when(
                $this->filterDateStart,
                function ($query, $date) {
                    return $query->whereDate('created_at', '>=', $date);
                }
            )
            ->when(
                $this->filterDateEnd,
                function ($query, $date) {
                    return $query->whereDate('created_at', '<=', $date);
                }
            )
            ->when(
                $this->filterModule,
                function ($query, $module) {
                    return $query->where('module', $module);
                }
            )
            ->when(
                $this->filterAction,
                function ($query, $action) {
                    return $query->where('action', $action);
                }
            )
            ->when(
                $this->filterUser,
                function ($query, $user) {
                    return $query->where('user_name', $user);
                }
            )
            ->when(
                $this->filterSearch,
                function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('description', 'LIKE', '%' . $search . '%')
                            ->orWhere('user_name', 'LIKE', '%' . $search . '%');
                    });
                }
            )
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }
}
