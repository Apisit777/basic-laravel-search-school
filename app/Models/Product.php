<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'name',
    //     'seq',
    //     'status'
    // ];

    public $timestamps = false;
    protected $guarded = [];

    public static function listBrandId($data = [])
    {
        $dataBrandId = (new static())->newQuery()->select('*');

        if (isset($data['brand_id'])) {
            $dataBrandId->where('products.brand_id', $data['brand_id']);
        }

        if (isset($data['orderby'])) {
            $dataBrandId->orderBy($data['orderby']);
        }

        return $dataBrandId->get();
    }
}
