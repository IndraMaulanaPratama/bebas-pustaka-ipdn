<?php

namespace App\Exports;

use App\Models\DonasiFakultas;
use Maatwebsite\Excel\Concerns\FromCollection;

class DonasiFakuktas implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DonasiFakultas::all();
    }
}
