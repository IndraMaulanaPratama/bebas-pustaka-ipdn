<?php

namespace App\Exports;

use App\Models\BebasPustaka;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResumeBelumSelesaiExcel implements FromQuery, WithHeadings
{
    use Exportable;

    public $sortSearch;

    public function forSearch($search)
    {
        $this->sortSearch = $search;
        return $this;
    }

    public function headings(): array
    {
        return [
            'Nomor Pokok Praja (NPP)',
            'Status Similaritas',
            'Status Pinjaman Perpustakaan',
            'Status Pinjaman Fakultas',
            'Status Donasi Perpustakaan',
            'Status Donasi Fakultas',
            'Status Donasi Elektronik',
            'Status Survei',
            'Status Konten Literasi',
            'Status Repository',
            'Status Skripsi Pusat',
            'Status Skripsi Fakultas',
            'Status Skripsi Soft Copy',
        ];
    }

    public function query()
    {

        return BebasPustaka::query()
            ->select(
                [
                    'BEBAS_PRAJA',
                    'BEBAS_SIMILARITAS',
                    'BEBAS_PINJAMAN_PUSAT',
                    'BEBAS_PINJAMAN_FAKULTAS',
                    'BEBAS_DONASI_FAKULTAS',
                    'BEBAS_DONASI_PUSAT',
                    'BEBAS_DONASI_POIN',
                    'BEBAS_SURVEI',
                    'BEBAS_KONTEN_LITERASI',
                    'BEBAS_REPOSITORY',
                    'BEBAS_HARD_COPY_PUSAT',
                    'BEBAS_HARD_COPY_FAKULTAS',
                    'BEBAS_SOFT_COPY',
                ]
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->sortSearch,
                function ($query, $npp) {
                    return $query->where("BEBAS_PRAJA", "LIKE", $npp . "%");
                }
            );
    }
}
