<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class pivotMenu extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'PIVOT_MENU';
    protected $pimaryKey = 'PIVOT_ID';
    protected $keyType = 'string';
    protected $perPage = 15;

    protected $fillable = [
        'PIVOT_ID',
        'PIVOT_MENU',
        'PIVOT_ROLE',
        'PIVOT_DESCRIPTION',
    ];

    protected $with = ['access', 'menu', 'role'];

    public function access(): HasMany
    {
        return $this->hasMany(Akses::class, 'ACCESS_MENU', 'PIVOT_ID');
    }

    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class, 'MENU_ID', 'PIVOT_MENU');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'PIVOT_ROLE', 'ROLE_ID');
    }
}
