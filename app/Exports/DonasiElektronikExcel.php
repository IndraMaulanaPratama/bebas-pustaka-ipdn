<?php

namespace App\Exports;

use App\Models\DonasiElektronik;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DonasiElektronikExcel implements FromQuery, WithHeadings
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
            'ID Purchase Order',
            'Nomor Pokok Praja',
            'Kode Fakultas',
            'Status Pengajuan',
            'Tanggal Pemeriksaan',
            'Catatan Pengajuan',
        ];
    }




    public function query()
    {

        return DonasiElektronik::query()
            ->select(
                [
                    'ELEKTRONIK_ID_PO',
                    'ELEKTRONIK_PRAJA',
                    'ELEKTRONIK_FAKULTAS',
                    'ELEKTRONIK_STATUS',
                    'ELEKTRONIK_APPROVED',
                    'ELEKTRONIK_NOTES',
                ]
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("ELEKTRONIK_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("ELEKTRONIK_FAKULTAS", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->sortSearch,
                function ($query, $npp) {
                    return $query->where("ELEKTRONIK_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->sortAngkatan,
                function ($query, $angkatan) {
                    return $query->where("ELEKTRONIK_PRAJA", "LIKE", $angkatan . "%");
                }
            );
    }

}
