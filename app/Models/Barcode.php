<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $primaryKey = "ID";
    // protected $guarded = [];
    protected $fillable = [
        'BRAND',
        'NUMBER'
    ];
}
