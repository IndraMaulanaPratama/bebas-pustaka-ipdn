<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Similaritas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "SIMILARITAS";
    protected $primaryKey = "SIMILARITAS_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];
    protected $fillable = [
        'SIMILARITAS_ID',
        'SIMILARITAS_NUMBER',
        'SIMILARITAS_PRAJA',
        'SIMILARITAS_OFFICER',
        'SIMILARITAS_TITLE',
        'SIMILARITAS_CLASS',
        'SIMILARITAS_ABSENT',
        'SIMILARITAS_VALUE',
        'SIMILARITAS_BIBLIOGRAFI',
        'SIMILARITAS_SMALL_WORD',
        'SIMILARITAS_SMALL_WORD_COUNT',
        'SIMILARITAS_QUOTE',
        'SIMILARITAS_APPROVED',
    ];
    protected $hidden = ['updated_at', 'deleted_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "SIMILARITAS_OFFICER", "id");
    }
}
