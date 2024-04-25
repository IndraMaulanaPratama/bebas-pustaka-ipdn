<?php

namespace App\Exports;

use App\Models\Similaritas;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SimilaritasExport implements FromQuery, WithHeadings
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
            'Nomor Surat',
            'Nomor Pokok Praja',
            'Judul Skripsi',
            'Nilai Similaritas',
            'Status Bibliografi',
            'Status Small Word',
            'Nilai Small Word',
            'Status Quote',
            'Status Pengajuan',
            'Taggal Pemeriksaan',
            'Catatan Pengajuan',
        ];
    }


    public function query()
    {

        return Similaritas::query()
            ->select(
                [
                    'SIMILARITAS_NUMBER',
                    'SIMILARITAS_PRAJA',
                    'SIMILARITAS_TITLE',
                    'SIMILARITAS_VALUE',
                    'SIMILARITAS_BIBLIOGRAFI',
                    'SIMILARITAS_SMALL_WORD',
                    'SIMILARITAS_SMALL_WORD_COUNT',
                    'SIMILARITAS_QUOTE',
                    'SIMILARITAS_STATUS',
                    'SIMILARITAS_APPROVED',
                    'SIMILARITAS_NOTES',
                ]
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana status
                $this->sortStatus,
                function ($query, $status) {
                    return $query->where("SIMILARITAS_STATUS", $status);
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana fakultas
                $this->sortFakultas,
                function ($query, $fakultas) {
                    return $query->where("SIMILARITAS_NUMBER", "LIKE", '%' . $fakultas . '%');
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana npp
                $this->sortSearch,
                function ($query, $npp) {
                    return $query->where("SIMILARITAS_PRAJA", "LIKE", $npp . "%");
                }
            )
            ->when(
                // <!-- Pilari data pengajuan dumasar kana angkatan
                $this->sortAngkatan,
                function ($query, $angkatan) {
                    return $query->where("SIMILARITAS_PRAJA", "LIKE", $angkatan . "%");
                }
            );

    }




    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return Similaritas::all();
    // }
}
