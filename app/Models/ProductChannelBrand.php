<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductChannelBrand extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $casts = [
        'PRODUCT' => 'string',
    ];
    protected $guarded = [];
}
