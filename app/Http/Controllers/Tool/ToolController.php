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
use App\Models\ProductLine;
use App\Models\ProductType;
use App\Models\CpsSkinType;
use App\Models\CpsCoverageBenefit;
use App\Models\CpsUsageArea;
use App\Models\CpsTextureFormula;
use App\Models\CpsFinish;
use App\Models\CpsPackageType1;
use App\Models\CpsPackageType2;
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
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        $data = Solution::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        if ($userpermission == 'OP') {
            $idSolutions = Solution::select('ID')->where('BRAND', 'OP')->pluck('ID')->toArray();
        } else if ($userpermission == 'CPS') {
            $idSolutions = Solution::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();
        } else if ($userpermission == 'BB') {
            $idSolutions = Solution::select('ID')->where('BRAND', 'BB')->pluck('ID')->toArray();
        } else if ($userpermission == 'LL') {
            $idSolutions = Solution::select('ID')->where('BRAND', 'LL')->pluck('ID')->toArray();
        }

        return view('tool.solution.index', compact('data', 'idSolutions'));
    }

    public function series()
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        $data = Series::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        if ($userpermission == 'OP') {
            $idSeries = Series::select('ID')->where('BRAND', 'OP')->pluck('ID')->toArray();
        } else if ($userpermission == 'CPS') {
            $idSeries = Series::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();
        } else if ($userpermission == 'BB') {
            $idSeries = Series::select('ID')->where('BRAND', 'BB')->pluck('ID')->toArray();
        } else if ($userpermission == 'LL') {
            $idSeries = Series::select('ID')->where('BRAND', 'LL')->pluck('ID')->toArray();
        }

        return view('tool.series.index', compact('data', 'idSeries'));
    }

    public function category()
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        $data = Category::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        if ($userpermission == 'OP') {
            $idCategories = Category::select('ID')->where('BRAND', 'OP')->pluck('ID')->toArray();
        } else if ($userpermission == 'CPS') {
            $idCategories = Category::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();
        } else if ($userpermission == 'BB') {
            $idCategories = Category::select('ID')->where('BRAND', 'BB')->pluck('ID')->toArray();
        } else if ($userpermission == 'LL') {
            $idCategories = Category::select('ID')->where('BRAND', 'LL')->pluck('ID')->toArray();
        }

        return view('tool.category.index', compact('data', 'idCategories'));
    }

    public function dataCategories()
    {
        $dataCategories = Sub_category::select(
            'ID',
            'DESCRIPTION',
            'BRAND')
        ->where('BRAND', 'OP')
        ->orderby('ID', 'ASC')
        ->get();

        return response()->json($dataCategories);
    }

    public function subCategory()
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        $data = Sub_category::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        if ($userpermission == 'OP') {
            $dataCategories = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->orderby('ID', 'ASC')
            ->get();

            $SubCategories = Sub_category::select('ID')->where('BRAND', 'OP')->pluck('ID')->toArray();
        } else if ($userpermission == 'CPS') {
            $dataCategories = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->orderby('ID', 'ASC')
            ->get();

            $SubCategories = Sub_category::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();
        } else if ($userpermission == 'BB') {
            $userpermission = 'BB';
        } else if ($userpermission == 'LL') {
            $userpermission = 'LL';
        }

        // dd($SubCategories);
        return view('tool.sub_category.index', compact('data', 'dataCategories', 'SubCategories'));
    }

    public function productGroup()
    {
        $data = ProductGroup::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();
        // dd($data);
        return view('tool.product_group.index', compact('data'));
    }

    public function productCoOrdinator()
    {

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        if ($userpermission == 'OP') {
            $dataNpdCoss = Npd_cos::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
                ->where('BRAND', 'OP')
                ->pluck('DESCRIPTION')
                ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
                ->where('BRAND', 'OP')
                ->pluck('BRAND')
                ->toArray();
        } else if ($userpermission == 'CPS') {
            $dataNpdCoss = Npd_cos::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')
                ->where('BRAND', 'CPS')
                ->pluck('DESCRIPTION')
                ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
                ->where('BRAND', 'CPS')
                ->pluck('BRAND')
                ->toArray();
        }

        // dd($data);
        return view('tool.pd_co_ordinator.index', compact('dataNpdCoss', 'brands'));
    }

    public function marketingManager()
    {
        $data = Npd_pdms::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();
        // dd($data);
        return view('tool.marketing_manager.index', compact('data'));
    }

    public function manageProductLine()
    {
        $data = ProductLine::select('ID', 'CATEGORY_ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        $productLines = ProductLine::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();

        $dataCategories = Category::select(
            'ID',
            'DESCRIPTION',
            'BRAND')
        ->where('BRAND', 'CPS')
        ->orderby('ID', 'ASC')
        ->get();

        // dd($skinTypes);
        return view('tool.product_line.index', compact('data', 'productLines', 'dataCategories'));
    }

    public function manageProductType()
    {
        $data = ProductType::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        $productTypes = ProductType::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();

        $dataProductLines = ProductLine::select(
            'ID',
            'DESCRIPTION',
            'BRAND')
        ->where('BRAND', 'CPS')
        ->orderby('ID', 'ASC')
        ->get();

        // dd($skinTypes);
        return view('tool.product_type.index', compact('data', 'productTypes', 'dataProductLines'));
    }

    public function skinType()
    {
        $data = CpsSkinType::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        $skinTypes = CpsSkinType::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();

        // dd($skinTypes);
        return view('tool.skin_type.index', compact('data', 'skinTypes'));
    }

    public function CoverageBenefit()
    {
        $data = CpsCoverageBenefit::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        $coverageBenefits = CpsCoverageBenefit::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();

        // dd($skinTypes);
        return view('tool.coverage_benefit.index', compact('data', 'coverageBenefits'));
    }

    public function usageArea()
    {
        $data = CpsUsageArea::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        $usageAreas = CpsUsageArea::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();

        // dd($skinTypes);
        return view('tool.usage_area.index', compact('data', 'usageAreas'));
    }

    public function textureFormula()
    {
        $data = CpsTextureFormula::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        $textureFormulas = CpsTextureFormula::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();

        // dd($skinTypes);
        return view('tool.texture_formula.index', compact('data', 'textureFormulas'));
    }
    public function finish()
    {
        $data = CpsFinish::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        $finishs = CpsFinish::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();

        // dd($skinTypes);
        return view('tool.finish.index', compact('data', 'finishs'));
    }
    public function packageType1()
    {
        $data = CpsPackageType1::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        $packageType1s = CpsPackageType1::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();

        // dd($skinTypes);
        return view('tool.package_type1.index', compact('data', 'packageType1s'));
    }
    public function packageType2()
    {
        $data = CpsPackageType2::select('ID', 'DESCRIPTION', 'BRAND', 'EDIT_DT')->get();

        $packageType2s = CpsPackageType2::select('ID')->where('BRAND', 'CPS')->pluck('ID')->toArray();

        // dd($skinTypes);
        return view('tool.package_type2.index', compact('data', 'packageType2s'));
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

    public function subCategoryCheckId(Request $request)
    {
        // dd($request);
        if ($request->Edit_SubCategory_ID) {
            $data = Sub_category::select('ID')
                ->where('ID', '!=', $request->Edit_SubCategory_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = Sub_category::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }

    public function subCategoryCheckName(Request $request)
    {
        // dd($request);
        if ($request->Edit_SubCategory_ID) {
            $data = Sub_category::select('ID')
                ->where('ID', '!=', $request->SubCategory_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = Sub_category::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
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

    public function productLineCheckId(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductLine_ID) {
            $data = ProductLine::select('ID')
                ->where('ID', '!=', $request->Edit_ProductLine_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = ProductLine::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }

    public function productLineCheckName(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductLine_ID) {
            $data = ProductLine::select('ID')
                ->where('ID', '!=', $request->Edit_ProductLine_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = ProductLine::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }

        return response()->json($data > 0 ? false : true);
    }

    public function productTypeCheckId(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductType_ID) {
            $data = ProductType::select('ID')
                ->where('ID', '!=', $request->Edit_ProductType_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = ProductType::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }

    public function productTypeCheckName(Request $request)
    {
        // dd($request);
        if ($request->Edit_ProductType_ID) {
            $data = ProductType::select('ID')
                ->where('ID', '!=', $request->Edit_ProductType_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = ProductType::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }

        return response()->json($data > 0 ? false : true);
    }

    public function skinTypeCheckId(Request $request)
    {
        // dd($request);
        if ($request->Edit_SkinType_ID) {
            $data = CpsSkinType::select('ID')
                ->where('ID', '!=', $request->Edit_SkinType_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = CpsSkinType::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }

    public function skinTypeCheckName(Request $request)
    {
        // dd($request);
        if ($request->Edit_SkinType_ID) {
            $data = CpsSkinType::select('ID')
                ->where('ID', '!=', $request->Edit_SkinType_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = CpsSkinType::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }

        return response()->json($data > 0 ? false : true);
    }

    public function CoverageBenefitId(Request $request)
    {
        // dd($request);
        if ($request->Edit_CoverageBenefit_ID) {
            $data = CpsCoverageBenefit::select('ID')
                ->where('ID', '!=', $request->Edit_CoverageBenefit_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = CpsCoverageBenefit::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }

    public function CoverageBenefitName(Request $request)
    {
        // dd($request);
        if ($request->Edit_CoverageBenefit_ID) {
            $data = CpsCoverageBenefit::select('ID')
                ->where('ID', '!=', $request->Edit_CoverageBenefit_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = CpsCoverageBenefit::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }

        return response()->json($data > 0 ? false : true);
    }

    public function usageAreaId(Request $request)
    {
        // dd($request);
        if ($request->Edit_UsageArea_ID) {
            $data = CpsUsageArea::select('ID')
                ->where('ID', '!=', $request->Edit_UsageArea_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = CpsUsageArea::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }

    public function usageAreaName(Request $request)
    {
        // dd($request);
        if ($request->Edit_UsageArea_ID) {
            $data = CpsUsageArea::select('ID')
                ->where('ID', '!=', $request->Edit_UsageArea_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = CpsUsageArea::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }

        return response()->json($data > 0 ? false : true);
    }

    public function textureFormulaId(Request $request)
    {
        // dd($request);
        if ($request->Edit_Texture_Formula_ID) {
            $data = CpsTextureFormula::select('ID')
                ->where('ID', '!=', $request->Edit_Texture_Formula_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = CpsTextureFormula::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }

    public function textureFormulaName(Request $request)
    {
        // dd($request);
        if ($request->Edit_Texture_Formula_ID) {
            $data = CpsTextureFormula::select('ID')
                ->where('ID', '!=', $request->Edit_Texture_Formula_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = CpsTextureFormula::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }

        return response()->json($data > 0 ? false : true);
    }

    public function finishId(Request $request)
    {
        // dd($request);
        if ($request->Edit_Finish_ID) {
            $data = CpsFinish::select('ID')
                ->where('ID', '!=', $request->Edit_Finish_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = CpsFinish::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }

    public function finishName(Request $request)
    {
        // dd($request);
        if ($request->Edit_Finish_ID) {
            $data = CpsFinish::select('ID')
                ->where('ID', '!=', $request->Edit_Finish_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = CpsFinish::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }

        return response()->json($data > 0 ? false : true);
    }

    public function packageType1Id(Request $request)
    {
        // dd($request);
        if ($request->Edit_PackageType1_ID) {
            $data = CpsPackageType1::select('ID')
                ->where('ID', '!=', $request->Edit_PackageType1_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = CpsPackageType1::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }

    public function packageType1Name(Request $request)
    {
        // dd($request);
        if ($request->Edit_PackageType1_ID) {
            $data = CpsPackageType1::select('ID')
                ->where('ID', '!=', $request->Edit_PackageType1_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = CpsPackageType1::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }

        return response()->json($data > 0 ? false : true);
    }

    public function packageType2Id(Request $request)
    {
        // dd($request);
        if ($request->Edit_PackageType2_ID) {
            $data = CpsPackageType2::select('ID')
                ->where('ID', '!=', $request->Edit_PackageType2_ID)
                ->where('ID', $request->ID)
                ->count();
        } else {
            $data = CpsPackageType2::select('ID')
                ->where('ID', $request->ID)
                ->count();
        }
        return response()->json($data > 0 ? false : true);
    }

    public function packageType2Name(Request $request)
    {
        // dd($request);
        if ($request->Edit_PackageType2_ID) {
            $data = CpsPackageType2::select('ID')
                ->where('ID', '!=', $request->Edit_PackageType2_ID)
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        } else {
            $data = CpsPackageType2::select('ID')
                ->where('DESCRIPTION', $request->DESCRIPTION)
                ->count();
        }

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
                'EDIT_DT' => date("Y/m/d H:i:s")
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
                'EDIT_DT' => date("Y/m/d H:i:s")
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

    public function productLineCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $dataProductLine = ProductLine::create([
                'ID' => $request->SubCategory_ID,
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ]);

            // dd($dataProductLine);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function productLineUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $data_product_line = [
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_product_line_upddate = ProductLine::where('ID', $id)->update($data_product_line);

            // dd($data_sub_category_upddate);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function productTypeCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $dataProductType = ProductType::create([
                'ID' => $request->SubCategory_ID,
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ]);

            // dd($dataProductType);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function productTypeUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $data_product_type = [
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_product_type_upddate = ProductType::where('ID', $id)->update($data_product_type);

            // dd($data_product_type_upddate);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function skinTypeCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $dataCpsSkinType = CpsSkinType::create([
                'ID' => $request->SubCategory_ID,
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ]);

            // dd($dataCpsSkinType);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function skinTypeUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $data_skin_type = [
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_skin_type_upddate = CpsSkinType::where('ID', $id)->update($data_skin_type);

            // dd($data_skin_type_upddate);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function CoverageBenefitCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $dataCoverageBenefit = CpsCoverageBenefit::create([
                'ID' => $request->SubCategory_ID,
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ]);

            // dd($dataCoverageBenefit);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function usageAreaCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $dataCpsUsageArea = CpsUsageArea::create([
                'ID' => $request->SubCategory_ID,
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ]);

            // dd($dataCpsUsageArea);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function usageAreaUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $data_usage_area = [
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_usage_area_upddate = CpsUsageArea::where('ID', $id)->update($data_usage_area);

            // dd($data_usage_area_upddate);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function textureFormulaCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $dataCpsTextureFormula = CpsTextureFormula::create([
                'ID' => $request->SubCategory_ID,
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ]);

            // dd($dataCpsTextureFormula);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function textureFormulaUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $data_texture_formula = [
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_texture_formula_upddate = CpsTextureFormula::where('ID', $id)->update($data_texture_formula);

            // dd($data_texture_formula_upddate);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function finishCreate(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $dataFinish = CpsFinish::create([
                'ID' => $request->SubCategory_ID,
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ]);

            // dd($dataFinish);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function finishUpdate(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $data_finish = [
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_finish_upddate = CpsFinish::where('ID', $id)->update($data_finish);

            // dd($data_finish_upddate);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }
    public function packageType1Create(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $dataPackageType1 = CpsPackageType1::create([
                'ID' => $request->SubCategory_ID,
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ]);

            // dd($dataPackageType1);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function packageType1Update(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $data_package_type1 = [
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_package_type1_upddate = CpsPackageType1::where('ID', $id)->update($data_package_type1);

            // dd($data_package_type1_upddate);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function packageType2Create(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $dataPackageType2 = CpsPackageType2::create([
                'ID' => $request->SubCategory_ID,
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ]);

            // dd($dataPackageType2);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function packageType2Update(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
            $userpermission = Auth::user()->getUserPermission->name_position;
            $namePosition  = explode('-', $userpermission);
            $userpermission = trim(end($namePosition));

            if ($userpermission == 'CPS') {
                $userpermission = 'CPS';
            }

            $data_package_type2 = [
                'CATEGORY_ID' => $request->CATEGORY_ID,
                'DESCRIPTION' => $request->DESCRIPTION,
                'BRAND' => $userpermission,
                'EDIT_DT' => ''
            ];

            $data_package_type2_upddate = CpsPackageType2::where('ID', $id)->update($data_package_type2);

            // dd($data_package_type2_upddate);
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
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $searchSolutionNameAll = $request->input('searchSolutiontName', '');

        $data = Solution::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        // ->join('product1s', 'solutions.ID', '=', 'product1s.SOLUTION')
        ->orderBy('DESCRIPTION', 'ASC');

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        if ($userpermission == $isSuperAdmin) {
                $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND'
            )
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'OP') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'solutions.BRAND AS BRAND'
            )
            // ->join('product1s', 'solutions.ID', '=', 'product1s.SOLUTION')
            ->where('solutions.BRAND', 'OP')
            ->orderBy('DESCRIPTION', 'ASC');

        } else if ($userpermission == 'CPS') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'KTY') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }  else if ($userpermission == 'GNC') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND'
            )
            ->where('BRAND', 'KTY')
            ->orderBy('DESCRIPTION', 'ASC');
        }
        else if ($userpermission == 'BB') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND'
            )
            ->where('BRAND', 'BB')
            ->orderBy('DESCRIPTION', 'ASC');
        } else if ($userpermission == 'LL') {
            $data = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND'
            )
            ->where('BRAND', 'LL')
            ->orderBy('DESCRIPTION', 'ASC');
        }

        if ($request->searchSolutionId) {
            $data = $data->where('solutions.ID', $request->searchSolutionId);
        }

        if (!empty($searchSolutionNameAll)) {
            $data->where(function ($q) use ($searchSolutionNameAll) {
                $q->orWhere('solutions.DESCRIPTION', 'like', '%' . $searchSolutionNameAll . '%');
            });
        }

        // dd($data->toSql());
        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        if ($limit > 0) {
             $data->limit($limit)->offset($start);
        }
        $records = $data->get();

        return response()->json([
             'draw' => intval($request->draw),
             'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
             'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
             'aaData' => $records,
        ]);
    }

    public function listSeries(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $searchSeriesNameAll = $request->input('searchSeriesName', '');

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

        if ($request->searchSeriesId) {
            $data = $data->where('series.ID', $request->searchSeriesId);
        }

        if (!empty($searchSeriesNameAll)) {
            $data->where(function ($q) use ($searchSeriesNameAll) {
                $q->orWhere('series.DESCRIPTION', 'like', '%' . $searchSeriesNameAll . '%');
            });
        }

        // dd($data->toSql());
        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        if ($limit > 0) {
             $data->limit($limit)->offset($start);
        }
        $records = $data->get();

        return response()->json([
             'draw' => intval($request->draw),
             'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
             'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
             'aaData' => $records,
        ]);
    }

    public function listCategory(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $searchCategoryNameAll = $request->input('searchCategoryName', '');

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

        if ($request->searchCategoryId) {
            $data = $data->where('categories.ID', $request->searchCategoryId);
        }

        if (!empty($searchCategoryNameAll)) {
            $data->where(function ($q) use ($searchCategoryNameAll) {
                $q->orWhere('categories.DESCRIPTION', 'like', '%' . $searchCategoryNameAll . '%');
            });
        }

        // dd($data->toSql());
        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        if ($limit > 0) {
             $data->limit($limit)->offset($start);
        }
        $records = $data->get();

        return response()->json([
             'draw' => intval($request->draw),
             'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
             'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
             'aaData' => $records,
        ]);
    }

    public function listSubCategory(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $searchSubCategoryNameAll = $request->input('searchSubCategoryName', '');

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

        if ($request->searchSubCategoryId) {
            $data = $data->where('sub_categories.ID', $request->searchSubCategoryId);
        }

        if (!empty($searchSubCategoryNameAll)) {
            $data->where(function ($q) use ($searchSubCategoryNameAll) {
                $q->orWhere('sub_categories.DESCRIPTION', 'like', '%' . $searchSubCategoryNameAll . '%');
            });
        }

        // dd($data->toSql());
        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        if ($limit > 0) {
             $data->limit($limit)->offset($start);
        }
        $records = $data->get();

        return response()->json([
             'draw' => intval($request->draw),
             'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
             'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
             'aaData' => $records,
        ]);
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
            ->whereIn('BRAND', ['OP'])
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

    public function listProductLine(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $searchProductLineNameAll = $request->input('searchProductLineName', '');

        $data = ProductLine::select(
            'ID',
            'CATEGORY_ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('ID', 'ASC');

        if ($request->searchProductLineId) {
            $data = $data->where('product_lines.ID', $request->searchProductLineId);
        }

        if (!empty($searchProductLineNameAll)) {
            $data->where(function ($q) use ($searchProductLineNameAll) {
                $q->orWhere('product_lines.DESCRIPTION', 'like', '%' . $searchProductLineNameAll . '%');
            });
        }

        // dd($data->toSql());
        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        if ($limit > 0) {
             $data->limit($limit)->offset($start);
        }
        $records = $data->get();

        return response()->json([
             'draw' => intval($request->draw),
             'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
             'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
             'aaData' => $records,
        ]);
    }

    public function listProductType(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $searchProductTypeNameAll = $request->input('searchProductTypeName', '');

        $data = ProductType::select(
            'ID',
            'PRODUCT_LINE_ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('ID', 'ASC');

        if ($request->searchProductTypeId) {
            $data = $data->where('product_types.ID', $request->searchProductTypeId);
        }

        if (!empty($searchProductTypeNameAll)) {
            $data->where(function ($q) use ($searchProductTypeNameAll) {
                $q->orWhere('product_types.DESCRIPTION', 'like', '%' . $searchProductTypeNameAll . '%');
            });
        }

        // dd($data->toSql());
        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        if ($limit > 0) {
             $data->limit($limit)->offset($start);
        }
        $records = $data->get();

        return response()->json([
             'draw' => intval($request->draw),
             'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
             'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
             'aaData' => $records,
        ]);
    }

    public function listSkinType(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $searchSkinTypeNameAll = $request->input('searchSkinTypeName', '');

        $data = CpsSkinType::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('ID', 'ASC');

        if ($request->searchSkinTypeId) {
            $data = $data->where('cps_skin_types.ID', $request->searchSkinTypeId);
        }

        if (!empty($searchSkinTypeNameAll)) {
            $data->where(function ($q) use ($searchSkinTypeNameAll) {
                $q->orWhere('cps_skin_types.DESCRIPTION', 'like', '%' . $searchSkinTypeNameAll . '%');
            });
        }

        // dd($data->toSql());
        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        if ($limit > 0) {
             $data->limit($limit)->offset($start);
        }
        $records = $data->get();

        return response()->json([
             'draw' => intval($request->draw),
             'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
             'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
             'aaData' => $records,
        ]);
    }

    public function listCoverageBenefit(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = CpsCoverageBenefit::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('ID', 'ASC');

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

    public function listUsageArea(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = CpsUsageArea::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('ID', 'ASC');

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

    public function listTextureFormula(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = CpsTextureFormula::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('ID', 'ASC');

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

    public function listFinish(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = CpsFinish::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('ID', 'ASC');

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

    public function listPackageType1(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = CpsPackageType1::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('ID', 'ASC');

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

    public function listPackageType2(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = CpsPackageType2::select(
            'ID',
            'DESCRIPTION',
            'BRAND',
            'EDIT_DT'
        )
        ->orderBy('ID', 'ASC');

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
