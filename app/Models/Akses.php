<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Akses extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "ACCESSES";
    protected $primaryKey = "ACCESS_ID";
    protected $keyType = "string";
    protected $perPage = 10;

    protected $fillable = [
        'ACCESS_ID',
        'ACCESS_NAME',
        'ACCESS_MENU',
        'ACCESS_CREATE',
        'ACCESS_READ',
        'ACCESS_UPDATE',
        'ACCESS_DELETE',
        'ACCESS_RESTORE',
        'ACCESS_DESTROY',
        'ACCESS_DETAIL',
        'ACCESS_VIEW',
    ];

    public function pivotMenu(): HasOne
    {
        return $this->hasOne(PivotMenu::class, 'ACCESS_MENU', 'PIVOT_ID');
    }
}
