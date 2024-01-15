<?php

namespace App\Exports;

use App\Models\SkripsiFakultas;
use Maatwebsite\Excel\Concerns\FromCollection;

class SkripsiHardcopyFakultas implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SkripsiFakultas::all();
    }
}
