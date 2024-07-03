<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    protected $fillable = [
        'menu_name',
        'menu_relate',
    ];

    protected $primaryKey = 'id';

    protected $table = 'menus';

    // public function getMenuRelation()
    // {
    //     return $this->hasOne(menu_relation::class, 'menu_id', 'id')
    //         ->leftJoin('position', 'position.id', '=', 'menu_relations.position_id');
    // }
}
