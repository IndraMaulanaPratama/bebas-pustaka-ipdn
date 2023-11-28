<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BebasPustaka extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "BEBAS_PUSTAKA";
    protected $primaryKey = "BEBAS_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];
    protected $fillable = [
        'BEBAS_ID',
        'BEBAS_NUMBER',
        'BEBAS_PRAJA',
        'BEBAS_OFFICER',
    ];

    // --- *** Ranahna Relasi *** --- //

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "BEBAS_OFFICER", "id");
    }

    // --- *** Tungtung tina Ranahna Relasi *** --- //

}
