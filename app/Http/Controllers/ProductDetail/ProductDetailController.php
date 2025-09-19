<?php

namespace App\Http\Controllers\ProductDetail;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Barcode;
use App\Models\Product1;
use App\Models\Product1Log;
use App\Models\ProductDetail;
use App\Models\ProductDetailExportExcel;
use App\Models\ProductDetailLog;
use App\Models\Com_product;
use App\Models\ComProductImage;
use App\Models\ComProductLog;
use App\Models\Countrie;
use App\Models\user_permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        if ($userpermission == 'CPS') {
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

            $getSelect2ProDevelops = Product1::select(
                'PRODUCT')
                ->whereIn('BRAND', ['CPS'])
                ->pluck('PRODUCT')
                ->toArray();    
        }

        // dd($getSelect2ProDevelops);
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
    public function show(Request $request)
    {
        //
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

        // dd($data);
        // แปลงวันที่เฉพาะตอนที่มีค่า
        if ($data && $data->launch) {
            $data->launch = date('Y-m', strtotime($data->launch));
        }

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

        $countriesDatas = Countrie::select('id AS country', 'name_country')->get()->toArray();
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

        $product_id = $images->first()->product_id ?? null;

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

                $data_product_upddate = [
                    'corporation_id' => $request->input('corporation_id'),
                    'product_id' => $request->input('product_id'),
                    'launch' => $request->input('launch'),
                    'country' => $request->input('country'),
                    'fad' => $request->input('fad'),
                    'ingredients' => $request->input('ingredients'),
                    'after_open_m' => $request->input('after_open_m'),
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

                // อัปเดตข้อมูล
                $upddateProductDetail = ProductDetail::where('product_id', $id)->update($data_product_upddate);

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
                        'BAR_PACK2' => $request->input('inner_pack_size') ?? '',
                        'PACK_SIZE1' => $request->input('case_barcode') ?? '',
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
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
        )
        ->leftJoin('product1s', 'product_details.product_id', '=', 'product1s.PRODUCT')
        ->orderBy('product_id', 'DESC');

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

        // เอาเฉพาะ field ที่ใช้แสดงผลจริง (ตัด created_at, updated_at ทิ้ง)
        $fields = array_filter($fields, fn($field) => !in_array($field, ['id', 'brand', 'position_id', 'created_at', 'updated_at']));

        // $fields = array_diff(
        // Schema::getColumnListing('product_detail_export_excels'),
        // ['id', 'position_id', 'brand', 'created_at', 'updated_at'] // field ที่ไม่ใช่ permission
        // );

        // ✅ เพิ่มบรรทัดนี้ก่อน transform
        // $fields = ['product', 'barcode', 'status', 'age', 'grp_p', 'supplier'];

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
            ->groupBy('positions.id', 'positions.name_position', 'positions.brand')
            ->orderBy('positions.id');

        $totalRecords = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query->getQuery())
            ->count();

        if ($limit > 0) {
            $query->limit($limit)->offset($start);
        }

        $records = $query->get();

        // ✅ ดึงสิทธิ์ export จาก product_detail_export_excel แยกตาม position_id
        $exportPermissions = ProductDetailExportExcel::all()->keyBy('position_id');

        // เช็กว่า key จริงมีอะไรบ้าง
        // foreach ($exportPermissions as $key => $val) {
        //     logger("KEY FOUND: $key");
        // }

        // แล้วตรงใน transform
        $records->transform(function ($row) use ($fields, $exportPermissions) {
            $positionId = $row->id;

            $perm = $exportPermissions[$positionId] ?? null;

            if (!$perm) {
                // logger("❌ NO permission for position_id = $positionId");
                $row->exportableFields = [];
                return $row;
            }

            // logger("✅ FOUND permission for position_id = $positionId");
            // logger("PERM DATA = " . json_encode($perm->toArray()));
            // logger("FIELDS = " . json_encode($fields));

            $row->exportableFields = collect($fields)
                ->map(function ($field) use ($perm) {
                    $value = data_get($perm, $field);
                    // logger("🧪 $field => " . json_encode($value));
                    return [
                        'key' => $field,
                        'label' => $field,
                        'allowed' => $value == 1,
                    ];
                })
                ->chunk(4)
                ->toArray();

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
