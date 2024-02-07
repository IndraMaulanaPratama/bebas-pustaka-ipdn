<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KontenLiterasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "KONTEN_LITERASI";
    protected $primaryKey = "KONTEN_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];
    protected $fillable = [
        'KONTEN_ID',
        'KONTEN_URL',
        'KONTEN_PRAJA',
        'KONTEN_FAKULTAS',
        'KONTEN_OFFICER',
        'KONTEN_STATUS',
        'KONTEN_APPROVED',
        'KONTEN_NOTES',
    ];


    // --- *** Ranahna Relasi *** --- //
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "KONTEN_OFFICER", "id");
    }
    // --- *** END OF Ranahna Relasi *** --- //
}
