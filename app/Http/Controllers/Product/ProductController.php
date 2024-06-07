<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

        return view('product.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
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
        $data = User::select('id')
            ->where('status', '=', 2)
            ->count();

        return $data;
    }

    public function list_users(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        // $doc_no = $request->input('doc_no');
        // $date_start = $request->input('date_start');
        // $date_end = $request->input('date_end');

        // $field_detail = ['trn_dona_totambons.doc_no', 'trn_dona_totambons.member_id'];

        $data = User::select(
            'id',
            'name',
            'email',
            'status'
        )
        ->orderBy('id', 'ASC');


        // if (null != $doc_no) {
        //     $data = $data->where(function ($data) use ($doc_no, $field_detail) {
        //         for ($i = 0; $i < count($field_detail); $i++) {
        //             $data->orWhere($field_detail[$i], 'like', '%'.$doc_no.'%');
        //         }
        //     });
        // }

        // if (null != $date_start && null != $date_end) {
        //     $data = $data->whereBetween('trn_dona_totambons.doc_datetime', ["$date_start", "$date_end"]);
        // } elseif (null != $date_start) {
        //     $data = $data->where('trn_dona_totambons.doc_datetime', '=', "$date_start");
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

    public function checkname_brand(Request $request) {

        $data = User::select('id')
            ->where('name', $request->name)
            ->count();

        return response()->json($data > 0 ? false : true);
    }

    public function search_product(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        // $doc_no = $request->input('doc_no');
        // $date_start = $request->input('date_start');
        // $date_end = $request->input('date_end');

        // $field_detail = ['trn_dona_totambons.doc_no', 'trn_dona_totambons.member_id'];

        $data = User::select(
            'id',
            'name',
            'email'
        )
        ->orderBy('id', 'ASC');


        // if (null != $doc_no) {
        //     $data = $data->where(function ($data) use ($doc_no, $field_detail) {
        //         for ($i = 0; $i < count($field_detail); $i++) {
        //             $data->orWhere($field_detail[$i], 'like', '%'.$doc_no.'%');
        //         }
        //     });
        // }

        // if (null != $date_start && null != $date_end) {
        //     $data = $data->whereBetween('trn_dona_totambons.doc_datetime', ["$date_start", "$date_end"]);
        // } elseif (null != $date_start) {
        //     $data = $data->where('trn_dona_totambons.doc_datetime', '=', "$date_start");
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

    public function upate_product_status($id)
    {
        $data = User::find($id);
        $data->status = 2;
        $data->save();

        return response()->json(['success'=>true]);
    }
}
