<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreIbshFiel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'core_ibsh_fiels';
    protected $guarded = [];
}
