<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class KontenLiterasi implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return \App\Models\KontenLiterasi::all();
    }
}
