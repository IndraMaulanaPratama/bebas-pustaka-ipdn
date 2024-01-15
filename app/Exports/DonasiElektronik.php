<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class DonasiElektronik implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return \App\Models\DonasiElektronik::all();
    }
}
