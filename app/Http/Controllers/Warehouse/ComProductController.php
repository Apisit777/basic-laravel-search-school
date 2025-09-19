<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductDetail;
use App\Models\ProductDetailLog;
use App\Models\Com_product;
use App\Models\ComProductExternal;
use App\Models\ComProductLog;
use App\Models\ComProduct;
use App\Models\Barcode;
use App\Models\Accessery;
use App\Models\MasterBrand;
use App\Models\Brand_p;
use App\Models\Food;
use App\Models\ComProductImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;


class ComProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();

        // $endpoint = "https://ins.schicher.com/api/users";
        // // Send a GET request
        // $response = Http::asForm()->get($endpoint);

        $roles = [];
        // if ($response->successful()) {
        //     $data = $response->json();

        //     $roles = collect($data)
        //         ->pluck('role')
        //         ->unique()
        //         ->values()
        //         ->toArray();

        //     // $roles = DB::table('users')
        //     //     ->select('role')
        //     //     ->distinct()
        //     //     ->get()
        //     //     ->pluck('role')
        //     //     ->toArray();

        //     // dd($roles);
        // } else {
        //     // Handle errors
        //     dd('Request failed', [
        //         'status' => $response->status(),
        //         'body' => $response->body(),
        //     ]);
        // }

        return view('warehouse.index', compact('brands', 'roles'));
    }

    public function indexCs()
    {
        $brands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();

        $roles = [];

        return view('warehouse.index_cs', compact('brands', 'roles'));
    }

    public function import()
    {
        Excel::import(new UserImport, request()->file('file'));
        return back();
    }

    public function listWarehouse(Request $request)
    {
        $draw   = (int) $request->input('draw', 0);
        $start  = (int) $request->input('start', 0);
        $limit  = (int) $request->input('length', 20);
        $brand  = $request->input('brand_id');
        $search = trim((string) $request->input('search', ''));

        // ฐานคิวรี (ยังไม่ใส่ search) — ใช้กับ recordsTotal
        // $baseQuery = Com_product::query()
        //     ->select([
        //         'com_products.company_id',
        //         'com_products.product_id AS product_id',
        //         'com_products.barcode    AS barcode',
        //         'com_products.vendor_id  AS vendor_id',
        //         'com_products.name_thai  AS name_thai',
        //         DB::raw("
        //             CASE
        //                 WHEN com_products.img_url IS NULL OR TRIM(com_products.img_url) = '' THEN ''
        //                 WHEN com_products.img_url LIKE 'http%' THEN com_products.img_url
        //                 ELSE com_products.img_url
        //             END AS img_url
        //         "),
        //     ])
        //     ->join('product1s', 'com_products.product_id', '=', 'product1s.PRODUCT');

        $baseQuery = ComProduct::query()
            ->select([
                'com_products.company_id',
                'com_products.product_id AS product_id',
                'com_products.barcode    AS barcode',
                'com_products.vendor_id  AS vendor_id',
                'com_products.name_thai  AS name_thai',
                DB::raw("
                    CASE
                        WHEN com_products.img_url IS NULL OR TRIM(com_products.img_url) = '' THEN ''
                        WHEN com_products.img_url LIKE 'http%' THEN com_products.img_url
                        ELSE com_products.img_url
                    END AS img_url
                "),
            ])
        ->join('product1s', 'com_products.product_id', '=', 'product1s.PRODUCT');

        // กรอง BRAND
        if (!empty($brand)) {
            if ($brand === 'CPS') {
                $baseQuery->whereIn('com_products.company_id', ['CPS', 'CP']);
            } else {
                $baseQuery->where('com_products.company_id', $brand);
            }
        }

        // นับจำนวนทั้งหมดก่อนกรอง (ตาม BRAND แต่ยังไม่ใส่ search)
        $recordsTotal = (clone $baseQuery)->count();

        // ใส่ search (กรณีมี)
        if ($search !== '') {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('com_products.product_id', 'like', "%{$search}%")
                ->orWhere('com_products.name_thai', 'like', "%{$search}%")
                ->orWhere('com_products.barcode',   'like', "%{$search}%");
            });
        }

        // นับหลังกรอง (สำหรับ recordsFiltered)
        $recordsFiltered = (clone $baseQuery)->count();

        // ใส่ limit/offset
        if ($limit > 0) {
            $baseQuery->limit($limit)->offset($start);
        }

        // ดึงข้อมูลหน้า
        $rows = $baseQuery->get();

        return response()->json([
            'draw'            => $draw,            // ต้องส่งกลับ
            'recordsTotal'    => $recordsTotal,    // จำนวนทั้งหมดก่อน search
            'recordsFiltered' => $recordsFiltered, // จำนวนหลัง search
            'data'            => $rows,            // แถวข้อมูล
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouse.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Com_product $com_product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $product_id)
    {
        $data = Com_product::select(
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
            // DB::raw("CASE
            //             WHEN com_products.img_url LIKE 'http%' 
            //             THEN com_products.img_url
            //             ELSE CONCAT('$scheme://$host/', com_products.img_url)
            //         END 
            //         AS img_url"
            // ),
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
        ->firstWhere('com_products.product_id', '=', $product_id);

        // dd($data);

        // $images = Food::all();
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
        ->where('product_id', $product_id)
            ->orderBy('seq', 'asc')
            ->get();

        $product_id = $images->first()->product_id ?? null;

        // dd($data);
        // dd($images);

        return view('warehouse.edit', compact('data', 'images', 'product_id'));
    }
    
    public function editCs(Request $request, $product_id)
    {
        $data = Com_product::select(
            'com_products.*',
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
        )
        ->leftJoin('product_details', 'com_products.product_id', '=', 'product_details.product_id')
        ->firstWhere('com_products.product_id', '=', $product_id);

        // $images = Food::all();
        $images = ComProductImage::where('product_id', $product_id)
            ->orderBy('seq', 'asc')
            ->get();
        $product_id = $images->first()->product_id ?? null;

        // dd($data);
        // dd($images);

        return view('warehouse.edit_cs', compact('data', 'images', 'product_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request, $id);
        $dateTime = Carbon::now(); // ใช้ Carbon เพื่อให้ใช้ format() ได้
        DB::beginTransaction();
        try {
                // $isSuperAdmin = (Auth::user()->id === 26);
                // $userPermissionFull = Auth::user()->getUserPermission->name_position ?? '';
                // $namePositionParts = explode('-', $userPermissionFull);
                // $userpermission = trim(end($namePositionParts)); // brand/suffix

                // … ก่อนอัปเดต
                $user = Auth::user();
                // 1) พยายามเอา brand จากความสัมพันธ์ก่อน (ถ้ามีคอลัมน์ brand ในตาราง positions)
                $brandFromRelation = optional($user->getUserPermission)->brand;
                // 2) ถ้าไม่มี brand ให้แตกจาก name_position (ชิ้นสุดท้ายหลังขีด)
                $namePositionFull = optional($user->getUserPermission)->name_position;  // null-safe
                $brandFromName    = '';
                if ($namePositionFull) {
                    // ตัดด้วย - แล้ว trim ทุกรายการ และกรองค่าว่าง
                    $parts = array_filter(array_map('trim', explode('-', $namePositionFull)));
                    $brandFromName = Arr::last($parts) ?: '';
                }
                // 3) สรุป brand สุดท้าย
                $brand = $brandFromRelation ?: $brandFromName;
                // 4) สร้างข้อความผู้แก้ไข ถ้าไม่มี brand จะไม่ใส่วงเล็บ
                $updUser = $user->username . ($brand ? "({$brand})" : '');
                // dd($updUser);

                // 5) เวลาให้ใช้ Carbon ตาม timezone ของแอป
                $now = Carbon::now()->format('Y-m-d H:i:s');
                
                // ค้นหาข้อมูลเดิมจาก ProductDetail
                $data_old = ProductDetail::where('product_id', $id)->first();

                // ตรวจสอบว่าเจอข้อมูลหรือไม่
                if ($data_old) {
                    $data_old_arr = $data_old->toArray();
                    // เพิ่ม Log ถ้ามีค่าที่ต้องการอัปเดต
                    $log = [
                        'user_update' => Auth::user()->username,
                        'update_dt' => $now,
                    ];

                    $data_old_arr = array_merge($data_old_arr, $log);
                    ProductDetailLog::create($data_old_arr);
                }

                $data_product_upddate = [
                    'unit_weight'    => $request->input('unit_weight') ?? '',
                    'unit_pak_size'  => $request->input('unit_pak_size') ?? '',
                    'case_width'     => $request->input('case_width') ?? '',
                    'case_length'    => $request->input('case_length') ?? '',
                    'case_height'    => $request->input('case_height') ?? '',
                    'case_barcode'   => $request->input('case_barcode') ?? '',
                    'case_weight'    => $request->input('case_weight') ?? '',
                    'case_pack_size' => $request->input('case_pack_size') ?? '',
                    'inner_width'    => $request->input('inner_width') ?? '',
                    'inner_length'   => $request->input('inner_length') ?? '',
                    'inner_height'   => $request->input('inner_height') ?? '',
                    'inner_barcode'  => $request->input('inner_barcode') ?? '',
                    'inner_weight'   => $request->input('inner_weight') ?? '',
                    'inner_pack_size'=> $request->input('inner_pack_size') ?? '',
                    'upd_user'       => Auth::user()->username,
                    'upd_date'       => $now
                ];

                // dd($data_product_upddate);
                // อัปเดตข้อมูล
                ProductDetail::where('product_id', $id)->update($data_product_upddate);

                // ดึงข้อมูลล่าสุดหลังจากอัปเดต
                $comProductUpddate = ProductDetail::where('product_id', $id)->first();

                $data_old_com_product = Com_product::where('product_id', $id)->first();

                // ตรวจสอบว่าเจอข้อมูลหรือไม่
                if ($data_old_com_product) {
                    $data_data_old_com_product_arr = $data_old_com_product->toArray();

                    // เพิ่ม Log ถ้ามีค่าที่ต้องการอัปเดต
                    $log = [
                        'user_update' => $updUser,
                        'update_dt' => $now
                    ];

                    $data_data_old_com_product_arr = array_merge($data_data_old_com_product_arr, $log);
                    ComProductLog::create($data_data_old_com_product_arr);
                }

                $refBarcodeReal = $request->input('ref_barcode_real') ?? '';  // กรณีไม่มีให้เป็นค่าว่าง
                if (strlen($refBarcodeReal) > 15) {
                    $refBarcodeReal = substr($refBarcodeReal, 0, 15);  // จำกัดความยาวที่ 15
                }

                // unit_net_weight
                // unit_gross_weight

                // inner_width
                // inner_long
                // inner_height

                // inner_net_weight
                // inner_gross_weight

                // case_width
                // case_long
                // case_height

                // case_net_weight
                // case_gross_weight

                // อัปเดตหรือสร้างข้อมูลใหม่
                $upddateComProduct = Com_product::updateOrCreate(
                    ['product_id' => $id],
                    [
                        // 'unit_weight' => $comProductUpddate->unit_weight,
                        // 'unit_pak_size' => $comProductUpddate->unit_pak_size,
                        // 'case_width' => $comProductUpddate->case_width,
                        // 'case_length' => $comProductUpddate->case_length,
                        // 'case_height' => $comProductUpddate->case_height,
                        // 'case_barcode' => $comProductUpddate->case_barcode,
                        // 'case_weight' => $comProductUpddate->case_weight,
                        // 'case_pack_size' => $comProductUpddate->case_pack_size,
                        // 'inner_width' => $comProductUpddate->inner_width,
                        // 'inner_length' => $comProductUpddate->inner_length,
                        // 'inner_height' => $comProductUpddate->inner_height,
                        // 'inner_barcode' => $comProductUpddate->inner_barcode,
                        // 'inner_weight' => $comProductUpddate->inner_weight,
                        // 'inner_pack_size' => $comProductUpddate->inner_pack_size,

                        'ref_barcode_real' => $refBarcodeReal,
                        'km_inner_width'            => $request->input('km_inner_width') ?? '',
                        'km_inner_long'            => $request->input('km_inner_long') ?? '',
                        'km_inner_height'            => $request->input('km_inner_height') ?? '',

                        'km_case_width'            => $request->input('km_case_width') ?? '',
                        'km_case_long'            => $request->input('km_case_long') ?? '',
                        'km_case_height'            => $request->input('km_case_height') ?? '',
                        
                        'width'            => $request->input('width') ?? '',
                        'long'             => $request->input('long') ?? '',
                        'height'           => $request->input('height') ?? '',
                        'area'             => $request->input('area') ?? '',
                        'box_qty'          => $request->input('box_qty') ?? '',
                        'pallet_qty'       => $request->input('pallet_qty') ?? '',

                        'unit_net_weight'           => $request->input('unit_net_weight') ?? '',
                        // unit_gross_weight
                        'weight'           => $request->input('weight') ?? '',

                        'inner_net_weight'           => $request->input('inner_net_weight') ?? '',
                        'inner_gross_weight'           => $request->input('inner_gross_weight') ?? '',
                        'case_net_weight'           => $request->input('case_net_weight') ?? '',
                        'case_gross_weight'           => $request->input('case_gross_weight') ?? '',

                        'upd_user'         => $updUser,
                        'upd_date'         => $dateTime->format('Y-m-d H:i:s'), // ใช้ format() ได้แล้ว
                        'status_tranfer_km'=> '',
                        'update_dt'        => $dateTime->format('Y-m-d H:i:s') // ใช้ format() ได้แล้ว
                    ]
                );

                // --- เตรียม payload เฉพาะคอลัมน์ที่ปลายทางมีจริง ---
                $payloadExternal = [
                    'product_id' => $id,
                    'ref_barcode_real' => $refBarcodeReal,
                    'width'            => $request->input('width') ?? '',
                    'long'             => $request->input('long') ?? '',
                    'height'           => $request->input('height') ?? '',
                    'area'             => $request->input('area') ?? '',
                    'box_qty'          => $request->input('box_qty') ?? '',
                    'pallet_qty'       => $request->input('pallet_qty') ?? '',
                    'weight'           => $request->input('weight') ?? '',
                    'upd_user'         => $updUser,
                    'upd_date'         => $dateTime->format('Y-m-d H:i:s'), // ใช้ format() ได้แล้ว
                    'status_tranfer_km'=> '',
                    'update_dt'        => $dateTime->format('Y-m-d H:i:s') // ใช้ format() ได้แล้ว
                ];

                // --- เขียนปลายทาง (mysql_external) แบบ transaction ---
                DB::connection('mysql_external')->transaction(function () use ($payloadExternal) {
                    ComProductExternal::updateOrCreate(
                        ['product_id' => $payloadExternal['product_id']],
                        $payloadExternal
                    );
                });

                // dd($upddateComProduct);

                // อัปเดตหรือสร้างข้อมูลใหม่ ComProductExternal
                // $upddateComProductExternal = ComProductExternal::updateOrCreate(
                //     ['product_id' => $id],
                //     [
                //         'ref_barcode_real' => $request->input('ref_barcode_real') ?? '',
                //         'width'            => $request->input('width') ?? '',
                //         'long'             => $request->input('long') ?? '',
                //         'height'           => $request->input('height') ?? '',
                //         'area'             => $request->input('area') ?? '',
                //         'box_qty'          => $request->input('box_qty') ?? '',
                //         'pallet_qty'       => $request->input('pallet_qty') ?? '',
                //         'weight'           => $request->input('weight') ?? '',
                //         'upd_user'         => $updUser,
                //         'upd_date'         => $now
                //     ]
                // );

                // dd($upddateComProduct);
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
    public function destroy(Com_product $com_product)
    {
        //
    }

    public function indexDocument()
    {
        $brands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();
        $brand_ps = Brand_p::all();
        $roles = [];

        $users = User::get();

        // dd( $roles);
        return view('warehouse.document.index', compact('users', 'brand_ps', 'brands', 'roles'));
    }

    // public function filter(Request $request)
    // {

    //     $endpoint = "https://ins.schicher.com/api/users";
    //     $response = Http::asForm()->get($endpoint);

    //     if ($response->successful()) {
    //         $data = $response->json();

    //         $roles = collect($data)
    //             ->pluck('role')
    //             ->unique()
    //             ->values();

    //         $type = $request->get('type');

    //         if ($type) {
    //             $roles = $roles->filter(fn($role) => $role === $type);
    //         }
    //         return response()->json($roles->values());
    //     } else {
    //         return response()->json([
    //             'error' => 'Request failed',
    //             'status' => $response->status(),
    //             'body' => $response->body(),
    //         ], $response->status());
    //     }
    // }

    // public function updateImageSequence(Request $request, $id)
    // {
    //     // https://pdmaster.ssup.co.th/uploads/upload_old/upload/20230826104610.jpg ผิด

    //     // https://pdmaster.ssup.co.th/uploads/upload_old/2025031002140325.jpg ถูก

    //     // dd($request)->all();
    //     if (!$request->has('img') || !is_array($request->img)) {
    //         return response()->json(['status' => 400, 'message' => 'Invalid request'], 400);
    //     }

    //     foreach ($request->img as $index => $imageId) {
    //         ComProductImage::where('id', $imageId)->update(['seq' => $index + 1]);
    //     }

    //     // ✅ Fix: เพิ่ม product_id filter
    //     $mainImage = ComProductImage::where('product_id', $id)
    //         ->where('seq', 1)
    //         ->first();

    //     // dd($mainImage);

    //     if ($mainImage && $mainImage->path) {
    //         Com_product::updateOrCreate(
    //             ['product_id' => $id],
    //             ['img_url' => $mainImage->path]
    //         );
    //     }

    //     session()->flash('message', 'อัปเดตข้อมูลสำเร็จ');
    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'อัปเดตข้อมูลสำเร็จ'
    //     ]);
    // }

    public function updateImageSequence(Request $request, $id)
    {
        // image test 27176
        // image ต้องลบ 
        // 22543
        // 76226 ไม่แน่ใจ

        // 76271 test
        // 76025, 76094(pack 4)

        if (!$request->has('img') || !is_array($request->img)) {
            return response()->json(['status' => 400, 'message' => 'Invalid request'], 400);
        }

        // ลำดับใหม่ที่มาจากหน้าบ้าน (id ของรูปตามตำแหน่ง 1..n)
        $newOrderIds = array_values($request->img);

        DB::transaction(function () use ($id, $newOrderIds) {
            // ลำดับปัจจุบัน (เรียงตาม seq)
            $current = ComProductImage::where('product_id', $id)
                ->orderBy('seq')
                ->get(['id','seq','path']);

            if ($current->isEmpty()) return;

            $currentIds = $current->pluck('id')->all();                  // [id1, id2, ...] ตำแหน่งปัจจุบัน
            $idBySeq    = $current->pluck('id','seq')->toArray();        // [seq => id]
            $seqById    = $current->pluck('seq','id')->toArray();        // [id  => seq]

            // หา index แรกที่ไม่ตรงกัน
            $firstDiff = null;
            $len = min(count($currentIds), count($newOrderIds));
            for ($i = 0; $i < $len; $i++) {
                if ((int)$currentIds[$i] !== (int)$newOrderIds[$i]) {
                    $firstDiff = $i;
                    break;
                }
            }

            // ถ้าเหมือนเดิมทุกตำแหน่ง ไม่ต้องทำอะไร
            if ($firstDiff === null) return;

            // ตำแหน่งที่ต่าง: ต้องการให้ id นี้มาอยู่ที่ seq เป้า
            $targetSeq  = $firstDiff + 1;
            $desiredId  = (int)$newOrderIds[$firstDiff];   // id ที่ผู้ใช้ลากมาวางตรง seq เป้า
            $currentId  = (int)$currentIds[$firstDiff];    // id ที่เดิมครอง seq เป้านี้อยู่

            // กรณีทั่วไป: สลับ desiredId ↔ currentId เท่านั้น (อัปเดต 2 แถว)
            $oldSeqDesired = $seqById[$desiredId] ?? null; // seq เดิมของ desiredId (จะไปแทน currentId)
            if (!$oldSeqDesired) {
                // ถ้าไม่มี seq (ข้อมูลเพิ่งเข้าหรือผิดปกติ) ให้ตั้งตรง ๆ 2 แถวเหมือนเดิม
                $oldSeqDesired = $targetSeq;
            }

            // ป้องกัน unique ชน (product_id, seq) ด้วย temp = 0
            ComProductImage::where('product_id', $id)->where('id', $desiredId)->update(['seq' => 0]);

            // ย้าย currentId ไป seq เดิมของ desiredId
            ComProductImage::where('product_id', $id)->where('id', $currentId)->update(['seq' => $oldSeqDesired]);

            // วาง desiredId ลง seq เป้า
            ComProductImage::where('product_id', $id)->where('id', $desiredId)->update(['seq' => $targetSeq]);

            // อัปเดตรูปหลัก (seq = 1) เฉพาะสินค้านี้
            $mainImage = ComProductImage::where('product_id', $id)->where('seq', 1)->first();
            if ($mainImage && $mainImage->path) {
                Com_product::updateOrCreate(
                    ['product_id' => $id],
                    ['img_url' => $mainImage->path]
                );
            }
        });

        session()->flash('message', 'อัปเดตข้อมูลสำเร็จ');
        return response()->json(['status' => 200, 'message' => 'อัปเดตข้อมูลสำเร็จ']);
    }

    public function filter(Request $request)
    {
        $endpoint = "https://ins.schicher.com/api/users";
        $response = Http::asForm()->get($endpoint);

        if ($response->successful()) {
            $data = collect($response->json()); // Convert data to a collection

            $type = $request->get('type'); // Retrieve the 'type' parameter from the request

            if ($type) {
                $filteredData = $data->filter(fn($item) => $item['role'] === $type);
            } else {
                $filteredData = $data;
            }
            return response()->json($filteredData->values());
        } else {
            return response()->json([
                'error' => 'Request failed',
                'status' => $response->status(),
                'body' => $response->body(),
            ], $response->status());
        }
    }
}
