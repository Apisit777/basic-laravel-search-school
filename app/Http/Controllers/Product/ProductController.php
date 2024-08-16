<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Models\position;
use App\Models\User;
use App\Models\Npd_cos;
use App\Models\Npd_pdms;
use App\Models\Npd_categorys;
use App\Models\Npd_textures;
use App\Models\Pro_develops;
use App\Models\Barcode;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

        $product_seq = Product::select('seq')->get();

        return view('product.index', compact('user', 'product_seq'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $productCodeMax = Product::max('seq');
        $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        $productCode = 'P'.sprintf('%05d', $productCodeNumber);

        $list_position = position::select('id', 'name_position')->get();
        $brands = Brand::listBrand();
        // dd($productCode);
        return view('product.create', compact('productCode', 'list_position', 'brands'));
    }
    public function productDetailCreate(Request $request)
    {
        $productCodeMax = Product::max('seq');
        $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        $productCode = 'P'.sprintf('%05d', $productCodeNumber);

        $list_position = position::select('id', 'name_position')->get();
        // dd($productCode);
        return view('product_detail.create', compact('productCode', 'list_position'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data_product = [
                'name' => $request->input('name')
            ];

            $product = Product::create($data_product);

            $productCodeMax = Product::max('seq');
            $productCodeNumber =  preg_replace( '/[^0-9]/', '', $productCodeMax ) + 1;
            $productCode = 'T'.sprintf('%06d', $productCodeNumber);

            $response = Product::where('id', $product->id)->update([
                'seq' => $productCode,
            ]);

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
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id_barcode)
    {
        $data = Pro_develops::select(
            'pro_develops.*',
            DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
            )
            ->firstWhere('BARCODE', '=', $id_barcode);

        // dd($data);

        return view('new_product_develop.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function get_users()
    {
        $get_users = User::all();

        return view('product.get_users', compact('get_users'));
    }

    public static function count_users()
    {
        $data = Product::select('id')
            ->where('status', '=', 2)
            ->count();

            // $data = $data->count();

        // return response()->json($data);
        return $data;
    }

    public function list_npd(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $BARCODE = $request->input('BARCODE');
        $DOC_NO = $request->search;
        $field_detail = [
            'pro_develops.DOC_NO',
            'pro_develops.NAME_ENG',
            'pro_develops.BARCODE', 
        ];
        $data = Pro_develops::select(
                'BRAND',
                DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
                'BARCODE',
                'NAME_ENG'
            )
            ->orderBy('BARCODE', 'DESC');

        if (null != $DOC_NO) {
            $data = $data->where(function ($data) use ($DOC_NO, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$DOC_NO.'%');
                }
            });
        }

        if (null != $BARCODE) {
            $productCodes = $data->where(DB::raw('SUBSTRING(BARCODE, 8, 5)'), $request->input('BARCODE'))->pluck('BARCODE');
            // $productCodeArr = [];
            // foreach($productCodes as $productCodeLast) {
            //     $productCodeArrLast = [];
            //     $productCodeArrLast[] = substr_replace($productCodeLast, '', -1);
            //     foreach($productCodeArrLast as $productCodeFirst) {
            //         $productCodeArr[] = substr($productCodeFirst, 7, 11);
            //     }
            // }
            // $productCodesObject = json_decode(json_encode($productCodes));
            // $data->where($productCodeArr, $BARCODE);
            // $data= collect($productCodes);
            // if (null != $productCodeArr) {
            // }

            // $obj->where('pro_develops.BARCODE', function ($barcode) use ($request) {
            //     $barcode->orWhere('BARCODE', $request->BARCODE);
            // });
        }

        // dd($data);
        $data = $data->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }

    public function list_products(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = Product::select(
            'id',
            'seq',
            'name'
        )
        ->where('status', 1)
        ->orderBy('id', 'ASC');

        // dd($data);
        $data = $data->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    
    public function checkname_brand(Request $request) {

        $data = User::select('id')
            ->where('name', $request->name)
            ->count();

        return response()->json($data > 0 ? false : true);
    }

    public function list_approve_products(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = Product::select(
            'id',
            'seq',
            'name',
            'status'
        )
        ->where('status', 1)
        ->orderBy('id', 'ASC');

        // dd($data);
        $data = $data->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }

    public function upate_product_status($id)
    {
        $data = Product::find($id);
        $data->status = 2;
        $data->save();

        return response()->json(['success'=>true]);
    }
    // public static function upate_product_status()
    // {
    //     $data = Product::find('id');
    //     $data->status = 2;
    //     $data->save();

    //     // return response()->json(['success'=>true]);
    //     return $data;
    // }
}
