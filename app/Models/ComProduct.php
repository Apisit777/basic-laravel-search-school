<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComProduct extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'com_products';
    public $timestamps = false;
    protected $primaryKey = 'product_id'; // ถ้าคีย์เป็น product_id
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'product_id' => 'string',
    ];
    protected $guarded = [];
}
