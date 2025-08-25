<?php

namespace App\Models;

use App\Models\Traits\HasSmartDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class bimbingan_pemustaka extends Model
{
    use HasFactory, SoftDeletes, HasSmartDates;

    protected $table = "BIMBINGAN_PEMUSTAKA";
    protected $primaryKey = "PEMUSTAKA_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];
    protected $fillable = ['PEMUSTAKA_ID', 'PEMUSTAKA_PRAJA', 'PEMUSTAKA_FAKULTAS', 'PEMUSTAKA_OFFICER', 'PEMUSTAKA_STATUS', 'PEMUSTAKA_APPROVED'];



    /**
     * --- *** RELATION AREA *** ---
     */


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'PEMUSTAKA_OFFICER', 'id');
    }


    /**
     * --- *** END OF RELATION AREA *** ---
     */
}
