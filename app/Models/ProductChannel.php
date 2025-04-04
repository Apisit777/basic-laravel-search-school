<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductChannel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $casts = [
        'PRODUCT' => 'string',
    ];
    protected $guarded = [];
}
