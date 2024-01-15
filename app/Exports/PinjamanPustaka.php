<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class PinjamanPustaka implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return \App\Models\PinjamanPustaka::all();
    }
}
