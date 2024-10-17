<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Com_product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barcode;
use App\Models\Accessery;


class ComProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Accessery::all();
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;

        // create brands consumables
        if (in_array($userpermission, [$isSuperAdmin])) {
            $brands = Accessery::select(
                'COMPANY',
                'DESCRIPTION')
            ->get();
        } else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $brands = Accessery::select(
                'COMPANY',
                'DESCRIPTION')
            ->where('COMPANY', 'OP')
            ->whereIn('DESCRIPTION', ['OP', 'KM'])
            ->get();
        } else if (in_array($userpermission, ['Marketing - CPS'])) {
            $brands = Accessery::select(
                'COMPANY',
                'DESCRIPTION')
            ->where('COMPANY', 'CPS')
            ->whereIn('DESCRIPTION', ['CPS', 'KM'])
            ->get();
        }

        return view('warehouse.index', compact('brands'));
    }

    public function listWarehouse(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $company = $request->input('company_id');
        $PRODUCT = $request->input('PRODUCT');
        // $BARCODE = $request->input('BARCODE');
        $DOC_NO = $request->search;
        $field_detail = [
            'product1s.PRODUCT',
            'product1s.NAME_THAI',
            'product1s.BARCODE',
        ];

        $data = Com_product::select(
            'company_id',
            'product_id',
            'barcode',
            'vendor_id',
            'name_thai'
        )
        ->orderBy('product_id', 'DESC');

        // $userpermission = Auth::user()->getUserPermission->name_position;
        // $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        // if (in_array($userpermission, [$isSuperAdmin, 'Admin'])) {
        //         $data = Com_product::select(
        //         'company_id',
        //         'product_id',
        //         'barcode',
        //         'vendor_id',
        //         'name_thai'
        //     )
        //     ->orderBy('BARCODE', 'DESC');
        // } else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
        //     $data = Com_product::select(
        //             'company_id',
        //             'product_id',
        //             'barcode',
        //             'vendor_id',
        //             'name_thai'
        //         )
        //         ->whereIn('company_id', ['OP', 'KM'])
        //         ->orderBy('barcode', 'DESC');
        // } else if (in_array($userpermission, ['Marketing - CPS'])) {
        //     $data = Com_product::select(
        //         'company_id',
        //         'product_id',
        //         'barcode',
        //         'vendor_id',
        //         'name_thai'
        //     )
        //     ->whereIn('company_id', ['CPS', 'KM'])
        //     ->orderBy('barcode', 'DESC');
        // }

        if ($company != null) {
            $data->where('com_products.company_id', $company);
        }

        if (null != $DOC_NO) {
            $data = $data->where(function ($data) use ($DOC_NO, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$DOC_NO.'%');
                }
            });
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
    public function edit(Com_product $com_product, $product_id)
    {
        $data = Com_product::select(
            'com_products.*',
        )
        ->firstWhere('product_id', '=', $product_id);

        return view('warehouse.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Com_product $com_product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Com_product $com_product)
    {
        //
    }
}
