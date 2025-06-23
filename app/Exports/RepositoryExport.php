<?php

namespace App\Exports;

use App\Models\Repository;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RepositoryExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public $sortStatus, $sortFakultas, $sortAngkatan, $sortSearch;

    public function forStatus($status)
    {
        $this->sortStatus = $status;
        return $this;
    }

    public function forFakultas($fakultas)
    {
        $this->sortFakultas = $fakultas;
        return $this;
    }


    public function forAngkatan($angkatan)
    {
        $this->sortAngkatan = $angkatan;
        return $this;
    }


    public function forSearch($search)
    {
        $this->sortSearch = $search;
        return $this;
    }


    public function headings(): array
    {
        return [
            'Nomor Pokok Praja',
            'Fakultas',
            'Status Pengajuan',
            'Petugas Pemeriksa',
            'Catatan Pengajuan',
            'URL Repository',
            'Tanggal Pemeriksaan',
        ];
    }


    public function query()
    {

        return Repository::query()
            // ->leftJoin('users', 'REPOSITORY.REPOSITORY_OFFICER', '=', 'users.id')
            ->select(
                [
                    'REPOSITORY_PRAJA',
                    'REPOSITORY_FAKULTAS',
                    'REPOSITORY_STATUS',
                    'REPOSITORY_OFFICER',
                    'REPOSITORY_NOTES',
                    'REPOSITORY_URL',
                    'REPOSITORY_APPROVED',
                ]
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("REPOSITORY_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->sortSearch,
                function ($query, $npp) {
                    return $query->where("REPOSITORY_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana angkatan
                $this->sortAngkatan,
                function ($query, $angkatan) {
                    return $query->where("REPOSITORY_PRAJA", "LIKE", $angkatan . "%");
                }
            );

    }

    public function map($repository): array
    {
        return [
            $repository->REPOSITORY_PRAJA,
            $repository->REPOSITORY_FAKULTAS,
            $repository->REPOSITORY_STATUS,
            $repository->user->name ?? '-', // Pakai alias dari join
            $repository->REPOSITORY_NOTES,
            $repository->REPOSITORY_URL,
            $repository->REPOSITORY_APPROVED,
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return Repository::all();
    // }
}
