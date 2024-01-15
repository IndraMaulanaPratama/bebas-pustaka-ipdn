<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class BebasPustaka implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return \App\Models\BebasPustaka::all();
    }
}
