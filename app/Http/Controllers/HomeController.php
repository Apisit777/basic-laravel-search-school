<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Food;
use App\Models\TrnDonaTotambon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search_school = TrnDonaTotambon::select(
            'id', 'doc_datetime', 'doc_no', 'event', 'doc_refer', 'flag', 'cancel_date', 'cancel_user', 'member_id', 'do_befor', 'do_reedem',
            'do_balance', 'donation_use', 'tb_id', 'school_id', 'remark', 'type_member', 'reg_user', 'reg_time', 'upd_user', 'upd_time', 'time_up'
        )
        ->get();

        // dd($search_school);
        return view('searchSchool', compact('search_school'));
    }

    public function search_school(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $doc_no = $request->input('doc_no');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        $field_detail = ['trn_dona_totambons.doc_no'];

        $data = TrnDonaTotambon::select(
            'id', 'doc_datetime', 'doc_no', 'event', 'doc_refer', 'flag', 'cancel_date', 'cancel_user', 'member_id', 'do_befor', 'do_reedem',
            'do_balance', 'donation_use', 'tb_id', 'school_id', 'remark', 'type_member', 'reg_user', 'reg_time', 'upd_user', 'upd_time', 'time_up'
        )
        ->orderBy('id', 'ASC');


        if (null != $doc_no) {
            $data = $data->where(function ($data) use ($doc_no, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$doc_no.'%');
                }
            });
        }

        if (null != $date_start && null != $date_end) {
            $data = $data->whereBetween('trn_dona_totambons.doc_datetime', ["$date_start", "$date_end"]);
        } elseif (null != $date_start) {
            $data = $data->where('trn_dona_totambons.doc_datetime', '=', "$date_start");
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
