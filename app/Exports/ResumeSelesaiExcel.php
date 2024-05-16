<?php

namespace App\Exports;

use App\Models\BebasPustaka;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResumeSelesaiExcel implements FromQuery, WithHeadings
{
    use Exportable;

    public $sortData, $sortFakultas, $sortAngkatan, $sortSearch;

    public function forData($data)
    {
        $this->sortData = $data;
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
            'Nomor Surat',
            'Nomor Pokok Praja',
        ];
    }

    public function query()
    {

        return BebasPustaka::query()
            ->select(
                [
                    'BEBAS_NUMBER',
                    'BEBAS_PRAJA',
                ]
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortData,
                function ($query, $sort) {
                    if ($sort == 'nomor'):
                        return $query->orderBy('BEBAS_NUMBER', 'ASC');
                    elseif ($sort == 'terbaru'):
                        return $query->latest();
                    endif;
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("BEBAS_NUMBER", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->sortSearch,
                function ($query, $npp) {
                    return $query->where("BEBAS_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana angkatan
                $this->sortAngkatan,
                function ($query, $angkatan) {
                    return $query->where("BEBAS_PRAJA", "LIKE", $angkatan . "%");
                }
            );
    }
}
