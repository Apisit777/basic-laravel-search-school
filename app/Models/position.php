<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class position extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public function getPs()
    {
        return $this->hasMany(menu_relation::class, 'position_id', 'id');
    }
}
