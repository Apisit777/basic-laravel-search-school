<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    public $timestamps = false;
    protected $guarded = [];


    public function getMenuRelation()
    {
        return $this->hasMany(menu_relation::class, 'menu_id', 'id');
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
}
