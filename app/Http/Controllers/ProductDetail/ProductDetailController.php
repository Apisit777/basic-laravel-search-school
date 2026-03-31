<?php

namespace App\Http\Controllers\ProductDetail;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Barcode;
use App\Models\Product1;
use App\Models\Product1Log;
use App\Models\ProductChannel;
use App\Models\ProductDetail;
use App\Models\ProductDetailExportExcel;
use App\Models\ProductDetailLog;
use App\Models\Com_product;
use App\Models\ComProductImage;
use App\Models\ComProduct;
use App\Models\ComProductLog;
use App\Models\Countrie;
use App\Models\ProductOther;
use App\Models\ProductOtherLog;
use App\Models\CoreIbshFiel;
use App\Models\user_permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use DateTime; // ✅ เพิ่มบรรทัดนี้
use Illuminate\Support\Facades\Cache;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // ✅ ดึงชื่อ field ทั้งหมดจากตาราง product_detail_export_excel
        // $fields = Schema::getColumnListing('product_detail_export_excels');

        // dd($fields);

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $userDepartment = Auth::user()->getUserDepartment->department;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        // dd($userpermission);

        $getSelect2ProDevelops = []; // ✅ กันไว้ก่อนเลย

        // if ($userpermission == $isSuperAdmin) {
        //     $brands = Barcode::select(
        //     'BRAND')
        //     ->pluck('BRAND')
        //     ->toArray();

        //     $dataProductMasterArr = Product1::select(
        //     'PRODUCT')
        //     ->pluck('PRODUCT')
        //     ->toArray();

        // } else if ($userpermission == 'OP') {

        //     $brands = Barcode::select(
        //     'BRAND',
        //         'STATUS')
        //     ->whereIn('STATUS', ['OP', 'RE', 'CM'])
        //     ->pluck('BRAND')
        //     ->toArray();

        //     $dataProductMasterArr = Product1::select(
        //     'PRODUCT')
        //     ->whereNotIn('BRAND', ['CPS', 'KM', 'KTY', 'BB', 'LL'])
        //     // ->get();
        //     ->pluck('PRODUCT')
        //     ->toArray();

        // } else 
        if ($userpermission == 'CPS' || $userDepartment == 'IBSH') {
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

            // ดึง PRODUCT ทั้งหมดที่มีอยู่ใน product1s ก่อน
            $validProducts = DB::table('product1s')
                ->pluck('PRODUCT')
                ->toArray();

            // จากนั้นดึงข้อมูลจาก ProductChannel ที่ brand = 'CPS' และมี PRODUCT อยู่ใน product1s.PRODUCT
            $getSelect2ProDevelops = ProductChannel::select('PRODUCT')
                ->whereIn('BRAND', ['CPS'])
                ->whereIn('PRODUCT', $validProducts)
                ->orderBy('PRODUCT', 'asc')
                ->pluck('PRODUCT')
                ->toArray();    
        }

        // $endpoint = "http://sapkmacc.ssup.co.th/api/bom/bulk";
        // $res = Http::get($endpoint);

        // $raw = $res->body();

        // // decode เอง (ตัดปัญหา header/format เพี้ยน)
        // $data = json_decode($raw, true);
        // // dd($data);

        // if (json_last_error() !== JSON_ERROR_NONE) {
        //     dd('JSON ERROR: '.json_last_error_msg(), $raw);
        // }

        // // ✅ pretty print
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);



        // $endpoint = "http://sapkmacc.ssup.co.th/api/bom/bulk";
        // $res = Http::get($endpoint);

        // $data = json_decode($res->body(), true);
        // if (json_last_error() !== JSON_ERROR_NONE) {
        //     dd('JSON ERROR: '.json_last_error_msg(), $res->body());
        // }

        // $normalized = [];

        // foreach ($data as $k => $items) {

        //     // ✅ บางตัวไม่ใช่ array ก็ข้าม
        //     if (!is_array($items)) continue;

        //     foreach ($items as $row) {

        //         // ✅ ถ้าเป็น "row จริง" จะมี mkt_code
        //         if (is_array($row) && array_key_exists('mkt_code', $row)) {
        //             $mkt = (string)$row['mkt_code'];
        //             $normalized[$mkt][] = $row;
        //             continue;
        //         }

        //         // ✅ ถ้าเป็น "ชุดของ rows" (ซ้อนอีกชั้น) ให้แตกออก
        //         if (is_array($row)) {
        //             foreach ($row as $row2) {
        //                 if (is_array($row2) && array_key_exists('mkt_code', $row2)) {
        //                     $mkt = (string)$row2['mkt_code'];
        //                     $normalized[$mkt][] = $row2;
        //                 }
        //             }
        //         }
        //     }
        // }

        // // dd($normalized);

        // // ... หลัง loop normalize เสร็จแล้ว
        // dd([
        // 'has_75422' => array_key_exists('75422', $normalized),
        // 'count_75422' => isset($normalized['75422']) ? count($normalized['75422']) : 0,
        // 'sample_75422' => $normalized['75422'][0] ?? null,
        // 'keys_like_75422' => array_values(array_filter(array_keys($normalized), fn($k)=>str_contains((string)$k,'75422'))),
        // ]);



        return view('product_detail.index', compact('brands', 'dataProductMasterArr', 'getSelect2ProDevelops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product_detail.create');
    }

    public function productDetailCreate(Request $request)
    {
        // $productCodeMax = Product::max('seq');
        // $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        // $productCode = 'P'.sprintf('%05d', $productCodeNumber);

        // $list_position = position::select('id', 'name_position')->get();
        // dd($productCode);
        return view('product_detail.create');
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
    // public function show(Request $request)
    // {
    //     //
    // }

    public function show(Request $request, $product_id)
    {
        // ✅ 1) DB เดิมของคุณ
        $data = ProductDetail::select(
            'product_details.corporation_id as corporation_id',
            'product_details.product_id as product_id',
            'product_details.ingredients as ingredients',
            'product_details.natural_active_ingredients as natural_active_ingredients',
            'product_details.ingredient_from_natural_origin as ingredient_from_natural_origin',
            'product_details.ingredient_from_natural_ref_isO16128 as ingredient_from_natural_ref_isO16128',
            'product_others.*',
            'pro_develops.JOB_REFNO as JOB_REFNO',
            'product1s.NAME_THAI as NAME_THAI',
            'product1s.AGE as AGE',
            'categories.DESCRIPTION as cat_name',
        )
        ->leftJoin('product1s', 'product_details.product_id', '=', 'product1s.PRODUCT')
        ->leftJoin('pro_develops', 'product_details.product_id', '=', 'pro_develops.PRODUCT')
        ->leftJoin('product_others', 'product_details.product_id', '=', 'product_others.product_id')
        ->leftJoin('categories', 'categories.ID', '=', 'product1s.CATEGORY')
        ->orderBy('product_details.product_id', 'ASC')
        ->firstWhere('product_details.product_id', '=', $product_id);

        // dd($data->ingredients);

        $images = ComProductImage::select(
            'id','product_id','seq',
            DB::raw("CASE
                WHEN com_product_images.path LIKE 'https%' THEN com_product_images.path
                ELSE com_product_images.path
            END AS path")
        )
        ->where('product_id', $product_id)
        ->orderBy('seq', 'asc')
        ->get();

        // ✅ 2) รับ FG code จาก query string
        $fgCode = trim((string)$request->query('code', '')); // เช่น 9-CP75422-2

        // ✅ 3) ดึง BOM จาก SAP API (cache 10 นาที)
        $endpoint = "http://sapkmacc.ssup.co.th/api/bom/bulk";
        $raw = Cache::remember('sap_bom_bulk_raw', 600, function () use ($endpoint) {
            return Http::timeout(30)->get($endpoint)->body();
        });

        $bomAll = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($bomAll)) {
            // ถ้า API พัง ก็ยังเข้า show ได้ แค่ไม่มี bom
            $bomAll = [];
        }

        // ✅ 4) ดึงเฉพาะชุดของ product_id (รองรับ key 75422 และ 75422F1)
        $bomRows = [];
        foreach ($bomAll as $k => $items) {
            $kStr = (string)$k;
            if ($kStr === (string)$product_id || str_starts_with($kStr, (string)$product_id)) {
                if (!is_array($items)) continue;

                foreach ($items as $row) {
                    if (is_array($row) && isset($row['code'])) {
                        $bomRows[] = $row;
                    } elseif (is_array($row)) { // เผื่อซ้อน
                        foreach ($row as $row2) {
                            if (is_array($row2) && isset($row2['code'])) $bomRows[] = $row2;
                        }
                    }
                }
            }
        }

        // ✅ 5) เลือก “เอกสารที่จะแสดง” ตาม fgCode
        $selectedBom = null;

        if ($fgCode !== '') {
            foreach ($bomRows as $r) {
                if (($r['code'] ?? '') === $fgCode) { $selectedBom = $r; break; }
            }
        }

        // ถ้าไม่ส่ง code มา: เลือกตัวหลักก่อน (ไม่ใช่ -1/-2) ถ้าไม่มีค่อยเอาตัวแรก
        if (!$selectedBom && count($bomRows) > 0) {
            foreach ($bomRows as $r) {
                $c = (string)($r['code'] ?? '');
                if (!preg_match('/-\d+$/', $c)) { $selectedBom = $r; break; }
            }
            if (!$selectedBom) $selectedBom = $bomRows[0];
        }

        // ✅ 6) ดึงรูป IBSH แยกตาม form_type (เฉพาะ image)
        $ibshSpecialImages = CoreIbshFiel::where('product_id', $product_id)
            ->where('form_type', 'special_ingredients')
            ->where('file_type', 'image')
            ->orderBy('id', 'desc')
            ->get();

        $ibshCharacteristicImages = CoreIbshFiel::where('product_id', $product_id)
            ->where('form_type', 'characteristic')
            ->where('file_type', 'image')
            ->orderBy('id', 'desc')
            ->get();

        // ✅ 7) ส่งไป view เพิ่มตัวแปร bom
        return view('product_detail.show', compact('data', 'images', 'selectedBom', 'bomRows', 'fgCode', 'ibshSpecialImages', 'ibshCharacteristicImages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        // dd($id);
        $data = ProductDetail::select(
            'product_details.*',
            'com_products.barcode AS barcode',
            'com_products.ref_barcode_real AS ref_barcode_real',
        )
        ->leftJoin('com_products', 'product_details.product_id', '=', 'com_products.product_id')
        ->firstWhere('product_details.product_id', '=', $id);

        // แปลงวันที่เฉพาะตอนที่มีค่า
        if (!empty($data) && !empty($data->launch)) {
            $raw = trim($data->launch);

            // รองรับทั้ง m-Y และ Y-m
            $dt = DateTime::createFromFormat('m-Y', $raw) ?: DateTime::createFromFormat('Y-m', $raw);

            if ($dt instanceof DateTime) {
                $data->launch = $dt->format('Y-m');   // ได้ 2019-09
            } else {
                // ถ้า parse ไม่ได้: เลือกจัดการตามต้องการ
                $data->launch = null; // หรือคงค่าเดิม $data->launch = $raw;
            }
        }
        // dd($data);

        // $dataComProduct = Com_product::select(
        //     'com_products.*',
        // )
        // ->firstWhere('product_id', '=', $id);

        // ✅ เรียก API ข้อมูลประเทศ
        // $endpoint = "https://restcountries.com/v3.1/all?fields=name";
        // $apiResponse = Http::asForm()->get($endpoint);
        // if (!$apiResponse->successful()) {
        //     return redirect()->back()->with('error', 'Failed to fetch country data.');
        // }
        // $countriesData = collect($apiResponse->json());
        // $countriesDatas = $countriesData->pluck('name.common')->toArray();

        $countriesDatas = Countrie::select('id AS country', 'name_country')->orderBy('name_country', 'ASC')->get()->toArray();
        if (!in_array($data->country, array_column($countriesDatas, 'country')))
            {
                $countriesDatas[] =  [
                    'id' => $data->country,
                    'name_country' => $data->country,
                ];
            }

        $dataComProduct = Com_product::select(
            'com_products.product_id as product_id',
            'com_products.name_thai as name_thai',
            'com_products.barcode as barcode',
            'com_products.ref_barcode_real as ref_barcode_real',
            
            'com_products.unit_net_weight as unit_net_weight',
            'com_products.unit_gross_weight as unit_gross_weight',
            'com_products.inner_net_weight as inner_net_weight',
            'com_products.inner_gross_weight as inner_gross_weight',
            'com_products.case_net_weight as case_net_weight',
            'com_products.case_gross_weight as case_gross_weight',

            'com_products.km_inner_width as km_inner_width',
            'com_products.km_inner_long as km_inner_long',
            'com_products.km_inner_height as km_inner_height',
            'com_products.km_case_width as km_case_width',
            'com_products.km_case_long as km_case_long',
            'com_products.km_case_height as km_case_height',

            'com_products.width as width',
            'com_products.long as long',
            'com_products.height as height',
            'com_products.area as area',
            'com_products.box_qty as box_qty',
            'com_products.pallet_qty as pallet_qty',
            'com_products.weight as weight',
            
            'product_details.unit_weight AS unit_weight',
            'product_details.unit_pak_size AS unit_pak_size',
            'product_details.case_weight AS case_weight',
            'product_details.case_pack_size AS case_pack_size',
            'product_details.case_width AS case_width',
            'product_details.case_length AS case_length',
            'product_details.case_height AS case_height',
            'product_details.case_barcode AS case_barcode',
            'product_details.inner_width AS inner_width',
            'product_details.inner_length AS inner_length',
            'product_details.inner_height AS inner_height',
            'product_details.inner_barcode AS inner_barcode',
            'product_details.inner_weight AS inner_weight',
            'product_details.inner_pack_size AS inner_pack_size',
            'product1s.PACK_SIZE1 AS PACK_SIZE1',
            'product1s.BAR_PACK1 AS BAR_PACK1',
        )
        ->leftJoin('product_details', 'com_products.product_id', '=', 'product_details.product_id')
        ->leftJoin('product1s', 'com_products.product_id', '=', 'product1s.PRODUCT')
        ->firstWhere('com_products.product_id', '=', $id);

        $scheme = request()->getScheme(); // http หรือ https
        $host   = request()->getHost();   // localhost หรือ pdmaster.ssup.co.th

        $images = ComProductImage::select(
            'id', 
            'product_id', 
            'seq', 
            DB::raw("CASE
                        WHEN com_product_images.path LIKE 'https%' 
                        THEN com_product_images.path
                        ELSE com_product_images.path
                    END 
                    AS path"
            ),
        )
        ->where('product_id', $id)
            ->orderBy('seq', 'asc')
            ->get();
        if ($images->isEmpty()) {
            // fallback ไปที่ com_products (ใช้ img_url แทน path และไม่มี seq)
            $images = ComProduct::select(
                    'id',
                    'product_id',
                    // DB::raw('0 as seq'),
                    DB::raw("img_url as path")
                )
                ->where('product_id', $id)
                ->orderBy('id', 'asc')   // หรือจะตัดบรรทัดนี้ออกก็ได้
                ->get();
        }

        $product_id = $images->first()->product_id ?? null;

        // ดึงรูปจาก API Oriental Princess (ใช้ cache เดียวกับ listWarehouse)
        $opApiImage = null;
        $opImages = Cache::remember('op_product_images', 60 * 60, function () {
            try {
                $response = Http::timeout(10)->get('https://orientalprincess.com/api/getProductImage.php');
                if ($response->successful()) {
                    return collect($response->json())->whereNotNull('image')->pluck('image', 'sku')->toArray();
                }
            } catch (\Exception $e) {
                \Log::warning('OP API getProductImage failed: ' . $e->getMessage());
            }
            return [];
        });
        if (isset($opImages[$product_id])) {
            $opApiImage = $opImages[$product_id];
        }

        // dd($dataComProduct);
        // $errorText = collect($dataComProduct);
        // dd(response()->json([
        //     'errorMessage' => $errorText,
        // ]));

        return view('product_detail.edit', compact('data', 'countriesDatas', 'dataComProduct', 'images', 'product_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        DB::beginTransaction();
        try {
                // ค้นหาข้อมูลเดิมจาก ProductDetail
                $data_old = ProductDetail::where('product_id', $id)->first();

                // ตรวจสอบว่าเจอข้อมูลหรือไม่
                if ($data_old) {
                    $data_old_arr = $data_old->toArray();
                    // เพิ่ม Log ถ้ามีค่าที่ต้องการอัปเดต
                    $log = [
                        'update_dt' => date("Y/m/d H:i:s"),
                        'user_update' => Auth::user()->username,
                    ];

                    $data_old_arr = array_merge($data_old_arr, $log);
                    ProductDetailLog::create($data_old_arr);
                }

                $after_open_m_raw = $request->input('after_open_m');
                $after_open_m = preg_replace('/\D/', '', $after_open_m_raw); // จะได้ "12"

                // $after_open_m_raw = $request->input('after_open_m');
                // $after_open_m = explode(' ', trim($after_open_m_raw))[0]; // จะได้ "12"

                $data_product_upddate = [
                    'corporation_id' => $request->input('corporation_id'),
                    'product_id' => $request->input('product_id'),
                    'launch' => $request->input('launch'),
                    'country' => $request->input('country'),
                    'fad' => $request->input('fad'),
                    'ingredients' => $request->input('ingredients'),
                    'natural_active_ingredients' => trim(str_replace('%', '', $request->input('natural_active_ingredients'))),
                    'ingredient_from_natural_origin' => trim(str_replace('%', '', $request->input('ingredient_from_natural_origin'))),
                    'ingredient_from_natural_ref_isO16128' => trim(str_replace('%', '', $request->input('ingredient_from_natural_ref_isO16128'))),
                    'after_open_m' => $after_open_m,
                    'description_th' => $request->input('description_th'),
                    'description_en' => $request->input('description_en'),
                    'usage_direction_th' => $request->input('usage_direction_th'),
                    'usage_direction_en' => $request->input('usage_direction_en'),
                    'color_code_th' => $request->input('color_code_th'),
                    'color_code_en' => $request->input('color_code_en'),
                    'desc_other' => $request->input('desc_other'),
                    'permission' => $request->input('permission', 'N'),

                    // 'case_width' => $request->input('case_width'),
                    // 'case_length' => $request->input('case_length'),
                    // 'case_height' => $request->input('case_height'),
                    // 'case_barcode' => $request->input('case_barcode'),
                    // 'case_weight' => $request->input('case_weight'),
                    // 'case_pack_size' => $request->input('case_pack_size'),
                    // 'inner_width' => $request->input('inner_width'),
                    // 'inner_length' => $request->input('inner_length'),
                    // 'inner_height' => $request->input('inner_height'),
                    // 'inner_barcode' => $request->input('inner_barcode'),
                    // 'inner_weight' => $request->input('inner_weight'),
                    // 'inner_pack_size' => $request->input('inner_pack_size'),
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s"),

                    // 'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                    // 'USER_EDIT' => Auth::user()->username,
                    // 'EDIT_DT' => date("Y-m-d"),
                    // 'STATUS_EDIT_DT' => '',
                ];

                // dd($data_product_upddate);

                // อัปเดตข้อมูล
                $upddateProductDetail = ProductDetail::where('product_id', $id)->update($data_product_upddate);

                // ค้นหาข้อมูลเดิมจาก ProductOther
                $data_other_old = ProductOther::where('product_id', $id)->first();
                if ($data_other_old) {
                    $data_other_old_arr = $data_other_old->toArray();
                    $log_other = [
                        'update_dt' => date("Y/m/d H:i:s"),
                        'user_update' => Auth::user()->username,
                    ];
                    $data_other_old_arr = array_merge($data_other_old_arr, $log_other);
                    ProductOtherLog::create($data_other_old_arr);
                }

                ProductOther::where('product_id', $id)->update([
                    'company_id' => $request->input('company_id'),
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

                    'sls_free' => $request->input('sls_free', 'N'),
                    'natural_alcohol' => $request->input('natural_alcohol', 'N'),
                    'silicone_free' => $request->input('silicone_free', 'N'),
                    'certified_food' => $request->input('certified_food', 'N'),
                    'mineral_free' => $request->input('mineral_free', 'N'),
                    'certified_organic' => $request->input('certified_organic', 'N'),
                    'colorant_free' => $request->input('colorant_free', 'N'),
                    'hypoallergenic' => $request->input('hypoallergenic', 'N'),
                    'phthalate_free' => $request->input('phthalate_free', 'N'),
                    'tested' => $request->input('tested', 'N'),
                    'cruelty_free' => $request->input('cruelty_free', 'N'),
                    'non_comedogenic' => $request->input('non_comedogenic', 'N'),
                    'talc_free' => $request->input('talc_free', 'N'),
                    'synthetic_colorant' => $request->input('synthetic_colorant', 'N'),
                    'oil_free' => $request->input('oil_free', 'N'),
                    'synthetic_fragrance' => $request->input('synthetic_fragrance', 'N'),
                    'triethanolamin_free' => $request->input('triethanolamin_free', 'N'),
                    'ph_balance' => $request->input('ph_balance', 'N'),
                    'petroleum_free' => $request->input('petroleum_free', 'N'),
                    'chil_over_6year' => $request->input('chil_over_6year', 'N'),
                    'petrolatum_free' => $request->input('petrolatum_free', 'N'),
                    'fragrance_free' => $request->input('fragrance_free', 'N'),
                    'alcohol_free' => $request->input('alcohol_free', 'N'),
                    'paraben_free' => $request->input('paraben_free', 'N'),
                    'pregnancy' => $request->input('pregnancy', 'N'),
                    'breastfeed' => $request->input('breastfeed', 'N'),
                    'custom_free_forms' => $request->input('custom_free_forms') ?: null,
                ]);

                $data_consumables_old = Product1::select(
                    'product1s.*',
                )
                ->firstWhere('product1s.PRODUCT', '=', $id);

                $data_consumables_old_arr = $data_consumables_old->toArray();

                if ($request) {
                    $log = [
                        'UPDATE_DT' => date("Y/m/d H:i:s"),
                        'USER_UPDATE' => Auth::user()->username
                    ];

                    $data_consumables_old_arr = array_merge($data_consumables_old_arr, $log);
                    $logProductUpddate = Product1Log::create($data_consumables_old_arr);
                }

                $upddateProduct1s = Product1::updateOrCreate(
                    ['PRODUCT' => $id],
                    [
                        'BAR_PACK1' => $request->input('inner_barcode') ?? '',
                        'BAR_PACK2' => $request->input('case_barcode') ?? '',
                        'PACK_SIZE1' => $request->input('inner_pack_size') ?? '',
                        'PACK_SIZE2' => $request->input('case_pack_size') ?? '',

                        // 'fad' => $productUpddate->REGISTER ?? '',
                        // 'inner_barcode' => $productUpddate->BAR_PACK1 ?? '',
                        // 'inner_pack_size' => $productUpddate->PACK_SIZE1 ?? '',
                        // 'case_barcode' => $productUpddate->BAR_PACK2 ?? '',
                        // 'case_pack_size' => $productUpddate->PACK_SIZE2 ?? '',

                        'USER_EDIT' => Auth::user()->username,
                        'EDIT_DT' => date("Y-m-d"),
                        'STATUS_EDIT_DT' => '',
                    ]
                );

                // Save uploaded files to core_ibsh_fiels
                if ($request->hasFile('dz_files')) {
                    $form_type = $request->input('dz_form_type', 'special_ingredients');
                    $imageExts = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
                    $year  = date('Y');
                    $month = date('m');
                    $dir   = "uploads/ibsh/$year/$month/";
                    if (!file_exists(public_path($dir))) {
                        mkdir(public_path($dir), 0777, true);
                    }
                    foreach ($request->file('dz_files') as $file) {
                        $ext = strtolower($file->getClientOriginalExtension());
                        $file_type = in_array($ext, $imageExts) ? 'image' : 'document';
                        $filename = Str::uuid() . '.' . $ext;
                        $file->move(public_path($dir), $filename);
                        CoreIbshFiel::create([
                            'product_id' => $id,
                            'form_type'  => $form_type,
                            'file_type'  => $file_type,
                            'path'       => $dir . $filename,
                            'upd_date'   => now(),
                        ]);
                    }
                }

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

    public function pdfCodes($product_id)
    {
        $productId = trim((string)$product_id);

        $endpoint = "http://sapkmacc.ssup.co.th/api/bom/bulk";
        $raw = Cache::remember('sap_bom_bulk_raw', 600, function () use ($endpoint) {
            return Http::timeout(30)->get($endpoint)->body();
        });

        $data = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            return response()->json(['ok' => false, 'message' => 'Invalid JSON'], 500);
        }

        // ดึงทั้ง key = productId และ key ที่ขึ้นต้น productId เช่น 11241F1
        $matched = [];
        foreach ($data as $k => $items) {
            $kStr = (string)$k;
            if ($kStr === $productId || str_starts_with($kStr, $productId)) {
                if (is_array($items)) $matched = array_merge($matched, $items);
            }
        }

        // flatten
        $rows = [];
        foreach ($matched as $row) {
            if (is_array($row) && isset($row['code'])) $rows[] = $row;
            elseif (is_array($row)) {
                foreach ($row as $row2) {
                    if (is_array($row2) && isset($row2['code'])) $rows[] = $row2;
                }
            }
        }

        // unique code
        $codes = [];
        foreach ($rows as $r) {
            $c = trim((string)($r['code'] ?? ''));
            if ($c === '') continue;
            $codes[$c] = [
                'code'   => $c,
                'name'   => $r['name'] ?? null,
                'c_code' => $r['c_code'] ?? null, // ✅ BULK CODE
                'c_name' => $r['c_name'] ?? null, // (ถ้าต้องการ)
            ];
        }

        $codes = array_values($codes);

        return response()->json([
            'ok' => true,
            'product_id' => $productId,
            'count' => count($codes),
            'codes' => $codes,
        ]);
    }

    public function listProductDetail(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $BRAND = $request->input('brand_id');
        $searchAll = $request->input('search', '');

        $data = ProductDetail::select(
            'corporation_id',
            'product_id',
            'inner_barcode',
            'product1s.NAME_THAI AS NAME_THAI',
            'product1s.BARCODE AS BARCODE',
            'pro_develops.JOB_REFNO as JOB_REFNO'
        )
        ->leftJoin('product1s', 'product_details.product_id', '=', 'product1s.PRODUCT')
        ->leftJoin('pro_develops', 'product_details.product_id', '=', 'pro_develops.PRODUCT')
        ->orderBy('product_details.upd_date', 'DESC');

        // dd($data->toSql());
        if ($BRAND != null) {
            $data->where('product_details.corporation_id', $BRAND);
        }
        // กรองข้อมูลถ้ามีคำค้นหา
        if (!empty($searchAll)) {
            $data->where(function ($q) use ($searchAll) {
                $q->orWhere('product_details.product_id', 'like', '%' . $searchAll . '%')
                ->orWhere('product1s.NAME_THAI', 'like', '%' . $searchAll . '%')
                ->orWhere('product1s.BARCODE', 'like', '%' . $searchAll . '%');
            });
        }

        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        // 🔹 ตรวจสอบ limit
        if ($limit > 0) {
            $data->limit($limit)->offset($start);
        }
        // 🔹 ดึงข้อมูลตาม limit และ offset
        $records = $data->get();

        return response()->json([
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
            'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
            'aaData' => $records,
        ]);
    }

    public function listProductDetailManageExportExcel(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        // ✅ ดึงชื่อ field ทั้งหมดจากตาราง product_detail_export_excel
        $fields = Schema::getColumnListing('product_detail_export_excels');

        // กำหนดกลุ่มที่สามารถเห็น 'cost'
        $canCostUsers = [
            32, 95, 86, 87, 26, 85, 100, 99,
            102, 103, 104, 105, 136, 106, 138,
            120, 179, 125, 139, 140, 141, 142,
            143, 144, 145, 148, 121
        ];

        // ตรวจสอบว่าผู้ใช้มีสิทธิ์ดู 'cost' หรือไม่
        if (in_array(Auth::user()->id, $canCostUsers)) {
            // หากผู้ใช้อยู่ใน $canCostUsers ให้แสดงฟิลด์ 'cost'
            $fields = array_filter($fields, fn($field) => !in_array($field, ['id', 'brand', 'position_id', 'created_at', 'updated_at']));
        } else {
            // หากผู้ใช้ไม่ได้อยู่ใน $canCostUsers ให้กรอง 'cost' ออก
            $fields = array_filter($fields, fn($field) => !in_array($field, ['id', 'brand', 'position_id', 'cost', 'created_at', 'updated_at']));
        }

        // ตรวจสอบว่า `fields` ถูกกรองถูกต้อง
        // dd(Auth::user()->id, $fields);  // ดูว่า `cost` ถูกกรองออกหรือไม่

        // $fields = array_diff(
        // Schema::getColumnListing('product_detail_export_excels'),
        // ['id', 'position_id', 'brand', 'created_at', 'updated_at'] // field ที่ไม่ใช่ permission
        // );

        // ✅ เพิ่มบรรทัดนี้ก่อน transform
        // $fields = ['product', 'barcode', 'status', 'age', 'grp_p', 'supplier'];

        // ตำแหน่งของ user ปัจจุบัน
        $currentPosition = Auth::user()->getUserPermission->name_position;

        // if (Auth::user()->id === 32 || Auth::user()->id === 95) {
        if (Auth::user()->id === 32) {
            // ✅ เตรียม query หลักเพื่อดึงสิทธิ์ของแต่ละตำแหน่ง
            $query = user_permission::select(
                    'positions.id',
                    'positions.name_position',
                    'positions.brand',
                    DB::raw('GROUP_CONCAT(users.username) as username'),
                    DB::raw('COUNT(users.id) as total_users')
                )
                ->join('users', 'users.id', '=', 'user_permission.user_id')
                ->join('positions', 'positions.id', '=', 'user_permission.position_id')
                ->where('positions.brand', 'CPS')
                // ->where('positions.name_position', $currentPosition)
                ->groupBy('positions.id', 'positions.name_position', 'positions.brand')
                ->orderBy('positions.id');

            $totalRecords = DB::table(DB::raw("({$query->toSql()}) as sub"))
                ->mergeBindings($query->getQuery())
                ->count();

            if ($limit > 0) {
                $query->limit($limit)->offset($start);
            }

            $records = $query->get();
        } else {
            // ✅ เตรียม query หลักเพื่อดึงสิทธิ์ของแต่ละตำแหน่ง
            $query = user_permission::select(
                    'positions.id',
                    'positions.name_position',
                    'positions.brand',
                    DB::raw('GROUP_CONCAT(users.username) as username'),
                    DB::raw('COUNT(users.id) as total_users')
                )
                ->join('users', 'users.id', '=', 'user_permission.user_id')
                ->join('positions', 'positions.id', '=', 'user_permission.position_id')
                ->where('positions.brand', 'CPS')
                ->where('positions.name_position', $currentPosition)
                ->groupBy('positions.id', 'positions.name_position', 'positions.brand')
                ->orderBy('positions.id');

            $totalRecords = DB::table(DB::raw("({$query->toSql()}) as sub"))
                ->mergeBindings($query->getQuery())
                ->count();

            if ($limit > 0) {
                $query->limit($limit)->offset($start);
            }

            $records = $query->get();
        }

        // ✅ ดึงสิทธิ์ export จาก product_detail_export_excel แยกตาม position_id
        $exportPermissions = ProductDetailExportExcel::all()->keyBy('position_id');

        // เช็กว่า key จริงมีอะไรบ้าง
        // foreach ($exportPermissions as $key => $val) {
        //     logger("KEY FOUND: $key");
        // }

        // แล้วตรงใน transform
        // แล้วตรงใน transform
        $records->transform(function ($row) use ($fields, $exportPermissions, $canCostUsers) {
            $positionId = $row->id;
            $perm = $exportPermissions[$positionId] ?? null;

            if (!$perm) {
                $row->exportableFields = [];
                $row->selected = [];
                return $row;
            }

            // กรองฟิลด์ที่ไม่สามารถให้แสดงได้ (กรอง 'cost' ถ้า user ไม่มีสิทธิ์)
            $filteredFields = collect($fields)->filter(function ($field) use ($canCostUsers) {
                // ถ้า user ไม่อยู่ในกลุ่มที่สามารถเห็น 'cost', ให้กรอง 'cost' ออก
                if (!in_array(Auth::user()->id, $canCostUsers) && $field === 'cost') {
                    return false;  // กรอง 'cost' ออก
                }
                return true;  // ส่งฟิลด์อื่น ๆ กลับมา
            });

            // ตรวจสอบข้อมูลหลังการกรอง
            // dd(Auth::user()->id, $filteredFields);

            // แปลงฟิลด์เพื่อแสดงผล (mapping) พร้อมการเลือกฟิลด์
            $row->exportableFields = $filteredFields
                ->map(function ($field) use ($perm) {
                    $value = data_get($perm, $field);
                    return [
                        'key'     => $field,
                        'label'   => $field,
                        'allowed' => $value == 1,  // ถ้าเป็น 1 หมายถึงมีสิทธิ์
                        'selected'=> (int)$value === 1,
                    ];
                })
                ->chunk(4)
                ->toArray();

            // flat array ของ key ที่ถูกเลือก
            $row->selected = collect($filteredFields)
                ->filter(fn($f) => (int) data_get($perm, $f) === 1)
                ->values()
                ->all();

            // ตรวจสอบว่า 'cost' ถูกเพิ่มเข้าไปใน selected หรือไม่
            if (in_array('cost', $filteredFields->toArray()) && in_array(Auth::user()->id, $canCostUsers)) {
                // เพิ่ม 'cost' ใน selected ถ้าผู้ใช้มีสิทธิ์
                $row->selected = array_unique(array_merge($row->selected, ['cost']));
            }

            // dd($row);  // ตรวจสอบข้อมูลหลังการแปลง
            return $row;
        });
            
        // ✅ ส่งออก JSON
        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $records,
        ]);
    }

    public function updateProductDetailManageExportExcel(Request $request, $position_id)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            
            $position_id = $request->input('position_id');
            $exportFields = $request->input('export_fields', []);
            
                // ดึง field ทั้งหมดจาก schema table
                $allFieldNames = Schema::getColumnListing('product_detail_export_excels');
                // dd($allFieldNames);

                // ตัด column ที่ไม่ต้องแก้ เช่น id, position_id, timestamps
                $exclude = ['id', 'brand','position_id', 'created_at', 'updated_at'];
                $fieldsToReset = array_diff($allFieldNames, $exclude);

                // 1. เคลียร์ทั้งหมด = 0
                $resetFields = array_fill_keys($fieldsToReset, 0);
                ProductDetailExportExcel::where('position_id', $position_id)->update($resetFields);

                // 2. อัปเดตเฉพาะที่เลือก
                $updateFields = array_fill_keys($exportFields, 1);
                ProductDetailExportExcel::where('position_id', $position_id)->update($updateFields);

                // dd($upddateProductDetail);
                DB::commit();
                $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
                return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }
}
