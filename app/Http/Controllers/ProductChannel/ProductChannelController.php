<?php

namespace App\Http\Controllers\ProductChannel;

use App\Http\Controllers\Controller;
use App\Models\Product1;
use App\Models\ProductChannel;
use App\Models\MasterBrand;
use Illuminate\Http\Request;

class ProductChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();

        // $allProducts = Product1::select(
        //     'product1s.PRODUCT AS PRODUCT',
        // )
        // ->join('product_channels', 'product1s.PRODUCT', '=', 'product_channels.PRODUCT')
        // ->pluck('PRODUCT')->toArray();

        // $allNameThais = Product1::select(
        //     'NAME_THAI'
        // )
        // ->pluck('NAME_THAI')->toArray();

        // dd($allProducts);
        return view('product_channel.index', compact('allBrands'));
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
    public function show(ProductChannel $productChannel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductChannel $productChannel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductChannel $productChannel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductChannel $productChannel)
    {
        //
    }

    public function list_product_channel(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        // $data = ProductChannel::select(
        //     'product_channels.BRAND AS BRAND',
        //     'product1s.PRODUCT AS PRODUCT',
        //     'product1s.NAME_THAI AS NAME_THAI'
        // )
        // ->join('product1s', 'product_channels.PRODUCT', '=', 'product1s.PRODUCT')
        // ->whereColumn('product_channels.PRODUCT', 'product1s.PRODUCT')
        // ->orderBy('PRODUCT', 'DESC');

        $searchProductAll = $request->input('searchProduct', '');
        $searchProductNameAll = $request->input('searchProductName', '');
        $data = Product1::select(
            'product_channels.BRAND AS BRAND',
            'product1s.PRODUCT AS PRODUCT',
            'product1s.NAME_THAI AS NAME_THAI'
        )
        ->join('product_channels', 'product1s.PRODUCT', '=', 'product_channels.PRODUCT');

        if ($request->BRAND) {
            $data = $data->where('product_channels.BRAND', $request->BRAND);
        }

        if ($request->PRODUCT) {
            $data->where('product_channels.PRODUCT', $request->PRODUCT);
        }

        if (!empty($searchProductAll)) {
            $data->where(function ($q) use ($searchProductAll) {
                $q->orWhere('product1s.PRODUCT', 'like', '%' . $searchProductAll . '%');
            });
        }

        if (!empty($searchProductNameAll)) {
            $data->where(function ($q) use ($searchProductNameAll) {
                $q->orWhere('product1s.NAME_THAI', 'like', '%' . $searchProductNameAll . '%');
            });
        }
        // dd($data->toSql());
<<<<<<< HEAD
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
=======
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
>>>>>>> 91b246dbc35479f4c34ce8289271a80eccbbc360
    }
}
