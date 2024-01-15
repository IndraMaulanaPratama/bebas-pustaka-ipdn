<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class PinjamanFakultas implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return \App\Models\PinjamanFakultas::all();
    }
}
