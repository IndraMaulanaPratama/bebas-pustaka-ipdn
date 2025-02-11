<?php

namespace App\Exports;

use App\Models\PinjamanPustaka;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PinjamanPerpustakaanExcel implements FromQuery, WithHeadings
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
            'Status Peminjaman',
            'Tanggal Pemeriksaan',
            'Catatan Pengajuan',
        ];
    }




    public function query()
    {

        return PinjamanPustaka::query()
            ->select(
                [
                    'PUSTAKA_PRAJA',
                    'PUSTAKA_STATUS',
                    'PUSTAKA_APPROVED',
                    'PUSTAKA_NOTES',
                ]
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("PUSTAKA_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("PUSTAKA_NUMBER", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->sortSearch,
                function ($query, $npp) {
                    return $query->where("PUSTAKA_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana angkatan
                $this->sortAngkatan,
                function ($query, $angkatan) {
                    return $query->where("PUSTAKA_PRAJA", "LIKE", $angkatan . "%");
                }
            );

    }

}
