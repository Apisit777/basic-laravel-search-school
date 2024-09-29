<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Com_product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('warehouse.index');
    }

    public function listWarehouse()
    {
        //
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
    public function edit(Com_product $com_product)
    {
        //
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
