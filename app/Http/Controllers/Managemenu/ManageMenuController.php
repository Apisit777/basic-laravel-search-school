<?php

namespace App\Http\Controllers\Managemenu;

use App\Models\ManageMenu;
use App\Models\position;
use App\Models\menu;
use App\models\menu_relation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menu = menu::all();
        $position = position::all();

        $options = menu_relation::all();

        // dd($options->all());

        return view('managemenu.index', compact('menu', 'position'));
    }

    public function menuAccess(Request $request)
    {
        // return $request->all();
        $data = menu_relation::where('position_id', $request->input('pos_id'))->pluck('menu_id');

        return response()->json($data);
    }
    
    public function createAccess(Request $request)
    {
        $checkboxes = $request->input('arrs', []);
        $keys = ['show', 'create', 'edit', 'delete'];
        $options = [];

        foreach ($keys as $key) {
                $options[$key] = in_array($key, $checkboxes);
        }
        // dd($request);
        $create = menu_relation::firstOrCreate([
            'position_id' => $request->input('pos_id'),
            'menu_id' => $request->input('menu_id'),
            'options' => json_encode($options),
        ]);

        return response()->json($create);
    }

    public function deleteAccess(Request $request)
    {
        $delete = menu_relation::where('position_id', $request->input('pos_id'))
            ->where('menu_id', $request->input('menu_id'))
            ->where('options', $request->input('action_name'))
            ->delete();

        return response()->json($delete);
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
