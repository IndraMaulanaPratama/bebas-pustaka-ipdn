<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SettingApps extends Model
{
    use HasFactory;

    protected $table = "SETTING_APPS";
    protected $primaryKey = "SETTING_ID";
    protected $keyType = "string";
    protected $with = ['user'];
    protected $fillable = [
        "SETTING_ID",
        "SETTING_HEAD_OFFICE",
        "SETTING_HEAD_OFFICE_ID",
        "SETTING_URL_SURVEY",
        "SETTING_URL_LITERASI",
        "SETTING_URL_REPOSITORY",
        "SETTING_OFFICER",
    ];



    // --- *** RELATION AREA *** ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'SETTING_ID', 'id');
    }

    // --- *** END OF RELATION AREA *** ---


}
