<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pro_develops extends Model
{
    use HasFactory;
    protected $casts = [
        'PRODUCT' => 'string',
    ];
    public $timestamps = false;
    protected $guarded = [];
    public static function listBrandProDevelops($data = [])
    {
        $dataBrand = (new static())->newQuery()->select('*');

        if (isset($data['orderby'])) {
            $dataBrand->orderBy($data['orderby']);
        }

        // dd($dataBrand);
        return $dataBrand->get();
    }
}
