<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class SkripsiSoftcopy implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return \App\Models\SkripsiSoftcopy::all();
    }
}
