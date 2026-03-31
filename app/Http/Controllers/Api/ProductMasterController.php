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
use App\Models\ProductChannel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProductMasterController extends Controller
{

    public function listProducts(Request $request)
    {

        // ดึงค่าที่ใช้ในการค้นหา
        $queryParams = request()->query();
        $BRAND = "";

        // ตรวจสอบว่ามีค่าหรือไม่
        if (!$queryParams) {
            return response()->json(['status' => false, 'message' => 'กรุณากรอกคำค้นหา', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }


        if (request()->has('BRAND')) {
            $BRAND = request()->query('BRAND');
        } else {
            return response()->json(['status' => false, 'total' => 0, 'message' => 'กรุณากรอกคำค้นหา BRAND', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }

        // $products = Product1::where('BRAND', $BRAND)->whereNotIn('STATUS', ['X', 'O', 'D']);

        $products = Product1::where(function ($q) use ($BRAND) {
            $q->where('BRAND', $BRAND)
              ->orWhereHas('productChannel', function ($query) use ($BRAND) {
                  $query->where('BRAND', $BRAND);
              });
        });

        if (request()->has('PRODUCT')) {
            $PRODUCT = request()->query('PRODUCT');
            $products =  $products->where('PRODUCT', $PRODUCT);
        }

        if (request()->has('PRODUCT_ARR')) {
            $PRODUCT_ARR = request()->query('PRODUCT_ARR');
            $products =  $products->whereIn('PRODUCT', $PRODUCT_ARR);
        }

        if (request()->has('SOLUTION')) {
            $SOLUTION = request()->query('SOLUTION');
            $products =  $products->where('SOLUTION', $SOLUTION);
        }

        if (request()->has('SERIES')) {
            $SERIES = request()->query('SERIES');
            $products =  $products->where('SERIES', $SERIES);
        }

        if (request()->has('CATEGORY')) {
            $CATEGORY = request()->query('CATEGORY');
            $products =  $products->where('CATEGORY', $CATEGORY);
        }

        if (request()->has('S_CAT')) {
            $S_CAT = request()->query('S_CAT');
            $products =  $products->where('S_CAT', $S_CAT);
        }
        if (request()->has('CATEGORY_ARR')) {
            $CATEGORY_ARR = request()->query('CATEGORY_ARR');
            $products =  $products->whereIn('CATEGORY', $CATEGORY_ARR);
        }

        if (request()->has('SUB_CATEGORY_ARR')) {
            $SUB_CATEGORY_ARR = request()->query('SUB_CATEGORY_ARR');
            $products =  $products->whereIn('S_CAT', $SUB_CATEGORY_ARR);
        }

        $products = $products->get();

        $message = "ไม่พบข้อมูล";
        if ($products->count() > 0) {
            $message = "พบข้อมูล";
        }

        return response()->json(['status' => true, 'total' =>  $products->count(),  'message' => $message, 'data' => $products], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function list_series(Request $request)
    {
        // ดึงค่าที่ใช้ในการค้นหา
        $queryParams = request()->query();
        $BRAND = "";

        // ตรวจสอบว่ามีค่าหรือไม่
        if (!$queryParams) {
            return response()->json(['status' => false, 'message' => 'กรุณากรอกคำค้นหา', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }

        if (request()->has('BRAND')) {
            $BRAND = request()->query('BRAND');
        } else {
            return response()->json(['status' => false, 'total' => 0, 'message' => 'กรุณากรอกคำค้นหา BRAND', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }

        $series = Series::where('BRAND', $BRAND);

        $series = $series->get();

        $message = "ไม่พบข้อมูล";
        if ($series->count() > 0) {
            $message = "พบข้อมูล";
        }

        return response()->json(['status' => true, 'total' =>  $series->count(),  'message' => $message, 'data' => $series], 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function list_solutions()
    {

        // ดึงค่าที่ใช้ในการค้นหา
        $queryParams = request()->query();
        $BRAND = "";

        // ตรวจสอบว่ามีค่าหรือไม่
        if (!$queryParams) {
            return response()->json(['status' => false, 'message' => 'กรุณากรอกคำค้นหา', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }

        if (request()->has('BRAND')) {
            $BRAND = request()->query('BRAND');
        } else {
            return response()->json(['status' => false, 'total' => 0, 'message' => 'กรุณากรอกคำค้นหา BRAND', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }

        $solutions = Solution::where('BRAND', $BRAND);

        $solutions = $solutions->get();

        $message = "ไม่พบข้อมูล";
        if ($solutions->count() > 0) {
            $message = "พบข้อมูล";
        }

        return response()->json(['status' => true, 'total' =>  $solutions->count(),  'message' => $message, 'data' => $solutions], 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function list_categorys(Request $request)
    {
        // ดึงค่าที่ใช้ในการค้นหา
        $queryParams = request()->query();
        $BRAND = "";
        $CATEGORY_ARR = [];
        // ตรวจสอบว่ามีค่าหรือไม่
        if (!$queryParams) {
            return response()->json(['status' => false, 'message' => 'กรุณากรอกคำค้นหา', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }

        if (request()->has('BRAND')) {
            $BRAND = request()->query('BRAND');
        } else {
            return response()->json(['status' => false, 'total' => 0, 'message' => 'กรุณากรอกคำค้นหา BRAND', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }


        if (request()->has('BRAND')) {
            $CATEGORY_ARR = request()->query('CATEGORY_ARR');
        }

        $categorys = Category::where('BRAND', $BRAND);
        if (!empty($CATEGORY_ARR)) {
            $categorys =  $categorys->whereIn('ID', $CATEGORY_ARR);
        }

        $categorys = $categorys->get();

        $message = "ไม่พบข้อมูล";
        if ($categorys->count() > 0) {
            $message = "พบข้อมูล";
        }

        return response()->json(['status' => true, 'total' =>  $categorys->count(),  'message' => $message, 'data' => $categorys], 200, [], JSON_UNESCAPED_UNICODE);
    }
    public function list_sub_categorys(Request $request)
    {

        // ดึงค่าที่ใช้ในการค้นหา
        $queryParams = request()->query();
        $BRAND = "";
        $CATEGORY = "";

        // ตรวจสอบว่ามีค่าหรือไม่
        if (!$queryParams) {
            return response()->json(['status' => false, 'message' => 'กรุณากรอกคำค้นหา', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }

        if (request()->has('BRAND')) {
            $BRAND = request()->query('BRAND');
        } else {
            return response()->json(['status' => false, 'total' => 0, 'message' => 'กรุณากรอกคำค้นหา BRAND', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }

        if (request()->has('CATEGORY')) {
            $CATEGORY = request()->query('CATEGORY');
        }

        $sub_categorys = Sub_category::where('BRAND', $BRAND);

        if (!empty($CATEGORY)) {
            $sub_categorys =  $sub_categorys->where('CATEGORY_ID', $CATEGORY);
        }

        $sub_categorys = $sub_categorys->get();

        $message = "ไม่พบข้อมูล";
        if ($sub_categorys->count() > 0) {
            $message = "พบข้อมูล";
        }

        return response()->json(['status' => true, 'total' =>  $sub_categorys->count(),  'message' => $message, 'data' => $sub_categorys], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function list_product_detail(Request $request)
    {

        // ดึงค่าที่ใช้ในการค้นหา
        $queryParams = request()->query();
        $BRAND = "";

        // ตรวจสอบว่ามีค่าหรือไม่
        if (!$queryParams) {
            return response()->json(['status' => false, 'message' => 'กรุณากรอกคำค้นหา', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }


        if (request()->has('BRAND')) {
            $BRAND = request()->query('BRAND');
        } else {
            return response()->json(['status' => false, 'total' => 0, 'message' => 'กรุณากรอกคำค้นหา BRAND', 'data' => []], 400, [], JSON_UNESCAPED_UNICODE);
        }

        // $products = Product1::where('BRAND', $BRAND)->whereNotIn('STATUS', ['X', 'O', 'D']);

        // $products = DB::table('com_product_detail')->where('corporation_id', $BRAND);
        $products = DB::table('product_details')->where(function ($q) use ($BRAND) {
            $q->where('corporation_id', $BRAND)
              ->orWhereIn('product_id', function ($sub) use ($BRAND) {
                  $sub->select('PRODUCT')->from('product_channels')->where('BRAND', $BRAND);
              });
        });


        if (request()->has('PRODUCT')) {
            $PRODUCT = request()->query('PRODUCT');
            $products =  $products->where('product_id', $PRODUCT);
        }



        $products = $products->get();

        $message = "ไม่พบข้อมูล";
        if ($products->count() > 0) {
            $message = "พบข้อมูล";
        }

        return response()->json(['status' => true, 'total' =>  $products->count(),  'message' => $message, 'data' => $products], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
