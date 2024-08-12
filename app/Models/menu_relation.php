<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu_relation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    // public function getMenuRelation()
    // {
    //     return $this->hasMany(menu_relation::class, 'position_id', 'position_id');
    // }
    public function getMenu()
    {
        return $this->belongsTo(menu::class, 'menu_id', 'id');
    }
    public function getSubMenu()
    {
        return $this->hasMany(submenu::class, 'menu_relation_id', 'id');
            // ->leftJoin('menu_relations', 'menu_relations.menu_id', 'menus.id');
    }
    public function getPosition()
    {
        return $this->hasOne(position::class, 'id', 'position_id');
    }
}
