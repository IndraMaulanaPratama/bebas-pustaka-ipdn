<?php

namespace App\Exports;

use App\Models\DonasiFakultas;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DonasiFakultasExcel implements FromQuery, WithHeadings
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
            'Kode Fakultas',
            'Status Pengajuan',
            'Tanggal Pemeriksaan',
            'Catatan Pengajuan',
        ];
    }




    public function query()
    {

        return DonasiFakultas::query()
            ->select(
                [
                    'FAKULTAS_PRAJA',
                    'FAKULTAS_FAKULTAS',
                    'FAKULTAS_STATUS',
                    'FAKULTAS_APPROVED',
                    'FAKULTAS_NOTES',
                ]
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("FAKULTAS_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("FAKULTAS_FAKULTAS", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->sortSearch,
                function ($query, $npp) {
                    return $query->where("FAKULTAS_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->sortAngkatan,
                function ($query, $angkatan) {
                    return $query->where("FAKULTAS_PRAJA", "LIKE", $angkatan . "%");
                }
            );
    }

}
