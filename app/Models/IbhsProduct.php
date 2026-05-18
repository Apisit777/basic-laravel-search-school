<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IbhsProduct extends Model
{
    use HasFactory;

    protected $table = 'ibhs_products';

    protected $guarded = [];
}
