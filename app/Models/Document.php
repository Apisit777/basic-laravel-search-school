<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    public $timestamps = false;
    // public $primaryKey = null;
    // protected $guarded = [];
    public $primaryKey = "DOC_TP";
    protected $fillable = [
        'DOC_TP',
        'NUMBER'
    ];
}
