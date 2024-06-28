<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class user_permission extends Model
{
    protected $table = 'user_permission';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'tent_id',
        'position_id',
    ];

    public $timestamps = true;

    // public function getTent()
    // {
    //     return $this->belongsTo(tent::class, 'tent_id', 'id');
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
