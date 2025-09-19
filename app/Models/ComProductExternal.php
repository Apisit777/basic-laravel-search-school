<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComProductExternal extends Model
{
    use HasFactory;
    protected $connection = 'mysql_external'; // ใช้ connection ของ external DB
    protected $table = 'com_products';
    public $timestamps = false;
    protected $primaryKey = 'product_id'; // ถ้าคีย์เป็น product_id
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'product_id' => 'string',
    ];
    protected $guarded = []; // อนุญาตทุกฟิลด์ หรือกำหนด $fillable แทนก็ได้
}
