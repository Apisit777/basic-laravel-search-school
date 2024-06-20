<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public static function listBrand($data = [])
    {
        $dataBrand = (new static())->newQuery()->select('*');

        if (isset($data['orderby'])) {
            $dataBrand->orderBy($data['orderby']);
        }

        return $dataBrand->get();
    }
}
