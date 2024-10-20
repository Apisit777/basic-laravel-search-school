<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Models\position;
use App\Models\User;
use App\Models\Npd_cos;
use App\Models\Npd_pdms;
use App\Models\Npd_categorys;
use App\Models\Npd_textures;
use App\Models\Pro_develops;
use App\Models\Product1;
use App\Models\Barcode;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\Accessery;
use App\Models\Owner;
use App\Models\Type_g;
use App\Models\Solution;
use App\Models\Series;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Pdm;
use App\Models\P_status;
use App\Models\Grp_p;
use App\Models\Brand_p;
use App\Models\Vendor;
use App\Models\Unit_p;
use App\Models\Unit_type;
use App\Models\Acctype;
use App\Models\Condition;
use App\Models\MasterBrand;
use App\Models\SeleChannel;
use App\Models\ProductChannel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //     $data = Product1::select(
    // 'product1s.BRAND AS BRAND',
    //         'GRP_P',
    //         'product1s.PRODUCT AS PRODUCT',
    //         'BARCODE',
    //         'NAME_THAI'
    //     )
    //     ->leftJoin('product_channels', 'product1s.PRODUCT', '=', 'product_channels.PRODUCT')
    //     ->where('product_channels.BRAND', '=', 'KTY')
    //     ->get();

        // $datas = Product1::select('BRAND', 'GRP_P','PRODUCT', 'BARCODE', 'NAME_THAI',)->get();
        // foreach ($datas as $data) {
        //     $product_channel_array = [];

        //     $item_channel = ProductChannel::select('PRODUCT', 'BRAND')
        //         ->where('PRODUCT', '=', $data->PRODUCT)
        //         ->get();

        //     foreach ($item_channel as $dataitem_channel) {
        //         $product_channel_array[] = $dataitem_channel->BRAND;
        //     }

        //     $data->product_channel_array = $product_channel_array;
        // }
        // dd($datas);

        $data = Product1::all();
        $user = User::all();
        $product_seq = Product::select('seq')->get();
        $brands = Barcode::select('BRAND')->pluck('BRAND')->toArray();
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        // dd($userpermission);

        if (in_array($userpermission, [$isSuperAdmin, 'Admin'])) {
            $brands = Barcode::select(
            'BRAND')
            // ->whereNotIn('STATUS', ['ALL'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->pluck('PRODUCT')
            ->toArray();

            $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            $dataProductMaster = Pro_develops::select(
            'PRODUCT')
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->pluck('PRODUCT')
            ->toArray();

        } else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['OP', 'RI'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['CPS', 'KM', 'KTY'])
            ->pluck('PRODUCT')
            ->toArray();

            $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            $dataProductMaster = Pro_develops::select(
            'PRODUCT')
            ->whereIn('BRAND', ['OP', 'RI'])
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->where('BRAND', 'KM')
            ->where('GRP_P', 'OP')
            ->pluck('PRODUCT')
            ->toArray();

        } else if (in_array($userpermission, ['Marketing - CPS'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['CPS'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'KM', 'KTY'])
            ->pluck('PRODUCT')
            ->toArray();

            $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            $dataProductMaster = Pro_develops::select(
            'PRODUCT')
            ->whereIn('BRAND', ['CPS'])
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->where('BRAND', 'KM')
            ->where('GRP_P', 'CPS')
            ->pluck('PRODUCT')
            ->toArray();

        } else if (in_array($userpermission, ['Procurement - KTY'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['KTY'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM'])
            ->pluck('PRODUCT')
            ->toArray();

            $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            $dataProductMaster = Pro_develops::select(
            'PRODUCT')
            ->whereIn('BRAND', ['KTY'])
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->where('BRAND', 'KM')
            ->where('GRP_P', 'KTY')
            ->pluck('PRODUCT')
            ->toArray();

        }

        // dd($dataProductMaster);
        $productCodeArr = $dataProductMaster->select('PRODUCT')->pluck('PRODUCT')->toArray();
        $data_barcode = Pro_develops::select(
        'BARCODE')
        ->pluck('BARCODE')->toArray();

        return view('product.index', compact('user', 'product_seq', 'brands', 'productCodeArr', 'dataProductMasterArr', 'dataProductMasterConsumablesArr', 'data_barcode'));
    }

    public function getBarcode(Request $request)
    {
        $productCodes = Pro_develops::select(
            'BARCODE')
        ->where('PRODUCT', $request->input('BARCODE'))
        ->first();

        // dd($productCodes);
        return response()->json(['productCodes' => $productCodes]);
    }

    public function check_product(Request $request)
    {
        // dd($request);
        $data = Product1::select('PRODUCT')
            ->where('PRODUCT', $request->PRODUCT)
            ->count();

        return response()->json($data > 0 ? false : true);
    }

    public function check_product_consumables(Request $request)
    {
        // dd($request);
        $data = Product1::select('PRODUCT')
            ->where('PRODUCT', $request->PRODUCT_Consumables)
            ->count();

        return response()->json($data > 0 ? false : true);
    }

    public function productMasterGetBrandListAjax(Request $request)
    {
        $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();

        $productCodes = Pro_develops::select(
                // 'product1s.*',
                DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code')
            )
            ->where('BRAND', $request->input('BRAND'))
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->orderby('Code')
            ->get();

        $digits_barcode = $this->ean13_check_digit($request);
        // dd($productCodes);
        return response()->json(['productCodes' => $productCodes, 'digits_barcode' => $digits_barcode]);
    }

    private function ean13_check_digit()
    {
        $request = request();
            $lastElement = Pro_develops::max('BARCODE');
            if ($request->BRAND == 'OP') {
                $lastElement = Pro_develops::where('BRAND', '=', $request->BRAND)->where('STATUS', '=', 'OP')->max('BARCODE');
            }
            if ($request->BRAND == 'RI') {
                $lastElement = Pro_develops::where('BRAND', '=', $request->BRAND)->where('STATUS', '=', 'RI')->max('BARCODE');
            }
            if ($request->BRAND == 'CPS') {
                $lastElement = Pro_develops::where('BRAND', '=', $request->BRAND)->where('STATUS', '=', 'CPS')->max('BARCODE');
            }
            $barcodeMax = substr_replace($lastElement, '', -1);
            $barcodeNumber =  preg_replace('/[^0-9]/', '', $barcodeMax) + 1;
            $barcode = sprintf('%04d', $barcodeNumber);

            $digits =(string)$barcode;
            $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
            $even_sum_three = $even_sum * 3;
            $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
            $total_sum = $even_sum_three + $odd_sum;
            $next_ten = (ceil($total_sum/10))*10;
            $check_digit = $next_ten - $total_sum;

        return $digits . $check_digit;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // $digits_barcode = $this->ean13_check_digit();
        // $ = $this->productMasterGetBrandListAjax();

        // dd($accessery);

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;

        $owners = Owner::all();
        $grp_ps = Grp_p::all();

        $brand_ps = Brand_p::all();

        if (in_array($userpermission, [$isSuperAdmin])) {
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK')
            ->get();
        }
        else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();

            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
        }
        else if (in_array($userpermission, ['Marketing - CPS'])) {
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();

            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
        }

        $venders = Vendor::all();
        $type_gs = Type_g::all();
        $solutions = Solution::all();
        $series = Series::all();
        $categorys = Category::all();
        $sub_categorys = Sub_category::all();
        $pdms = Pdm::all();
        $p_statuss = P_status::all();
        $unit_ps = Unit_p::all();
        $unit_types = Unit_type::all();
        $acctypes = Acctype::all();
        $conditions = Condition::all();

        $productCodeMax = Product::max('seq');
        $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        $productCode = 'P'.sprintf('%05d', $productCodeNumber);

        $list_position = position::select('id', 'name_position')->get();

        // $brands = Barcode::select('BRAND')->pluck('BRAND')->toArray();
        // $allBrands = Accessery::select('BRAND')->whereIn('BRAND', ['OP', 'CPS', 'KU'])->pluck('BRAND')->toArray();
        $allBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();
        // $allBrands = Accessery::select('COMPANY')->get();
        $defaultBrands = MasterBrand::all();

        $brands = MasterBrand::all();

        if (in_array($userpermission, [$isSuperAdmin])) {
            // $defaultBrands = Accessery::select(
            //     'COMPANY',
            //     'DESCRIPTION')
            // ->get();

            $brands = MasterBrand::select(
                'BRAND')
            ->get();
        }
        else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->pluck('BRAND')
            ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
        } else if (in_array($userpermission, ['Marketing - CPS'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->pluck('BRAND')
            ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
        } else if (in_array($userpermission, ['Procurement - KTY'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KTY')
            ->pluck('BRAND')
            ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
        }
        // dd($allBrands);
        return view('product.create', compact('productCode', 'list_position', 'brands', 'allBrands', 'defaultBrands', 'owners', 'grp_ps', 'brand_ps', 'venders', 'type_gs', 'solutions', 'series', 'categorys', 'sub_categorys', 'pdms', 'p_statuss', 'unit_ps', 'unit_types', 'acctypes', 'conditions'));
    }

    public function createConsumables(Request $request)
    {
        // $digits_barcode = $this->ean13_check_digit();
        // $ = $this->productMasterGetBrandListAjax();

        // dd($accessery);

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;

        $owners = Owner::all();
        $grp_ps = Grp_p::all();

        $brand_ps = Brand_p::all();

        if (in_array($userpermission, [$isSuperAdmin])) {
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK')
            ->get();
        }
        else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK')
            ->where('BRAND', 'GNC')
            ->get();
        }
        else if (in_array($userpermission, ['Marketing - CPS'])) {
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK')
            ->where('BRAND', 'CPS')
            ->get();
        }

        $venders = Vendor::all();
        $type_gs = Type_g::all();
        $solutions = Solution::all();
        $series = Series::all();
        $categorys = Category::all();
        $sub_categorys = Sub_category::all();
        $pdms = Pdm::all();
        $p_statuss = P_status::all();
        $unit_ps = Unit_p::all();
        $unit_types = Unit_type::all();
        $acctypes = Acctype::all();
        $conditions = Condition::all();

        $productCodeMax = Product::max('seq');
        $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        $productCode = 'P'.sprintf('%05d', $productCodeNumber);

        $list_position = position::select('id', 'name_position')->get();

        // $brands = Barcode::select('BRAND')->pluck('BRAND')->toArray();
        // create brands consumables
        $allBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();
        // $allBrands = Accessery::select('COMPANY')->get();
        $defaultBrands = MasterBrand::all();

        $brands = MasterBrand::all();

        if (in_array($userpermission, [$isSuperAdmin])) {
            // $defaultBrands = Accessery::select(
            //     'COMPANY',
            //     'DESCRIPTION')
            // ->get();

            $brands = MasterBrand::select(
                'BRAND')
            ->get();
        }
        else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->pluck('BRAND')
            ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
        } else if (in_array($userpermission, ['Marketing - CPS'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->pluck('BRAND')
            ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
        } else if (in_array($userpermission, ['Procurement - KTY'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KTY')
            ->pluck('BRAND')
            ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
        }

        // dd($brands);
        return view('product.create_consumables', compact('productCode', 'list_position', 'brands', 'allBrands', 'defaultBrands', 'owners', 'grp_ps', 'brand_ps', 'venders', 'type_gs', 'solutions', 'series', 'categorys', 'sub_categorys', 'pdms', 'p_statuss', 'unit_ps', 'unit_types', 'acctypes', 'conditions'));
    }
    public function productDetailCreate(Request $request)
    {
        $productCodeMax = Product::max('seq');
        $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        $productCode = 'P'.sprintf('%05d', $productCodeNumber);

        $list_position = position::select('id', 'name_position')->get();
        // dd($productCode);
        return view('product_detail.create', compact('productCode', 'list_position'));
    }

    public function createCopyConsumables(Request $request)
    {
        // dd($request);
        // $dataProductBarcode = Pro_develops::select(
        //     'PRODUCT',
        //     'BARCODE',
        // )
        // ->firstWhere('PRODUCT', '=', $request->NUMBER);

        $data = Product1::select(
            'product1s.*',
            'owners.OWNER AS VENDOR', // ในเอกสารสลับกัน
            'grp_ps.GRP_P AS GRP_P',
            'brand_ps.ID AS ID',
            'vendors.VEN_ID AS SUPPLIER', // ในเอกสารสลับกัน
            'type_gs.ID AS TYPE_G',
        )
        ->leftJoin('owners', 'product1s.VENDOR', '=', 'owners.OWNER') // ในเอกสารสลับกัน
        ->leftJoin('grp_ps', 'product1s.GRP_P', '=', 'grp_ps.GRP_P')
        ->leftJoin('brand_ps', 'product1s.BRAND_P', '=', 'brand_ps.ID')
        ->leftJoin('vendors', 'product1s.SUPPLIER', '=', 'vendors.VEN_ID') // ในเอกสารสลับกัน
        ->leftJoin('type_gs', 'product1s.TYPE_G', '=', 'type_gs.ID')
        ->firstWhere('PRODUCT', '=', $request->PRODUCT);

        // dd($data, $request->BARCODE);
        DB::beginTransaction();
        try {
            $data_product = [
                'BRAND' => $data->BRAND,
                'PRODUCT' => $request->BARCODE,
                'BARCODE' => $request->BARCODE,
                'COLOR' => $data->COLOR,
                'GRP_P' => $data->GRP_P,
                'SUPPLIER' => $data->SUPPLIER,
                'NAME_THAI' => $data->NAME_THAI,
                'NAME_ENG' => $data->NAME_ENG,
                'SHORT_THAI' => $data->SHORT_THAI,
                'SHORT_ENG' => $data->SHORT_ENG,
                'VENDOR' => $data->VENDOR,
                'PRICE' => $data->PRICE,
                'COST' => $data->COST,
                'UNIT' => $data->UNIT,
                'UNIT_Q' => $data->UNIT_Q,
                'SOLUTION' => $data->SOLUTION,
                'SERIES' => $data->SERIES,
                'CATEGORY' => $data->CATEGORY,
                'STATUS' => $data->STATUS,
                'S_CAT' => $data->S_CAT,
                'PDM_GROUP' => $data->PDM_GROUP,
                'BRAND_P' => $data->BRAND_P,
                'REGISTER' => $data->REGISTER,
                'CONDITION_SALE' => $data->CONDITION_SALE,
                'WHOLE_SALE' => $data->WHOLE_SALE,
                'GP' => $data->GP,
                'O_PRODUCT' => $data->O_PRODUCT,
                'BAR_PACK1' => $data->BAR_PACK1,
                'BAR_PACK2' => $data->BAR_PACK2,
                'BAR_PACK3' => $data->BAR_PACK3,
                'BAR_PACK4' => $data->BAR_PACK4,
                'PACK_SIZE1' => $data->PACK_SIZE1,
                'PACK_SIZE2' => $data->PACK_SIZE2,
                'PACK_SIZE3' => $data->PACK_SIZE3,
                'PACK_SIZE4' => $data->PACK_SIZE4,
                'REG_DATE' => date("Y/m/d h:i:s"),
                'AGE' => $data->AGE,
                'WIDTH' => $data->WIDTH,
                'HEIGHT' => $data->HEIGHT,
                'WIDE' => $data->WIDE,
                'NAME_EXP' => $data->NAME_EXP,
                'NET_WEIGHT' => $data->NET_WEIGHT,
                'UNIT_TYPE' => $data->UNIT_TYPE,
                'TYPE_G' => $data->TYPE_G,
                'OPT_DATE1' => $data->OPT_DATE1,
                'OPT_DATE2' => $data->OPT_DATE2,
                'OPT_TXT1' => $data->OPT_TXT1,
                'OPT_TXT2' => $data->OPT_TXT2,
                'OPT_NUM1' => $data->OPT_NUM1,
                'OPT_NUM2' => $data->OPT_NUM2,
                'ACC_TYPE' => $data->ACC_TYPE,
                'ACC_DT' => $data->ACC_DT,
                'EDIT_DT' => $data->EDIT_DT,
                'RETURN' => is_null($data->RETURN) ? 'N' : 'Y',
                'NON_VAT' => is_null($data->NON_VAT) ? 'N' : 'Y',
                'STORAGE_TEMP' => is_null($data->STORAGE_TEMP) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($data->CONTROL_STK) ? 'N' : 'Y',
                'TESTER' =>  is_null($data->TESTER) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->id
            ];

            $copyProductMaster = Product1::create($data_product);
            // dd($copyProductMaster);
            DB::commit();
            $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }
    public function createCopy(Request $request)
    {
        // dd($request);
        $dataProductBarcode = Pro_develops::select(
            'BRAND',
            'PRODUCT',
            'BARCODE',
        )
        ->firstWhere('PRODUCT', '=', $request->NUMBER);

        // dd($dataProductBarcode);

        // $venders = Vendor::all();
        // $type_gs = Type_g::all();
        // $solutions = Solution::all();
        // $series = Series::all();
        // $categorys = Category::all();
        // $sub_categorys = Sub_category::all();
        // $pdms = Pdm::all();
        // $p_statuss = P_status::all();
        // $unit_ps = Unit_p::all();
        // $unit_types = Unit_type::all();
        // $acctypes = Acctype::all();
        // $conditions = Condition::all();

        $data = Product1::select(
            'product1s.*',
            'owners.OWNER AS VENDOR', // ในเอกสารสลับกัน
            'grp_ps.GRP_P AS GRP_P',
            'brand_ps.ID AS ID',
            'vendors.VEN_ID AS SUPPLIER', // ในเอกสารสลับกัน
            'type_gs.ID AS TYPE_G',
        )
        ->leftJoin('owners', 'product1s.VENDOR', '=', 'owners.OWNER') // ในเอกสารสลับกัน
        ->leftJoin('grp_ps', 'product1s.GRP_P', '=', 'grp_ps.GRP_P')
        ->leftJoin('brand_ps', 'product1s.BRAND_P', '=', 'brand_ps.ID')
        ->leftJoin('vendors', 'product1s.SUPPLIER', '=', 'vendors.VEN_ID') // ในเอกสารสลับกัน
        ->leftJoin('type_gs', 'product1s.TYPE_G', '=', 'type_gs.ID')
        ->firstWhere('PRODUCT', '=', $request->PRODUCT);

        DB::beginTransaction();
        try {
            $data_product = [
                'BRAND' => $data->BRAND,
                'PRODUCT' => $dataProductBarcode->PRODUCT,
                'BARCODE' => $dataProductBarcode->BARCODE,
                'COLOR' => $data->COLOR,
                'GRP_P' => $dataProductBarcode->BRAND,
                'SUPPLIER' => $data->SUPPLIER,
                'NAME_THAI' => $data->NAME_THAI,
                'NAME_ENG' => $data->NAME_ENG,
                'SHORT_THAI' => $data->SHORT_THAI,
                'SHORT_ENG' => $data->SHORT_ENG,
                'VENDOR' => $data->VENDOR,
                'PRICE' => $data->PRICE,
                'COST' => $data->COST,
                'UNIT' => $data->UNIT,
                'UNIT_Q' => $data->UNIT_Q,
                'SOLUTION' => $data->SOLUTION,
                'SERIES' => $data->SERIES,
                'CATEGORY' => $data->CATEGORY,
                'STATUS' => $data->STATUS,
                'S_CAT' => $data->S_CAT,
                'PDM_GROUP' => $data->PDM_GROUP,
                'BRAND_P' => $data->BRAND_P,
                'REGISTER' => $data->REGISTER,
                'CONDITION_SALE' => $data->CONDITION_SALE,
                'WHOLE_SALE' => $data->WHOLE_SALE,
                'GP' => $data->GP,
                'O_PRODUCT' => $data->O_PRODUCT,
                'BAR_PACK1' => $data->BAR_PACK1,
                'BAR_PACK2' => $data->BAR_PACK2,
                'BAR_PACK3' => $data->BAR_PACK3,
                'BAR_PACK4' => $data->BAR_PACK4,
                'PACK_SIZE1' => $data->PACK_SIZE1,
                'PACK_SIZE2' => $data->PACK_SIZE2,
                'PACK_SIZE3' => $data->PACK_SIZE3,
                'PACK_SIZE4' => $data->PACK_SIZE4,
                'REG_DATE' => date("Y/m/d h:i:s"),
                'AGE' => $data->AGE,
                'WIDTH' => $data->WIDTH,
                'HEIGHT' => $data->HEIGHT,
                'WIDE' => $data->WIDE,
                'NAME_EXP' => $data->NAME_EXP,
                'NET_WEIGHT' => $data->NET_WEIGHT,
                'UNIT_TYPE' => $data->UNIT_TYPE,
                'TYPE_G' => $data->TYPE_G,
                'OPT_DATE1' => $data->OPT_DATE1,
                'OPT_DATE2' => $data->OPT_DATE2,
                'OPT_TXT1' => $data->OPT_TXT1,
                'OPT_TXT2' => $data->OPT_TXT2,
                'OPT_NUM1' => $data->OPT_NUM1,
                'OPT_NUM2' => $data->OPT_NUM2,
                'ACC_TYPE' => $data->ACC_TYPE,
                'ACC_DT' => $data->ACC_DT,
                'EDIT_DT' => $data->EDIT_DT,
                'RETURN' => is_null($data->RETURN) ? 'N' : 'Y',
                'NON_VAT' => is_null($data->NON_VAT) ? 'N' : 'Y',
                'STORAGE_TEMP' => is_null($data->STORAGE_TEMP) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($data->CONTROL_STK) ? 'N' : 'Y',
                'TESTER' =>  is_null($data->TESTER) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->id
            ];

            $copyProductMaster = Product1::create($data_product);
            // dd($copyProductMaster);
            DB::commit();
            $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataProductBarcode = Pro_develops::select(
            'BRAND',
            'PRODUCT',
            'BARCODE',
        )
        ->firstWhere('PRODUCT', '=', $request->NUMBER);

        // $digits_barcode = $this->ean13_check_digit();
        // $digits_code = substr($digits_barcode, 7, 5);
        $company = substr($request->BRAND, 0, 2);
        $description = substr($request->BRAND, 2, 2);
        $status = $company.' - '.$description;
        // dd($request);
        DB::beginTransaction();
        try {
            $data_product = [
                // 'BRAND' => $request->input('BRAND'),
                'BRAND' => $request->input('BRAND'),
                'PRODUCT' => $dataProductBarcode->PRODUCT,
                'BARCODE' => $dataProductBarcode->BARCODE,
                'COLOR' => $request->input('COLOR'),
                'GRP_P' => $request->input('GRP_P'),
                'SUPPLIER' => $request->input('SUPPLIER'),
                'NAME_THAI' => $request->input('NAME_THAI'),
                'NAME_ENG' => $request->input('NAME_ENG'),
                'SHORT_THAI' => $request->input('SHORT_THAI'),
                'SHORT_ENG' => $request->input('SHORT_ENG'),
                'VENDOR' => $request->input('VENDOR'),
                'PRICE' => $request->input('PRICE'),
                'COST' => $request->input('COST'),
                'UNIT' => $request->input('UNIT'),
                'UNIT_Q' => $request->input('UNIT_Q'),
                'SOLUTION' => $request->input('SOLUTION'),
                'SERIES' => $request->input('SERIES'),
                'CATEGORY' => $request->input('CATEGORY'),
                'STATUS' => $request->input('STATUS'),
                'S_CAT' => $request->input('S_CAT'),
                'PDM_GROUP' => $request->input('PDM_GROUP'),
                'BRAND_P' => $request->input('BRAND_P'),
                'REGISTER' => $request->input('REGISTER'),
                'CONDITION_SALE' => $request->input('CONDITION_SALE'),
                'WHOLE_SALE' => $request->input('WHOLE_SALE'),
                'GP' => $request->input('GP'),
                'O_PRODUCT' => $request->input('O_PRODUCT'),
                'BAR_PACK1' => $request->input('BAR_PACK1'),
                'BAR_PACK2' => $request->input('BAR_PACK2'),
                'BAR_PACK3' => $request->input('BAR_PACK3'),
                'BAR_PACK4' => $request->input('BAR_PACK4'),
                'PACK_SIZE1' => $request->input('PACK_SIZE1'),
                'PACK_SIZE2' => $request->input('PACK_SIZE2'),
                'PACK_SIZE3' => $request->input('PACK_SIZE3'),
                'PACK_SIZE4' => $request->input('PACK_SIZE4'),
                'REG_DATE' => date("Y/m/d h:i:s"),
                'AGE' => $request->input('AGE'),
                'WIDTH' => $request->input('WIDTH'),
                'HEIGHT' => $request->input('HEIGHT'),
                'WIDE' => $request->input('WIDE'),
                'NAME_EXP' => $request->input('NAME_EXP'),
                'NET_WEIGHT' => $request->input('NET_WEIGHT'),
                'UNIT_TYPE' => $request->input('UNIT_TYPE'),
                'TYPE_G' => $request->input('TYPE_G'),
                'OPT_DATE1' => $request->input('OPT_DATE1'),
                'OPT_DATE2' => $request->input('OPT_DATE2'),
                'OPT_TXT1' => $request->input('OPT_TXT1'),
                'OPT_TXT2' => $request->input('OPT_TXT2'),
                'OPT_NUM1' => $request->input('OPT_NUM1'),
                'OPT_NUM2' => $request->input('OPT_NUM2'),
                'ACC_TYPE' => $request->input('ACC_TYPE'),
                'ACC_DT' => $request->input('ACC_DT'),
                'EDIT_DT' => $request->input('EDIT_DT'),
                'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                'NON_VAT' => is_null($request->input('NON_VAT')) ? 'N' : 'Y',
                'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->id
            ];

            $productMaster = Product1::create($data_product);

            // dd($request);
            // if(!is_null($request->sele_channel[0])) {
            //     foreach ($request->sele_channel as $key => $value) {
            //         $createSeleChannel = SeleChannel::updateOrCreate(['PRODUCT' => $data_product['PRODUCT']],
            // [
            //             $value => is_null($value) ? 0 : 1,
            //             'UPDATED_BY' => Auth::user()->id,
            //         ]);
            //     }
            // }

            if (!is_null($request->sele_channel[0])) {

                // ProductChannel::select('id')->where('PRODUCT', $data_product['PRODUCT'])->whereNotIn('BRAND', $request->sele_channel)->delete();

                $user = Auth::user()->username;
                $dateTime = date('Y-m-d H:i:s');

                $updateData = [
                    'UPDATED_BY' => $user,
                    'UPDATED_AT' => $dateTime
                ];

                foreach ($request->sele_channel as $value) {
                    $createSeleChannel = ProductChannel::updateOrCreate(
            ['PRODUCT' => $data_product['PRODUCT'], 'BRAND' => $value],
                $updateData
                    );
                }
            }

            DB::commit();
            $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }
    public function storeConsumables(Request $request)
    {
        // $digits_barcode = $this->ean13_check_digit();
        // $digits_code = substr($digits_barcode, 7, 5);
        // $company = substr($request->BRAND, 0, 2);
        $description = substr($request->BRAND, 2, 2);
        // $status = $company.' - '.$description;

        // dd($description);
        DB::beginTransaction();
        try {
            $data_product = [
                // 'BRAND' => $request->input('BRAND'),
                'BRAND' => $description,
                'PRODUCT' => $request->input('PRODUCT'),
                'BARCODE' => $request->input('PRODUCT'),
                'COLOR' => $request->input('COLOR'),
                'GRP_P' => $request->input('GRP_P'),
                'SUPPLIER' => $request->input('SUPPLIER'),
                'NAME_THAI' => $request->input('NAME_THAI'),
                'NAME_ENG' => $request->input('NAME_ENG'),
                'SHORT_THAI' => $request->input('SHORT_THAI'),
                'SHORT_ENG' => $request->input('SHORT_ENG'),
                'VENDOR' => $request->input('VENDOR'),
                'PRICE' => $request->input('PRICE'),
                'COST' => $request->input('COST'),
                'UNIT' => $request->input('UNIT'),
                'UNIT_Q' => $request->input('UNIT_Q'),
                'SOLUTION' => $request->input('SOLUTION'),
                'SERIES' => $request->input('SERIES'),
                'CATEGORY' => $request->input('CATEGORY'),
                'STATUS' => $description,
                'S_CAT' => $request->input('S_CAT'),
                'PDM_GROUP' => $request->input('PDM_GROUP'),
                'BRAND_P' => $request->input('BRAND_P'),
                'REGISTER' => $request->input('REGISTER'),
                'CONDITION_SALE' => $request->input('CONDITION_SALE'),
                'WHOLE_SALE' => $request->input('WHOLE_SALE'),
                'GP' => $request->input('GP'),
                'O_PRODUCT' => $request->input('O_PRODUCT'),
                'BAR_PACK1' => $request->input('BAR_PACK1'),
                'BAR_PACK2' => $request->input('BAR_PACK2'),
                'BAR_PACK3' => $request->input('BAR_PACK3'),
                'BAR_PACK4' => $request->input('BAR_PACK4'),
                'PACK_SIZE1' => $request->input('PACK_SIZE1'),
                'PACK_SIZE2' => $request->input('PACK_SIZE2'),
                'PACK_SIZE3' => $request->input('PACK_SIZE3'),
                'PACK_SIZE4' => $request->input('PACK_SIZE4'),
                'REG_DATE' => date("Y/m/d h:i:s"),
                'AGE' => $request->input('AGE'),
                'WIDTH' => $request->input('WIDTH'),
                'HEIGHT' => $request->input('HEIGHT'),
                'WIDE' => $request->input('WIDE'),
                'NAME_EXP' => $request->input('NAME_EXP'),
                'NET_WEIGHT' => $request->input('NET_WEIGHT'),
                'UNIT_TYPE' => $request->input('UNIT_TYPE'),
                'TYPE_G' => $request->input('TYPE_G'),
                'OPT_DATE1' => $request->input('OPT_DATE1'),
                'OPT_DATE2' => $request->input('OPT_DATE2'),
                'OPT_TXT1' => $request->input('OPT_TXT1'),
                'OPT_TXT2' => $request->input('OPT_TXT2'),
                'OPT_NUM1' => $request->input('OPT_NUM1'),
                'OPT_NUM2' => $request->input('OPT_NUM2'),
                'ACC_TYPE' => $request->input('ACC_TYPE'),
                'ACC_DT' => $request->input('ACC_DT'),
                'EDIT_DT' => $request->input('EDIT_DT'),
                'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                'NON_VAT' => is_null($request->input('NON_VAT')) ? 'N' : 'Y',
                'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->id
            ];

            $productMaster = Product1::create($data_product);
            // dd($productMaster);
            DB::commit();
            $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $PRODUCT)
    {
        $data = Product1::select(
            'product1s.*',
            'owners.OWNER AS VENDOR', // ในเอกสารสลับกัน
            'grp_ps.GRP_P AS GRP_P',
            'brand_ps.ID AS BRAND_P',
            'vendors.VEN_ID AS SUPPLIER', // ในเอกสารสลับกัน
            'type_gs.ID AS TYPE_G',
            'solutions.ID AS SOLUTION',
            'series.ID AS SERIES',
            'categories.ID AS CATEGORY',
            'sub_categories.ID AS S_CAT',
            'pdms.ID AS PDM_GROUP',
            'p_statuses.ID AS STATUS',
            // 'product_channels.BRAND AS BRAND',
        )
        ->leftJoin('owners', 'product1s.VENDOR', '=', 'owners.OWNER') // ในเอกสารสลับกัน
        ->leftJoin('grp_ps', 'product1s.GRP_P', '=', 'grp_ps.GRP_P')
        ->leftJoin('brand_ps', 'product1s.BRAND_P', '=', 'brand_ps.ID')
        ->leftJoin('vendors', 'product1s.SUPPLIER', '=', 'vendors.VEN_ID') // ในเอกสารสลับกัน
        ->leftJoin('type_gs', 'product1s.TYPE_G', '=', 'type_gs.ID')
        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
        ->leftJoin('pdms', 'product1s.PDM_GROUP', '=', 'pdms.ID')
        ->leftJoin('p_statuses', 'product1s.STATUS', '=', 'p_statuses.ID')
        // ->leftJoin('product_channels', 'product1s.PRODUCT', '=', 'product_channels.PRODUCT')
        ->firstWhere('product1s.PRODUCT', '=', $PRODUCT);

        // $sub_categorys = Sub_category::all();
        // $pdms = Pdm::all();
        // $p_statuss = P_status::all();
        // $unit_ps = Unit_p::all();
        // $unit_types = Unit_type::all();
        // $acctypes = Acctype::all();
        // $conditions = Condition::all();

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;

        $owners = Owner::select('OWNER AS VENDOR', 'REMARK')->get();
        $grp_ps = Grp_p::select('GRP_P AS GRP_P', 'REMARK')->get();

        $brand_ps = Brand_p::select('ID AS BRAND_P', 'REMARK')->get();

        if (in_array($userpermission, [$isSuperAdmin])) {
            $brand_ps = Brand_p::select(
                'ID AS BRAND_P',
                'REMARK')
            ->get();
        }
        else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $brand_ps = Brand_p::select(
                'ID AS BRAND_P',
                'REMARK')
            ->where('BRAND', 'GNC')
            ->get();
        }
        else if (in_array($userpermission, ['Marketing - CPS'])) {
            $brand_ps = Brand_p::select(
                'ID AS BRAND_P',
                'REMARK')
            ->where('BRAND', 'CPS')
            ->get();
        }

        $venders = Vendor::select('VEN_ID AS SUPPLIER', 'VEN_NTHAI')->get();
        $type_gs = Type_g::select('ID AS TYPE_G', 'DESCRIPTION')->get();
        $solutions = Solution::select('ID AS SOLUTION', 'DESCRIPTION')->get();
        $series = Series::select('ID AS SERIES	', 'DESCRIPTION')->get();
        $categorys = Category::select('ID AS CATEGORY', 'DESCRIPTION')->get();
        $sub_categorys = Sub_category::select('ID AS S_CAT', 'DESCRIPTION')->get();
        $pdms = Pdm::select('ID AS PDM_GROUP', 'REMARK')->get();
        $p_statuss = P_status::select('ID AS STATUS', 'DESCRIPTION')->get();

        $unit_ps = Unit_p::all();
        $unit_types = Unit_type::all();
        $acctypes = Acctype::all();
        $conditions = Condition::all();

        $multiChannels = ProductChannel::select('BRAND')->where('PRODUCT', '=', $PRODUCT)->pluck('BRAND')->toArray();
        $allBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();
        $defaultBrands = MasterBrand::all();
        $brands = MasterBrand::all();

        if (in_array($userpermission, [$isSuperAdmin])) {

            $brands = MasterBrand::select(
                'BRAND')
            ->get();
        }
        else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->pluck('BRAND')
            ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
        } else if (in_array($userpermission, ['Marketing - CPS'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->pluck('BRAND')
            ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
        } else if (in_array($userpermission, ['Procurement - KTY'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KTY')
            ->pluck('BRAND')
            ->toArray();

            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
        }

        return view('product.edit', compact('data', 'multiChannels', 'allBrands', 'defaultBrands', 'owners', 'grp_ps', 'brand_ps', 'venders', 'type_gs', 'solutions', 'series', 'categorys', 'sub_categorys', 'pdms', 'p_statuss'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $PRODUCT)
    {
        // dd($request);
        // dd(strlen($PRODUCT));
        DB::beginTransaction();
        try {
            if (strlen($PRODUCT) > 5) {
                $data_product_upddate = [
                    'BRAND' => $request->input('BRAND'),
                    'PRODUCT' => $request->input('Code'),
                    'BARCODE' => $request->input('Code'),
                    'COLOR' => $request->input('COLOR'),
                    'GRP_P' => $request->input('GRP_P'),
                    'SUPPLIER' => $request->input('SUPPLIER'),
                    'NAME_THAI' => $request->input('NAME_THAI'),
                    'NAME_ENG' => $request->input('NAME_ENG'),
                    'SHORT_THAI' => $request->input('SHORT_THAI'),
                    'SHORT_ENG' => $request->input('SHORT_ENG'),
                    'VENDOR' => $request->input('VENDOR'),
                    'PRICE' => $request->input('PRICE'),
                    'COST' => $request->input('COST'),
                    'UNIT' => $request->input('UNIT'),
                    'UNIT_Q' => $request->input('UNIT_Q'),
                    'SOLUTION' => $request->input('SOLUTION'),
                    'SERIES' => $request->input('SERIES'),
                    'CATEGORY' => $request->input('CATEGORY'),
                    'STATUS' => $request->input('STATUS'),
                    'S_CAT' => $request->input('S_CAT'),
                    'PDM_GROUP' => $request->input('PDM_GROUP'),
                    'BRAND_P' => $request->input('BRAND_P'),
                    'REGISTER' => $request->input('REGISTER'),
                    'CONDITION_SALE' => $request->input('CONDITION_SALE'),
                    'WHOLE_SALE' => $request->input('WHOLE_SALE'),
                    'GP' => $request->input('GP'),
                    'O_PRODUCT' => $request->input('O_PRODUCT'),
                    'BAR_PACK1' => $request->input('BAR_PACK1'),
                    'BAR_PACK2' => $request->input('BAR_PACK2'),
                    'BAR_PACK3' => $request->input('BAR_PACK3'),
                    'BAR_PACK4' => $request->input('BAR_PACK4'),
                    'PACK_SIZE1' => $request->input('PACK_SIZE1'),
                    'PACK_SIZE2' => $request->input('PACK_SIZE2'),
                    'PACK_SIZE3' => $request->input('PACK_SIZE3'),
                    'PACK_SIZE4' => $request->input('PACK_SIZE4'),
                    'REG_DATE' => date("Y/m/d h:i:s"),
                    'AGE' => $request->input('AGE'),
                    'WIDTH' => $request->input('WIDTH'),
                    'HEIGHT' => $request->input('HEIGHT'),
                    'WIDE' => $request->input('WIDE'),
                    'NAME_EXP' => $request->input('NAME_EXP'),
                    'NET_WEIGHT' => $request->input('NET_WEIGHT'),
                    'UNIT_TYPE' => $request->input('UNIT_TYPE'),
                    'TYPE_G' => $request->input('TYPE_G'),
                    'OPT_DATE1' => $request->input('OPT_DATE1'),
                    'OPT_DATE2' => $request->input('OPT_DATE2'),
                    'OPT_TXT1' => $request->input('OPT_TXT1'),
                    'OPT_TXT2' => $request->input('OPT_TXT2'),
                    'OPT_NUM1' => $request->input('OPT_NUM1'),
                    'OPT_NUM2' => $request->input('OPT_NUM2'),
                    'ACC_TYPE' => $request->input('ACC_TYPE'),
                    'ACC_DT' => $request->input('ACC_DT'),
                    'EDIT_DT' => $request->input('EDIT_DT'),
                    'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                    'NON_VAT' => is_null($request->input('NON_VAT')) ? 'N' : 'Y',
                    'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                    'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                    'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                    'USER_EDIT' => Auth::user()->id
                ];

                $productUpddateConsumables = Product1::where('PRODUCT', $PRODUCT)->update($data_product_upddate);
                DB::commit();
                $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
                return response()->json(['success' => true]);
            } else {
                $data_product_upddate = [
                    'BRAND' => $request->input('BRAND'),
                    'PRODUCT' => $request->input('Code'),
                    'BARCODE' => $request->input('BARCODE'),
                    'COLOR' => $request->input('COLOR'),
                    'GRP_P' => $request->input('GRP_P'),
                    'SUPPLIER' => $request->input('SUPPLIER'),
                    'NAME_THAI' => $request->input('NAME_THAI'),
                    'NAME_ENG' => $request->input('NAME_ENG'),
                    'SHORT_THAI' => $request->input('SHORT_THAI'),
                    'SHORT_ENG' => $request->input('SHORT_ENG'),
                    'VENDOR' => $request->input('VENDOR'),
                    'PRICE' => $request->input('PRICE'),
                    'COST' => $request->input('COST'),
                    'UNIT' => $request->input('UNIT'),
                    'UNIT_Q' => $request->input('UNIT_Q'),
                    'SOLUTION' => $request->input('SOLUTION'),
                    'SERIES' => $request->input('SERIES'),
                    'CATEGORY' => $request->input('CATEGORY'),
                    'STATUS' => $request->input('STATUS'),
                    'S_CAT' => $request->input('S_CAT'),
                    'PDM_GROUP' => $request->input('PDM_GROUP'),
                    'BRAND_P' => $request->input('BRAND_P'),
                    'REGISTER' => $request->input('REGISTER'),
                    'CONDITION_SALE' => $request->input('CONDITION_SALE'),
                    'WHOLE_SALE' => $request->input('WHOLE_SALE'),
                    'GP' => $request->input('GP'),
                    'O_PRODUCT' => $request->input('O_PRODUCT'),
                    'BAR_PACK1' => $request->input('BAR_PACK1'),
                    'BAR_PACK2' => $request->input('BAR_PACK2'),
                    'BAR_PACK3' => $request->input('BAR_PACK3'),
                    'BAR_PACK4' => $request->input('BAR_PACK4'),
                    'PACK_SIZE1' => $request->input('PACK_SIZE1'),
                    'PACK_SIZE2' => $request->input('PACK_SIZE2'),
                    'PACK_SIZE3' => $request->input('PACK_SIZE3'),
                    'PACK_SIZE4' => $request->input('PACK_SIZE4'),
                    'REG_DATE' => date("Y/m/d h:i:s"),
                    'AGE' => $request->input('AGE'),
                    'WIDTH' => $request->input('WIDTH'),
                    'HEIGHT' => $request->input('HEIGHT'),
                    'WIDE' => $request->input('WIDE'),
                    'NAME_EXP' => $request->input('NAME_EXP'),
                    'NET_WEIGHT' => $request->input('NET_WEIGHT'),
                    'UNIT_TYPE' => $request->input('UNIT_TYPE'),
                    'TYPE_G' => $request->input('TYPE_G'),
                    'OPT_DATE1' => $request->input('OPT_DATE1'),
                    'OPT_DATE2' => $request->input('OPT_DATE2'),
                    'OPT_TXT1' => $request->input('OPT_TXT1'),
                    'OPT_TXT2' => $request->input('OPT_TXT2'),
                    'OPT_NUM1' => $request->input('OPT_NUM1'),
                    'OPT_NUM2' => $request->input('OPT_NUM2'),
                    'ACC_TYPE' => $request->input('ACC_TYPE'),
                    'ACC_DT' => $request->input('ACC_DT'),
                    'EDIT_DT' => $request->input('EDIT_DT'),
                    'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                    'NON_VAT' => is_null($request->input('NON_VAT')) ? 'N' : 'Y',
                    'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                    'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                    'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                    'USER_EDIT' => Auth::user()->id
                ];

                if (!is_null($request->sele_channel[0])) {

                    $multiChannels = ProductChannel::select('BRAND')->where('PRODUCT', $data_product_upddate['PRODUCT'])->whereNotIn('BRAND', $request->sele_channel)->delete();

                    $user = Auth::user()->username;
                    $dateTime = date('Y-m-d H:i:s');

                    $updateData = [
                        'UPDATED_BY' => $user,
                        'UPDATED_AT' => $dateTime
                    ];

                    foreach ($request->sele_channel as $value) {
                        $createSeleChannel = ProductChannel::updateOrCreate(
            ['PRODUCT' => $data_product_upddate['PRODUCT'], 'BRAND' => $value],
                    $updateData
                        );
                    }
                }

                // dd(
                // $test = [
                //         'data_product_upddate' => $data_product_upddate,
                //         'multiChannels' => $multiChannels
                //     ]);

                $productUpddate = Product1::where('PRODUCT', $PRODUCT)->update($data_product_upddate);
                // dd($productUpddate);
                DB::commit();
                $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function get_users()
    {
        $get_users = User::all();

        return view('product.get_users', compact('get_users'));
    }

    public static function count_users()
    {
        $data = Product::select('id')
            ->where('status', '=', 2)
            ->count();

            // $data = $data->count();

        // return response()->json($data);
        return $data;
    }

    public function list_products(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $BRAND = $request->input('brand_id');
        $PRODUCT = $request->input('PRODUCT');
        // $BARCODE = $request->input('BARCODE');
        $DOC_NO = $request->search;
        $field_detail = [
            'product1s.PRODUCT',
            'product1s.NAME_THAI',
            'product1s.BARCODE',
        ];

        $data = Product1::select(
   'BRAND',
            'GRP_P',
            'PRODUCT',
            'BARCODE',
            'NAME_THAI'
        )
        ->orderBy('PRODUCT', 'DESC');

        $datas = Product1::select('BRAND', 'GRP_P','PRODUCT', 'BARCODE', 'NAME_THAI',)->get();
        foreach ($datas as $data) {
            $product_channel_array = [];

            $item_channel = ProductChannel::select('PRODUCT', 'BRAND')
                ->where('PRODUCT', '=', $data->PRODUCT)
                ->get();

            foreach ($item_channel as $dataitem_channel) {
                $product_channel_array[] = $dataitem_channel->BRAND;
            }

            $data->product_channel_array = $product_channel_array;
        }

        $userpermission = Auth::user()->getUserPermission->name_position;
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        if (in_array($userpermission, [$isSuperAdmin, 'Admin'])) {
                $data = Product1::select(
       'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->orderBy('BARCODE', 'DESC');
        } else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $data = Product1::select(
           'BRAND',
                    'GRP_P',
                    'PRODUCT',
                    'BARCODE',
                    'NAME_THAI'
                )
                ->whereIn('BRAND', ['OP', 'KM'])
                ->orWhereHas('productChannel', function ($q) {
                    $q->whereIn('BRAND', ['OP', 'KM']);
                })
                ->orderBy('BARCODE', 'DESC');
        } else if (in_array($userpermission, ['Marketing - CPS'])) {
            $data = Product1::select(
       'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            // ->join('barcodes', 'pro_develops.BRAND', '=', 'barcodes.BRAND')
            ->whereIn('BRAND', ['CPS', 'KM'])
            ->orderBy('BARCODE', 'DESC');
        }

        if ($BRAND != null) {
            $data->where('product1s.BRAND', $BRAND);
        }

        // if ($PRODUCT != null) {
        //     $data->where('product1s.PRODUCT', $PRODUCT);
        // }

        if (null != $DOC_NO) {
            $data = $data->where(function ($data) use ($DOC_NO, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$DOC_NO.'%');
                }
            });
        }

        // if (null != $BARCODE) {
        //     $productCodes = $data->where(DB::raw('SUBSTRING(BARCODE, 8, 5)'), $request->input('BARCODE'))->pluck('BARCODE');
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

    public function checkname_brand(Request $request)
    {
        // dd($request);
        $data = Product1::select('PRODUCT')
            ->where('PRODUCT', $request->PRODUCT)
            ->count();

        return response()->json($data > 0 ? false : true);
    }

    public function list_approve_products(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = Product::select(
            'id',
            'seq',
            'name',
            'status'
        )
        ->where('status', 1)
        ->orderBy('id', 'ASC');

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

    public function upate_product_status($id)
    {
        $data = Product::find($id);
        $data->status = 2;
        $data->save();

        return response()->json(['success'=>true]);
    }
    // public static function upate_product_status()
    // {
    //     $data = Product::find('id');
    //     $data->status = 2;
    //     $data->save();

    //     // return response()->json(['success'=>true]);
    //     return $data;
    // }
}
