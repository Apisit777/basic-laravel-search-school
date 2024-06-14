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
}
