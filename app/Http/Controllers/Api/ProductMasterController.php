<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Series;
use App\Models\Solution;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Product1;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProductMasterController extends Controller
{
   
    public function listProducts()
    {
        $product = Product1::select(
            'product1s.*'
        )
            ->get();

        return response()->stream(function () use ($product) {
            echo json_encode($product, JSON_UNESCAPED_UNICODE);
        }, 200, ['Content-Type' => 'application/json']);
    }
}
