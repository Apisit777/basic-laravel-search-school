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

    public function getMenuRelation()
    {
        return $this->hasMany(menu_relation::class, 'menu_id', 'id');
    }

    public function getSubMenu()
    {
        return $this->belongsToMany(submenu::class, 'menu_relations');
    }
}
