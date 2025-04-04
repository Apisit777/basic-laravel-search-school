<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductDetail;
use App\Models\ProductDetailLog;
use App\Models\Com_product;
use App\Models\ComProductLog;
use App\Models\Barcode;
use App\Models\Accessery;
use App\Models\MasterBrand;
use App\Models\Brand_p;
use App\Models\Food;
use App\Models\ComProductImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


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

        // dd( $roles);
        return view('warehouse.index', compact('brands', 'roles'));
    }

    public function listWarehouse(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $BRAND = $request->input('brand_id');
        $searchAll = $request->input('search', '');

        $data = Com_product::select(
            'company_id',
            'com_products.product_id AS product_id',
            'com_products.barcode AS barcode',
            'vendor_id',
            'com_products.name_thai AS name_thai',
            'com_products.img_url AS img_url',
        )
        ->join('product1s', 'com_products.product_id', '=', 'product1s.PRODUCT');
        // ->orderBy('product_id', 'DESC');

        if ($BRAND != null) {
            $data->where('com_products.company_id', $BRAND);
        }

        // กรองข้อมูลถ้ามีคำค้นหา
        if (!empty($searchAll)) {
            $data->where(function ($q) use ($searchAll) {
                $q->orWhere('com_products.product_id', 'like', '%' . $searchAll . '%')
                ->orWhere('com_products.name_thai', 'like', '%' . $searchAll . '%')
                ->orWhere('com_products.barcode', 'like', '%' . $searchAll . '%');
            });
        }

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

        // dd($images);

        return view('warehouse.edit', compact('data', 'images', 'product_id'));
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
                        'user_update' => Auth::user()->username,
                        'update_dt' => date("Y/m/d H:i:s"),
                    ];

                    $data_old_arr = array_merge($data_old_arr, $log);
                    ProductDetailLog::create($data_old_arr);
                }

                $data_product_upddate = [
                    // 'corporation_id' => $request->input('corporation_id'),
                    // 'product_id' => $request->input('product_id'),
                    // 'launch' => $request->input('launch'),
                    // 'country' => $request->input('country'),
                    // 'fad' => $request->input('fad'),
                    // 'after_open_m' => $request->input('after_open_m'),
                    // 'description_th' => $request->input('description_th'),
                    // 'description_en' => $request->input('description_en'),
                    // 'usage_direction_th' => $request->input('usage_direction_th'),
                    // 'usage_direction_en' => $request->input('usage_direction_en'),
                    // 'color_code_th' => $request->input('color_code_th'),
                    // 'color_code_en' => $request->input('color_code_en'),

                    'unit_weight' => $request->input('unit_weight'),
                    'unit_pak_size' => $request->input('unit_pak_size'),
                    'case_width' => $request->input('case_width'),
                    'case_length' => $request->input('case_length'),
                    'case_height' => $request->input('case_height'),
                    'case_barcode' => $request->input('case_barcode'),
                    'case_weight' => $request->input('case_weight'),
                    'case_pack_size' => $request->input('case_pack_size'),
                    'inner_width' => $request->input('inner_width'),
                    'inner_length' => $request->input('inner_length'),
                    'inner_height' => $request->input('inner_height'),
                    'inner_barcode' => $request->input('inner_barcode'),
                    'inner_weight' => $request->input('inner_weight'),
                    'inner_pack_size' => $request->input('inner_pack_size'),
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s")
                ];

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
                        'user_update' => Auth::user()->username,
                        'update_dt' => date("Y/m/d H:i:s"),
                    ];

                    $data_data_old_com_product_arr = array_merge($data_data_old_com_product_arr, $log);
                    ComProductLog::create($data_data_old_com_product_arr);
                }
                // อัปเดตหรือสร้างข้อมูลใหม่
                $upddateComProduct = Com_product::updateOrCreate(
                    ['product_id' => $id],
                    [
                        'unit_weight' => $comProductUpddate->unit_weight,
                        'unit_pak_size' => $comProductUpddate->unit_pak_size,
                        'case_width' => $comProductUpddate->case_width,
                        'case_length' => $comProductUpddate->case_length,
                        'case_height' => $comProductUpddate->case_height,
                        'case_barcode' => $comProductUpddate->case_barcode,
                        'case_weight' => $comProductUpddate->case_weight,
                        'case_pack_size' => $comProductUpddate->case_pack_size,
                        'inner_width' => $comProductUpddate->inner_width,
                        'inner_length' => $comProductUpddate->inner_length,
                        'inner_height' => $comProductUpddate->inner_height,
                        'inner_barcode' => $comProductUpddate->inner_barcode,
                        'inner_weight' => $comProductUpddate->inner_weight,
                        'inner_pack_size' => $comProductUpddate->inner_pack_size,
                        'width' => $comProductUpddate->inner_pack_size,
                        'long' => $comProductUpddate->inner_pack_size,
                        'height' => $comProductUpddate->inner_pack_size,
                        'area' => $comProductUpddate->inner_pack_size,
                        'box_qty' => $comProductUpddate->inner_pack_size,
                        'pallet_qty' => $comProductUpddate->inner_pack_size,
                        'weight' => $comProductUpddate->inner_pack_size,
                        'upd_user' => Auth::user()->username,
                        'upd_date' => date("Y/m/d H:i:s")
                    ]
                );

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

        return view('warehouse.document.index', compact('brand_ps', 'brands', 'roles'));
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

    public function updateImageSequence(Request $request, $id)
    {
        // dd($request)->all();
        if (!$request->has('img') || !is_array($request->img)) {
            return response()->json(['status' => 400, 'message' => 'Invalid request'], 400);
        }
    
        foreach ($request->img as $index => $imageId) {
            ComProductImage::where('id', $imageId)->update(['seq' => $index + 1]);
        }
    
        // ✅ Fix: เพิ่ม product_id filter
        $mainImage = ComProductImage::where('product_id', $id)
            ->where('seq', 1)
            ->first();
    
        // dd($mainImage);

        if ($mainImage && $mainImage->path) {
            Com_product::updateOrCreate(
                ['product_id' => $id],
                ['img_url' => $mainImage->path]
            );
        }

        session()->flash('message', 'อัปเดตข้อมูลสำเร็จ');
        return response()->json([
            'status' => 200, 
            'message' => 'อัปเดตข้อมูลสำเร็จ'
        ]);
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
