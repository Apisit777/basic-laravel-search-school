<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu_relation extends Model
{
    use HasFactory;
    public $timestamps = false;
    // protected $guarded = [];

    protected $fillable = ['menu_relations'];

    protected $casts = [
        'menu_relations' => 'array',
    ];
}
