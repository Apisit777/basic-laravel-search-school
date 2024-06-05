<?php

namespace App\Http\Controllers\Managemenu;

use App\Models\ManageMenu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('managemenu.index');
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
    public function show(ManageMenu $manageMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManageMenu $manageMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ManageMenu $manageMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManageMenu $manageMenu)
    {
        //
    }
}
