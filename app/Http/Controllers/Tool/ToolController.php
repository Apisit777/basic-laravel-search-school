<?php

namespace App\Http\Controllers\Tool;

use App\Models\Tool;
use App\Models\ProductGroup;
use App\Models\Solution;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tool.index');
    }

    public function solution()
    {
        $data = Solution::all();
        return view('tool.solution.index', compact('data'));
    }

    public function series()
    {
        return view('tool.series.index');
    }

    public function category()
    {
        return view('tool.category.index');
    }

    public function subCategory()
    {
        return view('tool.sub_category.index');
    }

    public function productGroup()
    {
        $data = ProductGroup::all();
        // dd($data);
        return view('tool.product_group.index', compact('data'));
    }

    public function solutionCheckId(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductGroup_ID) {
            $data = Solution::select('ID')
                ->where('ID', '!=', $request->Edit_ProductGroup_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = Solution::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        // dd($data);
        return response()->json($data > 0 ? false : true);
    }

    public function solutionCheckName(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductGroup_ID) {
            $data = Solution::select('ID')
                ->where('ID', '!=', $request->Edit_ProductGroup_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = Solution::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }
        // dd($data);
        return response()->json($data > 0 ? false : true);
    }
    public function productGroupCheckId(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductGroup_ID) {
            $data = ProductGroup::select('ID')
                ->where('ID', '!=', $request->Edit_ProductGroup_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = ProductGroup::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        // dd($data);
        return response()->json($data > 0 ? false : true);
    }

    public function productGroupCheckName(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductGroup_ID) {
            $data = ProductGroup::select('ID')
                ->where('ID', '!=', $request->Edit_ProductGroup_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = ProductGroup::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }
        // dd($data);
        return response()->json($data > 0 ? false : true);
    }

    public function solutionCreateOrUpdate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $userpermission = Auth::user()->getUserPermission->name_position;
            if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
                $userpermission = 'OP';
            } else if (in_array($userpermission, ['Marketing - CPS'])) {
                $userpermission = 'CPS';
            }

            $dataSolution = Solution::updateOrCreate(['ID' => $request->ID], [
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'updated_at' => date("Y/m/d H:i:s")
            ]);

            // dd($dataProductGroup);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }
    public function productGroupCreateOrUpdate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $userpermission = Auth::user()->getUserPermission->name_position;
            if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
                $userpermission = 'OP';
            } else if (in_array($userpermission, ['Marketing - CPS'])) {
                $userpermission = 'CPS';
            }

            // dd([
            //     'User Permission' => $userpermission,
            //     'Request' => $request->all(),
            // ]);
            $dataProductGroup = ProductGroup::updateOrCreate(['ID' => $request->ID], [
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'updated_at' => date("Y/m/d H:i:s")
            ]);

            // dd($dataProductGroup);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function listSolution(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $GRP_P = $request->input('brand_id');
        $DOC_NO = $request->search;
        $field_detail = [
            'product1s.PRODUCT',
        ];

        $data = Solution::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'updated_at'
        )
        ->orderBy('DESCRIPTION', 'ASC');

        $userpermission = Auth::user()->getUserPermission->name_position;
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        if (in_array($userpermission, [$isSuperAdmin, 'Admin'])) {
                $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'updated_at'
            )
            ->orderBy('DESCRIPTION', 'ASC');
        } else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'updated_at'
            )
            ->where('BRAND', 'OP')
            ->orderBy('DESCRIPTION', 'ASC');

        } else if (in_array($userpermission, ['Marketing - CPS'])) {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'updated_at'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if (in_array($userpermission, ['Procurement - KTY'])) {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'updated_at'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }

        if ($GRP_P != null) {
            $data->where('product1s.GRP_P', $GRP_P);
        }

        if (null != $DOC_NO) {
            $data = $data->where(function ($data) use ($DOC_NO, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$DOC_NO.'%');
                }
            });
        }

        // dd($data->toSql());
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
    public function listProductGroup(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $GRP_P = $request->input('brand_id');
        $DOC_NO = $request->search;
        $field_detail = [
            'product1s.PRODUCT',
        ];

        $data = ProductGroup::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'updated_at'
        )
        ->orderBy('DESCRIPTION', 'ASC');

        $userpermission = Auth::user()->getUserPermission->name_position;
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        if (in_array($userpermission, [$isSuperAdmin, 'Admin'])) {
                $data = ProductGroup::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'updated_at'
            )
            ->orderBy('DESCRIPTION', 'ASC');
        } else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $data = ProductGroup::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'updated_at'
            )
            ->where('BRAND', 'OP')
            ->orderBy('DESCRIPTION', 'ASC');

        } else if (in_array($userpermission, ['Marketing - CPS'])) {
            $data = ProductGroup::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'updated_at'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if (in_array($userpermission, ['Procurement - KTY'])) {
            $data = ProductGroup::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'updated_at'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }

        if ($GRP_P != null) {
            $data->where('product1s.GRP_P', $GRP_P);
        }

        if (null != $DOC_NO) {
            $data = $data->where(function ($data) use ($DOC_NO, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$DOC_NO.'%');
                }
            });
        }

        // dd($data->toSql());
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

    public function supplier()
    {
        return view('tool.supplier.index');
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
    public function show(Tool $tool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tool $tool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tool $tool)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tool $tool)
    {
        //
    }
}
