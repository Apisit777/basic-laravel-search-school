<?php

namespace App\Http\Controllers\ProductDetail;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Barcode;
use App\Models\Product1;
use App\Models\ProductDetail;
use App\Models\Com_product;
use App\Models\Countrie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ProductDetailController extends Controller
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

        }

        // dd($dataProductMasterArr);
        return view('product_detail.index', compact('brands', 'dataProductMasterArr'));
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
        )
        ->firstWhere('product_details.product_id', '=', $id);

        $data->launch = date('Y-m', strtotime($data->launch));

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

        // dd($countriesDatas);
        return view('product_detail.edit', compact('data', 'countriesDatas', 'dataComProduct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        dd($request);
        DB::beginTransaction();
        try {
                $data_old = ProductDetail::select(
                    'product1s.*',
                )
                ->firstWhere('product1s.PRODUCT', '=', $id);

                $data_old_arr = $data_old->toArray();

                if ($request) {
                    $log = [
                        'UPDATE_DT' => date("Y/m/d H:i:s"),
                        'USER_UPDATE' => Auth::user()->username
                    ];

                    $data_old_arr = array_merge($data_old_arr, $log);
                    // dd($data_old_arr);
                    $logProductUpddate = Product1Log::create($data_old_arr);
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

                    // 'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                    // 'USER_EDIT' => Auth::user()->username,
                    // 'EDIT_DT' => date("Y-m-d"),
                    // 'STATUS_EDIT_DT' => '',
                ];

                $productUpddate = ProductDetail::where('PRODUCT', $id)->update($data_product_upddate);

                // dd($productUpddate);
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

        $data = ProductDetail::select(
            'corporation_id',
            'product_id',
            'inner_barcode'
        )
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
