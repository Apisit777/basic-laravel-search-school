<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class position extends Model
{
    protected $table = 'position';

    protected $fillable = [
        'id_position',
        'name_position',
        'menu_1',
        'menu_2',
        'menu_3',
        'menu_4',
        'menu_5',
        'menu_6',
        'menu_7',
        'menu_8',
        'menu_9',
        'menu_10',
        'menu_11',
    ];
}
