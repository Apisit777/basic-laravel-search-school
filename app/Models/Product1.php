<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product1 extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function productChannel()
    {
        return $this->hasMAny(ProductChannel::class, 'PRODUCT', 'PRODUCT');
    }
}
