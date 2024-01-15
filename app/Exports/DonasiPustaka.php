<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class DonasiPustaka implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return \App\Models\DonasiPustaka::all();
    }
}
