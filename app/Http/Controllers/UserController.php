<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\MasterBrand;
use App\Models\Brand_p;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
    */
    public function index()
    {
        $users = User::get();
        $brands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();
        $brand_ps = Brand_p::all();
        $roles = [];

        return view('warehouse.document.index', compact('users', 'brand_ps', 'brands', 'roles'));
        // return view('users', compact('users'));
    }

    /**
     * @return \Illuminate\Support\Collection
    */
    public function export()
    {
        //
    }
    /**
     * @return \Illuminate\Support\Collection
    */
    public function import()
    {
        Excel::import(new UserImport, request()->file('file'));
        return back();
    }
}
