<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function getBrandIdListAjax(Request $request)
    {
        $Product = new Product();
        $brandId = $Product->listBrandId(['brand_id' => (int) $request->input('brand_id'), 'orderby' => "product_id"]);

        return response()->json($brandId);
    }
}
