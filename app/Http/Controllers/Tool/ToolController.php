<?php

namespace App\Http\Controllers\Tool;

use App\Models\Tool;
use App\Models\ProductGroup;
use App\Models\Solution;
use App\Models\Series;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Npd_cos;
use App\Models\Npd_pdms;
use App\Models\MasterBrand;
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
        $data = Solution::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();
        return view('tool.solution.index', compact('data'));
    }

    public function series()
    {
        $data = Series::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();
        return view('tool.series.index', compact('data'));
    }

    public function category()
    {
        $data = Category::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();
        return view('tool.category.index', compact('data'));
    }

    public function subCategory()
    {
        $data = Sub_category::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        if ($userpermission == 'OP') {
            $dataCategories = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->orderby('ID', 'ASC')
            ->get();
        } else if ($userpermission == 'CPS') {
            $dataCategories = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->orderby('ID', 'ASC')
            ->get();
        } else if ($userpermission == 'KTY') {
            $userpermission = 'KTY';
        } else if ($userpermission == 'GNC') {
            $userpermission = 'GNC';
        } else if ($userpermission == 'BB') {
            $userpermission = 'BB';
        } else if ($userpermission == 'LL') {
            $userpermission = 'LL';
        }

        // dd($dataCategories);
        return view('tool.sub_category.index', compact('data', 'dataCategories'));
    }

    public function productGroup()
    {
        $data = ProductGroup::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();
        // dd($data);
        return view('tool.product_group.index', compact('data'));
    }

    public function productCoOrdinator()
    {
        $dataNpdCoss = Npd_cos::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
            ->whereIn('BRAND', ['OP', 'BB'])
            ->pluck('DESCRIPTION')
            ->toArray();

        $brands = MasterBrand::select(
            'BRAND')
            ->whereIn('BRAND', ['OP', 'BB'])
            ->pluck('BRAND')
            ->toArray();

        // dd($data);
        return view('tool.pd_co_ordinator.index', compact('dataNpdCoss', 'brands'));
    }

    public function marketingManager()
    {
        $data = Npd_pdms::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();
        // dd($data);
        return view('tool.marketing_manager.index', compact('data'));
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
    
    public function seriesCheckId(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductGroup_ID) {
            $data = Series::select('ID')
                ->where('ID', '!=', $request->Edit_ProductGroup_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = Series::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        // dd($data);
        return response()->json($data > 0 ? false : true);
    }

    public function seriesCheckName(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductGroup_ID) {
            $data = Series::select('ID')
                ->where('ID', '!=', $request->Edit_ProductGroup_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = Series::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }
        // dd($data);
        return response()->json($data > 0 ? false : true);
    }
    public function categoryCheckId(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductGroup_ID) {
            $data = Category::select('ID')
                ->where('ID', '!=', $request->Edit_ProductGroup_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = Category::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        // dd($data);
        return response()->json($data > 0 ? false : true);
    }

    public function categoryCheckName(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductGroup_ID) {
            $data = Category::select('ID')
                ->where('ID', '!=', $request->Edit_ProductGroup_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = Category::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }
        // dd($data);
        return response()->json($data > 0 ? false : true);
    }

    public function subCategoryCheckName(Request $request)
    {
        // dd($request);
        if ($request->SubCategory_ID) {
            $data = Sub_category::select('ID')
                ->where('ID', '!=', $request->SubCategory_ID)
                ->where('CATEGORY_ID',  $request->ID_Category)
                ->where($request->key, $request->data)
                ->count();
        } else {
            $data = Sub_category::select('ID')
                ->where('CATEGORY_ID',  $request->ID_Category)
                ->where($request->key, $request->data)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }


    public function manageSubCategory(Request $request)
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        if ($userpermission == 'OP') {
            $dataSubCategories = Sub_category::select(
                'categories.ID AS ID_CATEGORY',
                'categories.DESCRIPTION AS NAME_CATEGORY',
                'sub_categories.BRAND AS BRAND')
            ->where('sub_categories.BRAND', 'OP')
            ->orderby('ID', 'ASC')
            ->get();
        } else if ($userpermission == 'CPS') {
            $userpermission = 'CPS';
        } else if ($userpermission == 'KTY') {
            $userpermission = 'KTY';
        } else if ($userpermission == 'GNC') {
            $userpermission = 'GNC';
        } else if ($userpermission == 'BB') {
            $userpermission = 'BB';
        } else if ($userpermission == 'LL') {
            $userpermission = 'LL';
        }

        // $dataSubCategories = Sub_category::select(
        //     'categories.ID AS ID_CATEGORY',
        //     'categories.DESCRIPTION AS NAME_CATEGORY',
        //     'sub_categories.BRAND AS BRAND',)
        // ->orderby('ID', 'ASC')
        // ->get();

        dd($dataSubCategories);
        return view('tool.sub_category.index', compact('dataSubCategories'));
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

    public function productCoOrdinatorCheckName(Request $request)
    {
        // dd($request);
        if ($request->Edit_Product_Co_Ordinator_ID) {
            $data = Npd_cos::select('ID')
                ->where('ID', '!=', $request->Edit_Product_Co_Ordinator_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = Npd_cos::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }
        // dd($data);
        return response()->json($data > 0 ? false : true);
    }

    public function solutionCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $dataSolution = Solution::create([
                'ID' => $request->ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
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
    public function solutionUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $data_solution = [
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_solution_upddate = Solution::where('ID', $id)->update($data_solution);

            // dd($dataProductGroup);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function seriesCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $dataSeries = Series::create([
                'ID' => $request->ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
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
    
    public function seriesUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $data_series = [
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_series_upddate = Series::where('ID', $id)->update($data_series);

            // dd($dataProductGroup);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }
    public function categoryCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $dataCategory = Category::create([
                'ID' => $request->ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
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

    public function categoryUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $data_category = [
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_category_upddate = Category::where('ID', $id)->update($data_category);

            // dd($data_category_upddate);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function subCategoryCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $dataSubCategory = Sub_category::create([
                'ID' => $request->SubCategory_ID,
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ]);

            // dd($dataSubCategory);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function subCategoryUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $data_sub_category = [
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_sub_category_upddate = Sub_category::where('ID', $id)->update($data_sub_category);

            // dd($data_sub_category_upddate);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function productGroupCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }
            
            $dataProductGroup = ProductGroup::create([
                'ID' => $request->ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
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
    public function productGroupUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $data_product_group = [
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_product_group_upddate = ProductGroup::where('ID', $id)->update($data_product_group);

            // dd($dataProductGroup);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function productCoOrdinatorCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $dataNpdCos = Npd_cos::create([
                'ID' => $request->ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ]);

            // dd($dataNpdCos); 
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function productCoOrdinatorUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'OP') {
                $userpermission = 'OP';
            } else if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            } else if ($userpermission == 'KTY') {
                $userpermission = 'KTY';
            } else if ($userpermission == 'GNC') {
                $userpermission = 'GNC';
            } else if ($userpermission == 'BB') {
                $userpermission = 'BB';
            } else if ($userpermission == 'LL') {
                $userpermission = 'LL';
            }

            $productCoOrdinator = [
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $productCoOrdinatorUpddate = Npd_cos::where('ID', $id)->update($productCoOrdinator);

            // dd($dataNpdCos); 
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
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        if ($userpermission == $isSuperAdmin) {
                $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'OP') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'OP')
            ->orderBy('DESCRIPTION', 'ASC');

        } else if ($userpermission == 'CPS') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'KTY') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }  else if ($userpermission == 'GNC') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        } 
        else if ($userpermission == 'BB') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'BB')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'LL') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'LL')
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

    public function listSeries(Request $request)
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

        $data = Series::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        if ($userpermission == $isSuperAdmin) {
            $data = Series::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'OP') {
            $data = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'OP')
            ->orderBy('DESCRIPTION', 'ASC');

        } else if ($userpermission == 'CPS') {
            $data = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'KTY') {
            $data = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }  else if ($userpermission == 'GNC') {
            $data = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'GNC')
            ->orderBy('DESCRIPTION', 'ASC');
        } 
        else if ($userpermission == 'BB') {
            $data = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'BB')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'LL') {
            $data = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'LL')
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

    public function listCategory(Request $request)
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

        $data = Category::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        
        if ($userpermission == $isSuperAdmin) {
            $data = Category::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'OP') {
            $data = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'OP')
            ->orderBy('DESCRIPTION', 'ASC');

        } else if ($userpermission == 'CPS') {
            $data = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'KTY') {
            $data = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }  else if ($userpermission == 'GNC') {
            $data = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'GNC')
            ->orderBy('DESCRIPTION', 'ASC');
        } 
        else if ($userpermission == 'BB') {
            $data = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'BB')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'LL') {
            $data = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'LL')
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

    public function listSubCategory(Request $request)
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

        $data = Sub_category::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        
        if ($userpermission == $isSuperAdmin) {
            $data = Sub_category::select(
            'ID',
            'CATEGORY_ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'OP') {
            $data = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'OP')
            ->orderBy('DESCRIPTION', 'ASC');

        } else if ($userpermission == 'CPS') {
            $data = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'KTY') {
            $data = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }  else if ($userpermission == 'GNC') {
            $data = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'GNC')
            ->orderBy('DESCRIPTION', 'ASC');
        } 
        else if ($userpermission == 'BB') {
            $data = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'BB')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'LL') {
            $data = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'LL')
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
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        
        if ($userpermission == $isSuperAdmin) {
            $data = ProductGroup::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'OP') {
            $data = ProductGroup::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'OP')
            ->orderBy('DESCRIPTION', 'ASC');

        } else if ($userpermission == 'CPS') {
            $data = ProductGroup::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'KTY') {
            $data = ProductGroup::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }  else if ($userpermission == 'GNC') {
            $data = ProductGroup::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'GNC')
            ->orderBy('DESCRIPTION', 'ASC');
        } 
        else if ($userpermission == 'BB') {
            $data = ProductGroup::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'BB')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'LL') {
            $data = ProductGroup::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'LL')
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

    public function listProductCoOrdinator(Request $request)
    {
        // dd($request);
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $GRP_P = $request->input('brand_id');
        $DOC_NO = $request->search;
        $field_detail = [
            'product1s.PRODUCT',
        ];

        $data = Npd_cos::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        
        if ($userpermission == $isSuperAdmin) {
            $data = Npd_cos::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'OP') {
            $data = Npd_cos::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->whereIn('BRAND', ['OP', 'BB'])
            ->orderBy('DESCRIPTION', 'ASC');

        } else if ($userpermission == 'CPS') {
            $data = Npd_cos::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('ID', 'ASC');
        } else if ($userpermission == 'KTY') {
            $data = Npd_cos::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }  else if ($userpermission == 'GNC') {
            $data = Npd_cos::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'GNC')
            ->orderBy('DESCRIPTION', 'ASC');
        } 
        else if ($userpermission == 'BB') {
            $data = Npd_cos::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'BB')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'LL') {
            $data = Npd_cos::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'LL')
            ->orderBy('DESCRIPTION', 'ASC');
        }

        if ($request->BRAND) {
            $data = $data->where('npd_cos.BRAND', $request->BRAND);
        }

        if ($request->DESCRIPTION) {
            $data->where('npd_cos.DESCRIPTION', $request->DESCRIPTION);
        }

        if ($GRP_P != null) {
            $data->where('product1s.GRP_P', $GRP_P);
        }

        // if (null != $DOC_NO) {
        //     $data = $data->where(function ($data) use ($DOC_NO, $field_detail) {
        //         for ($i = 0; $i < count($field_detail); $i++) {
        //             $data->orWhere($field_detail[$i], 'like', '%'.$DOC_NO.'%');
        //         }
        //     });
        // }

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
    public function listMarketingManager(Request $request)
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

        $data = Npd_pdms::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        
        if ($userpermission == $isSuperAdmin) {
            $data = Npd_pdms::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'OP') {
            $data = Npd_pdms::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'OP')
            ->orderBy('ID', 'ASC');

        } else if ($userpermission == 'CPS') {
            $data = Npd_pdms::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('ID', 'ASC');
        } else if ($userpermission == 'KTY') {
            $data = Npd_pdms::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }  else if ($userpermission == 'GNC') {
            $data = Npd_pdms::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'GNC')
            ->orderBy('DESCRIPTION', 'ASC');
        } 
        else if ($userpermission == 'BB') {
            $data = Npd_pdms::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'BB')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'LL') {
            $data = Npd_pdms::select(
                'ID',
                'DESCRIPTION',
                'BRAND',
                'EDIT_DT'
            )
            ->where('BRAND', 'LL')
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
