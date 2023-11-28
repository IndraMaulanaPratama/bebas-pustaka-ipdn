<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PivotSkripsi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "PIVOT_SKRIPSI";
    protected $primaryKey = "PIVOT_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['skripsi_perpustakaan', 'skripsi_fakultas', 'skripsi_softcopy'];
    protected $fillable = [
        "PIVOT_ID",
        "PIVOT_PRAJA",
        "PIVOT_PUSTAKA",
        "PIVOT_FAKULTAS",
        "PIVOT_SOFTCOPY",
    ];

    /**
     * --- *** RANAHNA RELASI *** ---
     */

    public function skripsi_perpustakaan(): HasOne
    {
        return $this->hasOne(SkripsiPerpustakaan::class, 'SKRIPSI_ID', 'PIVOT_PUSTAKA');
    }

    public function skripsi_fakultas(): HasOne
    {
        return $this->hasOne(SkripsiFakultas::class, 'SKRIPSI_ID', 'PIVOT_FAKULTAS');
    }

    public function skripsi_softcopy(): HasOne
    {
        return $this->hasOne(SkripsiSoftcopy::class, 'SKRIPSI_ID', 'PIVOT_SOFTCOPY');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'SKRIPSI_OFFICER', 'id');
    }


    /**
     * --- *** END OF RANAHNA RELASI *** ---
     */


}
