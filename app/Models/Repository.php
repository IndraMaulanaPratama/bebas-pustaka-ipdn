<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repository extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "REPOSITORY";
    protected $primaryKey = "REPOSITORY_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];
    protected $fillable = [
        'REPOSITORY_ID',
        'REPOSITORY_URL',
        'REPOSITORY_PRAJA',
        'REPOSITORY_FAKULTAS',
        'REPOSITORY_OFFICER',
        'REPOSITORY_STATUS',
        'REPOSITORY_APPROVED',
        'REPOSITORY_NOTES',
    ];

    // --- *** Ranahna Relasi *** --- //
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "REPOSITORY_OFFICER", "id");
    }
    // --- *** END OF Ranahna Relasi *** --- //
}
