<?php

namespace App\Http\Controllers\Managemenu;

use App\Models\ManageMenu;
use App\Models\position;
use App\Models\menu;
use App\models\menu_relation;
use App\models\User;
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
        // $users = User::select()
        //     ->with('getUserPermission:id,user_id')->get();
        $menus = menu_relation::select('position_id')
            ->with('getMenuRelation:position_id,menu_id,view,create,edit,delete')
            ->get()
            ->toArray();
        // $permissions[] = ['view', 'create', 'edit', 'delete'];
        // $userIds = menu_relation::pluck('menu_id');
        // $permissionData = $userIds->map(function ($userId) use ($permissions) {
        //     return collect($permissions)->mapWithKeys(function ($permission) use ($permissions) {
        //         return [$permission => in_array($permission, $permissions)]; // Corrected line
        //     })->toArray();
        // });
        // dd($menus);

        return view('managemenu.index', compact('menu', 'position'));
    }

    public function menuAccess(Request $request)
    {
        // $data = menu_relation::where('position_id', $request->input('pos_id'))->pluck('menu_id');
        $menus = menu_relation::select('position_id')
            ->with('getMenuRelation:position_id,menu_id,view,create,edit,delete')
            ->get()
            ->toArray();

        // dd($menus);

        return response()->json(['menus' => $menus]);
    }

    public function createAccess(Request $request)
    {
        // $checkboxes = $request->input('arrs', []);

        // foreach ($checkboxes as $key => $value) {
        //         $options[] = $value;
        // }

        // dd(['Array1' => $request]);
        // foreach ($keys as $key) {
        //         $options[$key] = in_array($key, $checkboxes);
        // }
        // dd($request->action);

        $state = $request->input('state');

        $create_menu_relation = menu_relation::updateOrCreate(['position_id' => $request->pos_id, 'menu_id' => $request->menu_id],
        [
            $request->action => $state,
        ]);
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
