<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PinjamanPustaka extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "PINJAMAN_PUSTAKA";
    protected $primaryKey = "PUSTAKA_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];

    protected $fillable = [
        'PUSTAKA_ID',
        'PUSTAKA_NUMBER',
        'PUSTAKA_PRAJA',
        'PUSTAKA_OFFICER',
        'PUSTAKA_STATUS',
        'PUSTAKA_APPROVED',
        'PUSTAKA_NOTES',
    ];


    // --- *** Ranahna Relasi *** --- //
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "PUSTAKA_OFFICER", "id");
    }

    public function pivot_pinjaman(): HasOne
    {
        return $this->hasOne(PivotPinjaman::class, "PIVOT_PUSTAKA", "PUSTAKA_ID");
    }

    // --- *** Tungtung tina Ranahna Relasi *** --- //
}
