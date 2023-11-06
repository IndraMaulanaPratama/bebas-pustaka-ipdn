<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PinjamanFakultas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "PINJAMAN_FAKULTAS";
    protected $primaryKey = "FAKULTAS_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];

    protected $fillable = [
        'FAKULTAS_ID',
        'FAKULTAS_NUMBER',
        'FAKULTAS_PRAJA',
        'FAKULTAS_OFFICER',
        'FAKULTAS_STATUS',
        'FAKULTAS_APPROVED',
        'FAKULTAS_NOTES',
    ];


    // --- *** Ranahna Relasi *** --- //
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "FAKULTAS_OFFICER", "id");
    }


    public function pivot_pinjaman(): HasOne
    {
        return $this->hasOne(PivotPinjaman::class, "PIVOT_FAKULTAS", "FAKULTAS_ID");
    }


    // --- *** Tungtung tina Ranahna Relasi *** --- //
}
