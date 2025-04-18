<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product1 extends Model
{
    use HasFactory;
    protected $table = 'product1s';
    protected $primaryKey = 'PRODUCT';
    protected $casts = [
        'PRODUCT' => 'string',
        'BARCODE' => 'string', // กันพลาดในอนาคต
    ];
    public $timestamps = false;
    protected $guarded = [];

    public function productChannel()
    {
        return $this->hasMAny(ProductChannel::class, 'PRODUCT', 'PRODUCT');
    }

    public function getProductAttribute($value)
    {
        return (string) $value;
    }
}
