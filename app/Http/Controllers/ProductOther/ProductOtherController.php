<?php

namespace App\Http\Controllers\ProductOther;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Barcode;
use App\Models\Product1;
use App\Models\Series;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\ProductLine;
use App\Models\ProductType;
use App\Models\MasterBrand;
use App\Models\MasterBrandChannel;
use App\Models\ProductOther;
use Illuminate\Http\Request;

class ProductOtherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        // dd($data);

        if ($userpermission == $isSuperAdmin) {
            $brands = Barcode::select(
            'BRAND')
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->pluck('PRODUCT')
            ->toArray();

        } else if ($userpermission == 'OP') {

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['OP', 'RE', 'CM'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['CPS', 'KM', 'KTY', 'BB', 'LL'])
            // ->get();
            ->pluck('PRODUCT')
            ->toArray();

        } else if ($userpermission == 'CPS') {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['CPS'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'KM', 'KTY', 'BB', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();

        } else if ($userpermission == 'KTY') {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['KTY'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'BB', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();
        } else if ($userpermission == 'GNC') {
            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['GNC'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'BB', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();
        } else if ($userpermission == 'KM') {

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['GNC'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'BB', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();
        } else if ($userpermission == 'BB') {

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['BB'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();
        } else if ($userpermission == 'LL') {

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['LL'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB'])
            ->pluck('PRODUCT')
            ->toArray();
        }

        // dd($dataProductMasterArr);
        return view('product_other.index', compact('brands', 'dataProductMasterArr'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        $allChannels = MasterBrandChannel::select('CHANNEL_NAME')->pluck('CHANNEL_NAME')->toArray();
        $defaultAllChannels = MasterBrandChannel::all();

        if ($userpermission == $isSuperAdmin) {
            $brands = MasterBrand::select(
                'BRAND')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
        } else if ($userpermission == 'CPS') {
            $defaultAllChannels = MasterBrandChannel::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
        }

        // dd($categorys);

        return view('product_other.create', compact(  'brands', 'series', 'categorys', 'sub_categorys', 'allChannels', 'defaultAllChannels'));
    }

    public function productLine(Request $request) 
    {
        // $isSuperAdmin = (Auth::user()->id === 26);
        // $userpermission = Auth::user()->getUserPermission->name_position;
        // $namePosition = explode('-', $userpermission);
        // $userpermission = trim(end($namePosition));

        // // กำหนดรายการ Brand ที่รองรับ
        // $validBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();

        // // ตรวจสอบว่า user มีสิทธิ์ใน Brand ใด
        // $brand = in_array($userpermission, $validBrands) ? $userpermission : 'OP';

        // $data = ProductLine::select('ID', 'CATEGORY_ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
        //     ->where('BRAND', $brand)
        //     ->where('CATEGORY_ID', $request->category_id)
        //     ->get();

        $data = ProductLine::select('ID', 'CATEGORY_ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
            ->where('CATEGORY_ID', $request->category_id)
            ->get();

        return response()->json($data);
    }

    public function productType(Request $request) 
    {
        // $isSuperAdmin = (Auth::user()->id === 26);
        // $userpermission = Auth::user()->getUserPermission->name_position;
        // $namePosition = explode('-', $userpermission);
        // $userpermission = trim(end($namePosition));

        // // กำหนดรายการ Brand ที่รองรับ
        // $validBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();

        // // ตรวจสอบว่า user มีสิทธิ์ใน Brand ใด
        // $brand = in_array($userpermission, $validBrands) ? $userpermission : 'OP';

        // $data = ProductType::select('ID', 'PRODUCT_LINE_ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
        //     ->where('BRAND', $brand)
        //     ->where('PRODUCT_LINE_ID', $request->line_id)
        //     ->get();

        $data = ProductType::select('ID', 'PRODUCT_LINE_ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
            ->where('PRODUCT_LINE_ID', $request->line_id)
            ->get();

        return response()->json($data);
    }

    public function productOtherCategory(Request $request) 
    {
        $isSuperAdmin = (Auth::user()->id === 26);
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        // กำหนดรายการ Brand ที่รองรับ
        $validBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();

        // ตรวจสอบว่า user มีสิทธิ์ใน Brand ใด
        $brand = in_array($userpermission, $validBrands) ? $userpermission : 'OP';

        $data = Category::select('ID', 'SERIES_ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
            ->where('BRAND', $brand)
            ->where('SERIES_ID', $request->series_id)
            ->get();

        return response()->json($data);
    }

    public function productOtherSubCategory(Request $request) 
    {
        $isSuperAdmin = (Auth::user()->id === 26);
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        if ($userpermission == 'OP') {
            $data = Sub_category::select('ID', 'CATEGORY_ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
                ->where('BRAND', 'OP')
                ->where('CATEGORY_ID', $request->category_id)
                ->get();
        } elseif ($userpermission == 'CPS') {
            $data = Sub_category::select('ID', 'CATEGORY_ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
                ->where('BRAND', 'CPS')
                ->where('CATEGORY_ID', $request->category_id)
                ->get();
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $data = ProductOther::select(
            'product_others.product_id AS product_id',
            'product1s.NAME_THAI AS NAME_THAI',
            'product_others.item_name AS item_name',
            'product_others.cat_name AS cat_name',
            'product_others.product_line AS product_line',
            'product_others.product_type AS product_type',
            'categories.ID AS category_id',
            'product_lines.ID AS product_line_id',
            'product_types.ID AS product_type_id',
            'inner_barcode'
        )
        ->leftjoin('product1s', 'product1s.PRODUCT', '=', 'product_others.product_id')
        ->leftjoin('categories', 'categories.ID', '=', 'product1s.CATEGORY')
        ->leftjoin('product_lines', 'product_lines.ID', '=', 'product_others.product_line') // แก้จุดนี้
        ->leftjoin('product_types', 'product_types.ID', '=', 'product_others.product_type') // แก้จุดนี้ด้วย
        ->leftjoin('product_details', 'product_details.product_id', '=', 'product_others.product_id')
        ->firstWhere('product_others.product_id', '=', $id);
        
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        // Backend Controller (แก้ไขเพื่อความถูกต้อง)
        $allChannels = MasterBrandChannel::where('CHANNEL_NAME', '!=', 'all')
        ->pluck('CHANNEL_NAME')->toArray();

        $defaultChannel = ProductOther::where('product_id', '=', $id)
            ->pluck('channel')
            ->map(function ($item) {
                return ucfirst(strtolower($item)); // ปรับให้ตัวแรกใหญ่เสมอ ตรงกับฐานข้อมูล
            })
            ->toArray();

        // ตรวจสอบให้แน่ใจว่ากลับมาเป็น Array แม้จะมีแค่ช่องเดียว
        if (in_array('all', array_map('strtolower', $defaultChannel))) {
            $defaultAllChannels = ['all'];
            } else {
            $defaultAllChannels = count($defaultChannel) > 0 ? $defaultChannel : [];
        }

        $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
        $series = Series::select(
            'ID',
            'DESCRIPTION',
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $categorys = Category::select(
            'ID',
            'DESCRIPTION',
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $sub_categorys = Sub_category::select(
            'ID',
            'CATEGORY_ID',
            'DESCRIPTION',
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();

        $product_lines = ProductLine::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $product_types = ProductType::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();

        // dd($data);  
        // if ($userpermission == $isSuperAdmin) {
        //     $brands = MasterBrand::select(
        //         'BRAND')
        //     ->get();
        //     $series = Series::select(
        //         'ID',
        //         'DESCRIPTION',
        //         'BRAND')
        //     ->get();
        //     $categorys = Category::select(
        //         'ID',
        //         'DESCRIPTION',
        //         'BRAND')
        //     ->get();
        // } else if ($userpermission == 'CPS') {
        //     $defaultAllChannels = MasterBrandChannel::select(
        //         'BRAND')
        //     ->where('BRAND', 'CPS')
        //     ->pluck('BRAND')
        //     ->toArray();
        //     $brands = MasterBrand::select(
        //         'BRAND')
        //     ->where('BRAND', 'CPS')
        //     ->get();
        //     $series = Series::select(
        //         'ID',
        //         'DESCRIPTION',
        //         'BRAND')
        //     ->where('BRAND', 'CPS')
        //     ->get();
        //     $categorys = Category::select(
        //         'ID',
        //         'DESCRIPTION',
        //         'BRAND')
        //     ->where('BRAND', 'CPS')
        //     ->get();
        //     $sub_categorys = Sub_category::select(
        //         'ID',
        //         'CATEGORY_ID',
        //         'DESCRIPTION',
        //         'BRAND')
        //     ->where('BRAND', 'CPS')
        //     ->get();
        // }

        return view('product_other.edit', compact('data', 'brands', 'series', 'categorys', 'product_lines', 'product_types', 'sub_categorys', 'allChannels', 'defaultAllChannels', 'defaultChannel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }

    public function listProductOther(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        // product_others
        $data = ProductOther::select(
            'product_others.product_id AS product_id',
            'product1s.NAME_THAI AS NAME_THAI',
            'product_others.item_name AS item_name',
            'product_others.cat_name AS cat_name',
            'product_others.product_line AS product_line',
            'product_others.product_type AS product_type',
            'inner_barcode'
        )
        ->join('product1s', 'product1s.PRODUCT', '=', 'product_others.product_id')
        ->leftjoin('product_details', 'product_details.product_id', '=', 'product_others.product_id')
        ->orderBy('product_id', 'DESC');

        // dd($data->toSql());
        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        if ($limit > 0) {
            $data->limit($limit)->offset($start);
        }
        $records = $data->get();

        return response()->json([
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
            'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
            'aaData' => $records,
        ]);
    }
}
