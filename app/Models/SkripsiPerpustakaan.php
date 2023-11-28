<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkripsiPerpustakaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "SKRIPSI_PERPUSTAKAAN";
    protected $primaryKey = "SKRIPSI_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];
    protected $fillable = [
        'SKRIPSI_ID',
        'SKRIPSI_PRAJA',
        'SKRIPSI_OFFICER',
        'SKRIPSI_STATUS',
        'SKRIPSI_APPROVED',
        'SKRIPSI_NOTES',
    ];

    /**
     * --- *** RELATION AREA *** ---
     */

    public function pivot_skripsi(): BelongsTo
    {
        return $this->belongsTo(PivotSkripsi::class, 'SKRIPSI_ID', 'PIVOT_PUSTAKA');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'SKRIPSI_OFFICER', 'id');
    }


    /**
     * --- *** END OF RELATION AREA *** ---
     */

}
