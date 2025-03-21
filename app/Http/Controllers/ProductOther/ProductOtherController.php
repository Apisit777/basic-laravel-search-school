<?php

namespace App\Http\Controllers\ProductOther;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Barcode;
use App\Models\Product1;
use App\Models\Product1Log;
use App\Models\Series;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\ProductLine;
use App\Models\ProductType;
use App\Models\CpsSkinType;
use App\Models\CpsCoverageBenefit;
use App\Models\CpsUsageArea;
use App\Models\CpsTextureFormula;
use App\Models\CpsFinish;
use App\Models\CpsPackageType1;
use App\Models\CpsPackageType2;
use App\Models\MasterBrand;
use App\Models\MasterBrandChannel;
use App\Models\ProductOther;
use App\Models\ProductOtherLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'product_others.*',
            'product_others.product_id AS product_id',
            'product1s.NAME_THAI AS NAME_THAI',
            'product_others.item_name AS item_name',
            'product_others.cat_name AS cat_name',
            'product_others.product_line AS product_line',
            'product_others.product_type AS product_type',
            'product_others.color_name_th AS color_name_th',
            'product_others.color_name_en AS color_name_en',
            'product_others.suppiler_th AS suppiler_th',
            'product_others.suppiler_en AS suppiler_en',
            'product_others.other_detail AS other_detail',
            'categories.ID AS category_id',
            'product_lines.ID AS product_line_id',
            'product_types.ID AS product_type_id',
            'cps_skin_types.ID AS skin_type_id',
            'cps_coverage_benefits.ID AS coverage_id',
            'cps_usage_areas.ID AS usage_area_id',
            'cps_texture_formulas.ID AS texture_id',
            'cps_finishes.ID AS finish_id',
            'cps_package_type1s.ID AS package_type1_id',
            'cps_package_type2s.ID AS package_type2_id',
            'inner_barcode'
        )
        ->leftjoin('product1s', 'product1s.PRODUCT', '=', 'product_others.product_id')
        ->leftjoin('categories', 'categories.ID', '=', 'product1s.CATEGORY')
        ->leftjoin('product_lines', 'product_lines.ID', '=', 'product_others.product_line') // แก้จุดนี้
        ->leftjoin('product_types', 'product_types.ID', '=', 'product_others.product_type') // แก้จุดนี้ด้วย
        ->leftjoin('product_details', 'product_details.product_id', '=', 'product_others.product_id')
        ->leftjoin('cps_skin_types', 'cps_skin_types.ID', '=', 'product_others.skin_type')
        ->leftjoin('cps_coverage_benefits', 'cps_coverage_benefits.ID', '=', 'product_others.coverage')
        ->leftjoin('cps_usage_areas', 'cps_usage_areas.ID', '=', 'product_others.usage_area')
        ->leftjoin('cps_texture_formulas', 'cps_texture_formulas.ID', '=', 'product_others.texture')
        ->leftjoin('cps_finishes', 'cps_finishes.ID', '=', 'product_others.finish')
        ->leftjoin('cps_package_type1s', 'cps_package_type1s.ID', '=', 'product_others.package')
        ->leftjoin('cps_package_type2s', 'cps_package_type2s.ID', '=', 'product_others.package2')
        ->firstWhere('product_others.product_id', '=', $id);
        
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        // Backend Controller (แก้ไขเพื่อความถูกต้อง)
        $allChannels = MasterBrandChannel::where('CHANNEL_NAME', '!=', 'all')
        ->pluck('CHANNEL_NAME')->toArray();

        // $defaultChannel = ProductOther::where('product_id', '=', $id)
        //     ->pluck('channel')
        //     ->map(function ($item) {
        //         return ucfirst(strtolower($item)); // ปรับให้ตัวแรกใหญ่เสมอ ตรงกับฐานข้อมูล
        //     })
        //     ->toArray();

        $defaultChannel = ProductOther::where('product_id', '=', $id)
            ->pluck('channel')
            ->map(function ($item) {
                // แปลงตัวอักษรทุกตัวให้เป็นตัวเล็กก่อน
                $lowercaseItem = strtolower($item);
                // ตรวจสอบว่าค่ามีแค่ 2 ตัวอักษร (เช่น "MT") หรือไม่
                if (strlen($lowercaseItem) <= 2) {
                    return ucfirst($lowercaseItem);
                }
                // ถ้าเป็นคำปกติ ใช้ ucwords() ทำให้ตัวแรกของแต่ละคำเป็นตัวใหญ่
                return ucwords($lowercaseItem);
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
        $skinTypes = CpsSkinType::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $coverageBenefits = CpsCoverageBenefit::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $usageAreas = CpsUsageArea::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $textureFormulas = CpsTextureFormula::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $finishs = CpsFinish::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $packageType1s = CpsPackageType1::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $packageType2s = CpsPackageType2::select(
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

        return view('product_other.edit', compact('data', 'brands', 'series', 'categorys', 'product_lines', 'product_types', 'skinTypes', 'coverageBenefits', 'usageAreas', 'textureFormulas', 'finishs', 'packageType1s', 'packageType2s', 'sub_categorys', 'allChannels', 'defaultAllChannels', 'defaultChannel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        DB::beginTransaction();
        try {
                // ค้นหาข้อมูลเดิมจาก ProductOther
                $data_old = ProductOther::where('product_id', $id)->first();

                // ตรวจสอบว่าเจอข้อมูลหรือไม่
                if ($data_old) {
                    $data_old_arr = $data_old->toArray();
                    // เพิ่ม Log ถ้ามีค่าที่ต้องการอัปเดต
                    $log = [
                        'update_dt' => date("Y/m/d H:i:s"),
                        'user_update' => Auth::user()->username,
                    ];

                    $data_old_arr = array_merge($data_old_arr, $log);
                    ProductOtherLog::create($data_old_arr);
                }

                $data_product_upddate = [
                    'item_name' => $request->input('item_name'),
                    'cat_name' => $request->input('cat_name'),
                    'usage_area' => $request->input('usage_area'),
                    'product_line' => $request->input('product_line'),
                    'texture' => $request->input('texture'),
                    'product_type' => $request->input('product_type'),
                    'finish' => $request->input('finish'),
                    'skin_type' => $request->input('skin_type'),
                    'package' => $request->input('package'),
                    'coverage' => $request->input('coverage'),
                    'package2' => $request->input('package2'),
                    'color_name_th' => $request->input('color_name_th'),
                    'color_name_en' => $request->input('color_name_en'),
                    'suppiler_th' => $request->input('suppiler_th'),
                    'suppiler_en' => $request->input('suppiler_en'),
                    'color_code' => $request->input('color_code'),
                    'other_detail' => $request->input('other_detail'),
                    'sls_free' => $request->input('sls_free'),
                    'natural_alcohol' => $request->input('natural_alcohol'),
                    'silicone_free' => $request->input('silicone_free'),
                    'certified_food' => $request->input('certified_food'),
                    'mineral_free' => $request->input('mineral_free'),
                    'certified_organic' => $request->input('certified_organic'),
                    'colorant_free' => $request->input('colorant_free'),
                    'hypoallergenic' => $request->input('hypoallergenic'),
                    'phthalate_free' => $request->input('phthalate_free'),
                    'tested' => $request->input('tested'),
                    'cruelty_free' => $request->input('cruelty_free'),
                    'non_comedogenic' => $request->input('non_comedogenic'),
                    'talc_free' => $request->input('talc_free'),
                    'synthetic_colorant' => $request->input('synthetic_colorant'),
                    'oil_free' => $request->input('oil_free'),
                    'synthetic_fragrance' => $request->input('synthetic_fragrance'),
                    'triethanolamin_free' => $request->input('triethanolamin_free'),
                    'ph_balance' => $request->input('ph_balance'),
                    'petroleum_free' => $request->input('petroleum_free'),
                    'chil_over_6year' => $request->input('chil_over_6year'),
                    'petrolatum_free' => $request->input('petrolatum_free'),
                    'fragrance_free' => $request->input('fragrance_free'),
                    'alcohol_free' => $request->input('alcohol_free'),
                    'paraben_free' => $request->input('paraben_free'),
                    'pregnancy' => $request->input('pregnancy'),
                    'breastfeed' => $request->input('breastfeed'),
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s")
                ];

                // อัปเดตข้อมูล
                $ProductOther = ProductOther::where('product_id', $id)->update($data_product_upddate);

                // ดึงข้อมูลล่าสุดหลังจากอัปเดต
                $upddateProduct1s = ProductOther::where('product_id', $id)->first();

                $data_old_product1s = Product1::where('PRODUCT', $id)->first();

                // ตรวจสอบว่าเจอข้อมูลหรือไม่
                if ($data_old_product1s) {
                    $data_old_product1s_arr = $data_old_product1s->toArray();

                    // เพิ่ม Log ถ้ามีค่าที่ต้องการอัปเดต
                    $log = [
                        'UPDATE_DT' => date("Y/m/d H:i:s"),
                        'USER_UPDATE' => Auth::user()->username,
                    ];

                    $data_old_product1s_arr = array_merge($data_old_product1s_arr, $log);
                    $Product1Log = Product1Log::create($data_old_product1s_arr);
                }
                // dd($id);
                // อัปเดตหรือสร้างข้อมูลใหม่
                $Product1 = Product1::updateOrCreate(
                    ['PRODUCT' => $id],
                    [
                        'CATEGORY' => $upddateProduct1s->cat_name,
                        'USER_EDIT' => Auth::user()->username,
                        'EDIT_DT' => date("Y-m-d"),
                        'STATUS_EDIT_DT' => ''
                    ]
                );

                // dd($attributes = [
                //     'ProductOther' => $ProductOther,
                //     'Product1Log' => $Product1Log->toArray(),
                //     'Product1' => $Product1->toArray(),
                //     // 'craeteProductAccountSchedule' => $craeteProductAccountSchedule->toArray(),
                // ]);
                // dd($ProductOther);
                DB::commit();
                $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
                return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
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
