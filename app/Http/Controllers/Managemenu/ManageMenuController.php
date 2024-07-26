<?php

namespace App\Http\Controllers\Managemenu;

use App\Models\ManageMenu;
use App\Models\position;
use App\Models\menu;
use App\Models\submenu;
use App\models\menu_relation;
use App\models\Post;
use App\models\Comment;
use App\models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class ManageMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $menu = menu::all();
        // $menu = menu::select('position_id', 'menu_name')
        //     ->leftJoin('menu_relations', 'menus.id', 'menu_relations.menu_id')
        //     ->get();

        $position = position::all();
        $options = menu_relation::all();
        // $menus = menu::all();

        // $menu_data = [];
        // foreach ($menus as $key => $menu) {
        //     foreach ($menu->getMenuRelation()->where('position_id', '=', 1)->get() as $key_sub_menu => $menu_relation) {
        //         $menu_data[$key_sub_menu] = $menu_relation->with('getSubMenu')->where('position_id', '=', 1)->get();
        //     }
        // }
        // dd($menu_data);

        $Routename = Route::currentRouteName();
        $menus = menu::with(['getMenuRelation' => function ($query) {
            $query->where('status', 1)
            ->with('getSubMenu');
        }])
        ->get();
        $menus2 = menu::with(['getSubMenuLeft' => function ($query) {
            $query->where('status', 1);
        }])
        ->get();
        // dd($Routename);

        // $permissions[] = ['view', 'create', 'edit', 'delete'];
        // $userIds = menu_relation::pluck('menu_id');
        // $permissionData = $userIds->map(function ($userId) use ($permissions) {
        //     return collect($permissions)->mapWithKeys(function ($permission) use ($permissions) {
        //         return [$permission => in_array($permission, $permissions)]; // Corrected line
        //     })->toArray();
        // });

        $ps = Post::select('id')
            ->with('comments:post_id,user_id')
            ->get()
            ->toArray();

        // dd($menus);

        $menuData = [
            [
                'main_menu' => ['id' => 1, 'name' => 'Menu 1', 'view' => '', 'create' => '', 'edit' => '', 'delete' => ''],
                'sub_menus' => [
                    ['id' => 1, 'name' => 'Submenu 1.1', 'view' => '', 'create' => '', 'edit' => '', 'delete' => ''],
                    ['id' => 2, 'name' => 'Submenu 1.2', 'view' => '', 'create' => '', 'edit' => '', 'delete' => ''],
                ],
            ],
            [
                'main_menu' => ['id' => 2, 'name' => 'Menu 2', 'view' => '', 'create' => '', 'edit' => '', 'delete' => ''],
                'sub_menus' => [],
            ],
            [
                'main_menu' => ['id' => 3, 'name' => 'Menu 3', 'view' => '', 'create' => '', 'edit' => '', 'delete' => ''],
                'sub_menus' => [
                    ['id' => 3, 'name' => 'Submenu 3.1', 'view' => '', 'create' => '', 'edit' => '', 'delete' => ''],
                    ['id' => 4, 'name' => 'Submenu 3.2', 'view' => '', 'create' => '', 'edit' => '', 'delete' => ''],
                ],
            ],
        ];

        return view('managemenu.index', compact('menus', 'menus2', 'position', 'menuData'));
    }
    public function updateOrCreateMenu(Request $request, $id)
    {
        dd($request);
        DB::beginTransaction();
        try {

            $seq = menu::select('seq')
                ->where('id', $id)
                ->orderBy('seq', 'DESC')
                ->first();

            if (NUll == $seq) {
                $seq = 1;
            } else {
                $seq = $seq->seq + 1;
            }

            $data_menu = menu::updateOrCreate(['id' => $request->menu_id], [
                'name' => $request->input('menu_name'),
                'seq' => $seq,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);

            if (NUll != $request->inputs_submenu && count($request->input('inputs_submenu')) > 0) {
                $i = 0;
                $x = 1;
                foreach ($request->inputs_submenu as $key => $value) {
                    // $data_update = [
                    //     'tent_id' => $id,
                    //     'sale_name' => $request->sale_name[$i],
                    //     'seq' => $x,
                    //     'status' => $request->status[$key],
                    //     'updated_by' => Auth::user()->id,
                    // ];

                    if ('' != $request->menu_relation_id[$i] && '' != $request->inputs_submenu[$i]) {
                        $data_submenu = submenu::updateOrCreate(['menu_relation_id' => $request->menu_relation_id[$i]], [
                            'name' => $request->sale_name[$i],
                            'seq' => $x,
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                        ++$x;
                    } elseif ('' == $request->menu_relation_id[$i] && '' != $request->inputs_submenu[$i]) {
                        $seq = submenu::select('seq')
                            ->where('menu_relation_id', $id)
                            ->orderBy('seq', 'DESC')
                            ->first();

                        if (NUll == $seq) {
                            $seq = 1;
                        } else {
                            $seq = $seq->seq + 1;
                        }

                        $data_submenu = submenu::updateOrCreate(['menu_relation_id' => $request->menu_relation_id[$i]], [
                            'name' => $request->sale_name[$i],
                            'seq' => $seq,
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                        ]);
                        $seq = (int) $seq + 1;
                    } elseif ('' != $request->menu_relation_id[$i] && '' == $request->inputs_submenu[$i]) {
                        $data_submenu = submenu::where('menu_relation_id', $request->menu_relation_id[$i])
                            ->delete();
                    }
                    ++$i;
                }
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }
    public function menuAccess(Request $request)
    {
        // $data = menu_relation::where('position_id', $request->input('pos_id'))->pluck('menu_id');
        $menus = menu::all();

        $check_permission_menus = [];
        foreach ($menus as $key => $menu) {
            foreach ($menu->getMenuRelation()->where('position_id', '=', $request->input('pos_id'))->get() as $key_sub_menu => $menu_relation) {
                $check_permission_menus[$key_sub_menu] = $menu_relation->with('getSubMenu')->where('position_id', '=', $request->input('pos_id'))->get();
            }
        }
        // dd($check_permission_menus);
        return response()->json(['check_permission_menus' => $check_permission_menus]);
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

        $menu_state = $request->input('state');

        $menu_relation = menu_relation::updateOrCreate(['position_id' => $request->pos_id, 'menu_id' => $request->menu_id], [
            $request->action => $menu_state,
        ]);

        $submenu_state = $request->input('submenu_state');

        $submenu_relation = submenu::updateOrCreate(['menu_relation_id' => $request->menu_relation_id], [
            $request->submenu_action => $submenu_state,
        ]);

        return response()->json(['menu' => $menu_relation, 'submenu' => $submenu_relation]);
    }
    public function deleteAccess(Request $request)
    {
        $delete = menu_relation::where('position_id', $request->input('pos_id'))
            ->where('menu_id', $request->input('menu_id'))
            ->delete();

        return response()->json($delete);
    }
    public function listMenu(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = menu::all();

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
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'menu_name' => 'required',
                'url' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'message' => $validator->errors()]);
            }

            $seq = menu::max('seq');

            $createMenu = menu::create([
                'menu_name' => $request->input('menu_name'),
                'url' => $request->input('menu_url'),
                'status' => 1,
                'seq' => $seq + 1,
            ]);

            // dd($request->inputs_submenu);
            if ($request->inputs_submenu > 0) {
                if (NUll != $request->inputs_submenu && count($request->input('inputs_submenu')) > 0) {
                    $createMenuRelation  = menu_relation::create([
                        'position_id' => $createMenu->id,
                        'menu_id' => $createMenu->id,
                        'status' => 1,
                    ]);
                }
    
                if (NUll != $request->inputs_submenu && count($request->input('inputs_submenu')) > 0) {
                    $x = 1;
                    foreach ($request->inputs_submenu as $key => $value) {
                        $createSubmenu = submenu::create([
                            'menu_relation_id' => $createMenuRelation->id,
                            'menu_id' => $createMenu->id,
                            'name' => $value['submenu_name'],
                            'url' => $value['submenu_url'],
                            'seq' => $x,
                            'status' => 1,
                        ]);
                        ++$x;
                    }
                }
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');

            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
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
