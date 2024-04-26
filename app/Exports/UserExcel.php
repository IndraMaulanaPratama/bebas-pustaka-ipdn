<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExcel implements FromQuery, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Nama Pengguna',
            'Alama E-Mail',
        ];
    }


    public function query()
    {

        return User::query()
            ->select(
                [
                    'name',
                    'email',
                ]
            );
    }


}
