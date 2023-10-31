<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Praja extends Model
{
    use HasFactory;
    protected $table = "PRAJA";
    protected $primaryKey = "PRAJA_NPP";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $fillable = [
        'PRAJA_NPP',
        'PRAJA_EMAIL',
        'PRAJA_NOMOR_PONSEL',
    ];


    //  <--- *** Relation Area *** ---> //

    public function similaritas(): HasOne
    {
        return $this->hasOne(Praja::class, 'SIMILARITAS_PRAJA', 'PRAJA_NPP');
    }

    //  <--- *** End Of Relation Area *** ---> //

}
