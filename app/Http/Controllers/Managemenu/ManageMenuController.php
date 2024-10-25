<?php

namespace App\Http\Controllers\Managemenu;

use App\Models\ManageMenu;
use App\Models\position;
use App\Models\menu;
use App\Models\submenu;
use App\Models\menu_relation;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
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
        // $menu_data = [];
        // foreach ($menus as $key => $menu) {
        //     foreach ($menu->getMenuRelation()->where('position_id', '=', 1)->get() as $key_sub_menu => $menu_relation) {
        //         $menu_data[$key_sub_menu] = $menu_relation->with('getSubMenu')->where('position_id', '=', 1)->get();
        //     }
        // }
        // dd($menu_data);

        // $menus = menu::with(['getMenuRelation' => function ($query) {
        //     $query->where('status', 1)
        //     ->with('getSubMenu');
        // }])
        // ->get();

         // $test_menu_all = menu::all();
        // $menuObjects = $test_menu_all->map(function ($menu) {
        //     return (object) [
        //         'id' => $menu->id,
        //         'menu_name' => $menu->menu_name,
        //         'seq' => $menu->seq,
        //     ];
        // })->toArray();
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

        $position = position::all();
        $options = menu_relation::all();

        // $Routename = Route::currentRouteName();
        // $menu_permissions = menu::select('menus.id', 'menus.menu_name')
        //     ->get();

        // foreach ($menu_permissions as $menu_permission) {
        //     $submenu_array = [];

        //     $item_menu = menu_relation::select('submenus.name', 'submenus.id')
        //         ->leftJoin('submenus', 'menu_relations.submenu_id', 'submenus.id')
        //         ->where('menu_relations.menu_id', '=', $menu_permission->id)
        //         ->whereNotNull('menu_relations.submenu_id')
        //         ->get();

        //     foreach ($item_menu as $dataitem_menu) {
        //         $submenu_array[] = $dataitem_menu->name;
        //     }

        //     $menu_permission->submenu_array = $submenu_array;
        // }

        // dd($menu_permissions);

        $menus = menu::with('submenus')->get();
        // dd($menus);
        $authPosition = Auth::user()->getUserPermission->position_id;
        $menusAuthPosition = menu::with(['getPermissionSubmenus' => function ($query) use ($authPosition) {
                $query->where('menu_relations.position_id', $authPosition)
                ->whereNotNull('submenu_id');
            }])
            ->with(['getMenuRelation' => function ($query) use ($authPosition) {
                $query->where('menu_relations.position_id', $authPosition)
                ->whereNotNull('menu_relations.submenu_id');
            }])
            ->whereHas('getMenuRelation', function ($query) use ($authPosition) {
                $query->where('menu_relations.position_id', $authPosition);
            })
        ->get();
        // dd($menusAuthPosition);
        // $filters = [
        //     ['some_filter' => true],
        //     ['some_filter' => false],
        //     'filter1',
        //     'filter2',
        //     true,
        //     false
        // ];

        // $count = 0;
        // foreach ($filters as $filter) {
        //     if (is_array($filter)) {
        //         foreach ($filter as $option) {
        //             if ($option !== false) {
        //                 $count++;
        //             }
        //         }
        //     } else {
        //         if ($filter !== false) {
        //             $count++;
        //         }
        //     }
        // }

        // dump(collect($filters));
        // dump(collect($filters)->flatten());
        // dump(collect($filters)->flatten()->filter());

        return view('managemenu.index', compact('menus', 'position', 'menuData', 'menusAuthPosition'));
    }

    public static function menus_data()
    {
        $menuPpermissions = menu::select('menus.id', 'menus.menu_name')->get();
        foreach ($menuPpermissions as $menu_permission) {
            $submenu_array = [];

            $item_menu = menu_relation::select('submenus.name', 'submenus.id')
                ->leftJoin('submenus', 'menu_relations.submenu_id', 'submenus.id')
                ->where('menu_relations.menu_id', '=', $menu_permission->id)
                ->whereNotNull('menu_relations.submenu_id')
                ->get();

            foreach ($item_menu as $dataitem_menu) {
                $submenu_array[] = $dataitem_menu->name;
            }

            $menu_permission->submenu_array = $submenu_array;
        }
        return $menuPpermissions;
    }
    // public static function auth_position()
    // {
    //     $authPosition = Auth::user()->getUserPermission->position_id;
    //     // dd($authPosition);
    //     return $authPosition;
    // }

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
        // $check_permission_menus = [];
        // foreach ($menus as $key => $menu) {
        //     foreach ($menu->getMenuRelation()->where('position_id', '=', $request->input('pos_id'))->get() as $key_sub_menu => $menu_relation) {
        //         $check_permission_menus[$key_sub_menu] = $menu_relation->with('getSubMenu')->where('position_id', '=', $request->input('pos_id'))->get();
        //     }
        // }

        $data = menu_relation::where('position_id', '=', $request->input('pos_id'))
            ->whereNull('submenu_id')
            ->get();

        $submenu_array = [];
        foreach ($data as $dataitem_menu) {
            $submenu = menu_relation::where('menu_id', '=', $dataitem_menu->menu_id)
                ->where('position_id', '=', $request->input('pos_id'))
                ->whereNotNull('submenu_id')
                ->get();

            $submenu_array[] = $dataitem_menu->toArray();
            foreach($submenu as $dataitem_submenu) {
                $submenu_array[] = $dataitem_submenu->toArray();
            }
        }

        // dd($submenu_array);
        return response()->json(['submenu_array' => $submenu_array]);
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
        // dd($request);
        $menu_state = $request->input('state');
        if($request->submenuId > 0) {
            $menu_relation = menu_relation::updateOrCreate(['position_id' => $request->pos_id, 'menu_id' => $request->menu_id, 'submenu_id' => $request->submenuId], [
                $request->action => $menu_state,
            ]);
        } else {
            $menu_relation = menu_relation::updateOrCreate(['position_id' => $request->pos_id, 'menu_id' => $request->menu_id], [
                $request->action => $menu_state,
            ]);
        }

        return response()->json(['menu' => $menu_relation]);
    }
    public function deleteAccess(Request $request)
    {
        // dd($request);
        $menu_state = $request->input('state');

        if ($request->submenuId > 0) {
            if ($request->action == "view") {
                $delete = menu_relation::where('position_id', $request->input('pos_id'))
                    ->where('menu_id', $request->input('menu_id'))
                    ->where('submenu_id', $request->submenuId)
                    ->whereNotNull('submenu_id')
                    ->delete();
            } else {
                $delete = menu_relation::where('position_id', $request->input('pos_id'))
                    ->where('menu_id', $request->input('menu_id'))
                    ->where('submenu_id', $request->submenuId)
                    ->whereNotNull('submenu_id')
                    ->update([
                        $request->action => $menu_state
                    ]);
            }
        } else if ($request->action == "view") {
                $delete = menu_relation::where('position_id', $request->input('pos_id'))
                    ->where('menu_id', $request->input('menu_id'))
                    ->delete();
        } else {
            $delete = menu_relation::where('position_id', $request->input('pos_id'))
                ->where('menu_id', $request->input('menu_id'))
                ->update([
                    $request->action => $menu_state
                ]);
        }

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
        // dd($request);
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'menu_name' => 'required',
                'menu_url' => 'required',
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

            if (!is_null($request->inputs_submenu[0]['submenu_name'])) {
                $createMenuRelation  = menu_relation::create([
                    'position_id' => Auth::user()->id,
                    'menu_id' => $createMenu->id,
                    'status' => 1,
                ]);
                $x = 1;
                foreach ($request->inputs_submenu as $key => $value) {
                    $createSubmenu = submenu::create([
                        // 'menu_relation_id' => $createMenuRelation->id,
                        'menu_id' => $createMenu->id,
                        'name' => $value['submenu_name'],
                        'url' => $value['submenu_url'],
                        'seq' => $x,
                        'status' => 1,
                    ]);
                    ++$x;
                    $createSubMenuRelation = menu_relation::create([
                        'position_id' => Auth::user()->id,
                        'menu_id' => $createMenu->id,
                        'submenu_id' => $createSubmenu->id,
                        'status' => 1,
                    ]);
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
