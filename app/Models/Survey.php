<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "SURVEY";
    protected $primaryKey = "SURVEY_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];
    protected $fillable = ['SURVEY_ID', 'SURVEY_URL', 'SURVEY_OFFICER'];


    /**
     * --- *** RELATION AREA *** ---
     */


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'SURVEY_OFFICER', 'id');
    }


    /**
     * --- *** END OF RELATION AREA *** ---
     */

}
