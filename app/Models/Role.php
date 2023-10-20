<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ROLES';
    protected $primaryKey = 'ROLE_ID';
    protected $keyType = 'string';
    protected $perpage = 10;

    protected $fillable = [
        'ROLE_NAME'
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'user_role', 'ROLE_ID');
    }

    public function pivotMenu(): HasMany
    {
        return $this->hasMany(pivotMenu::class, 'PIVOT_ROLE', 'ROLE_ID');
    }

}
