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
    //     return $this->belongsTo(position::class, 'id_position', 'position_id')
    //         ->leftJoin('menus', 'menus.id', '=', 'menu_relations.menu_id');
    // }

    public function getMenuRelation()
    {
        return $this->hasMany(menu_relation::class, 'position_id', 'position_id');
    }

    public function getPosition()
    {
        return $this->hasOne(position::class, 'id_position', 'position_id');
    }
}
