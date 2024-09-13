<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    public $timestamps = false;
    protected $guarded = [];


    // public function getMenuRelation()
    // {
    //     return $this->hasMany(menu_relation::class, 'menu_id', 'id');
    // }
    public function getMenuRelation()
    {
        return $this->hasMany(menu_relation::class, 'menu_id', 'id')
            ->leftJoin('submenus', 'menu_relations.submenu_id', '=', 'submenus.id');
    }

    public function getSubMenu()
    {
        return $this->belongsToMany(submenu::class, 'menu_relations');
    }
    public function getSubMenuLeft()
    {
        return $this->hasMany(submenu::class, 'menu_id', 'id');
    }
    public function submenus()
    {
        return $this->hasMany(submenu::class, 'menu_id', 'id');
    }
    public function getPermissionSubmenus()
    {
        return $this->hasMany(submenu::class, 'menu_id', 'id')
            ->leftJoin('menu_relations', 'submenus.id', '=', 'menu_relations.submenu_id');
    }
}
