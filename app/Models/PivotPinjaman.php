<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PivotPinjaman extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "PIVOT_PINJAMAN";
    protected $primaryKey = "PIVOT_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['pinjaman_pustaka', 'pinjaman_fakultas'];

    protected $fillable = [
        "PIVOT_ID",
        "PIVOT_PRAJA",
        "PIVOT_PUSTAKA",
        "PIVOT_FAKULTAS",
        "PIVOT_STATUS",
    ];


    // --- *** Ranahna Relasi *** --- //
    public function pinjaman_pustaka(): BelongsTo
    {
        return $this->belongsTo(PinjamanPustaka::class, "PIVOT_PUSTAKA", "PUSTAKA_ID");
    }


    public function pinjaman_fakultas(): BelongsTo
    {
        return $this->belongsTo(PinjamanFakultas::class, "PIVOT_FAKULTAS", "FAKULTAS_ID");
    }

    // --- *** Tungtung tina Ranahna Relasi *** --- //

}
