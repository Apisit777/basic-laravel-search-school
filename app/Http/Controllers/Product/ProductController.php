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
use App\Models\Product1Log;
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
use App\Models\ProductGroup;
use App\Models\Account;

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
        // $product_seq = Product::select('seq')->get();
        $brands = Barcode::select('BRAND')->pluck('BRAND')->toArray();

        $getSelect2ProDevelops = Pro_develops::select(
            'PRODUCT'
        )
        ->get();

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        // dd($data);

        if ($userpermission == $isSuperAdmin) {

            // $brands = Product1::select(
            //     'BRAND',
            // )
            // ->where(function ($query) {
            //     $query->whereIn('BRAND', ['OP', 'KM'])
            //         ->orWhereHas('productChannel', function ($q) {
            //             $q->whereIn('BRAND', ['OP', 'KM']);
            //         });
            // })
            // ->groupBy('BRAND')
            // ->pluck('BRAND')
            // ->toArray();

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

        } else if ($userpermission == 'OP') {
            // $brands = Product1::select(
            //     'BRAND',
            // )
            // ->where(function ($query) {
            //     $query->whereIn('BRAND', ['OP', 'KM'])
            //         ->orWhereHas('productChannel', function ($q) {
            //             $q->whereIn('BRAND', ['OP']);
            //         });
            // })
            // ->groupBy('BRAND')
            // ->pluck('BRAND')
            // ->toArray();

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['OP', 'RE', 'CM'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['CPS', 'KM', 'KTY', 'BB', 'LL'])
            // ->get();
            ->pluck('PRODUCT')
            ->toArray();

            $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            $dataProductMaster = Pro_develops::select(
            'PRODUCT')
            ->whereIn('BRAND', ['OP', 'RE'])
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->where('BRAND', 'OP')
            ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
            ->pluck('PRODUCT')
            ->toArray();

            $getSelect2ProDevelops = Product1::select(
                'PRODUCT')
                ->whereIn('BRAND', ['OP'])
                ->pluck('PRODUCT')
                ->toArray();

        } else if ($userpermission == 'CPS') {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['CPS'])
            ->pluck('BRAND')
            ->toArray();

            // $brands = Product1::select(
            //     'BRAND',
            // )
            // ->where(function ($query) {
            //     $query->whereIn('BRAND', ['CPS', 'KM'])
            //         ->orWhereHas('productChannel', function ($q) {
            //             $q->whereIn('BRAND', ['CPS']);
            //         });
            // })
            // ->groupBy('BRAND')
            // ->pluck('BRAND')
            // ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'KM', 'KTY', 'BB', 'LL'])
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
            ->where('BRAND', 'CPS')
            ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
            ->pluck('PRODUCT')
            ->toArray();

            $getSelect2ProDevelops = Product1::select(
                'PRODUCT')
                ->whereIn('BRAND', ['CPS'])
                ->pluck('PRODUCT')
                ->toArray();

        } else if ($userpermission == 'KTY') {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['KTY'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'BB', 'LL'])
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
            ->where('BRAND', 'KTY')
            ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
            ->pluck('PRODUCT')
            ->toArray();

            $getSelect2ProDevelops = Pro_develops::select(
                'PRODUCT')
                ->whereIn('BRAND', ['KTY'])
                ->pluck('PRODUCT')
                ->toArray();
        } else if ($userpermission == 'GNC') {

            // $brands = Product1::select(
            //     'BRAND',
            // )
            // ->where(function ($query) {
            //     $query->whereIn('BRAND', ['OP', 'KM'])
            //         ->orWhereHas('productChannel', function ($q) {
            //             $q->whereIn('BRAND', ['OP']);
            //         });
            // })
            // ->groupBy('BRAND')
            // ->pluck('BRAND')
            // ->toArray();

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['GNC'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'BB', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();

            // $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            // $dataProductMaster = Pro_develops::select(
            // 'PRODUCT')
            // ->whereIn('BRAND', ['OP', 'RE'])
            // ->whereNotIn('PRODUCT', $data_PRODUCT)
            // ->get();
            $dataProductMaster = Product1::select('PRODUCT')
                // ->whereNotIn('BRAND', ['OP', 'CPS'])
                ->whereNotIn('BRAND', ['GNC'])
                ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->where('BRAND', 'GNC')
            ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
            ->pluck('PRODUCT')
            ->toArray();

            $getSelect2ProDevelops = Pro_develops::select(
                'PRODUCT')
                ->whereIn('BRAND', ['GNC'])
                ->pluck('PRODUCT')
                ->toArray();
        } else if ($userpermission == 'KM') {

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['GNC'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'BB', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();

            $dataProductMaster = Product1::select('PRODUCT')
                // ->whereNotIn('BRAND', ['OP', 'CPS'])
                ->whereNotIn('BRAND', ['OP'])
                ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->where('BRAND', 'KM')
            ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
            ->pluck('PRODUCT')
            ->toArray();

            $getSelect2ProDevelops = Pro_develops::select(
                'PRODUCT')
                ->whereIn('BRAND', ['KM'])
                ->pluck('PRODUCT')
                ->toArray();
        } else if ($userpermission == 'BB') {

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['BB'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();

            // $dataProductMaster = Product1::select('PRODUCT')
            //     // ->whereNotIn('BRAND', ['OP', 'CPS'])
            //     ->whereNotIn('BRAND', ['BB'])
            //     ->get();


            $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            $dataProductMaster = Pro_develops::select(
            'PRODUCT')
            ->whereIn('BRAND', ['BB'])
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->where('BRAND', 'BB')
            ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
            ->pluck('PRODUCT')
            ->toArray();

            $getSelect2ProDevelops = Pro_develops::select(
                'PRODUCT')
                ->whereIn('BRAND', ['BB'])
                ->pluck('PRODUCT')
                ->toArray();
        } else if ($userpermission == 'LL') {

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['LL'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB'])
            ->pluck('PRODUCT')
            ->toArray();

            // $dataProductMaster = Product1::select('PRODUCT')
            //     // ->whereNotIn('BRAND', ['OP', 'CPS'])
            //     ->whereNotIn('BRAND', ['LL'])
            //     ->get();

            $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            $dataProductMaster = Pro_develops::select(
            'PRODUCT')
            ->whereIn('BRAND', ['LL'])
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->where('BRAND', 'LL')
            ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
            ->pluck('PRODUCT')
            ->toArray();

            $getSelect2ProDevelops = Pro_develops::select(
                'PRODUCT')
                ->whereIn('BRAND', ['LL'])
                ->pluck('PRODUCT')
                ->toArray();
        } else if ($userpermission == 'ACC') {

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB', 'LL'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB'])
            ->pluck('PRODUCT')
            ->toArray();

            $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            $dataProductMaster = Pro_develops::select(
            'PRODUCT')
            ->whereIn('BRAND', ['LL'])
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->where('BRAND', 'LL')
            ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
            ->pluck('PRODUCT')
            ->toArray();

            $getSelect2ProDevelops = Pro_develops::select(
                'PRODUCT')
                ->whereIn('BRAND', ['LL'])
                ->pluck('PRODUCT')
                ->toArray();
        }
        // else if (in_array($userpermission, ['Accounting'])) {

        //     $brands = Barcode::select(
        //     'BRAND',
        //         'STATUS')
        //     ->whereIn('STATUS', ['LL'])
        //     ->pluck('BRAND')
        //     ->toArray();

        //     $dataProductMasterArr = Product1::select(
        //     'PRODUCT')
        //     ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB'])
        //     ->pluck('PRODUCT')
        //     ->toArray();

        //     $dataProductMaster = Product1::select('PRODUCT')
        //         // ->whereNotIn('BRAND', ['OP', 'CPS'])
        //         ->whereNotIn('BRAND', ['LL'])
        //         ->get();

        //     $dataProductMasterConsumablesArr = Product1::select(
        //     'PRODUCT')
        //     ->where('BRAND', 'LL')
        //     ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
        //     ->pluck('PRODUCT')
        //     ->toArray();
        // }

        // dd($dataProductMasterArr);
        $productCodeArr = $dataProductMaster->select('PRODUCT')->pluck('PRODUCT')->toArray();
        $data_barcode = Pro_develops::select(
        'BARCODE')
        ->pluck('BARCODE')->toArray();

        // $result = DB::table('product1s_all as p')
        //     ->selectRaw("
        //         CONCAT(BRAND, ' = ', LEFT(product, 1)) AS `Number 0-9`,
        //         COUNT(*) AS `Count`,
        //         (SELECT COUNT(*)
        //         FROM product1s_all
        //         WHERE LEFT(product, 1) = LEFT(p.product, 1)
        //         AND BRAND = 'gnc') AS `Total`
        //     ")
        //     ->whereRaw("product REGEXP '^[0-9]'")
        //     ->where('BRAND', '=', 'gnc')
        //     ->groupBy(DB::raw('BRAND, LEFT(product, 1)'))
        //     ->get();

        // attributes: array:3[ 'id' => 1,
        //                         'position_id' => 1,
        //                         'positions:[ 'name_position' => 1,
        //                                 'name_position' => 1,
        //                         ]
        //                     ];

        // $user = Auth::user()->load('userRole.position');
        // dd($dataProductMasterConsumablesArr);
        // dd(Auth::user()->getUserPermission->name_position);
        return view('product.index', compact('user',  'brands', 'productCodeArr', 'dataProductMasterArr', 'dataProductMasterConsumablesArr', 'data_barcode', 'getSelect2ProDevelops'));
    }

    public function getBarcode(Request $request)
    {
        $product = $request->input('PRODUCT');
        $lengthNumber = strlen((string) $product);

        if ($lengthNumber > 5) {
            $productCodes = Product1::select('BARCODE')
                ->where('PRODUCT', $request->input('BARCODE'))
                ->first();
        } else {
            $productCodes = Pro_develops::select('BARCODE')
                ->where('PRODUCT', $request->input('BARCODE'))
                ->first();
        }

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

    public function checkCode(Request $request)
    {
        // dd($request);
        $data = Product1::select('PRODUCT')
            ->where('PRODUCT', $request->PRODUCT)
            ->count();

        return response()->json($data > 0 ? false : true);
    }

    public function checkBarcode(Request $request)
    {
        // dd($request);
        $data = Product1::select('BARCODE')
            ->where('BARCODE', $request->BARCODE)
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
        // $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();

        // $productCodes = Pro_develops::select(
        //         // 'product1s.*',
        //         // DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code')
        //         'PRODUCT'
        //     )
        //     ->where('BRAND', $request->input('BRAND'))
        //     ->whereNotIn('PRODUCT', $data_PRODUCT)
        //     ->orderby('PRODUCT')
        //     ->get();

        $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();

        $productCodes = Pro_develops::select(
                'PRODUCT AS Code'
            )
            ->where('BRAND', $request->input('BRAND'))
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->orderby('PRODUCT')
            ->get();

        // $digits_barcode = $this->ean13_check_digit($request);
        // dd($productCodes->toArray());
        return response()->json(['productCodes' => $productCodes]);
        // return response()->json(['productCodes' => $productCodes, 'digits_barcode' => $digits_barcode]);
    }

    // private function ean13_check_digit()
    // {
    //     $request = request();
    //         $lastElement = Pro_develops::max('BARCODE');
    //         if ($request->BRAND == 'OP') {
    //             // $lastElement = Pro_develops::where('BRAND', '=', $request->BRAND)->where('STATUS', '=', 'OP')->max('BARCODE');
    //             $lastElement = Pro_develops::where('BRAND', '=', $request->BRAND)->max('BARCODE');
    //         }
    //         if ($request->BRAND == 'RE') {
    //             $lastElement = Pro_develops::where('BRAND', '=', $request->BRAND)->where('STATUS', '=', 'RE')->max('BARCODE');
    //         }
    //         if ($request->BRAND == 'CPS') {
    //             // $lastElement = Pro_develops::where('BRAND', '=', $request->BRAND)->where('STATUS', '=', 'CPS')->max('BARCODE');
    //             $lastElement = Pro_develops::where('BRAND', '=', $request->BRAND)->max('BARCODE');
    //         }
    //         // dd($lastElement);
    //         $barcodeMax = substr_replace($lastElement, '', -1);
    //         // dd($barcodeMax);
    //         $barcodeNumber =  preg_replace('/[^0-9]/', '', $barcodeMax) + 1;
    //         $barcode = sprintf('%04d', $barcodeNumber);

    //         $digits =(string)$barcode;
    //         $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
    //         $even_sum_three = $even_sum * 3;
    //         $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
    //         $total_sum = $even_sum_three + $odd_sum;
    //         $next_ten = (ceil($total_sum/10))*10;
    //         $check_digit = $next_ten - $total_sum;

    //     return $digits . $check_digit;
    // }

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
        $venders = Vendor::all();
        $type_gs = Type_g::all();
        $solutions = Solution::all();
        $series = Series::all();
        $categorys = Category::all();
        $sub_categorys = Sub_category::all();
        $pdms = Pdm::all();
        $p_statuss = P_status::all();
        $unit_ps = Unit_p::all();               // ไม่มี ID
        $unit_types = Unit_type::all();         // ไม่มี ID
        $acctypes = Acctype::all();
        $conditions = Condition::all();
        $product_groups = ProductGroup::all();

        $allBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();
        $defaultBrands = MasterBrand::all();
        $brands = MasterBrand::all();

        // dd($series);
        if (in_array($userpermission, [$isSuperAdmin])) {
            $brands = MasterBrand::select(
                'BRAND')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();

            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->get();
        }
        else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP', 'Senior Executive - Product Development-OP', 'Assistant-Product-Manager-OP', 'Assistant Manager - Product Development-OP', 'Product Manager-OP'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            // ->where('BRAND', 'OP')
            ->where('BRAND', 'OP')
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
        } else if (in_array($userpermission, ['Marketing - CPS', 'Division Manager- Strategy & New Product Development-CPS', 'Department Manager - New Product Development Manager-CPS', 'Senior Executive - New Product Development-CPS', 'Senior Executive - Packaging Development-CPS', 'Senior Executive - Product Designer-CPS', 'Executive - New Product Development-CPS', 'MARKETING DIRECTOR-CPS', 'Department Manager - Marketing Support & Executive Assistant to Marketing Director-CPS', 'Department Manager - Category Manager-CPS'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $owners = Owner::select(
                'OWNER',
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
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
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
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->whereIn('BRAND', ['KTY', 'FR'])
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();

            // KTY ไม่มี Series, Category, Sub_category, Pdm
        } else if (in_array($userpermission, ['Regional Operation Manager-GNC'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'GNC')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
        } else if (in_array($userpermission, ['BB'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'BB')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
        } else if (in_array($userpermission, ['LL'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'LL')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
        } else if (in_array($userpermission, ['KM'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KM')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
        }

        // $productCodeMax = Product::max('seq');
        // $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        // $productCode = 'P'.sprintf('%05d', $productCodeNumber);
        // $list_position = position::select('id', 'name_position')->get();
        // dd($product_groups);

        return view('product.create', compact(  'brands', 'allBrands', 'defaultBrands', 'owners', 'grp_ps', 'brand_ps', 'venders', 'type_gs', 'solutions', 'series', 'categorys', 'sub_categorys', 'pdms', 'p_statuss', 'unit_ps', 'unit_types', 'acctypes', 'conditions', 'product_groups'));
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

        $venders = Vendor::all();
        $type_gs = Type_g::all();
        $solutions = Solution::all();
        $series = Series::all();
        $categorys = Category::all();
        $sub_categorys = Sub_category::all();
        $pdms = Pdm::all();
        $p_statuss = P_status::all();
        $unit_ps = Unit_p::all();               // ไม่มี ID
        $unit_types = Unit_type::all();         // ไม่มี ID
        $acctypes = Acctype::all();
        $conditions = Condition::all();

        $allBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();
        $defaultBrands = MasterBrand::all();
        $brands = MasterBrand::all();

        if (in_array($userpermission, [$isSuperAdmin])) {
            $brands = MasterBrand::select(
                'BRAND')
            ->get();
            $owners = Owner::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();

            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->get();
        }
        else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP', 'Senior Executive - Product Development-OP', 'Assistant-Product-Manager-OP', 'Assistant Manager - Product Development-OP', 'Product Manager-OP'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $owners = Owner::select(
                'OWNER',
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
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
        } else if (in_array($userpermission, ['Marketing - CPS', 'Division Manager- Strategy & New Product Development-CPS', 'Department Manager - New Product Development Manager-CPS', 'Senior Executive - New Product Development-CPS', 'Senior Executive - Packaging Development-CPS', 'Senior Executive - Product Designer-CPS', 'Executive - New Product Development-CPS', 'MARKETING DIRECTOR-CPS', 'Department Manager - Marketing Support & Executive Assistant to Marketing Director-CPS', 'Department Manager - Category Manager-CPS'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->whereIn('BRAND', ['CPS', 'KM'])
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
                ->whereIn('BRAND', ['CPS', 'KM'])
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
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
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();

            // KTY ไม่มี Series, Category, Sub_category, Pdm
        } else if (in_array($userpermission, ['BB'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'BB')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->whereIn('BRAND', ['BB', 'KM'])
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
                ->whereIn('BRAND', ['BB', 'KM'])
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
        } else if (in_array($userpermission, ['LL'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'LL')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->whereIn('BRAND', ['LL', 'KM'])
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
                ->whereIn('BRAND', ['LL', 'KM'])
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
        } else if (in_array($userpermission, ['Regional Operation Manager-GNC'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'GNC')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->whereIn('BRAND', ['GNC', 'KM'])
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
                ->whereIn('BRAND', ['GNC', 'KM'])
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
        } else if (in_array($userpermission, ['KM'])) {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KM')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            // ->where('BRAND', 'OP')
            ->whereIn('BRAND', ['KM'])
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
        }

        // dd($brands);
        return view('product.create_consumables', compact(  'brands', 'allBrands', 'defaultBrands', 'owners', 'grp_ps', 'brand_ps', 'venders', 'type_gs', 'solutions', 'series', 'categorys', 'sub_categorys', 'pdms', 'p_statuss', 'unit_ps', 'unit_types', 'acctypes', 'conditions'));
    }
    // public function productDetailCreate(Request $request)
    // {
    //     $productCodeMax = Product::max('seq');
    //     $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
    //     $productCode = 'P'.sprintf('%05d', $productCodeNumber);

    //     $list_position = position::select('id', 'name_position')->get();
    //     // dd($productCode);
    //     return view('product_detail.create', compact('productCode', 'list_position'));
    // }

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
                'BRAND' => $data->BRAND ?? '',
                'PRODUCT' => $request->BARCODE ?? '',
                'BARCODE' => $request->BARCODE ?? '',
                'COLOR' => $data->COLOR ?? '',
                'GRP_P' => $data->GRP_P ?? '',
                'SUPPLIER' => $data->SUPPLIER ?? '',
                'NAME_THAI' => $data->NAME_THAI ?? '',
                'NAME_ENG' => $data->NAME_ENG ?? '',
                'SHORT_THAI' => $data->SHORT_THAI ?? '',
                'SHORT_ENG' => $data->SHORT_ENG ?? '',
                'VENDOR' => $data->VENDOR ?? '',
                'PRICE' => $data->PRICE ?? '',
                'COST' => $data->COST ?? '',
                'UNIT' => $data->UNIT ?? '',
                'UNIT_Q' => $data->UNIT_Q ?? '',
                'SOLUTION' => $data->SOLUTION ?? '',
                'SERIES' => $data->SERIES ?? '',
                'CATEGORY' => $data->CATEGORY ?? '',
                'STATUS' => $data->STATUS ?? '',
                'S_CAT' => $data->S_CAT ?? '',
                'PDM_GROUP' => $data->PDM_GROUP ?? '',
                'BRAND_P' => $data->BRAND_P ?? '',
                'REGISTER' => $data->REGISTER ?? '',
                'OPT_TXT1' => $data->OPT_TXT1 ?? '',
                'CONDITION_SALE' => $data->CONDITION_SALE ?? '',
                'WHOLE_SALE' => $data->WHOLE_SALE ?? '',
                'GP' => $data->GP ?? '',
                'O_PRODUCT' => $data->O_PRODUCT ?? '',
                'BAR_PACK1' => $data->BAR_PACK1 ?? '',
                'BAR_PACK2' => $data->BAR_PACK2 ?? '',
                'BAR_PACK3' => $data->BAR_PACK3 ?? '',
                'BAR_PACK4' => $data->BAR_PACK4 ?? '',
                'PACK_SIZE1' => $data->PACK_SIZE1 ?? '',
                'PACK_SIZE2' => $data->PACK_SIZE2 ?? '',
                'PACK_SIZE3' => $data->PACK_SIZE3 ?? '',
                'PACK_SIZE4' => $data->PACK_SIZE4 ?? '',

                'REG_DATE' => date("Y/m/d h:i:s"),
                'AGE' => $data->AGE ?? '',
                'WIDTH' => $data->WIDTH ?? '',
                'HEIGHT' => $data->HEIGHT ?? '',
                'WIDE' => $data->WIDE ?? '',
                'NAME_EXP' => $data->NAME_EXP ?? '',
                'NET_WEIGHT' => $data->NET_WEIGHT ?? '',
                'UNIT_TYPE' => $data->UNIT_TYPE ?? '',
                'TYPE_G' => $data->TYPE_G ?? '',

                'OPT_DATE1' => $data->OPT_DATE1,
                'OPT_DATE2' => $data->OPT_DATE2,

                'OPT_TXT2' => $data->OPT_TXT2 ?? '',
                'OPT_NUM1' => $data->OPT_NUM1 ?? '',
                'OPT_NUM2' => $data->OPT_NUM2 ?? '',
                'ACC_TYPE' => $data->ACC_TYPE ?? '',
                'ACC_DT' => $data->ACC_DT ?? '',
                'RETURN' => is_null($data->RETURN) ? 'N' : 'Y',
                'NON_VAT' => is_null($data->NON_VAT) ? 'N' : 'Y',
                'STORAGE_TEMP' => is_null($data->STORAGE_TEMP) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($data->CONTROL_STK) ? 'N' : 'Y',
                'TESTER' =>  is_null($data->TESTER) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->username,
                'EDIT_DT' => date("Y/m/d h:i:s")
            ];

            $copyProductMaster = Product1::create($data_product);

            $craeteProductAccount = Account::updateOrCreate(['product' => $copyProductMaster->PRODUCT], [
                'COST' => $copyProductMaster->COST,
                'created_at' => date("Y/m/d h:i:s"),
            ]);

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

        $changeBrand = '';
        if ($dataProductBarcode->BRAND == 'OP' && (int) $request->NUMBER >= 20000 && (int) $request->NUMBER <= 28999) {
            $changeBrand = 'OP';
        } else if ($dataProductBarcode->BRAND == 'OP' && (int) $request->NUMBER >= 29000 && (int) $request->NUMBER <= 29699) {
            $changeBrand = 'RE';
        } else if ($dataProductBarcode->BRAND == 'OP' && (int) $request->NUMBER >= 29700 && (int) $request->NUMBER <= 29999) {
            $changeBrand = 'CM';
        } else if ($dataProductBarcode->BRAND == 'CPS') {
            $changeBrand = 'CP';
        }

        // dd($changeBrand);
        // dd($dataProductBarcode->BRAND);

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
                'BRAND' => $data->BRAND ?? '',
                'PRODUCT' => $dataProductBarcode->PRODUCT ?? '',
                'BARCODE' => $dataProductBarcode->BARCODE ?? '',
                'COLOR' => $data->COLOR ?? '',
                'GRP_P' => $changeBrand ?? '',
                'SUPPLIER' => $data->SUPPLIER ?? '',
                'NAME_THAI' => $data->NAME_THAI ?? '',
                'NAME_ENG' => $data->NAME_ENG ?? '',
                'SHORT_THAI' => $data->SHORT_THAI ?? '',
                'SHORT_ENG' => $data->SHORT_ENG ?? '',
                'VENDOR' => $data->VENDOR ?? '',
                'PRICE' => $data->PRICE ?? '',
                'COST' => $data->COST ?? '',
                'UNIT' => $data->UNIT ?? '',
                'UNIT_Q' => $data->UNIT_Q ?? '',
                'SOLUTION' => $data->SOLUTION ?? '',
                'SERIES' => $data->SERIES ?? '',
                'CATEGORY' => $data->CATEGORY ?? '',
                'STATUS' => $data->STATUS ?? '',
                'S_CAT' => $data->S_CAT ?? '',
                'PDM_GROUP' => $data->PDM_GROUP ?? '',
                'BRAND_P' => $data->BRAND_P ?? '',
                'REGISTER' => $data->REGISTER ?? '',
                'OPT_TXT1' => $data->OPT_TXT1 ?? '',
                'CONDITION_SALE' => $data->CONDITION_SALE ?? '',
                'WHOLE_SALE' => $data->WHOLE_SALE ?? '',
                'GP' => $data->GP ?? '',
                'O_PRODUCT' => $data->O_PRODUCT ?? '',
                'BAR_PACK1' => $data->BAR_PACK1 ?? '',
                'BAR_PACK2' => $data->BAR_PACK2 ?? '',
                'BAR_PACK3' => $data->BAR_PACK3 ?? '',
                'BAR_PACK4' => $data->BAR_PACK4 ?? '',
                'PACK_SIZE1' => $data->PACK_SIZE1 ?? '',
                'PACK_SIZE2' => $data->PACK_SIZE2 ?? '',
                'PACK_SIZE3' => $data->PACK_SIZE3 ?? '',
                'PACK_SIZE4' => $data->PACK_SIZE4 ?? '',

                'REG_DATE' => date("Y/m/d h:i:s"),

                'AGE' => $data->AGE ?? '',
                'WIDTH' => $data->WIDTH ?? '',
                'HEIGHT' => $data->HEIGHT ?? '',
                'WIDE' => $data->WIDE ?? '',
                'NAME_EXP' => $data->NAME_EXP ?? '',
                'NET_WEIGHT' => $data->NET_WEIGHT ?? '',
                'UNIT_TYPE' => $data->UNIT_TYPE ?? '',
                'TYPE_G' => $data->TYPE_G ?? '',

                'OPT_DATE1' => $data->OPT_DATE1,
                'OPT_DATE2' => $data->OPT_DATE2,

                'OPT_TXT2' => $data->OPT_TXT2 ?? '',
                'OPT_NUM1' => $data->OPT_NUM1 ?? '',
                'OPT_NUM2' => $data->OPT_NUM2 ?? '',
                'ACC_TYPE' => $data->ACC_TYPE ?? '',
                'ACC_DT' => $data->ACC_DT ?? '',
                'RETURN' => is_null($data->RETURN) ? 'N' : 'Y',
                'NON_VAT' => is_null($data->NON_VAT) ? 'N' : 'Y',
                'STORAGE_TEMP' => is_null($data->STORAGE_TEMP) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($data->CONTROL_STK) ? 'N' : 'Y',
                'TESTER' =>  is_null($data->TESTER) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->username,
                'EDIT_DT' => date("Y/m/d h:i:s")
            ];

            $copyProductMaster = Product1::create($data_product);

            $craeteProductAccount = Account::updateOrCreate(['product' => $copyProductMaster->PRODUCT], [
                'COST' => $copyProductMaster->COST,
                'created_at' => date("Y/m/d h:i:s"),
            ]);

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
        // dd($request);
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
        DB::beginTransaction();
        try {

            // dd($request->GRP_P);
            // if($request->GRP_P) {
            //     $productCodeMax = Barcode::max('NUMBER');
            //     if ($request->BRAND == 'RE') {
            //         $productCodeMax = Barcode::where('COMPANY', '=', 'OP')->where('STATUS', '=', 'RE')->max('NUMBER');
            //     }
            //     $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
            //     $productCode = $productCodeNumber;

            //     $data_BRAND = Barcode::updateOrCreate(['BRAND' => $request->BRAND], [
            //         'NUMBER' => $productCode
            //     ]);
            // }
            // if($request->GRP_P) {
            //     $productCodeMax = Document::max('NUMBER');
            //     if ($request->BRAND == 'RE') {
            //         $productCodeMax = Document::where('COMPANY', '=', 'OP')->where('STATUS', '=', 'RE')->max('NUMBER');
            //     }
            //     $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
            //     $productCode = $productCodeNumber;

            //     $data_BRAND = Document::updateOrCreate(['BRAND' => $request->BRAND], [
            //         'NUMBER' => $productCode
            //     ]);
            // }

            $data_product = [
                'BRAND' => $request->input('BRAND') ?? '',
                // 'BRAND' => $request->input('BRAND') ?? '',
                'PRODUCT' => $dataProductBarcode->PRODUCT,
                'BARCODE' => $dataProductBarcode->BARCODE,
                'COLOR' => $request->input('COLOR') ?? '',
                'GRP_P' => $request->input('GRP_P') ?? '',
                'SUPPLIER' => $request->input('SUPPLIER') ?? '',
                'NAME_THAI' => $request->input('NAME_THAI') ?? '',
                'NAME_ENG' => $request->input('NAME_ENG') ?? '',
                'SHORT_THAI' => $request->input('SHORT_THAI') ?? '',
                'SHORT_ENG' => $request->input('SHORT_ENG') ?? '',
                'VENDOR' => $request->input('VENDOR') ?? '',
                'PRICE' => $request->input('PRICE') ?? '',
                'COST' => $request->input('COST') ?? '',
                'UNIT' => $request->input('UNIT') ?? '',
                'UNIT_Q' => $request->input('UNIT_Q') ?? '',
                'SOLUTION' => $request->input('SOLUTION') ?? '',
                'SERIES' => $request->input('SERIES') ?? '',
                'CATEGORY' => $request->input('CATEGORY') ?? '',
                'STATUS' => $request->input('STATUS') ?? '',
                'S_CAT' => $request->input('S_CAT') ?? '',
                'PDM_GROUP' => $request->input('PDM_GROUP') ?? '',
                'BRAND_P' => $request->input('BRAND_P') ?? '',

                'REGISTER' => $request->input('REGISTER') ?? '',

                'OPT_TXT1' => $request->input('OPT_TXT1') ?? '',
                'CONDITION_SALE' => $request->input('CONDITION_SALE') ?? '',
                'WHOLE_SALE' => $request->input('WHOLE_SALE') ?? '',
                'GP' => $request->input('GP') ?? '',
                'O_PRODUCT' => $request->input('O_PRODUCT') ?? '',
                'BAR_PACK1' => $request->input('BAR_PACK1') ?? '',
                'BAR_PACK2' => $request->input('BAR_PACK2') ?? '',
                'BAR_PACK3' => $request->input('BAR_PACK3') ?? '',
                'BAR_PACK4' => $request->input('BAR_PACK4') ?? '',
                'PACK_SIZE1' => $request->input('PACK_SIZE1') ?? '',
                'PACK_SIZE2' => $request->input('PACK_SIZE2') ?? '',
                'PACK_SIZE3' => $request->input('PACK_SIZE3') ?? '',
                'PACK_SIZE4' => $request->input('PACK_SIZE4') ?? '',
                'REG_DATE' => date("Y/m/d h:i:s") ?? '',
                'AGE' => $request->input('AGE') ?? '',
                'WIDTH' => $request->input('WIDTH') ?? '',
                'HEIGHT' => $request->input('HEIGHT') ?? '',
                'WIDE' => $request->input('WIDE') ?? '',
                'NAME_EXP' => $request->input('NAME_EXP') ?? '',
                'NET_WEIGHT' => $request->input('NET_WEIGHT') ?? '',
                'UNIT_TYPE' => $request->input('UNIT_TYPE') ?? '',
                // 'TYPE_G' => $request->input('TYPE_G') ?? '',

                'OPT_DATE1' => $request->input('OPT_DATE1') ?? '',
                'OPT_DATE2' => $request->input('OPT_DATE2') ?? '',
                
                'OPT_TXT2' => $request->input('OPT_TXT2') ?? '',
                'OPT_NUM1' => $request->input('OPT_NUM1') ?? '',
                'OPT_NUM2' => $request->input('OPT_NUM2') ?? '',
                // 'ACC_TYPE' => $request->input('ACC_TYPE') ?? '',
                'ACC_DT' => $request->input('ACC_DT') ?? '',
                'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                'NON_VAT' => is_null($request->input('NON_VAT')) ? 'N' : 'Y',
                'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->username,
                'EDIT_DT' => date("Y-m-d"),
                'STATUS_EDIT_DT' => '',
            ];

            $productMaster = Product1::create($data_product);

            $craeteProductAccount = Account::updateOrCreate(['product' => $productMaster->PRODUCT], [
                'COST' => $productMaster->COST,
                'created_at' => date("Y/m/d H:i:s"),
            ]);

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

        // dd($request);
        DB::beginTransaction();
        try {
            $data_product = [
                'BRAND' => $request->input('BRAND') ?? '',
                // 'BRAND' => $description,
                'PRODUCT' => $request->input('PRODUCT') ?? '',
                'BARCODE' => $request->input('PRODUCT') ?? '',
                'COLOR' => $request->input('COLOR') ?? '',
                'GRP_P' => $request->input('GRP_P') ?? '',
                'SUPPLIER' => $request->input('SUPPLIER') ?? '',
                'NAME_THAI' => $request->input('NAME_THAI') ?? '',
                'NAME_ENG' => $request->input('NAME_ENG') ?? '',
                'SHORT_THAI' => $request->input('SHORT_THAI') ?? '',
                'SHORT_ENG' => $request->input('SHORT_ENG') ?? '',
                'VENDOR' => $request->input('VENDOR') ?? '',
                'PRICE' => $request->input('PRICE') ?? '',
                'COST' => $request->input('COST') ?? '',
                'UNIT' => $request->input('UNIT') ?? '',
                'UNIT_Q' => $request->input('UNIT_Q') ?? '',
                'SOLUTION' => $request->input('SOLUTION') ?? '',
                'SERIES' => $request->input('SERIES') ?? '',
                'CATEGORY' => $request->input('CATEGORY') ?? '',
                'STATUS' => $request->input('STATUS') ?? '',
                'S_CAT' => $request->input('S_CAT') ?? '',
                'PDM_GROUP' => $request->input('PDM_GROUP') ?? '',
                'BRAND_P' => $request->input('BRAND_P') ?? '',
                'REGISTER' => $request->input('REGISTER') ?? '',
                'OPT_TXT1' => $request->input('OPT_TXT1') ?? '',
                'CONDITION_SALE' => $request->input('CONDITION_SALE') ?? '',
                'WHOLE_SALE' => $request->input('WHOLE_SALE') ?? '',
                'GP' => $request->input('GP') ?? '',
                'O_PRODUCT' => $request->input('O_PRODUCT') ?? '',
                'BAR_PACK1' => $request->input('BAR_PACK1') ?? '',
                'BAR_PACK2' => $request->input('BAR_PACK2') ?? '',
                'BAR_PACK3' => $request->input('BAR_PACK3') ?? '',
                'BAR_PACK4' => $request->input('BAR_PACK4') ?? '',
                'PACK_SIZE1' => $request->input('PACK_SIZE1') ?? '',
                'PACK_SIZE2' => $request->input('PACK_SIZE2') ?? '',
                'PACK_SIZE3' => $request->input('PACK_SIZE3') ?? '',
                'PACK_SIZE4' => $request->input('PACK_SIZE4') ?? '',
                'REG_DATE' => date("Y/m/d h:i:s"),
                'AGE' => $request->input('AGE') ?? '',
                'WIDTH' => $request->input('WIDTH') ?? '',
                'HEIGHT' => $request->input('HEIGHT') ?? '',
                'WIDE' => $request->input('WIDE') ?? '',
                'NAME_EXP' => $request->input('NAME_EXP') ?? '',
                'NET_WEIGHT' => $request->input('NET_WEIGHT') ?? '',
                'UNIT_TYPE' => $request->input('UNIT_TYPE') ?? '',
                'TYPE_G' => $request->input('TYPE_G') ?? '',
                'OPT_DATE1' => $request->input('OPT_DATE1') ?? '',
                'OPT_DATE2' => $request->input('OPT_DATE2') ?? '',
                'OPT_TXT2' => $request->input('OPT_TXT2') ?? '',
                'OPT_NUM1' => $request->input('OPT_NUM1') ?? '',
                'OPT_NUM2' => $request->input('OPT_NUM2') ?? '',
                'ACC_TYPE' => $request->input('ACC_TYPE') ?? '',
                'ACC_DT' => $request->input('ACC_DT') ?? '',
                'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                'NON_VAT' => is_null($request->input('NON_VAT')) ? 'N' : 'Y',
                'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->username,
                'EDIT_DT' => date("Y-m-d"),
                'STATUS_EDIT_DT' => '',
                
            ];

            $productMaster = Product1::create($data_product);

            if (!is_null($request->sele_channel[0])) {

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

            $craeteProductAccount = Account::updateOrCreate(['product' => $productMaster->PRODUCT], [
                'COST' => $productMaster->COST,
                'created_at' => date("Y/m/d H:i:s"),
            ]);
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
            // 'owners.OWNER AS VENDOR',
            // 'grp_ps.GRP_P AS GRP_P',
            // 'brand_ps.ID AS BRAND_P',
            // 'vendors.VEN_NTHAI'
            // 'type_gs.ID AS TYPE_G',
            // 'solutions.ID AS SOLUTION',
            // 'series.ID AS SERIES',
            // 'categories.ID AS CATEGORY',
            // 'sub_categories.ID AS S_CAT',
            // 'pdms.ID AS PDM_GROUP',
            // 'p_statuses.ID AS STATUS',
            // 'unit_ps.DESCRIPTION AS UNIT',
            // 'unit_types.DESCRIPTION AS UNIT_TYPE',
            // 'acctypes.ID AS ACC_TYPE',
            // 'conditions.ID AS CONDITION_SALE'
        )
        ->leftJoin('owners', 'product1s.VENDOR', '=', 'owners.OWNER')
        ->leftJoin('grp_ps', 'product1s.GRP_P', '=', 'grp_ps.GRP_P')
        ->leftJoin('brand_ps', 'product1s.BRAND_P', '=', 'brand_ps.ID')
        // ->leftJoin('vendors', 'product1s.SUPPLIER', '=', 'vendors.VEN_ID')
        ->leftJoin('type_gs', 'product1s.TYPE_G', '=', 'type_gs.ID')
        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
        ->leftJoin('pdms', 'product1s.PDM_GROUP', '=', 'pdms.ID')
        ->leftJoin('p_statuses', 'product1s.STATUS', '=', 'p_statuses.ID')
        ->leftJoin('unit_ps', 'product1s.UNIT', '=', 'unit_ps.DESCRIPTION')
        ->leftJoin('unit_types', 'product1s.UNIT_TYPE', '=', 'unit_types.DESCRIPTION')
        ->leftJoin('acctypes', 'product1s.ACC_TYPE', '=', 'acctypes.ID')
        ->leftJoin('conditions', 'product1s.CONDITION_SALE', '=', 'conditions.ID')
        ->firstWhere('product1s.PRODUCT', '=', $PRODUCT);

        $data->REG_DATE = date('Y-m-d', strtotime($data->REG_DATE));
        // dd($data);

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        $owners = Owner::select('OWNER AS VENDOR', 'REMARK')->get()->toArray();
        $grp_ps = Grp_p::select('GRP_P AS GRP_P', 'REMARK')->get()->toArray();
       
        // dd($owners);
        $brand_ps = Brand_p::select('ID AS BRAND_P', 'REMARK', 'BRAND')->get()->toArray();

        $venders = Vendor::select('VEN_ID AS SUPPLIER', 'VEN_NTHAI')->get()->toArray();

        // dd($venders);
        // dd(!in_array($data->SUPPLIER, array_column($venders, 'SUPPLIER')));
        if (!in_array($data->SUPPLIER, array_column($venders, 'SUPPLIER')))
        {
            $venders[] =  [
                'SUPPLIER' => $data->SUPPLIER,
                'VEN_NTHAI' => $data->SUPPLIER,
            ];
        } 

        // dd($data->SUPPLIER);
        $type_gs = Type_g::select('ID AS TYPE_G', 'DESCRIPTION')->get();
        $solutions = Solution::select('ID AS SOLUTION', 'DESCRIPTION')->get()->toArray();
        $series = Series::select('ID AS SERIES', 'DESCRIPTION')->get()->toArray();
        $categorys = Category::select('ID AS CATEGORY', 'DESCRIPTION')->get()->toArray();
        $sub_categorys = Sub_category::select('ID AS S_CAT', 'DESCRIPTION')->get()->toArray();
        $pdms = Pdm::select('ID AS PDM_GROUP', 'REMARK')->get()->toArray();
        $p_statuss = P_status::select('ID AS STATUS', 'DESCRIPTION')->get()->toArray();

        if (!in_array($data->STATUS, array_column($p_statuss, 'STATUS')))
        {
            $p_statuss[] =  [
                'STATUS' => $data->STATUS,
                'DESCRIPTION' => $data->STATUS,
            ];
        } 

        // $unit_ps = Unit_p::all();
        $unit_ps = Unit_p::select('DESCRIPTION AS UNIT', 'BRAND')->get()->toArray();
        $unit_types = Unit_type::select('DESCRIPTION AS UNIT_TYPE', 'BRAND')->get()->toArray();
        $acctypes = Acctype::select('ID AS ACC_TYPE', 'DESCRIPTION')->get();
        $conditions = Condition::select('ID AS CONDITION_SALE', 'DESCRIPTION')->get()->toArray();

        if (!in_array($data->CONDITION_SALE, array_column($conditions, 'CONDITION_SALE')))
        {
            $conditions[] =  [
                'CONDITION_SALE' => $data->CONDITION_SALE,
                'DESCRIPTION' => $data->CONDITION_SALE,
            ];
        } 

        $multiChannels = ProductChannel::select('BRAND')->where('PRODUCT', '=', $PRODUCT)->pluck('BRAND')->toArray();
        $allBrands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();
        $defaultBrands = MasterBrand::all();
        $brands = MasterBrand::all();

        if ($userpermission == $isSuperAdmin) {
            $brands = MasterBrand::select(
                'BRAND')
            ->get();
            $owners = Owner::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->get();
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK')
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->get();

            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->get();
        } else if ($userpermission == 'OP') {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'OP')
            ->get();
            $owners = Owner::select(
                'OWNER AS VENDOR',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();
            if (!in_array($data->VENDOR, array_column($owners, 'VENDOR')))
            {
                $owners[] =  [
                    'VENDOR' => $data->VENDOR,
                    'REMARK' => $data->VENDOR,
                ];
            } 
            $grp_ps = Grp_p::select(
                'GRP_P AS GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();
            if (!in_array($data->GRP_P, array_column($grp_ps, 'GRP_P')))
            {
                $grp_ps[] =  [
                    'GRP_P' => $data->GRP_P,
                    'REMARK' => $data->GRP_P,
                ];
            }
            $brand_ps = Brand_p::select(
                'ID AS BRAND_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();
            if (!in_array($data->BRAND_P, array_column($brand_ps, 'BRAND_P')))
            {
                $brand_ps[] =  [
                    'BRAND_P' => $data->BRAND_P,
                    'REMARK' => $data->BRAND_P,
                ];
            }
            $solutions = Solution::select(
                'ID AS SOLUTION',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();
            if (!in_array($data->SOLUTION, array_column($solutions, 'SOLUTION')))
            {
                $solutions[] =  [
                    'SOLUTION' => $data->SOLUTION,
                    'DESCRIPTION' => $data->SOLUTION,
                ];
            }
            $series = Series::select(
                'ID AS SERIES',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();
            if (!in_array($data->SERIES, array_column($series, 'SERIES')))
            {
                $series[] =  [
                    'SERIES' => $data->SERIES,
                    'DESCRIPTION' => $data->SERIES,
                ];
            }
            $categorys = Category::select(
                'ID AS CATEGORY',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();
            if (!in_array($data->CATEGORY, array_column($categorys, 'CATEGORY')))
            {
                $categorys[] =  [
                    'CATEGORY' => $data->CATEGORY,
                    'DESCRIPTION' => $data->CATEGORY,
                ];
            }
            $sub_categorys = Sub_category::select(
                'ID AS S_CAT',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();
            if (!in_array($data->S_CAT, array_column($sub_categorys, 'S_CAT')))
            {
                $sub_categorys[] =  [
                    'S_CAT' => $data->S_CAT,
                    'DESCRIPTION' => $data->S_CAT,
                ];
            }
            $pdms = Pdm::select(
                'ID AS PDM_GROUP',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();
            if (!in_array($data->PDM_GROUP, array_column($pdms, 'PDM_GROUP')))
            {
                $pdms[] =  [
                    'PDM_GROUP' => $data->PDM_GROUP,
                    'REMARK' => $data->PDM_GROUP,
                ];
            }
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();
            if (!in_array($data->UNIT, array_column($unit_ps, 'UNIT')))
            {
                $unit_ps[] =  [
                    'UNIT' => $data->UNIT,
                ];
            }
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();
            if (!in_array($data->UNIT_TYPE, array_column($unit_types, 'UNIT_TYPE')))
            {
                $unit_types[] =  [
                    'UNIT_TYPE' => $data->UNIT_TYPE,
                ];
            }
        } else if ($userpermission == 'CPS') {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
            $owners = Owner::select(
                'OWNER AS VENDOR',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get()->toArray();
            if (!in_array($data->VENDOR, array_column($owners, 'VENDOR')))
            {
                $owners[] =  [
                    'VENDOR' => $data->VENDOR,
                    'REMARK' => $data->VENDOR,
                ];
            } 
            $grp_ps = Grp_p::select(
                'GRP_P AS GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get()->toArray();
            if (!in_array($data->GRP_P, array_column($grp_ps, 'GRP_P')))
            {
                $grp_ps[] =  [
                    'GRP_P' => $data->GRP_P,
                    'REMARK' => $data->GRP_P,
                ];
            } 
            $brand_ps = Brand_p::select(
                'ID AS BRAND_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get()->toArray();
            if (!in_array($data->BRAND_P, array_column($brand_ps, 'BRAND_P')))
            {
                $brand_ps[] =  [
                    'BRAND_P' => $data->BRAND_P,
                    'REMARK' => $data->BRAND_P,
                ];
            }
            $solutions = Solution::select(
                'ID AS SOLUTION',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get()->toArray();
            if (!in_array($data->SOLUTION, array_column($solutions, 'SOLUTION')))
            {
                $solutions[] =  [
                    'SOLUTION' => $data->SOLUTION,
                    'DESCRIPTION' => $data->SOLUTION,
                ];
            }
            $series = Series::select(
                'ID AS SERIES',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get()->toArray();
            if (!in_array($data->SERIES, array_column($series, 'SERIES')))
            {
                $series[] =  [
                    'SERIES' => $data->SERIES,
                    'DESCRIPTION' => $data->SERIES,
                ];
            }
            $categorys = Category::select(
                'ID AS CATEGORY',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get()->toArray();
            if (!in_array($data->CATEGORY, array_column($categorys, 'CATEGORY')))
            {
                $categorys[] =  [
                    'CATEGORY' => $data->CATEGORY,
                    'DESCRIPTION' => $data->CATEGORY,
                ];
            }
            $sub_categorys = Sub_category::select(
                'ID AS S_CAT',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get()->toArray();
            if (!in_array($data->S_CAT, array_column($sub_categorys, 'S_CAT')))
            {
                $sub_categorys[] =  [
                    'S_CAT' => $data->S_CAT,
                    'DESCRIPTION' => $data->S_CAT,
                ];
            }
            $pdms = Pdm::select(
                'ID AS PDM_GROUP',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get()->toArray();
            if (!in_array($data->PDM_GROUP, array_column($pdms, 'PDM_GROUP')))
            {
                $pdms[] =  [
                    'PDM_GROUP' => $data->PDM_GROUP,
                    'REMARK' => $data->PDM_GROUP,
                ];
            }
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get()->toArray();
            if (!in_array($data->UNIT, array_column($unit_ps, 'UNIT')))
            {
                $unit_ps[] =  [
                    'UNIT' => $data->UNIT,
                ];
            }
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get()->toArray();
            if (!in_array($data->UNIT_TYPE, array_column($unit_types, 'UNIT_TYPE')))
            {
                $unit_types[] =  [
                    'UNIT_TYPE' => $data->UNIT_TYPE,
                ];
            }
        } else if ($userpermission == 'KTY') {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KTY')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get();
            $owners = Owner::select(
                'OWNER AS VENDOR',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get()->toArray();
            if (!in_array($data->VENDOR, array_column($owners, 'VENDOR')))
            {
                $owners[] =  [
                    'VENDOR' => $data->VENDOR,
                    'REMARK' => $data->VENDOR,
                ];
            } 
            $grp_ps = Grp_p::select(
                'GRP_P AS GRP_P',
                'REMARK',
                'BRAND')
            ->whereIn('BRAND', ['KTY', 'FR'])
            ->get()->toArray();
            if (!in_array($data->GRP_P, array_column($grp_ps, 'GRP_P')))
            {
                $grp_ps[] =  [
                    'GRP_P' => $data->GRP_P,
                    'REMARK' => $data->GRP_P,
                ];
            } 
            $brand_ps = Brand_p::select(
                'ID AS BRAND_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get()->toArray();
            if (!in_array($data->BRAND_P, array_column($brand_ps, 'BRAND_P')))
            {
                $brand_ps[] =  [
                    'BRAND_P' => $data->BRAND_P,
                    'REMARK' => $data->BRAND_P,
                ];
            }
            $solutions = Solution::select(
                'ID AS SOLUTION',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get()->toArray();
            if (!in_array($data->SOLUTION, array_column($solutions, 'SOLUTION')))
            {
                $solutions[] =  [
                    'SOLUTION' => $data->SOLUTION,
                    'DESCRIPTION' => $data->SOLUTION,
                ];
            }
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'KTY')
            ->get()->toArray();
            if (!in_array($data->UNIT_TYPE, array_column($unit_types, 'UNIT_TYPE')))
            {
                $unit_types[] =  [
                    'UNIT_TYPE' => $data->UNIT_TYPE,
                ];
            }
            // KTY ไม่มี Series, Category, Sub_category, Pdm
        } else if ($userpermission == 'GNC') {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'GNC')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
            $owners = Owner::select(
                'OWNER AS VENDOR',
                'REMARK',
                'BRAND')
            // ->where('BRAND', 'GNC')
            ->where('BRAND', 'GNC')
            ->get()->toArray();
            if (!in_array($data->VENDOR, array_column($owners, 'VENDOR')))
            {
                $owners[] =  [
                    'VENDOR' => $data->VENDOR,
                    'REMARK' => $data->VENDOR,
                ];
            } 
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get()->toArray();
            if (!in_array($data->GRP_P, array_column($grp_ps, 'GRP_P')))
            {
                $grp_ps[] =  [
                    'GRP_P' => $data->GRP_P,
                    'REMARK' => $data->GRP_P,
                ];
            }
            $brand_ps = Brand_p::select(
                'ID AS BRAND_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'GNC')
           ->get()->toArray();
            if (!in_array($data->BRAND_P, array_column($brand_ps, 'BRAND_P')))
            {
                $brand_ps[] =  [
                    'BRAND_P' => $data->BRAND_P,
                    'REMARK' => $data->BRAND_P,
                ];
            }
            $solutions = Solution::select(
                'ID AS SOLUTION',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get()->toArray();
            if (!in_array($data->SOLUTION, array_column($solutions, 'SOLUTION')))
            {
                $solutions[] =  [
                    'SOLUTION' => $data->SOLUTION,
                    'DESCRIPTION' => $data->SOLUTION,
                ];
            }
            $series = Series::select(
                'ID AS SERIES',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get()->toArray();
            if (!in_array($data->SERIES, array_column($series, 'SERIES')))
            {
                $series[] =  [
                    'SERIES' => $data->SERIES,
                    'DESCRIPTION' => $data->SERIES,
                ];
            }
            $categorys = Category::select(
                'ID AS CATEGORY',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get()->toArray();
            if (!in_array($data->CATEGORY, array_column($categorys, 'CATEGORY')))
            {
                $categorys[] =  [
                    'CATEGORY' => $data->CATEGORY,
                    'DESCRIPTION' => $data->CATEGORY,
                ];
            }
            $sub_categorys = Sub_category::select(
                'ID AS S_CAT',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get()->toArray();
            if (!in_array($data->S_CAT, array_column($sub_categorys, 'S_CAT')))
            {
                $sub_categorys[] =  [
                    'S_CAT' => $data->S_CAT,
                    'DESCRIPTION' => $data->S_CAT,
                ];
            }
            $pdms = Pdm::select(
                'ID AS PDM_GROUP',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get()->toArray();
            if (!in_array($data->PDM_GROUP, array_column($pdms, 'PDM_GROUP')))
            {
                $pdms[] =  [
                    'PDM_GROUP' => $data->PDM_GROUP,
                    'REMARK' => $data->PDM_GROUP,
                ];
            }
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get()->toArray();
            if (!in_array($data->UNIT, array_column($unit_ps, 'UNIT')))
            {
                $unit_ps[] =  [
                    'UNIT' => $data->UNIT,
                ];
            }
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get()->toArray();
            if (!in_array($data->UNIT_TYPE, array_column($unit_types, 'UNIT_TYPE')))
            {
                $unit_types[] =  [
                    'UNIT_TYPE' => $data->UNIT_TYPE,
                ];
            }
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', 'GNC')
            ->get();
        } else if ($userpermission == 'BB') {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'BB')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
            $owners = Owner::select(
                'OWNER AS VENDOR',
                'REMARK',
                'BRAND')
            // ->where('BRAND', 'OP')
            ->where('BRAND', 'BB')
            ->get()->toArray();
            if (!in_array($data->VENDOR, array_column($owners, 'VENDOR')))
            {
                $owners[] =  [
                    'VENDOR' => $data->VENDOR,
                    'REMARK' => $data->VENDOR,
                ];
            } 
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get()->toArray();
            if (!in_array($data->GRP_P, array_column($grp_ps, 'GRP_P')))
            {
                $grp_ps[] =  [
                    'GRP_P' => $data->GRP_P,
                    'REMARK' => $data->GRP_P,
                ];
            } 
            $brand_ps = Brand_p::select(
                'ID AS BRAND_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get()->toArray();
            if (!in_array($data->BRAND_P, array_column($brand_ps, 'BRAND_P')))
            {
                $brand_ps[] =  [
                    'BRAND_P' => $data->BRAND_P,
                    'REMARK' => $data->BRAND_P,
                ];
            }
            $solutions = Solution::select(
                'ID AS SOLUTION',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get()->toArray();
            if (!in_array($data->SOLUTION, array_column($solutions, 'SOLUTION')))
            {
                $solutions[] =  [
                    'SOLUTION' => $data->SOLUTION,
                    'DESCRIPTION' => $data->SOLUTION,
                ];
            }
            $series = Series::select(
                'ID AS SERIES',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get()->toArray();
            if (!in_array($data->SERIES, array_column($series, 'SERIES')))
            {
                $series[] =  [
                    'SERIES' => $data->SERIES,
                    'DESCRIPTION' => $data->SERIES,
                ];
            }
            $categorys = Category::select(
                'ID AS CATEGORY',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get()->toArray();
            if (!in_array($data->CATEGORY, array_column($categorys, 'CATEGORY')))
            {
                $categorys[] =  [
                    'CATEGORY' => $data->CATEGORY,
                    'DESCRIPTION' => $data->CATEGORY,
                ];
            }
            $sub_categorys = Sub_category::select(
                'ID AS S_CAT',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get()->toArray();
            if (!in_array($data->S_CAT, array_column($sub_categorys, 'S_CAT')))
            {
                $sub_categorys[] =  [
                    'S_CAT' => $data->S_CAT,
                    'DESCRIPTION' => $data->S_CAT,
                ];
            }
            $pdms = Pdm::select(
                'ID AS PDM_GROUP',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get()->toArray();
            if (!in_array($data->PDM_GROUP, array_column($pdms, 'PDM_GROUP')))
            {
                $pdms[] =  [
                    'PDM_GROUP' => $data->PDM_GROUP,
                    'REMARK' => $data->PDM_GROUP,
                ];
            }
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get()->toArray();
            if (!in_array($data->UNIT, array_column($unit_ps, 'UNIT')))
            {
                $unit_ps[] =  [
                    'UNIT' => $data->UNIT,
                ];
            }
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get()->toArray();
            if (!in_array($data->UNIT_TYPE, array_column($unit_types, 'UNIT_TYPE')))
            {
                $unit_types[] =  [
                    'UNIT_TYPE' => $data->UNIT_TYPE,
                ];
            }
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', 'BB')
            ->get();
        } else if ($userpermission == 'LL') {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'LL')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
            $owners = Owner::select(
                'OWNER AS VENDOR',
                'REMARK',
                'BRAND')
            // ->where('BRAND', 'OP')
            ->where('BRAND', 'LL')
            ->get()->toArray();
            if (!in_array($data->VENDOR, array_column($owners, 'VENDOR')))
            {
                $owners[] =  [
                    'VENDOR' => $data->VENDOR,
                    'REMARK' => $data->VENDOR,
                ];
            } 
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get()->toArray();
            if (!in_array($data->GRP_P, array_column($grp_ps, 'GRP_P')))
            {
                $grp_ps[] =  [
                    'GRP_P' => $data->GRP_P,
                    'REMARK' => $data->GRP_P,
                ];
            }
            $brand_ps = Brand_p::select(
                'ID AS BRAND_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get()->toArray();
            if (!in_array($data->BRAND_P, array_column($brand_ps, 'BRAND_P')))
            {
                $brand_ps[] =  [
                    'BRAND_P' => $data->BRAND_P,
                    'REMARK' => $data->BRAND_P,
                ];
            }
            $solutions = Solution::select(
                'ID AS SOLUTION',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get()->toArray();
            if (!in_array($data->SOLUTION, array_column($solutions, 'SOLUTION')))
            {
                $solutions[] =  [
                    'SOLUTION' => $data->SOLUTION,
                    'DESCRIPTION' => $data->SOLUTION,
                ];
            }
            $series = Series::select(
                'ID AS SERIES',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get()->toArray();
            if (!in_array($data->SERIES, array_column($series, 'SERIES')))
            {
                $series[] =  [
                    'SERIES' => $data->SERIES,
                    'DESCRIPTION' => $data->SERIES,
                ];
            }
            $categorys = Category::select(
                'ID AS CATEGORY',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get()->toArray();
            if (!in_array($data->CATEGORY, array_column($categorys, 'CATEGORY')))
            {
                $categorys[] =  [
                    'CATEGORY' => $data->CATEGORY,
                    'DESCRIPTION' => $data->CATEGORY,
                ];
            }
            $sub_categorys = Sub_category::select(
                'ID AS S_CAT',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get()->toArray();
            if (!in_array($data->S_CAT, array_column($sub_categorys, 'S_CAT')))
            {
                $sub_categorys[] =  [
                    'S_CAT' => $data->S_CAT,
                    'DESCRIPTION' => $data->S_CAT,
                ];
            }
            $pdms = Pdm::select(
                'ID AS PDM_GROUP',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get()->toArray();
            if (!in_array($data->PDM_GROUP, array_column($pdms, 'PDM_GROUP')))
            {
                $pdms[] =  [
                    'PDM_GROUP' => $data->PDM_GROUP,
                    'REMARK' => $data->PDM_GROUP,
                ];
            }
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get()->toArray();
            if (!in_array($data->UNIT, array_column($unit_ps, 'UNIT')))
            {
                $unit_ps[] =  [
                    'UNIT' => $data->UNIT,
                ];
            }
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get()->toArray();
            if (!in_array($data->UNIT_TYPE, array_column($unit_types, 'UNIT_TYPE')))
            {
                $unit_types[] =  [
                    'UNIT_TYPE' => $data->UNIT_TYPE,
                ];
            }
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', 'LL')
            ->get();
        } else if ($userpermission == 'KM') {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KM')
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            // ->where('BRAND', 'OP')
            ->where('BRAND', 'KM')
            ->get()->toArray();
            if (!in_array($data->VENDOR, array_column($owners, 'VENDOR')))
            {
                $owners[] =  [
                    'VENDOR' => $data->VENDOR,
                    'REMARK' => $data->VENDOR,
                ];
            } 
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get()->toArray();
            if (!in_array($data->GRP_P, array_column($grp_ps, 'GRP_P')))
            {
                $grp_ps[] =  [
                    'GRP_P' => $data->GRP_P,
                    'REMARK' => $data->GRP_P,
                ];
            }
            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get()->toArray();
            if (!in_array($data->BRAND_P, array_column($brand_ps, 'BRAND_P')))
            {
                $brand_ps[] =  [
                    'BRAND_P' => $data->BRAND_P,
                    'REMARK' => $data->BRAND_P,
                ];
            }
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get()->toArray();
            if (!in_array($data->SOLUTION, array_column($solutions, 'SOLUTION')))
            {
                $solutions[] =  [
                    'SOLUTION' => $data->SOLUTION,
                    'DESCRIPTION' => $data->SOLUTION,
                ];
            }
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get()->toArray();
            if (!in_array($data->SERIES, array_column($series, 'SERIES')))
            {
                $series[] =  [
                    'SERIES' => $data->SERIES,
                    'DESCRIPTION' => $data->SERIES,
                ];
            }
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get()->toArray();
            if (!in_array($data->CATEGORY, array_column($categorys, 'CATEGORY')))
            {
                $categorys[] =  [
                    'CATEGORY' => $data->CATEGORY,
                    'DESCRIPTION' => $data->CATEGORY,
                ];
            }
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get()->toArray();
            if (!in_array($data->S_CAT, array_column($sub_categorys, 'S_CAT')))
            {
                $sub_categorys[] =  [
                    'S_CAT' => $data->S_CAT,
                    'DESCRIPTION' => $data->S_CAT,
                ];
            }
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get()->toArray();
            if (!in_array($data->PDM_GROUP, array_column($pdms, 'PDM_GROUP')))
            {
                $pdms[] =  [
                    'PDM_GROUP' => $data->PDM_GROUP,
                    'REMARK' => $data->PDM_GROUP,
                ];
            }
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get()->toArray();
            if (!in_array($data->UNIT, array_column($unit_ps, 'UNIT')))
            {
                $unit_ps[] =  [
                    'UNIT' => $data->UNIT,
                ];
            }
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get()->toArray();
            if (!in_array($data->UNIT_TYPE, array_column($unit_types, 'UNIT_TYPE')))
            {
                $unit_types[] =  [
                    'UNIT_TYPE' => $data->UNIT_TYPE,
                ];
            }
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', 'KM')
            ->get();
        }

        // dd($grp_ps);
        // dd($venders);
        return view('product.edit', compact('data', 'multiChannels', 'allBrands', 'defaultBrands', 'owners', 'grp_ps', 'brand_ps', 'venders', 'type_gs', 'solutions', 'series', 'categorys', 'sub_categorys', 'pdms', 'p_statuss', 'unit_ps', 'unit_types', 'acctypes', 'conditions'));
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

                $data_consumables_old = Product1::select(
                    'product1s.*',
                )
                ->firstWhere('product1s.PRODUCT', '=', $PRODUCT);

                $data_consumables_old_arr = $data_consumables_old->toArray();

                if ($request) {
                    $log = [
                        'UPDATE_DT' => date("Y/m/d H:i:s"),
                        'USER_UPDATE' => Auth::user()->username
                    ];

                    $data_consumables_old_arr = array_merge($data_consumables_old_arr, $log);
                    // dd($data_consumables_old_arr);
                    $logProductUpddate = Product1Log::create($data_consumables_old_arr);
                }

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
                    'OPT_TXT1' => $request->input('OPT_TXT1'),
                    'CONDITION_SALE' => $request->input('CONDITION_SALE'),
                    'WHOLE_SALE' => $request->input('WHOLE_SALE'),
                    'GP' => $request->input('GP'),
                    'O_PRODUCT' => $request->input('O_PRODUCT'),
                    // 'BAR_PACK1' => $request->input('BAR_PACK1'),
                    // 'BAR_PACK2' => $request->input('BAR_PACK2'),
                    // 'BAR_PACK3' => $request->input('BAR_PACK3'),
                    // 'BAR_PACK4' => $request->input('BAR_PACK4'),
                    'PACK_SIZE1' => $request->input('PACK_SIZE1'),
                    'PACK_SIZE2' => $request->input('PACK_SIZE2'),
                    'PACK_SIZE3' => $request->input('PACK_SIZE3'),
                    'PACK_SIZE4' => $request->input('PACK_SIZE4'),
                    'REG_DATE' => $request->input('REG_DATE'),
                    'AGE' => $request->input('AGE'),
                    'WIDTH' => $request->input('WIDTH'),
                    'HEIGHT' => $request->input('HEIGHT'),
                    'WIDE' => $request->input('WIDE'),
                    'NAME_EXP' => $request->input('NAME_EXP'),
                    'NET_WEIGHT' => $request->input('NET_WEIGHT'),
                    'UNIT_TYPE' => $request->input('UNIT_TYPE'),
                    // 'TYPE_G' => $request->input('TYPE_G'),
                    'OPT_DATE1' => $request->input('OPT_DATE1'),
                    'OPT_DATE2' => $request->input('OPT_DATE2'),
                    'OPT_TXT2' => $request->input('OPT_TXT2'),
                    'OPT_NUM1' => $request->input('OPT_NUM1'),
                    'OPT_NUM2' => $request->input('OPT_NUM2'),
                    // 'ACC_TYPE' => $request->input('ACC_TYPE'),
                    'ACC_DT' => $request->input('ACC_DT'),
                    'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                    'NON_VAT' => is_null($request->input('NON_VAT')) ? 'N' : 'Y',
                    'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                    'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                    'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                    'USER_EDIT' => Auth::user()->username,
                    'EDIT_DT' => date("Y-m-d"),
                    'STATUS_EDIT_DT' => '',
                ];

                // dd($data_product_upddate);
                $productUpddateConsumables = Product1::where('PRODUCT', $PRODUCT)->update($data_product_upddate);

                // dd($productUpddateConsumables);
                DB::commit();
                $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
                return response()->json(['success' => true]);
            } else {

                $data_old = Product1::select(
                    'product1s.*',
                )
                ->firstWhere('product1s.PRODUCT', '=', $PRODUCT);

                $data_old_arr = $data_old->toArray();

                if ($request) {
                    $log = [
                        'UPDATE_DT' => date("Y/m/d H:i:s"),
                        'USER_UPDATE' => Auth::user()->username
                    ];

                    $data_old_arr = array_merge($data_old_arr, $log);
                    // dd($data_old_arr);
                    $logProductUpddate = Product1Log::create($data_old_arr);
                }

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
                    'OPT_TXT1' => $request->input('OPT_TXT1'),
                    'CONDITION_SALE' => $request->input('CONDITION_SALE'),
                    'WHOLE_SALE' => $request->input('WHOLE_SALE'),
                    'GP' => $request->input('GP'),
                    'O_PRODUCT' => $request->input('O_PRODUCT'),
                    // 'BAR_PACK1' => $request->input('BAR_PACK1'),
                    // 'BAR_PACK2' => $request->input('BAR_PACK2'),
                    // 'BAR_PACK3' => $request->input('BAR_PACK3'),
                    // 'BAR_PACK4' => $request->input('BAR_PACK4'),
                    'PACK_SIZE1' => $request->input('PACK_SIZE1'),
                    'PACK_SIZE2' => $request->input('PACK_SIZE2'),
                    'PACK_SIZE3' => $request->input('PACK_SIZE3'),
                    'PACK_SIZE4' => $request->input('PACK_SIZE4'),
                    'REG_DATE' => $request->input('REG_DATE'),
                    'AGE' => $request->input('AGE'),
                    'WIDTH' => $request->input('WIDTH'),
                    'HEIGHT' => $request->input('HEIGHT'),
                    'WIDE' => $request->input('WIDE'),
                    'NAME_EXP' => $request->input('NAME_EXP'),
                    'NET_WEIGHT' => $request->input('NET_WEIGHT'),
                    'UNIT_TYPE' => $request->input('UNIT_TYPE'),
                    // 'TYPE_G' => $request->input('TYPE_G'),
                    'OPT_DATE1' => $request->input('OPT_DATE1'),
                    'OPT_DATE2' => $request->input('OPT_DATE2'),
                    'OPT_TXT2' => $request->input('OPT_TXT2'),
                    'OPT_NUM1' => $request->input('OPT_NUM1'),
                    'OPT_NUM2' => $request->input('OPT_NUM2'),
                    // 'ACC_TYPE' => $request->input('ACC_TYPE'),
                    'ACC_DT' => $request->input('ACC_DT'),
                    'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                    'NON_VAT' => is_null($request->input('NON_VAT')) ? 'N' : 'Y',
                    'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                    'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                    'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                    'USER_EDIT' => Auth::user()->username,
                    'EDIT_DT' => date("Y-m-d"),
                    'STATUS_EDIT_DT' => '',
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

    // public function get_users()
    // {
    //     $get_users = User::all();

    //     return view('product.get_users', compact('get_users'));
    // }

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

        // if ($request->order[0]) {
        //     switch  ($request->order[0]['column']) {
        //         case 0:
        //             $data->orderBy('BRAND', $request->order[0]['dir']);
        //             break;
        //         case 1:
        //             $data->orderBy('GRP_P', $request->order[0]['dir']);
        //             break;
        //         case 2:
        //             $data->orderBy('PRODUCT', $request->order[0]['dir']);
        //             break;
        //         case 3:
        //             $data->orderBy('BARCODE', $request->order[0]['dir']);
        //             break;
        //         case 4:
        //             $data->orderBy('NAME_THAI', $request->order[0]['dir']);
        //             break;
        //         default:
        //             // code...
        //             break;
        //     }
        // }

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        if ($userpermission == $isSuperAdmin) {
                $data = Product1::select(
       'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->orderBy('BARCODE', 'DESC');
        } else if ($userpermission == 'OP') {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->where('BRAND', 'OP')
            // ->where(function ($query) {
            //     $query->whereIn('BRAND', ['OP', 'KM']) // First check for BRAND in ['OP', 'KM']
            //         ->orWhereHas('productChannel', function ($q) {
            //             $q->whereIn('BRAND', ['OP']); // Check the relation productChannel
            //         });
            // })
            ->orderBy('BARCODE', 'DESC');

        } else if ($userpermission == 'CPS') {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->where('BRAND', 'CPS')
            // ->where(function ($query) {
            //     $query->whereIn('BRAND', ['CPS', 'KM']) // First check for BRAND in ['CPS', 'KM']
            //           ->orWhereHas('productChannel', function ($q) {
            //               $q->whereIn('BRAND', ['CPS']); // Check the relation productChannel
            //           });
            // })
            ->orderBy('BARCODE', 'DESC');
        } else if ($userpermission == 'KTY') {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->whereIn('BRAND', ['KTY'])
            ->orderBy('BARCODE', 'DESC');
        } else if ($userpermission == 'GNC') {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->where('BRAND', 'GNC')
            ->orderBy('BARCODE', 'DESC');
        } else if ($userpermission == 'BB') {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->where('BRAND', 'BB')
            ->orderBy('BARCODE', 'DESC');
        } else if ($userpermission == 'LL') {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->where('BRAND', 'LL')
            ->orderBy('BARCODE', 'DESC');
        } else if ($userpermission == 'KM') {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            // ->whereIn('BRAND', ['OP', 'CPS', 'KTY', 'GNC', 'BB', 'LL', 'KM'])
            ->where('BRAND', 'KM')
            ->orderBy('BARCODE', 'DESC');
        } else if ($userpermission == 'ACC') {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->whereIn('BRAND', ['OP', 'CPS', 'KTY', 'GNC', 'BB', 'LL'])
            ->orderBy('BARCODE', 'DESC');
        }

        // dd($data);
        if ($BRAND != null) {
            $data->where('product1s.BRAND', $BRAND);
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
