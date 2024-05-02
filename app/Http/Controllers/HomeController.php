<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Food;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::select(
            'id',
            'name',
            'price'
        )
        ->get();

        // dd($foods);
        return view('searchSchool', compact('foods'));
    }

    public function search_school(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $name_number = $request->input('name_number');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        $field_detail = ['booking_ins.name', 'booking_ins.tel'];

        $data = Food::select(
            'id',
            'name',
            'price')
        ->orderBy('id', 'ASC');


        if (null != $name_number) {
            $data = $data->where(function ($data) use ($name_number, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$name_number.'%');
                }
            });
        }

        if (null != $date_start && null != $date_end) {
            $data = $data->whereBetween('booking_ins.booking_date', ["$date_start", "$date_end"]);
        } elseif (null != $date_start) {
            $data = $data->where('booking_ins.booking_date', '=', "$date_start");
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
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Home $home)
    {
        //
    }
}
