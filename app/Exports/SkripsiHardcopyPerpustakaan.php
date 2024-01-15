<?php

namespace App\Exports;

use App\Models\SkripsiPerpustakaan;
use Maatwebsite\Excel\Concerns\FromCollection;

class SkripsiHardcopyPerpustakaan implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SkripsiPerpustakaan::all();
    }
}
