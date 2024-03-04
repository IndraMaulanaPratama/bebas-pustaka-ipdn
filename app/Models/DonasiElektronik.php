<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonasiElektronik extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "DONASI_ELEKTRONIK";
    protected $primaryKey = "ELEKTRONIK_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];

    protected $fillable = [
        'ELEKTRONIK_ID',
        'ELEKTRONIK_ID_PO',
        'ELEKTRONIK_PRAJA',
        'ELEKTRONIK_FAKULTAS',
        'ELEKTRONIK_OFFICER',
        'ELEKTRONIK_STATUS',
        'ELEKTRONIK_APPROVED',
        'ELEKTRONIK_NOTES',
    ];


    // --- *** Ranahna Relasi *** --- //
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "ELEKTRONIK_OFFICER", "id");
    }


    public function pivot_donasi(): HasOne
    {
        return $this->hasOne(PivotDonasi::class, "PIVOT_ELEKTRONIK", "ELEKTRONIK_ID");
    }


    // --- *** Tungtung tina Ranahna Relasi *** --- //
}
