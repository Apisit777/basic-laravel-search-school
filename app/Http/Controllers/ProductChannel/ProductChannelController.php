<?php

namespace App\Http\Controllers\ProductChannel;

use App\Http\Controllers\Controller;
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
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $BRAND = $request->input('brand_id');
        $DOC_NO = $request->search;
        $field_detail = [
            'product_channels.PRODUCT',
            'product_channels.BRAND',
        ];

        $data = ProductChannel::select(
            'product_channels.BRAND AS BRAND',
            'product1s.PRODUCT AS PRODUCT',
            'product1s.NAME_THAI AS NAME_THAI'
        )
        ->leftJoin('product1s', 'product_channels.PRODUCT', '=', 'product1s.PRODUCT')
        ->whereColumn('product_channels.PRODUCT', 'product1s.PRODUCT')
        ->orderBy('PRODUCT', 'DESC');

        if ($BRAND != null) {
            $data->where('product_channels.BRAND', $BRAND);
        }

        if (null != $DOC_NO) {
            $data = $data->where(function ($data) use ($DOC_NO, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$DOC_NO.'%');
                }
            });
        }

        // dd($data->toSql());
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
}
