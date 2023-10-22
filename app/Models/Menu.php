<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'MENUS';
    protected $primaryKey = 'MENU_ID';
    protected $keyType = 'string';
    protected $perPage = 10;
    protected $fillable = ['MENU_ID','MENU_NAME', 'MENU_ICON', 'MENU_DESCRIPTION', 'MENU_URL', 'MENU_POSITION'];

    /**
     * --- *** RELATION AREA *** ---
     */

    public function pivotMenu(): HasMany
    {
        return $this->hasMany(pivotMenu::class, 'PIVOT_MENU', 'MENU_ID');
    }

    // --- *** END OF RELATION AREA *** ---


    /**
     * --- *** SCOPE AREA *** ---
     */
    public function scopeDelete(Builder $builder, string $id)
    {
        return $builder->delete()->where('MENU_ID', $id);
    }

    public function scopeGetData(Builder $builder, ...$params)
    {
        return $builder
            ->when(
                $params['id'],
                function (Builder $query) use ($params) {
                    $query->where('MENU_ID', $params['id']);
                }
            )
            ->when($params['menu'], function (Builder $query) use ($params) {
                $query->where('MENU_NAME', $params['menu']);
            });
    }

    public function scopeGetTrash(Builder $builder, ...$params)
    {
        return $builder
            ->when(
                $params['id'],
                function (Builder $query) use ($params) {
                    $query->where('MENU_ID', $params['id']);
                }
            )
            ->when($params['menu'], function (Builder $query) use ($params) {
                $query->where('MENU_NAME', $params['menu']);
            })
            ->withoutTrashed();
    }

    public function scopeUpdate(Builder $builder, array $data)
    {
        return $builder->where('MENU_ID', '=', $data['id'])->update($data);
    }

    // --- *** END OF SCOPE AREA *** ---
}
