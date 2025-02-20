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
        $isSuperAdmin = (Auth::user()->id === 26);
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        // กำหนดรายการ Brand ที่รองรับ
        $validBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();

        // ตรวจสอบว่า user มีสิทธิ์ใน Brand ใด
        $brand = in_array($userpermission, $validBrands) ? $userpermission : 'OP';

        $data = ProductLine::select('ID', 'CATEGORY_ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
            ->where('BRAND', $brand)
            ->where('CATEGORY_ID', $request->category_id)
            ->get();

        return response()->json($data);
    }

    public function productType(Request $request) 
    {
        $isSuperAdmin = (Auth::user()->id === 26);
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        // กำหนดรายการ Brand ที่รองรับ
        $validBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();

        // ตรวจสอบว่า user มีสิทธิ์ใน Brand ใด
        $brand = in_array($userpermission, $validBrands) ? $userpermission : 'OP';

        $data = ProductType::select('ID', 'PRODUCT_LINE_ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
            ->where('BRAND', $brand)
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
    public function edit(Request $request)
    {
        //
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
}
