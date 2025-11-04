<?php

namespace App\Http\Controllers\ManagePrice;

use App\Http\Controllers\Controller;
use App\Models\ManagePrice;
use Illuminate\Http\Request;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\MasterBrand;
use App\Models\Brand_p;
use App\Models\Product1;
use App\Models\Com_product;
use App\Models\Product1Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ManagePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        $brands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();
        $brand_ps = Brand_p::all();
        $managePrices = ManagePrice::all();

        // dd($managePrices);

        return view('manageprice.index', compact('users', 'brand_ps', 'brands'));
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new UserImport, $request->file('file'));

            $request->session()->flash('status', 'เพิ่มข้อมูลสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => '❌ เกิดข้อผิดพลาด: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updatePrice(Request $request)
    {
        DB::beginTransaction();
        try {
            $products = $request->input('products');
            $updatedItems = [];

            foreach ($products as $product) {
                $brand = trim($product['brand'] ?? '');
                $productCode = trim($product['product'] ?? '');

                if (!$brand || !$productCode) {
                    continue;
                }

                $priceData = ManagePrice::where('brand', $brand)
                    ->where('product', $productCode)
                    ->first();

                // ตรวจสอบว่ามีใน manage_prices
                if ($priceData) {
                    // ดึงข้อมูลเดิมจาก product1s
                    $data_old = Product1::where('BRAND', $brand)
                        ->where('PRODUCT', $productCode)
                        ->first();

                    if ($data_old) {
                        $data_old_arr = $data_old->toArray();
                        // เพิ่มข้อมูล log
                        $log = [
                            'UPDATE_DT' => now()->format('Y-m-d H:i:s'),
                            'USER_UPDATE' => Auth::user()->username ?? 'system',
                        ];
                        // รวมข้อมูลเดิม + log
                        $data_log = array_merge($data_old_arr, $log);
                        // สร้าง log
                        Product1Log::create($data_log);
                    }

                    // 1) อัปเดต product1s
                    $affectedP1 = Product1::where('BRAND',$brand)
                        ->where('PRODUCT',$productCode)
                        ->update([
                            'COST'            => $priceData->cost,
                            'EDIT_DT'         => now()->format('Y-m-d H:i:s'),
                            'STATUS_EDIT_DT'  => '',
                        ]);

                    // 2) อัปเดต com_products
                    $affectedCom = Com_product::where('company_id', $brand)
                        ->where('product_id', $productCode)
                        ->update([
                            'cost'               => $priceData->cost,
                            'update_dt'          => now()->format('Y-m-d H:i:s'),
                            'status_tranfer_km'  => '',
                        ]);

                    $updatedItems[] = [
                        'brand'        => $brand,
                        'product'      => $productCode,
                        'cost'         => $priceData->cost,
                        'updated_p1'   => $affectedP1 > 0,
                        'updated_com'  => $affectedCom > 0,
                    ];
                }
            }

            // ✅ แสดงรายการทั้งหมดที่อัปเดต
            // dd($updatedItems);
            DB::commit();
            $request->session()->flash('status', 'เพิ่มข้อมูลสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => '❌ เกิดข้อผิดพลาด: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function listImportExcel(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $BRAND = $request->input('brand_id');
        $searchAll = $request->input('search', '');

        $data = ManagePrice::select('manage_prices.*');

        if ($BRAND != null) {
            $data->where('product1s.BRAND', $BRAND);
        }

        // กรองข้อมูลถ้ามีคำค้นหา
        if (!empty($searchAll)) {
            $data->where(function ($q) use ($searchAll) {
                $q->orWhere('PRODUCT', 'like', '%' . $searchAll . '%')
                ->orWhere('NAME_THAI', 'like', '%' . $searchAll . '%');
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
            'recordsTotal' => $totalRecords,         // ✅ เปลี่ยนชื่อให้ตรง
            'recordsFiltered' => $totalRecords,      // ✅ เปลี่ยนชื่อให้ตรง
            'data' => $records,                      // ✅ ใช้ชื่อ 'data'
        ]);
    }

    public function listPriceAll(Request $request)
    {
        $query = ManagePrice::query();

        if ($request->brand_id) {
            $query->where('brand', $request->brand_id);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->orWhere('product', 'like', '%' . $request->search . '%');
            });
        }

        $allData = $query->get(); // ไม่มี limit → ได้ทั้งหมดที่ตรง filter

        return response()->json([
            'data' => $allData
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(ManagePrice $managePrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManagePrice $managePrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ManagePrice $managePrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManagePrice $managePrice)
    {
        //
    }
}
