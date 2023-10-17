<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'ROLES';
    protected $primaryKey = 'ROLE_ID';

    protected $fillable = [
        'ROLE_NAME'
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'user_role', 'ROLE_ID');
    }
}
