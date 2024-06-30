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
        $data = menu_relation::where('position_id', $request->input('pos_id'))->pluck('menu_id');
        // $action = menu_relation::select(
        //     'view',
        //     'create',
        //     'edit',
        //     'delete',
        // )
        // ->pluck("view", "create", "edit", "delete")
        // ->toArray();

        $menus = menu::select('id')->get();

        foreach ($menus as $menu) {
            $dataarray_code = [];
                $item_code = menu_relation::select("id", "view")
                    ->where('menu_id', '=', $menu->id)
                    ->get();

                foreach ($item_code as $dataitem_code) {
                    $dataarray_code[] = $dataitem_code->view;
                }

                $menu->dataarray_code = $dataarray_code;

        }

        dd($menus->all());

        return response()->json(['data' => $data, 'menus' => $menus]);
    }

    public function createAccess(Request $request)
    {
        // $checkboxes = $request->input('arrs', []);
        // $keys = ['show', 'create', 'edit', 'delete'];
        // $options = [];
        // $keys = [
        //     'show' => false,
        //     'create' => false,
        //     'edit' => false,
        //     'delete' => false,
        // ];

        // foreach ($checkboxes as $key => $value) {
        //         $options[] = $value;
        // }

        // foreach ($keys as $key) {
        //         $options[$key] = in_array($key, $checkboxes);
        // }
        // dd(['Array1' => $request]);
        // foreach ($checkboxes as $key => $value) {
        //     if (isset($keys[$key])) {
        //         $keys[$key] = true;
        //     }
        // }
        // dd(['Array2' => $request->all()]);

        $view = '';
        if ($request->action == 'view') {
            $view = $request->state;
        }
        $create = '';
        if ($request->action == 'create') {
            $create = $request->state;
        }
        $edit = '';
        if ($request->action == 'edit') {
            $edit = $request->state;
        }
        $delete = '';
        if ($request->action == 'delete') {
            $delete = $request->state;
        }

        $create_menu_relation = menu_relation::updateOrCreate([
            'position_id' => $request->input('pos_id'),
            'menu_id' => $request->input('menu_id'),
            'view' => intval($view) ?? null,
            'create' => intval($create) ?? null,
            'edit' => intval($edit) ?? null,
            'delete' => intval($delete) ?? null,
        ]);
        // dd(['Array3' => $request]);
        return response()->json($create_menu_relation);
    }

    public function deleteAccess(Request $request)
    {
        $delete = menu_relation::where('position_id', $request->input('pos_id'))
            ->where('menu_id', $request->input('menu_id'))
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
