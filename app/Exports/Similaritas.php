<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class Similaritas implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return \App\Models\Similaritas::all();
    }
}
