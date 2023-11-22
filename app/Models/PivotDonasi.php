<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PivotDonasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "PIVOT_DONASI";
    protected $primaryKey = "PIVOT_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['donasi_pustaka', 'donasi_fakultas', 'donasi_elektronik'];

    protected $fillable = [
        "PIVOT_ID",
        "PIVOT_PRAJA",
        "PIVOT_PUSTAKA",
        "PIVOT_FAKULTAS",
        "PIVOT_ELEKTRONIK",
        "PIVOT_STATUS",
    ];


    // --- *** Ranahna Relasi *** --- //
    public function donasi_pustaka(): BelongsTo
    {
        return $this->belongsTo(DonasiPustaka::class, "PIVOT_PUSTAKA", "PUSTAKA_ID");
    }


    public function donasi_fakultas(): BelongsTo
    {
        return $this->belongsTo(DonasiFakultas::class, "PIVOT_FAKULTAS", "FAKULTAS_ID");
    }


    public function donasi_elektronik(): BelongsTo
    {
        return $this->belongsTo(DonasiElektronik::class, "PIVOT_ELEKTRONIK", "ELEKTRONIK_ID");
    }

    // --- *** Tungtung tina Ranahna Relasi *** --- //

}
