<?php

namespace App\Http\Controllers\ProductDetail;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Barcode;
use App\Models\Product1;
use App\Models\ProductDetail;
use App\Models\ProductDetailExportExcel;
use App\Models\ProductDetailLog;
use App\Models\Com_product;
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

            $getSelect2ProDevelops = Product1::select(
                'PRODUCT')
                ->whereIn('BRAND', ['CPS'])
                ->pluck('PRODUCT')
                ->toArray();    
        }

        // dd($dataProductMasterArr);
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

        $dataComProduct = Com_product::select(
            'com_products.*',
        )
        ->firstWhere('product_id', '=', $id);

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

        // dd($dataComProduct);
        // $errorText = collect($dataComProduct);
        // dd(response()->json([
        //     'errorMessage' => $errorText,
        // ]));
        return view('product_detail.edit', compact('data', 'countriesDatas', 'dataComProduct'));
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
                    'after_open_m' => $request->input('after_open_m'),
                    'description_th' => $request->input('description_th'),
                    'description_en' => $request->input('description_en'),
                    'usage_direction_th' => $request->input('usage_direction_th'),
                    'usage_direction_en' => $request->input('usage_direction_en'),
                    'color_code_th' => $request->input('color_code_th'),
                    'color_code_en' => $request->input('color_code_en'),
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
        dd($request);
        DB::beginTransaction();
        try {
                $position_id = $request->input('position_id');
                $exportFields = $request->input('export_fields', []);

                // ลบรายการเก่า
                ProductDetailExportExcel::where('position_id', $position_id)->delete();

                // Insert รายการใหม่ทั้งหมด
                foreach ($exportFields as $fieldKey) {
                    ProductDetailExportExcel::create([
                        'position_id' => $position_id,
                        'field_key' => $fieldKey,
                        'allowed' => true,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

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
