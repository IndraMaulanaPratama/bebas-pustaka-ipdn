<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'MENUS';
    protected $primaryKey = 'MENU_ID';
    protected $fillable = ['MENU_NAME', 'MENU_DESCRIPTION', 'MENU_URL'];
    protected $perPage = 10;

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
}
