<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class position extends Model
{
    protected $table = 'position';

    protected $fillable = [
        'id_position',
        'name_position',
    ];
    // public function getMenuRelation()
    // {
    //     return $this->hasOne(menu_relation::class, 'position_id', 'id_position')
    //         ->leftJoin('menus', 'menus.id', '=', 'menu_relations.menu_id');
    // }
}
