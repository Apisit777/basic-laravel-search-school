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
}
