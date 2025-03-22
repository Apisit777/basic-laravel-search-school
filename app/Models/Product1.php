<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product1 extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======
    protected $table = 'product1s';
    protected $primaryKey = 'PRODUCT';
>>>>>>> 91b246dbc35479f4c34ce8289271a80eccbbc360
    public $timestamps = false;
    protected $guarded = [];

    public function productChannel()
    {
        return $this->hasMAny(ProductChannel::class, 'PRODUCT', 'PRODUCT');
    }
}
