<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Com_product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barcode;
use App\Models\Accessery;
use App\Models\MasterBrand;
use App\Models\Brand_p;
use Illuminate\Support\Facades\Http;


class ComProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();

        // $group_data_origin = Http::asForm()->withHeaders([])->post($endpoint);

        $endpoint = "https://ins.schicher.com/api/users";

        // Send a GET request
        $response = Http::asForm()->get($endpoint);

        $roles = [];
        if ($response->successful()) {
            $data = $response->json();

            $roles = collect($data)
                ->pluck('role')
                ->unique()
                ->values()
                ->toArray();

            // $roles = DB::table('users')
            //     ->select('role')
            //     ->distinct()
            //     ->get()
            //     ->pluck('role')
            //     ->toArray();

            // dd($roles);
        } else {
            // Handle errors
            dd('Request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        // dd( $roles);
        // $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        // $userpermission = Auth::user()->getUserPermission->name_position;

        // if (in_array($userpermission, [$isSuperAdmin])) {
        //     $brands = MasterBrand::select(
        //         'BRAND')
        //     ->get();
        // } else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
        //     $brands = MasterBrand::select(
        //         'BRAND')
        //     ->whereIn('BRAND', $brands)
        //     ->get();
        // } else if (in_array($userpermission, ['Marketing - CPS'])) {
        //     $brands = MasterBrand::select(
        //         'BRAND')
        //     ->whereIn('DESCRIPTION', $brands)
        //     ->get();
        // }

        return view('warehouse.index', compact('brands', 'roles'));
    }

    public function listWarehouse(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $company_id = $request->input('brand_id');
        // $BARCODE = $request->input('BARCODE');
        $DOC_NO = $request->search;
        $field_detail = [
            'com_products.product_id',
            'com_products.name_thai',
            'com_products.barcode',
        ];

        $data = Com_product::select(
            'company_id',
            'product_id',
            'barcode',
            'vendor_id',
            'name_thai'
        )
        ->orderBy('product_id', 'DESC');

        if ($company_id != null) {
            $data->where('com_products.company_id', $company_id);
        }

        if (null != $DOC_NO) {
            $data = $data->where(function ($data) use ($DOC_NO, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$DOC_NO.'%');
                }
            });
        }

        // if (null != $BARCODE) {
        //     $productCodes = $data->where(DB::raw('SUBSTRING(BARCODE, 8, 5)'), $request->input('BARCODE'))->pluck('BARCODE');
        // }

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

    public function indexDocument()
    {
        $brand_ps = Brand_p::all();
        return view('warehouse.document.index', compact('brand_ps'));
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