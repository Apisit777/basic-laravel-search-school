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
use InvalidArgumentException;
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
use App\Models\ProductPrice;
use App\Models\Com_product;
use App\Models\ComProductExternal;
use App\Models\ComProductImage;
use App\Models\ComProductLog;
use App\Models\ProductPriceSchedule;
use App\Models\ProductDetail;
use App\Models\ProductDetailLog;
use App\Models\ProductOther;
use App\Models\ProductOtherLog;
use App\Models\ComProductPack;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Events\AccountApprovalRequested;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $mysql = DB::connection('mysql')->select('select database() as db');
        // $mysql_external = DB::connection('mysql_external')->select('select database() as db');

        // $totalmysql = DB::connection('mysql')->table('com_products')->count();                 
        // $totalmysql_external = DB::connection('mysql_external')->table('com_products')->count();     

        // dd($mysql, $mysql_external, $totalmysql, $totalmysql_external);
        
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
                ->whereNotIn('BRAND', ['GNC'])
                ->get();

            $dataProductMasterConsumablesArr = Product1::select(
            'PRODUCT')
            ->where('BRAND', 'GNC')
            ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
            ->pluck('PRODUCT')
            ->toArray();

            $getSelect2ProDevelops = Product1::select(
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
        } else if ($userpermission == 'FR') {

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['FR'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();

            $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            $dataProductMaster = Pro_develops::select(
            'PRODUCT')
            ->whereIn('BRAND', ['FR'])
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->get();

            $dataProductMasterConsumablesArr = Product1::select(
                'PRODUCT')
                ->where('BRAND', 'FR')
                ->whereRaw("PRODUCT REGEXP '^[0-9]' AND LENGTH(PRODUCT) >= 7")
                ->pluck('PRODUCT')
                ->toArray();
        } else if ($userpermission == 'BD') {

            $brands = Barcode::select(
            'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB', 'LL', 'FR'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();

            $data_PRODUCT = Product1::select('PRODUCT')->pluck('PRODUCT')->toArray();
            $dataProductMaster = Pro_develops::select(
            'PRODUCT')
            ->whereIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB', 'LL'])
            ->whereNotIn('PRODUCT', $data_PRODUCT)
            ->get();

            $dataProductMasterConsumablesArr = Product1::select(
                'PRODUCT')
                ->where('BRAND', 'FR')
                ->whereRaw("PRODUCT REGEXP '^[0-9]' AND LENGTH(PRODUCT) >= 7")
                ->pluck('PRODUCT')
                ->toArray();

            $getSelect2ProDevelops = Pro_develops::select(
            'PRODUCT')
            // ->whereIn('BRAND', ['OP'])
            ->whereIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();
        }

        // dd($dataProductMasterConsumablesArr);
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

    public function ean13_check_digit_GNC($barcode)
    {
        $digits = (string)$barcode;
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        $even_sum_three = $even_sum * 3;
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        $total_sum = $even_sum_three + $odd_sum;
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;

        return $digits . $check_digit;
    }

    public function generatebarcodeGNC(Request $request, $baocode)
    {
        $digits_barcode_gnc = $this->ean13_check_digit_GNC($baocode);

        // dd($digits_barcode_gnc);
        return response()->json(['digitsBarcodeGnc' => $digits_barcode_gnc]);
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

    // public function checkCode(Request $request)
    // {
    //     // dd($request);
    //     $data = Product1::select('PRODUCT')
    //         ->where('PRODUCT', $request->PRODUCT)
    //         ->count();

    //     return response()->json($data > 0 ? false : true);
    // }

    public function checkCode(Request $request)
    {
        $productCode = trim($request->PRODUCT); // ตัดช่องว่างด้านหน้า/หลัง
        \Log::info("🚀 Checking PRODUCT in DB: " . $productCode);

        $isDuplicate = Product1::whereRaw("CAST(PRODUCT AS CHAR) = ?", [$productCode])->exists();

        \Log::info("🚀 isDuplicate (Backend Result): " . ($isDuplicate ? 'true' : 'false'));

        return response()->json(['isDuplicate' => $isDuplicate]);
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

    public function calculateEAN14CheckDigit($ean13)
    {
        if (!preg_match('/^\d{12,13}$/', $ean13)) { // รองรับ 12 หรือ 13 หลัก
            return response()->json(['error' => "ต้องเป็นตัวเลข 12 หรือ 13 หลักเท่านั้น"], 400);
        }

        $ean13 = str_pad($ean13, 13, '0', STR_PAD_LEFT); // ถ้าเป็น 12 หลัก ให้เติม 0 ข้างหน้า
        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $digit = (int) $ean13[$i];
            $sum += ($i % 2 === 0) ? $digit * 3 : $digit;
        }

        $checkDigit = (10 - ($sum % 10)) % 10;
        return response()->json(['checkDigit' => $ean13 . $checkDigit]); // ส่ง EAN-14 กลับ
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
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        $owners = Owner::all();
        $grp_ps = Grp_p::all();
        $brand_ps = Brand_p::all();
        $venders = Vendor::all();
        $type_gs = Type_g::all();
        $acctypes = Acctype::all();
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

        // dd($acctypes);
        if ($userpermission == $isSuperAdmin) {
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

            $venders = Vendor::select(
                'VEN_ID',
                'VEN_NTHAI',
                'BRAND'
            )
            ->where(function ($q) {
                $q->where('BRAND', 'OP')
                ->orWhere('BRAND', '');
            })
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

            $venders = Vendor::select(
                'VEN_ID',
                'VEN_NTHAI',
                'BRAND')
            ->where(function ($q) {
                $q->where('BRAND', 'CPS')
                ->orWhere('BRAND', '');
            })
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

            // ดึงเฉพาะ Category ที่มี Product Line อยู่จริง และ BRAND = CPS
            $categorys = Category::select('categories.ID', 'categories.DESCRIPTION', 'categories.BRAND')
                ->join('product_lines', 'product_lines.CATEGORY_ID', '=', 'categories.ID')
                ->where('categories.BRAND', 'CPS')
                ->where('product_lines.BRAND', 'CPS')
                ->groupBy('categories.ID', 'categories.DESCRIPTION', 'categories.BRAND')
                ->orderBy('categories.DESCRIPTION')
                ->get();

            // $categorys = Category::select(
            //     'ID',
            //     'DESCRIPTION',
            //     'BRAND')
            // ->where('BRAND', 'CPS')
            // ->get();
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
        } else {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', $userpermission)
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();

            $venders = Vendor::select(
                'VEN_ID',
                'VEN_NTHAI',
                'BRAND')
            ->where(function ($q) {
                $q->where('BRAND', 'CPS')
                ->orWhere('BRAND', '');
            })
            ->get();

            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $product_groups = ProductGroup::select(
                'ID',
                'DESCRIPTION AS product_group_name',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
        }

        // $productCodeMax = Product::max('seq');
        // $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        // $productCode = 'P'.sprintf('%05d', $productCodeNumber);
        // $list_position = position::select('id', 'name_position')->get();

        // ทดสอบตัวอย่าง
        // $ean13 = "3885008021578"; // เปลี่ยนเป็นเลขที่ต้องการ
        // $checkDigit = $this->calculateEAN14CheckDigit($ean13);
        // $ean14 = $ean13 . $checkDigit;
        // dd($venders);

        return view('product.create', compact(  'brands', 'allBrands', 'defaultBrands', 'owners', 'grp_ps', 'brand_ps', 'venders', 'type_gs', 'acctypes', 'solutions', 'series', 'categorys', 'sub_categorys', 'pdms', 'p_statuss', 'unit_ps', 'unit_types', 'acctypes', 'conditions', 'product_groups', 'userpermission'));
    }

    public function createConsumables(Request $request)
    {
        // $digits_barcode = $this->ean13_check_digit();
        // $ = $this->productMasterGetBrandListAjax();
        // dd($accessery);

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

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

            $venders = Vendor::select(
                'VEN_ID',
                'VEN_NTHAI',
                'BRAND')
            ->where(function ($q) {
                $q->where('BRAND', 'OP')
                ->orWhere('BRAND', '');
            })
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

            $venders = Vendor::select(
                'VEN_ID',
                'VEN_NTHAI',
                'BRAND')
            ->where(function ($q) {
                $q->where('BRAND', 'CPS')
                ->orWhere('BRAND', '');
            })
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
        } else if ($userpermission == 'KTY') {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', $userpermission)
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
                 ->whereIn('BRAND', ['KTY', 'FR'])
            ->get();

            $venders = Vendor::select(
                'VEN_ID',
                'VEN_NTHAI',
                'BRAND')
            ->where(function ($q) {
                $q->where('BRAND', 'CPS')
                ->orWhere('BRAND', '');
            })
            ->get();

            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
        } else {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', $userpermission)
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $owners = Owner::select(
                'OWNER',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $grp_ps = Grp_p::select(
                'GRP_P',
                'REMARK',
                'BRAND')
                ->where('BRAND', $userpermission)
            ->get();

            $venders = Vendor::select(
                'VEN_ID',
                'VEN_NTHAI',
                'BRAND')
            ->where(function ($q) {
                $q->where('BRAND', 'CPS')
                ->orWhere('BRAND', '');
            })
            ->get();

            $brand_ps = Brand_p::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $solutions = Solution::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $series = Series::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $categorys = Category::select(
                'ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $sub_categorys = Sub_category::select(
                'ID',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $pdms = Pdm::select(
                'ID',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $unit_ps = Unit_p::select(
                'DESCRIPTION AS UNIT',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $unit_types = Unit_type::select(
                'DESCRIPTION AS UNIT_TYPE',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
        }

        // dd($userpermission);
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

        // dd($data);
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
                'NON_VAT' => is_null($data->NON_VAT) ? '' : 'Y',
                'STORAGE_TEMP' => is_null($data->STORAGE_TEMP) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($data->CONTROL_STK) ? 'N' : 'Y',
                'TESTER' =>  is_null($data->TESTER) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->username,
                'EDIT_DT' => date("Y/m/d h:i:s")
            ];

            $copyConsumablesProductMaster = Product1::create($data_product);

            if (!is_null($data->BRAND)) {

                $user = Auth::user()->username;
                $dateTime = date('Y-m-d H:i:s');

                $updateData = [
                    'UPDATED_BY' => $user,
                    'UPDATED_AT' => $dateTime
                ];

                $createSeleChannel = ProductChannel::updateOrCreate(
                    ['PRODUCT' => $data_product['BARCODE'], 'BRAND' => $data_product['BRAND']],
                        $updateData
                );
            }

            // Phase 2
            if ( $copyConsumablesProductMaster->BRAND == 'CPS' ) {
                $createProductDetail = ProductDetail::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                    'corporation_id' => $copyConsumablesProductMaster->BRAND,
                    'company_id' => $copyConsumablesProductMaster->BRAND,
                    'fad' => $copyConsumablesProductMaster->REGISTER,
                    'inner_barcode' => $copyConsumablesProductMaster->BAR_PACK1,
                    'inner_pack_size' => $copyConsumablesProductMaster->PACK_SIZE1,
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s"),
                ]);

                $createProductOther = ProductOther::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                    'corporation_id' => $copyConsumablesProductMaster->BRAND,
                    'company_id' => $copyConsumablesProductMaster->BRAND,
                    'item_name' => $copyConsumablesProductMaster->NAME_ENG,
                    'cat_name' => $copyConsumablesProductMaster->CATEGORY,
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s"),
                ]);
            }

            $createComProduct = Com_product::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                'company_id' => $copyConsumablesProductMaster->BRAND,
                'barcode' => $copyConsumablesProductMaster->BARCODE,
                'vendor_id' => $copyConsumablesProductMaster->VENDOR,
                'name_thai' => $copyConsumablesProductMaster->NAME_THAI,
                'name_eng' => $copyConsumablesProductMaster->NAME_ENG,
                'short_thai' => $copyConsumablesProductMaster->SHORT_THAI,
                'short_eng' => $copyConsumablesProductMaster->SHORT_ENG,
                'upd_user' => Auth::user()->username,
                'upd_date' => date("Y/m/d H:i:s"),
            ]);

            // dd($createComProduct);
            // dd($copyConsumablesProductMaster);
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

        // dd($data);
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
                'NON_VAT' => is_null($data->NON_VAT) ? '' : 'Y',
                'STORAGE_TEMP' => is_null($data->STORAGE_TEMP) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($data->CONTROL_STK) ? 'N' : 'Y',
                'TESTER' =>  is_null($data->TESTER) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->username,
                'EDIT_DT' => date("Y/m/d h:i:s")
            ];

            // dd($data_product, $data->BRAND);
            $copyProductMaster = Product1::create($data_product);

            if (!is_null($data->BRAND)) {

                $user = Auth::user()->username;
                $dateTime = date('Y-m-d H:i:s');

                $updateData = [
                    'UPDATED_BY' => $user,
                    'UPDATED_AT' => $dateTime
                ];

                $createSeleChannel = ProductChannel::updateOrCreate(
                    ['PRODUCT' => $data_product['PRODUCT'], 'BRAND' => $data_product['BRAND']],
                        $updateData
                    );
            }

            // Phase 2
            // วนลูป 4 รอบเพื่อบันทึก barcode และ pack size
            for ($i = 1; $i <= 4; $i++) {
                $barcode = $data_product["BAR_PACK{$i}"];
                $quantity = $data_product["PACK_SIZE{$i}"];

                if (!empty($barcode)) {
                    ComProductPack::updateOrCreate(
                        [
                            'company_id' => $data_product['BRAND'],
                            'product_id' => $data_product['PRODUCT'],
                            'barcode'    => $barcode,
                        ],
                        [
                            'quantity'   => $quantity,
                            'reg_user'   => Auth::user()->username,
                            'upd_user'   => Auth::user()->username,
                            'reg_date'   => now()->toDateString(),
                            'reg_time'   => now()->format('H:i:s'),
                            'upd_date'   => now()->toDateString(),
                            'upd_time'   => now()->format('H:i:s'),
                            'timestamps' => date('Y-m-d H:i:s'),
                        ]
                    );
                }
            }

            // Phase 2
            if ( $copyProductMaster->BRAND == 'CPS' ) {
                $createProductDetail = ProductDetail::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                    'corporation_id' => $copyProductMaster->BRAND,
                    'company_id' => $copyProductMaster->BRAND,
                    'fad' => $copyProductMaster->REGISTER,
                    'inner_barcode' => $copyProductMaster->BAR_PACK1,
                    'inner_pack_size' => $copyProductMaster->PACK_SIZE1,
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s"),
                ]);

                $createProductOther = ProductOther::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                    'corporation_id' => $copyProductMaster->BRAND,
                    'company_id' => $copyProductMaster->BRAND,
                    'item_name' => $copyProductMaster->NAME_ENG,
                    'cat_name' => $copyProductMaster->CATEGORY,
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s"),
                ]);
            }

            $createComProduct = Com_product::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                'company_id' => $copyProductMaster->BRAND,
                'barcode' => $copyProductMaster->BARCODE,
                'vendor_id' => $copyProductMaster->VENDOR,
                'name_thai' => $copyProductMaster->NAME_THAI,
                'name_eng' => $copyProductMaster->NAME_ENG,
                'short_thai' => $copyProductMaster->SHORT_THAI,
                'short_eng' => $copyProductMaster->SHORT_ENG,
                'upd_user' => Auth::user()->username,
                'upd_date' => date("Y/m/d H:i:s"),
            ]);

            // dd($createComProduct);
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
        // dd($request->sele_channel);
        $dataProductBarcode = Pro_develops::select(
            'BRAND',
            'PRODUCT',
            'BARCODE',
        )
        ->firstWhere('PRODUCT', '=', $request->NUMBER);

        // dd($dataProductBarcode);
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

            $isSuperAdmin = (Auth::user()->id === 26);
            $userPermissionFull = Auth::user()->getUserPermission->name_position ?? '';
            $namePositionParts = explode('-', $userPermissionFull);
            $userpermission = trim(end($namePositionParts)); // brand/suffix

            $data_product = [
                'BRAND' => $request->input('BRAND') ?? '',
                // 'BRAND' => $request->input('BRAND') ?? '',
                // 'PRODUCT' => $dataProductBarcode->PRODUCT,
                // 'BARCODE' => $dataProductBarcode->BARCODE,
                'PRODUCT' => $request->input('PRODUCT') ?? '',
                'BARCODE' => $request->input('BARCODE') ?? '',
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
                'TYPE_G' => $request->input('TYPE_G') ?? '',

                'OPT_DATE1' => $request->input('OPT_DATE1') ?? '',
                'OPT_DATE2' => $request->input('OPT_DATE2') ?? '',
                
                'OPT_TXT2' => $request->input('OPT_TXT2') ?? '',
                'OPT_NUM1' => $request->input('OPT_NUM1') ?? '',
                'OPT_NUM2' => $request->input('OPT_NUM2') ?? '',
                'ACC_TYPE' => $request->input('ACC_TYPE') ?? '',
                'ACC_DT' => $request->input('ACC_DT') ?? '',
                'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                'NON_VAT' => is_null($request->input('NON_VAT')) ? '' : 'Y',
                'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                'USER_EDIT' => Auth::user()->username,
                'EDIT_DT' => date("Y-m-d"),
                'STATUS_EDIT_DT' => '',
            ];

            // dd($request->sele_channel, $data_product);
            $productMaster = Product1::create($data_product);

            // dd($productMaster);
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
            [
                            'PRODUCT' => $data_product['PRODUCT'], 
                            'BRAND' => $value
                        ],
                $updateData
                    );
                }
            }

            // Phase 2
            // วนลูป 4 รอบเพื่อบันทึก barcode และ pack size
            for ($i = 1; $i <= 4; $i++) {
                $barcode = $data_product["BAR_PACK{$i}"];
                $quantity = $data_product["PACK_SIZE{$i}"];

                if (!empty($barcode)) {
                    ComProductPack::updateOrCreate(
                        [
                            'company_id' => $data_product['BRAND'],
                            'product_id' => $data_product['PRODUCT'],
                            'barcode'    => $barcode,
                        ],
                        [
                            'quantity'   => $quantity,
                            'reg_user'   => Auth::user()->username,
                            'upd_user'   => Auth::user()->username,
                            'reg_date'   => now()->toDateString(),
                            'reg_time'   => now()->format('H:i:s'),
                            'upd_date'   => now()->toDateString(),
                            'upd_time'   => now()->format('H:i:s'),
                            'timestamps' => date('Y-m-d H:i:s'),
                        ]
                    );
                }
            }

            // Phase 2
            if ( $productMaster->BRAND == 'CPS' ) {
                $createProductDetail = ProductDetail::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                    'corporation_id' => $productMaster->BRAND,
                    'company_id' => $productMaster->BRAND,
                    'fad' => $productMaster->REGISTER,
                    'inner_barcode' => $productMaster->BAR_PACK1,
                    'inner_pack_size' => $productMaster->PACK_SIZE1,
                    'case_barcode' => $productMaster->BAR_PACK2,
                    'case_pack_size' => $productMaster->PACK_SIZE2,
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s"),
                ]);

                $createProductOther = ProductOther::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                    'corporation_id' => $productMaster->BRAND,
                    'company_id' => $productMaster->BRAND,
                    'item_name' => $productMaster->NAME_ENG,
                    'cat_name' => $productMaster->CATEGORY,
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s"),
                ]);
            }

            // SELECT * FROM com_products WHERE update_dt BETWEEN '2025-09-01' AND CURDATE();
            // SELECT * FROM com_products WHERE update_dt >= '2025-09-01' AND update_dt < CURDATE() + INTERVAL 1 DAY ORDER BY update_dt DESC;
            $createComProduct = Com_product::updateOrCreate(
                ['product_id' => $data_product['PRODUCT']], 
                [
                'company_id' => $productMaster->BRAND ?? '',
                'barcode' => $productMaster->BARCODE ?? '',
                'vendor_id' => $productMaster->VENDOR ?? '',
                'name_thai' => $productMaster->NAME_THAI ?? '',
                'name_eng' => $productMaster->NAME_ENG ?? '',
                'short_thai' => $productMaster->SHORT_THAI ?? '',
                'short_eng' => $productMaster->SHORT_ENG ?? '',
                'price' => $productMaster->PRICE ?? '',
                'cost' => $productMaster->COST ?? '',
                'unit_id'       => $productMaster->UNIT ?? '',
                'capacity'       => $productMaster->UNIT_Q ?? '',
                'non_vat'       => $productMaster->NON_VAT ?? '',
                'status'       => $productMaster->STATUS ?? '',
                'gp'       => $productMaster->GP ?? '',
                'return'       => $productMaster->RETURN ?? '',
                'o_product'       => $productMaster->O_PRODUCT ?? '',
                'acc_type'       => $productMaster->ACC_TYPE ?? '',
                'group2'       => $productMaster->TYPE_G ?? '',
                'series'       => $productMaster->SERIES ?? '',
                'solution'       => $productMaster->SOLUTION ?? '',
                'category'       => $productMaster->CATEGORY ?? '',
                'upd_user' => Auth::user()->username . '(' . $userpermission . ')',
                'status_tranfer_km' => '',
                'update_dt' => date("Y/m/d H:i:s"),
            ]);

            
            $images = ComProductImage::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                'brand' => $productMaster->BRAND,
            ]);
            
            // status_delivery
            // ---------- 2) บันทึก com_products ----------
            $shippingCostCode = (int) ($productMaster->BARCODE ?? 0);

            $comUpdate = []; // payload ของ com_products (อย่าใส่ UPDATED_BY/UPDATED_AT ถ้าไม่มีคอลัมน์)

            // ธงจัดส่งเฉพาะ com_products
            
            if ($shippingCostCode >= 95090001 && $shippingCostCode <= 95090999) {
                $comUpdate['status_delivery'] = 'Y';   // ใช้ชื่อคอลัมน์จริงใน com_products
            }

            // อยากอัปเดตฟิลด์อื่น ๆ ใน com_products ด้วยก็ใส่เพิ่มที่นี่ เช่น:
            // $comUpdate['brand']   = $data_product['BRAND'];
            // $comUpdate['barcode'] = $data_product['BARCODE'];

            Com_product::updateOrCreate(
                ['product_id' => $data_product['PRODUCT']],  // key ที่ชนต้องตรง unique key จริง
                $comUpdate
            );

            // dd( $createComProduct);
            // dd( $images);
            // $craeteProductPrice = Account::updateOrCreate(['product' => $data_product['PRODUCT']], [
            $craeteProductPrice = ProductPrice::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                'cost' => $productMaster->COST,
                'status_edit_dt' => '',
                'created_at' => date("Y/m/d H:i:s"),
                'created_by' => Auth::user()->username . '(' . $userpermission . ')',
                // 'updated_at' => date("Y/m/d H:i:s"),
                // 'updated_by' => Auth::user()->username . '(' . $userpermission . ')',
            ]);
            
            //     $craeteProductAccountSchedule = ProductPriceSchedule::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
            //         // 'price' => $productMaster->COST,
            //         'price' => 0,
            //         'status' => 0,
            //         'status_edit_dt' => '',
            //         'created_by' => Auth::user()->username,
            //         'created_at' => date("Y/m/d H:i:s")
            //     ]);

            // dd($attributes = [
            //     // 'productMaster' => $productMaster->toArray(),
            //     'craeteProductPrice' => $craeteProductPrice->toArray(),
            //     // 'createProductDetail' => $createProductDetail->toArray(),
            //     // 'createProductOther' => $createProductOther->toArray(),
            //     // 'createComProduct' => $createComProduct->toArray(),
            //     // 'craeteProductAccountSchedule' => $craeteProductAccountSchedule->toArray(),
            // ]);
            
            // dd( $createComProduct);

            // 🔴 ตรงนี้: ยิง event "เพิ่ม noti" ทุกครั้งที่สร้าง product สำเร็จ
            // log ฝั่ง server
            Log::info('🔥 FIRE EVENT AccountApprovalRequested', [
                'brand'   => $data_product['BRAND'],
                'product' => $data_product['PRODUCT'],
                'user'    => Auth::user()->username ?? null,
            ]);

            event(new AccountApprovalRequested(
                $data_product['BRAND'],
                $data_product['PRODUCT'],
                Auth::user()->username ?? 'system'
            ));

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
        // 95090026
        DB::beginTransaction();
        try {

            $isSuperAdmin = (Auth::user()->id === 26);
            $userPermissionFull = Auth::user()->getUserPermission->name_position ?? '';
            $namePositionParts = explode('-', $userPermissionFull);
            $userpermission = trim(end($namePositionParts)); // brand/suffix
            
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
                'NON_VAT' => is_null($request->input('NON_VAT')) ? '' : 'Y',
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

            // Phase 2
            if ( $productMaster->BRAND == 'CPS' ) {
                $createProductDetail = ProductDetail::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                    'corporation_id' => $productMaster->BRAND,
                    'company_id' => $productMaster->BRAND,
                    'fad' => $productMaster->REGISTER,
                    'inner_barcode' => $productMaster->BAR_PACK1,
                    'inner_pack_size' => $productMaster->PACK_SIZE1,
                    'case_barcode' => $productMaster->BAR_PACK2,
                    'case_pack_size' => $productMaster->PACK_SIZE2,
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s"),
                ]);

                $createProductOther = ProductOther::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                    'corporation_id' => $productMaster->BRAND,
                    'company_id' => $productMaster->BRAND,
                    'item_name' => $productMaster->NAME_ENG,
                    'cat_name' => $productMaster->CATEGORY,
                    'upd_user' => Auth::user()->username,
                    'upd_date' => date("Y/m/d H:i:s"),
                ]);
            }

            $createComProduct = Com_product::updateOrCreate(
                ['product_id' => $data_product['PRODUCT']], 
                [
                'company_id' => $productMaster->BRAND ?? '',
                'barcode' => $productMaster->BARCODE ?? '',
                'vendor_id' => $productMaster->VENDOR ?? '',
                'name_thai' => $productMaster->NAME_THAI ?? '',
                'name_eng' => $productMaster->NAME_ENG ?? '',
                'short_thai' => $productMaster->SHORT_THAI ?? '',
                'short_eng' => $productMaster->SHORT_ENG ?? '',
                'price' => $productMaster->PRICE ?? '',
                'cost' => $productMaster->COST ?? '',
                'unit_id'       => $productMaster->UNIT ?? '',
                'capacity'       => $productMaster->UNIT_Q ?? '',
                'non_vat'       => $productMaster->NON_VAT ?? '',
                'status'       => $productMaster->STATUS ?? '',
                'gp'       => $productMaster->GP ?? '',
                'return'       => $productMaster->RETURN ?? '',
                'o_product'       => $productMaster->O_PRODUCT ?? '',
                'acc_type'       => $productMaster->ACC_TYPE ?? '',
                'group2'       => $productMaster->TYPE_G ?? '',
                'series'       => $productMaster->SERIES ?? '',
                'solution'       => $productMaster->SOLUTION ?? '',
                'category'       => $productMaster->CATEGORY ?? '',
                'upd_user' =>Auth::user()->username . '(' . $userpermission . ')',
                'status_tranfer_km' => '',
                'update_dt' => date("Y/m/d H:i:s"),
            ]);

            $images = ComProductImage::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                'brand' => $productMaster->BRAND,
            ]);

            // ---------- 2) บันทึก com_products ----------
            $shippingCostCode = (int) ($productMaster->BARCODE ?? 0);

            $comUpdate = []; // payload ของ com_products (อย่าใส่ UPDATED_BY/UPDATED_AT ถ้าไม่มีคอลัมน์)

            // ธงจัดส่งเฉพาะ com_products
            if ($shippingCostCode >= 95090001 && $shippingCostCode <= 95090999) {
                $comUpdate['status_delivery'] = 'Y';   // ใช้ชื่อคอลัมน์จริงใน com_products
            }

            // อยากอัปเดตฟิลด์อื่น ๆ ใน com_products ด้วยก็ใส่เพิ่มที่นี่ เช่น:
            // $comUpdate['brand']   = $data_product['BRAND'];
            // $comUpdate['barcode'] = $data_product['BARCODE'];

            $dataComUpdate = Com_product::updateOrCreate(
                ['product_id' => $data_product['PRODUCT']],  // key ที่ชนต้องตรง unique key จริง
                $comUpdate
            );

            // dd($dataComUpdate);

            // // เพิ่มเงื่อนไข รหัสค่าจัดส่งสินค้า 95090001 - 95099999
            // $shippingCostCode = (int) $productMaster->BARCODE;
            // if ($shippingCostCode >= 95090001 && $shippingCostCode <= 95090999) {
            //     $updateData['status_delivery'] = 'Y';
            // }

            // Com_product::updateOrCreate(
            //     ['product_id' => $data_product['PRODUCT']],
            //     $updateData
            // );

            // dd($productMaster);

            // $craeteProductAccount = Account::updateOrCreate(['product' => $productMaster->PRODUCT], [
            //     'COST' => $productMaster->COST,
            //     'created_at' => date("Y/m/d H:i:s"),
            // ]);
            // dd($productMaster);

            // Phase 2
            // $craeteProductAccount = Account::updateOrCreate(['product' => $data_product['PRODUCT']], [
            //     'COST' => $productMaster->COST,
            //     'status_edit_dt' => '',
            //     'created_at' => date("Y/m/d H:i:s"),
            // ]);

            // if ( $productMaster->BRAND == 'CPS' ) {
            //     $craeteProductretail = ProductDetail::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
            //         'corporation_id' => $productMaster->BRAND,
            //         'fad' => $productMaster->REGISTER,
            //         'inner_barcode' => $productMaster->BAR_PACK1,
            //         'inner_pack_size' => $productMaster->PACK_SIZE1,
            //         'upd_user' => Auth::user()->username,
            //         'upd_date' => date("Y/m/d H:i:s"),
            //     ]);

            //     $craeteProductretail = ProductOther::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
            //         'corporation_id' => $productMaster->BRAND,
            //         'upd_user' => Auth::user()->username,
            //         'upd_date' => date("Y/m/d H:i:s"),
            //     ]);
    
            //     $craeteProductAccountSchedule = ProductPriceSchedule::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
            //         // 'price' => $productMaster->COST,
            //         'price' => 0,
            //         'status' => 0,
            //         'status_edit_dt' => '',
            //         'created_by' => Auth::user()->username,
            //         'created_at' => date("Y/m/d H:i:s")
            //     ]);
            // }
            
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

        if ($data && $data->REG_DATE) {
            $data->REG_DATE = date('Y-m-d', strtotime($data->REG_DATE));
        }
        // dd($data);

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        $owners = Owner::select('OWNER AS VENDOR', 'REMARK')->get()->toArray();
        $grp_ps = Grp_p::select('GRP_P AS GRP_P', 'REMARK')->get()->toArray();
        $brand_ps = Brand_p::select('ID AS BRAND_P', 'REMARK', 'BRAND')->get()->toArray();

        $venders = Vendor::select('VEN_ID AS SUPPLIER', 'VEN_NTHAI')->get()->toArray();

        // if ($data && !in_array($data->SUPPLIER, array_column($venders, 'SUPPLIER'))) {
        //     $venders[] =  [
        //         'SUPPLIER' => $data->SUPPLIER,
        //         'VEN_NTHAI' => $data->SUPPLIER,
        //     ];
        // }

        // ==== ดึง brand code จาก role แบบกันพลาด ====
        $role = Auth::user()->getUserPermission->name_position ?? ''; // ex. "… - ACCOUNTING-ACC)"
        if (preg_match('/([A-Z]{2,3})\)?$/', $role, $m)) {
            $brandCode = $m[1]; // ex. "ACC" ไม่ติด ")"
        } else {
            $brandCode = '';
        }

        // ==== กำหนดแบรนด์ที่อนุญาต ====
        $allForACC = ['OP', 'RI', 'CPS', 'LL', 'KTY', 'GNC', 'BB'];   // รายการที่ ACC ควรเห็น
        $brandFilter = ($brandCode === 'ACC') ? $allForACC : [$brandCode];

        $type_gs = Type_g::select('ID AS TYPE_G', 'DESCRIPTION')->get();

        // ==== ดึงรายการหมวดหมู่ตามสิทธิ์ SOLUTION ====
        $rawSolutions = Solution::select('ID AS SOLUTION', 'DESCRIPTION', 'BRAND')
            ->whereIn('BRAND', $brandFilter)
            ->orderBy('ID')
            ->get()
            ->toArray();
        // (ทางเลือก) กันรายการชนกันข้ามแบรนด์: เก็บ SOLUTION ซ้ำไว้แค่แถวแรก
        $seenSolutions = [];
        $solutions = array_values(array_filter($rawSolutions, function ($row) use (&$seenSolutions) {
            if (isset($seenSolutions[$row['SOLUTION']])) return false;
            $seenSolutions[$row['SOLUTION']] = true;
            return true;
        }));

        // ==== ดึงรายการหมวดหมู่ตามสิทธิ์ SERIES ====
        $rawSeries = Solution::select('ID AS SERIES', 'DESCRIPTION', 'BRAND')
            ->whereIn('BRAND', $brandFilter)
            ->orderBy('ID')
            ->get()
            ->toArray();
        // (ทางเลือก) กันรายการชนกันข้ามแบรนด์: เก็บ SERIES ซ้ำไว้แค่แถวแรก
        $seenSeries = [];
        $series = array_values(array_filter($rawSeries, function ($row) use (&$seenSeries) {
            if (isset($seenSeries[$row['SERIES']])) return false;
            $seenSeries[$row['SERIES']] = true;
            return true;
        }));

        // ==== ดึงรายการหมวดหมู่ตามสิทธิ์ CATEGORY ====
        $rawCategories = Category::select('ID AS CATEGORY', 'DESCRIPTION', 'BRAND')
            ->whereIn('BRAND', $brandFilter)
            ->orderBy('ID')
            ->get()
            ->toArray();

        // (ทางเลือก) กันรายการชนกันข้ามแบรนด์: เก็บ CATEGORY ซ้ำไว้แค่แถวแรก
        $seenCategories = [];
        $categorys = array_values(array_filter($rawCategories, function ($row) use (&$seenCategories) {
            if (isset($seenCategories[$row['CATEGORY']])) return false;
            $seenCategories[$row['CATEGORY']] = true;
            return true;
        }));
        // $categorys = Category::select('ID AS CATEGORY', 'DESCRIPTION')->get()->toArray();

         // ==== ดึงรายการหมวดหมู่ตามสิทธิ์ S_CAT ====
        $rawSubCategorys = Sub_category::select('ID AS S_CAT', 'DESCRIPTION', 'BRAND')
            ->whereIn('BRAND', $brandFilter)
            ->orderBy('ID')
            ->get()
            ->toArray();

        // (ทางเลือก) กันรายการชนกันข้ามแบรนด์: เก็บ S_CAT ซ้ำไว้แค่แถวแรก
        $seenSubCategorys = [];
        $sub_categorys = array_values(array_filter($rawSubCategorys, function ($row) use (&$seenSubCategorys) {
            if (isset($seenSubCategorys[$row['S_CAT']])) return false;
            $seenSubCategorys[$row['S_CAT']] = true;
            return true;
        }));

        $pdms = Pdm::select('ID AS PDM_GROUP', 'REMARK')->get()->toArray();
        $p_statuss = P_status::select('ID AS STATUS', 'DESCRIPTION')->get()->toArray();

        // if (!in_array($data->STATUS, array_column($p_statuss, 'STATUS')))
        // {
        //     $p_statuss[] =  [
        //         'STATUS' => $data->STATUS,
        //         'DESCRIPTION' => $data->STATUS,
        //     ];
        // } 
        if ($data && !in_array($data->STATUS, array_column($p_statuss, 'STATUS'))) {
            $p_statuss[] =  [
                'STATUS' => $data->STATUS,
                'DESCRIPTION' => $data->STATUS,
            ];
        }
        $unit_ps = Unit_p::select('DESCRIPTION AS UNIT', 'BRAND')->get()->toArray();
        $unit_types = Unit_type::select('DESCRIPTION AS UNIT_TYPE', 'BRAND')->get()->toArray();
        $acctypes = Acctype::select('ID AS ACC_TYPE', 'DESCRIPTION')->get()->toArray();
        $conditions = Condition::select('ID AS CONDITION_SALE', 'DESCRIPTION')->get()->toArray();

        if ($data && !in_array($data->CONDITION_SALE, array_column($conditions, 'CONDITION_SALE'))) {
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

            $venders = Vendor::select(
                'VEN_ID AS SUPPLIER',
                'VEN_NTHAI',
                'BRAND')
            ->where('BRAND', 'OP')
            ->get()->toArray();

            if (!in_array($data->SUPPLIER, array_column($venders, 'SUPPLIER'))) {
                $venders[] =  [
                    'SUPPLIER' => $data->SUPPLIER,
                    'VEN_NTHAI' => $data->SUPPLIER,
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
            // $TYPE_G = Type_g::select('ID AS TYPE_G', 'DESCRIPTION')->get()->toArray();
            $acctypes = Acctype::select(
                'ID AS ACC_TYPE',
                'DESCRIPTION')
            ->get()->toArray();
            if (!in_array($data->ACC_TYPE, array_column($acctypes, 'ACC_TYPE')))
            {
                $acctypes[] =  [
                    'ACC_TYPE' => $data->ACC_TYPE,
                    'DESCRIPTION' => $data->ACC_TYPE,
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

            $venders = Vendor::select(
                'VEN_ID AS SUPPLIER',
                'VEN_NTHAI',
                'BRAND'
            )
            ->where(function ($q) {
                $q->where('BRAND', 'CPS')
                ->orWhere('BRAND', '');
            })
            ->get()
            ->toArray();

            if (!in_array($data->SUPPLIER, array_column($venders, 'SUPPLIER'))) {
                $venders[] =  [
                    'SUPPLIER' => $data->SUPPLIER,
                    'VEN_NTHAI' => $data->SUPPLIER,
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

            $TYPE_G = Type_g::select(
                'ID AS TYPE_G',
                'DESCRIPTION')
            ->get()->toArray();
            if (!in_array($data->TYPE_G, array_column($TYPE_G, 'TYPE_G')))
            {
                $TYPE_G[] =  [
                    'TYPE_G' => $data->TYPE_G,
                    'DESCRIPTION' => $data->TYPE_G,
                ];
            }

            $acctypes = Acctype::select(
                'ID AS ACC_TYPE',
                'DESCRIPTION')
            ->get()->toArray();
            if (!in_array($data->ACC_TYPE, array_column($acctypes, 'ACC_TYPE')))
            {
                $acctypes[] =  [
                    'ACC_TYPE' => $data->ACC_TYPE,
                    'DESCRIPTION' => $data->ACC_TYPE,
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

            // ดึงเฉพาะ Category ที่มี Product Line อยู่จริง และ BRAND = CPS
            $categorys = Category::select('categories.ID AS CATEGORY', 'categories.DESCRIPTION AS DESCRIPTION', 'categories.BRAND AS BRAND')
                ->join('product_lines', 'product_lines.CATEGORY_ID', '=', 'categories.ID')
                ->where('categories.BRAND', 'CPS')
                ->where('product_lines.BRAND', 'CPS')
                ->groupBy('categories.ID', 'categories.DESCRIPTION', 'categories.BRAND')
                ->orderBy('categories.DESCRIPTION')
                ->get()->toArray();

            // $categorys = Category::select(
            //     'ID AS CATEGORY',
            //     'DESCRIPTION',
            //     'BRAND')
            // ->where('BRAND', 'CPS')
            // ->get()->toArray();
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
        // KTY ไม่มี Series, Category, Sub_category, Pdm
        } else  {
            $defaultBrands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', $userpermission)
            ->pluck('BRAND')
            ->toArray();
            $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get();
            $owners = Owner::select(
                'OWNER AS VENDOR',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
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
            ->where('BRAND', $userpermission)
            ->get()->toArray();
            if (!in_array($data->GRP_P, array_column($grp_ps, 'GRP_P')))
            {
                $grp_ps[] =  [
                    'GRP_P' => $data->GRP_P,
                    'REMARK' => $data->GRP_P,
                ];
            }

            $venders = Vendor::select(
                'VEN_ID AS SUPPLIER',
                'VEN_NTHAI',
                'BRAND'
            )
            ->where(function ($q) {
                $q->where('BRAND', 'CPS')
                ->orWhere('BRAND', '');
            })
            ->get()
            ->toArray();

            if (!in_array($data->SUPPLIER, array_column($venders, 'SUPPLIER'))) {
                $venders[] =  [
                    'SUPPLIER' => $data->SUPPLIER,
                    'VEN_NTHAI' => $data->SUPPLIER,
                ];
            }

            $brand_ps = Brand_p::select(
                'ID AS BRAND_P',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get()->toArray();
            if (!in_array($data->BRAND_P, array_column($brand_ps, 'BRAND_P')))
            {
                $brand_ps[] =  [
                    'BRAND_P' => $data->BRAND_P,
                    'REMARK' => $data->BRAND_P,
                ];
            }
            $acctypes = Acctype::select(
                'ID AS ACC_TYPE',
                'DESCRIPTION')
            ->get()->toArray();
            if (!in_array($data->ACC_TYPE, array_column($acctypes, 'ACC_TYPE')))
            {
                $acctypes[] =  [
                    'ACC_TYPE' => $data->ACC_TYPE,
                    'DESCRIPTION' => $data->ACC_TYPE,
                ];
            }

             $solutions = Solution::select(
                'ID AS SOLUTION',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get()->toArray();

            // ==== ถ้า SOLUTION ของสินค้าที่เปิดอยู่ ไม่อยู่ในลิสต์ → เติมเข้าไป พร้อมพยายามดึง DESCRIPTION จากทุกแบรนด์ ====
            if (!in_array($data->SOLUTION, array_column($solutions, 'SOLUTION'))) {
                $descAnyBrand = Solution::where('ID', $data->SOLUTION)->value('DESCRIPTION');

                $solutions[] = [
                    'SOLUTION'    => $data->SOLUTION,
                    'DESCRIPTION' => $descAnyBrand ?? $data->SOLUTION, // ถ้าไม่เจอจริง ๆ ค่อย fallback เป็น ID
                    'BRAND'       => $brandCode,
                ];
            }

            $series = Series::select(
                'ID AS SERIES',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get()->toArray();

            // ==== ถ้า SERIES ของสินค้าที่เปิดอยู่ ไม่อยู่ในลิสต์ → เติมเข้าไป พร้อมพยายามดึง DESCRIPTION จากทุกแบรนด์ ====
            if (!in_array($data->SERIES, array_column($series, 'SERIES'))) {
                $descAnyBrand = Series::where('ID', $data->SERIES)->value('DESCRIPTION');

                $series[] = [
                    'SERIES'    => $data->SERIES,
                    'DESCRIPTION' => $descAnyBrand ?? $data->SERIES, // ถ้าไม่เจอจริง ๆ ค่อย fallback เป็น ID
                    'BRAND'       => $brandCode,
                ];
            }

            // $categorys = Category::select(
            //     'ID AS CATEGORY',
            //     'DESCRIPTION',
            //     'BRAND')
            // ->where('BRAND', $userpermission)
            // ->get()->toArray();
            // if (!in_array($data->CATEGORY, array_column($categorys, 'CATEGORY')))
            // {
            //     $categorys[] =  [
            //         'CATEGORY' => $data->CATEGORY,
            //         'DESCRIPTION' => $data->CATEGORY,
            //     ];
            // }

            $categorys = Category::select(
                'ID AS CATEGORY',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get()->toArray();
            // ==== ถ้า CATEGORY ของสินค้าที่เปิดอยู่ ไม่อยู่ในลิสต์ → เติมเข้าไป พร้อมพยายามดึง DESCRIPTION จากทุกแบรนด์ ====
            if (!in_array($data->CATEGORY, array_column($categorys, 'CATEGORY'))) {
                $descAnyBrand = Category::where('ID', $data->CATEGORY)->value('DESCRIPTION');

                $categorys[] = [
                    'CATEGORY'    => $data->CATEGORY,
                    'DESCRIPTION' => $descAnyBrand ?? $data->CATEGORY, // ถ้าไม่เจอจริง ๆ ค่อย fallback เป็น ID
                    'BRAND'       => $brandCode,
                ];
            }

            $sub_categorys = Sub_category::select(
                'ID AS S_CAT',
                'CATEGORY_ID',
                'DESCRIPTION',
                'BRAND')
            ->where('BRAND', $userpermission)
            ->get()->toArray();
            // ==== ถ้า S_CAT ของสินค้าที่เปิดอยู่ ไม่อยู่ในลิสต์ → เติมเข้าไป พร้อมพยายามดึง DESCRIPTION จากทุกแบรนด์ ====
            if (!in_array($data->S_CAT, array_column($sub_categorys, 'S_CAT'))) {
                $descAnyBrand = Sub_category::where('ID', $data->S_CAT)->value('DESCRIPTION');

                $sub_categorys[] = [
                    'S_CAT'    => $data->S_CAT,
                    'DESCRIPTION' => $descAnyBrand ?? $data->S_CAT, // ถ้าไม่เจอจริง ๆ ค่อย fallback เป็น ID
                    'BRAND'       => $brandCode,
                ];
            }

            $pdms = Pdm::select(
                'ID AS PDM_GROUP',
                'REMARK',
                'BRAND')
            ->where('BRAND', $userpermission)
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
            ->where('BRAND', $userpermission)
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
            ->where('BRAND', $userpermission)
            ->get()->toArray();
            if (!in_array($data->UNIT_TYPE, array_column($unit_types, 'UNIT_TYPE')))
            {
                $unit_types[] =  [
                    'UNIT_TYPE' => $data->UNIT_TYPE,
                ];
            }
        }

        // dd($categorys);
        // dd($solutions);

        // ✅ ดึง BOM FG จาก SAP API (cache 10 นาที)
        $bomCodes = [];
        $endpoint = "http://sapkmacc.ssup.co.th/api/bom/bulk";
        $raw = Cache::remember('sap_bom_bulk_raw', 600, function () use ($endpoint) {
            return Http::timeout(30)->get($endpoint)->body();
        });
        $bomData = json_decode($raw, true);
        if (is_array($bomData)) {
            $productId = (string) $PRODUCT;
            foreach ($bomData as $k => $items) {
                $kStr = (string) $k;
                if ($kStr === $productId || str_starts_with($kStr, $productId)) {
                    if (is_array($items)) {
                        foreach ($items as $row) {
                            if (is_array($row) && isset($row['code'])) {
                                $bomCodes[] = [
                                    'code'     => $row['code'] ?? '',
                                    'name'     => $row['name'] ?? '',
                                    'inactive' => $row['inactive'] ?? 'N',
                                ];
                            }
                        }
                    }
                }
            }
        }

        return view('product.edit', compact('data', 'multiChannels', 'allBrands', 'defaultBrands', 'owners', 'grp_ps', 'brand_ps', 'venders', 'type_gs', 'solutions', 'series', 'categorys', 'sub_categorys', 'pdms', 'p_statuss', 'unit_ps', 'unit_types', 'acctypes', 'conditions', 'bomCodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $PRODUCT)
    {
        // dd($request);
        // dd(strlen($PRODUCT));

        $now = Carbon::now(); // ใช้ภายในเมธอดพอ

        DB::beginTransaction();
        try {
            if (strlen($PRODUCT) > 5) {

                $isSuperAdmin = (Auth::user()->id === 26);
                $userPermissionFull = Auth::user()->getUserPermission->name_position ?? '';
                $namePositionParts = explode('-', $userPermissionFull);
                $userpermission = trim(end($namePositionParts)); // brand/suffix

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
                    $logProductUpddate = Product1Log::create($data_consumables_old_arr);
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
                    'BAR_PACK1' => $request->input('BAR_PACK1'),
                    'BAR_PACK2' => $request->input('BAR_PACK2'),
                    'BAR_PACK3' => $request->input('BAR_PACK3'),
                    'BAR_PACK4' => $request->input('BAR_PACK4'),
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
                    'TYPE_G' => $request->input('TYPE_G'),
                    'OPT_DATE1' => $request->input('OPT_DATE1'),
                    'OPT_DATE2' => $request->input('OPT_DATE2'),
                    'OPT_TXT2' => $request->input('OPT_TXT2'),
                    'OPT_NUM1' => $request->input('OPT_NUM1'),
                    'OPT_NUM2' => $request->input('OPT_NUM2'),
                    'ACC_TYPE' => $request->input('ACC_TYPE'),
                    'ACC_DT' => $request->input('ACC_DT'),
                    'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                    'NON_VAT' => is_null($request->input('NON_VAT')) ? '' : 'Y',
                    'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                    'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                    'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                    'USER_EDIT' => Auth::user()->username,
                    'EDIT_DT' => date("Y-m-d"),
                    'STATUS_EDIT_DT' => '',
                ];

                // dd($data_product_upddate);

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

                // dd($data_product_upddate);
                // อัปเดตข้อมูล
                Product1::where('PRODUCT', $PRODUCT)->update($data_product_upddate);

                // ดึงข้อมูลล่าสุดหลังจากอัปเดต
                $productUpddateConsumables = Product1::where('PRODUCT', $PRODUCT)->first();

                // dd($productUpddateConsumables);
                // Phase 2
                // ตรวจสอบว่าพบข้อมูลหรือไม่ ก่อนใช้งานตัวแปร
                if ($productUpddateConsumables && $productUpddateConsumables->BRAND == 'CPS') {
                    // ค้นหาข้อมูลเดิมจาก ProductDetail
                    $data_consumables_old_product_detail = ProductDetail::where('product_id', $PRODUCT)->first();

                    // ตรวจสอบว่าเจอข้อมูลหรือไม่
                    if ($data_consumables_old_product_detail) {
                        $data_product_detail_consumables_old_arr = $data_consumables_old_product_detail->toArray();

                        // เพิ่ม Log ถ้ามีค่าที่ต้องการอัปเดต
                        $log = [
                            'update_dt' => date("Y/m/d H:i:s"),
                            'user_update' => Auth::user()->username,
                        ];

                        $data_product_detail_consumables_old_arr = array_merge($data_product_detail_consumables_old_arr, $log);
                        ProductDetailLog::create($data_product_detail_consumables_old_arr);
                    }
                    // อัปเดตหรือสร้างข้อมูลใหม่
                    ProductDetail::updateOrCreate(
                        ['product_id' => $PRODUCT],
                        [
                            'corporation_id' => $productUpddateConsumables->BRAND,
                            'fad' => $productUpddateConsumables->REGISTER ?? '',
                            'inner_barcode' => $productUpddateConsumables->BAR_PACK1 ?? '',
                            'inner_pack_size' => $productUpddateConsumables->PACK_SIZE1 ?? '',
                            'upd_user' => Auth::user()->username,
                            'upd_date' => date("Y/m/d H:i:s"),
                        ]
                    );

                    // ค้นหาข้อมูลเดิมจาก ProductOther
                    $data_consumables_old_product_other = ProductOther::where('product_id', $PRODUCT)->first();

                    // ตรวจสอบว่าเจอข้อมูลหรือไม่
                    if ($data_consumables_old_product_other) {
                        $data_product_other_consumables_old_arr = $data_consumables_old_product_other->toArray();

                        // เพิ่ม Log ถ้ามีค่าที่ต้องการอัปเดต
                        $log = [
                            'update_dt' => date("Y/m/d H:i:s"),
                            'user_update' => Auth::user()->username,
                        ];

                        $data_product_other_consumables_old_arr = array_merge($data_product_other_consumables_old_arr, $log);
                        ProductOtherLog::create($data_product_other_consumables_old_arr);
                    }
                    // อัปเดตหรือสร้างข้อมูลใหม่
                    ProductOther::updateOrCreate(['product_id' => $PRODUCT],
                        [
                            'corporation_id' => $productUpddateConsumables->BRAND,
                            'item_name' => $productUpddateConsumables->NAME_ENG ?? '',
                            'cat_name' => $productUpddateConsumables->CATEGORY ?? '',
                            'upd_user' => Auth::user()->username,
                            'upd_date' => date("Y/m/d H:i:s"),
                        ]
                    );
                    // ค้นหาข้อมูลเดิมจาก ComProduct
                    // --- Log ของ com_products (แหล่ง) ---
                    if ($old = Com_product::where('product_id', $PRODUCT)->first()) {
                        ComProductLog::create(array_merge($old->toArray(), [
                            'update_dt'   => $now->format('Y-m-d H:i:s'),
                            'user_update' => Auth::user()->username,
                        ]));
                    }

                    // --- อัปเดตแหล่ง (mysql) ---
                    $updateComProduct = Com_product::updateOrCreate(
                        ['product_id' => $PRODUCT],
                        [
                            'company_id' => $productUpddateConsumables->BRAND,
                            'barcode'    => $productUpddateConsumables->BARCODE,
                            'vendor_id'  => $productUpddateConsumables->VENDOR ?? '',
                            'name_thai'  => $productUpddateConsumables->NAME_THAI ?? '',
                            'name_eng'   => $productUpddateConsumables->NAME_ENG ?? '',
                            'short_thai' => $productUpddateConsumables->SHORT_THAI ?? '',
                            'short_eng'  => $productUpddateConsumables->SHORT_ENG ?? '',
                            'price'      => $productUpddateConsumables->PRICE ?? '',
                            'cost'       => $productUpddateConsumables->COST ?? '',
                            'unit_id'       => $productUpddateConsumables->UNIT ?? '',
                            'capacity'       => $productUpddateConsumables->UNIT_Q ?? '',
                            'non_vat'       => $productUpddateConsumables->NON_VAT ?? '',
                            'status'       => $productUpddateConsumables->STATUS ?? '',
                            'gp'       => $productUpddateConsumables->GP ?? '',
                            'return'       => $productUpddateConsumables->RETURN ?? '',
                            'o_product'       => $productUpddateConsumables->O_PRODUCT ?? '',
                            'acc_type'       => $productUpddateConsumables->ACC_TYPE ?? '',
                            'group2'       => $productUpddateConsumables->TYPE_G ?? '',
                            'series'       => $productUpddateConsumables->SERIES ?? '',
                            'solution'       => $productUpddateConsumables->SOLUTION ?? '',
                            'category'       => $productUpddateConsumables->CATEGORY ?? '',
                            'upd_user'   => Auth::user()->username . '(' . $userpermission . ')',
                            'status_tranfer_km' => '',
                            'update_dt'  => $now->format('Y-m-d H:i:s'),
                        ]
                    );

                    // --- เตรียม payload เฉพาะคอลัมน์ที่ปลายทางมีจริง ---
                    $payloadExternal = [
                        'product_id' => $PRODUCT,
                        'company_id' => $productUpddateConsumables->BRAND,
                        'barcode'    => $productUpddateConsumables->BARCODE,
                        'vendor_id'  => $productUpddateConsumables->VENDOR ?? '',
                        'name_thai'  => $productUpddateConsumables->NAME_THAI ?? '',
                        'name_eng'   => $productUpddateConsumables->NAME_ENG ?? '',
                        'short_thai' => $productUpddateConsumables->SHORT_THAI ?? '',
                        'short_eng'  => $productUpddateConsumables->SHORT_ENG ?? '',
                        'price'      => $productUpddateConsumables->PRICE ?? '',
                        'cost'       => $productUpddateConsumables->COST ?? '',
                        'unit_id'       => $productUpddateConsumables->UNIT ?? '',
                        'capacity'       => $productUpddateConsumables->UNIT_Q ?? '',
                        'non_vat'       => $productUpddateConsumables->NON_VAT ?? '',
                        'status'       => $productUpddateConsumables->STATUS ?? '',
                        'gp'       => $productUpddateConsumables->GP ?? '',
                        'return'       => $productUpddateConsumables->RETURN ?? '',
                        'o_product'       => $productUpddateConsumables->O_PRODUCT ?? '',
                        'acc_type'       => $productUpddateConsumables->ACC_TYPE ?? '',
                        'group2'       => $productUpddateConsumables->TYPE_G ?? '',
                        'series'       => $productUpddateConsumables->SERIES ?? '',
                        'solution'       => $productUpddateConsumables->SOLUTION ?? '',
                        'category'       => $productUpddateConsumables->CATEGORY ?? '',
                        'upd_user'   => Auth::user()->username . '(' . $userpermission . ')',
                        'status_tranfer_km' => '',
                        'update_dt'  => $now->format('Y-m-d H:i:s'),
                    ];

                    // --- เขียนปลายทาง (mysql_external) แบบ transaction ---
                    DB::connection('mysql_external')->transaction(function () use ($payloadExternal) {
                        ComProductExternal::updateOrCreate(
                            ['product_id' => $payloadExternal['product_id']],
                            $payloadExternal
                        );
                    });

                    $images = ComProductImage::updateOrCreate(['product_id' => $PRODUCT], [
                        'brand' => $productUpddateConsumables->BRAND,
                    ]);

                    // ---------- 2) บันทึก com_products ----------
                    $shippingCostCode = (int) ($productUpddateConsumables->BARCODE ?? 0);

                    $comUpdate = []; // payload ของ com_products (อย่าใส่ UPDATED_BY/UPDATED_AT ถ้าไม่มีคอลัมน์)

                    // ธงจัดส่งเฉพาะ com_products
                    if ($shippingCostCode >= 95090001 && $shippingCostCode <= 95090999) {
                        $comUpdate['status_delivery'] = 'Y';   // ใช้ชื่อคอลัมน์จริงใน com_products
                    }

                    // อยากอัปเดตฟิลด์อื่น ๆ ใน com_products ด้วยก็ใส่เพิ่มที่นี่ เช่น:
                    // $comUpdate['brand']   = $data_product['BRAND'];
                    // $comUpdate['barcode'] = $data_product['BARCODE'];

                    $dataComUpdate = Com_product::updateOrCreate(
                        ['product_id' => ['product_id' => $PRODUCT]],  // key ที่ชนต้องตรง unique key จริง
                        $comUpdate
                    );

                } else {

                    $productUpddateConsumables = Product1::where('PRODUCT', $PRODUCT)->first();

                    // ค้นหาข้อมูลเดิมจาก ComProduct
                    // --- Log ของ com_products (แหล่ง) ---
                    if ($old = Com_product::where('product_id', $PRODUCT)->first()) {
                        ComProductLog::create(array_merge($old->toArray(), [
                            'update_dt'   => $now->format('Y-m-d H:i:s'),
                            'user_update' => Auth::user()->username,
                        ]));
                    }

                    // --- อัปเดตแหล่ง (mysql) ---
                    $updateComProduct = Com_product::updateOrCreate(
                        ['product_id' => $PRODUCT],
                        [
                            'company_id' => $productUpddateConsumables->BRAND,
                            'barcode'    => $productUpddateConsumables->BARCODE,
                            'vendor_id'  => $productUpddateConsumables->VENDOR ?? '',
                            'name_thai'  => $productUpddateConsumables->NAME_THAI ?? '',
                            'name_eng'   => $productUpddateConsumables->NAME_ENG ?? '',
                            'short_thai' => $productUpddateConsumables->SHORT_THAI ?? '',
                            'short_eng'  => $productUpddateConsumables->SHORT_ENG ?? '',
                            'price'      => $productUpddateConsumables->PRICE ?? '',
                            'cost'       => $productUpddateConsumables->COST ?? '',
                            'unit_id'       => $productUpddateConsumables->UNIT ?? '',
                            'capacity'       => $productUpddateConsumables->UNIT_Q ?? '',
                            'non_vat'       => $productUpddateConsumables->NON_VAT ?? '',
                            'status'       => $productUpddateConsumables->STATUS ?? '',
                            'gp'       => $productUpddateConsumables->GP ?? '',
                            'return'       => $productUpddateConsumables->RETURN ?? '',
                            'o_product'       => $productUpddateConsumables->O_PRODUCT ?? '',
                            'acc_type'       => $productUpddateConsumables->ACC_TYPE ?? '',
                            'group2'       => $productUpddateConsumables->TYPE_G ?? '',
                            'series'       => $productUpddateConsumables->SERIES ?? '',
                            'solution'       => $productUpddateConsumables->SOLUTION ?? '',
                            'category'       => $productUpddateConsumables->CATEGORY ?? '',
                            'upd_user'   => Auth::user()->username . '(' . $userpermission . ')',
                            'status_tranfer_km' => '',
                            'update_dt'  => $now->format('Y-m-d H:i:s'),
                        ]
                    );

                    // dd($updateComProduct);

                    // --- เตรียม payload เฉพาะคอลัมน์ที่ปลายทางมีจริง ---
                    $payloadExternal = [
                        'product_id' => $PRODUCT,
                        'company_id' => $productUpddateConsumables->BRAND,
                        'barcode'    => $productUpddateConsumables->BARCODE,
                        'vendor_id'  => $productUpddateConsumables->VENDOR ?? '',
                        'name_thai'  => $productUpddateConsumables->NAME_THAI ?? '',
                        'name_eng'   => $productUpddateConsumables->NAME_ENG ?? '',
                        'short_thai' => $productUpddateConsumables->SHORT_THAI ?? '',
                        'short_eng'  => $productUpddateConsumables->SHORT_ENG ?? '',
                        'price'      => $productUpddateConsumables->PRICE ?? '',
                        'cost'       => $productUpddateConsumables->COST ?? '',
                        'unit_id'       => $productUpddateConsumables->UNIT ?? '',
                        'capacity'       => $productUpddateConsumables->UNIT_Q ?? '',
                        'non_vat'       => $productUpddateConsumables->NON_VAT ?? '',
                        'status'       => $productUpddateConsumables->STATUS ?? '',
                        'gp'       => $productUpddateConsumables->GP ?? '',
                        'return'       => $productUpddateConsumables->RETURN ?? '',
                        'o_product'       => $productUpddateConsumables->O_PRODUCT ?? '',
                        'acc_type'       => $productUpddateConsumables->ACC_TYPE ?? '',
                        'group2'       => $productUpddateConsumables->TYPE_G ?? '',
                        'series'       => $productUpddateConsumables->SERIES ?? '',
                        'solution'       => $productUpddateConsumables->SOLUTION ?? '',
                        'category'       => $productUpddateConsumables->CATEGORY ?? '',
                        'upd_user'   => Auth::user()->username . '(' . $userpermission . ')',
                        'status_tranfer_km' => '',
                        'update_dt'  => $now->format('Y-m-d H:i:s'),
                    ];

                    // dd($payloadExternal);

                    // --- เขียนปลายทาง (mysql_external) แบบ transaction ---
                    DB::connection('mysql_external')->transaction(function () use ($payloadExternal) {
                        ComProductExternal::updateOrCreate(
                            ['product_id' => $payloadExternal['product_id']],
                            $payloadExternal
                        );
                    });

                    $images = ComProductImage::updateOrCreate(['product_id' => $PRODUCT], [
                        'brand' => $productUpddateConsumables->BRAND,
                    ]);
                    
                    // ---------- 2) บันทึก com_products ----------
                    $shippingCostCode = (int) ($productUpddateConsumables->BARCODE ?? 0);

                    $comUpdate = []; // payload ของ com_products (อย่าใส่ UPDATED_BY/UPDATED_AT ถ้าไม่มีคอลัมน์)

                    // ธงจัดส่งเฉพาะ com_products
                    if ($shippingCostCode >= 95090001 && $shippingCostCode <= 95090999) {
                        $comUpdate['status_delivery'] = 'Y';   // ใช้ชื่อคอลัมน์จริงใน com_products
                    }

                    // อยากอัปเดตฟิลด์อื่น ๆ ใน com_products ด้วยก็ใส่เพิ่มที่นี่ เช่น:
                    // $comUpdate['brand']   = $data_product['BRAND'];
                    // $comUpdate['barcode'] = $data_product['BARCODE'];

                    $dataComUpdate = Com_product::updateOrCreate(
                        ['product_id' => ['product_id' => $PRODUCT]],  // key ที่ชนต้องตรง unique key จริง
                        $comUpdate
                    );
                    // dd($dataComUpdate);
                }
    
                //     $craeteProductAccountSchedule = ProductPriceSchedule::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                //         // 'price' => $productMaster->COST,
                //         'price' => 0,
                //         'status' => 0,
                //         'status_edit_dt' => '',
                //         'created_by' => Auth::user()->username,
                //         'created_at' => date("Y/m/d H:i:s")
                //     ]);

                DB::commit();
                $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
                return response()->json(['success' => true]);
            } else {

                $isSuperAdmin = (Auth::user()->id === 26);
                $userPermissionFull = Auth::user()->getUserPermission->name_position ?? '';
                $namePositionParts = explode('-', $userPermissionFull);
                $userpermission = trim(end($namePositionParts)); // brand/suffix

                // ค้นหาข้อมูลเดิมจาก Product1
                $data_old = Product1::where('PRODUCT', $PRODUCT)->first();

                // ตรวจสอบว่าเจอข้อมูลหรือไม่
                if ($data_old) {
                    $data_old_arr = $data_old->toArray();

                    // เพิ่ม Log ถ้ามีค่าที่ต้องการอัปเดต
                    $log = [
                        'UPDATE_DT' => date("Y/m/d H:i:s"),
                        'USER_UPDATE' => Auth::user()->username,
                    ];

                    $data_old_arr = array_merge($data_old_arr, $log);
                    Product1Log::create($data_old_arr);
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
                    'BAR_PACK1' => $request->input('BAR_PACK1'),
                    'BAR_PACK2' => $request->input('BAR_PACK2'),
                    'BAR_PACK3' => $request->input('BAR_PACK3'),
                    'BAR_PACK4' => $request->input('BAR_PACK4'),
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
                    'TYPE_G' => $request->input('TYPE_G'),
                    'OPT_DATE1' => $request->input('OPT_DATE1'),
                    'OPT_DATE2' => $request->input('OPT_DATE2'),
                    'OPT_TXT2' => $request->input('OPT_TXT2'),
                    'OPT_NUM1' => $request->input('OPT_NUM1'),
                    'OPT_NUM2' => $request->input('OPT_NUM2'),
                    'ACC_TYPE' => $request->input('ACC_TYPE'),
                    'ACC_DT' => $request->input('ACC_DT'),
                    'RETURN' => is_null($request->input('RETURN')) ? 'N' : 'Y',
                    'NON_VAT' => is_null($request->input('NON_VAT')) ? '' : 'Y',
                    'STORAGE_TEMP' => is_null($request->input('STORAGE_TEMP')) ? 'N' : 'Y',
                    'CONTROL_STK' => is_null($request->input('CONTROL_STK')) ? 'N' : 'Y',
                    'TESTER' =>  is_null($request->input('TESTER')) ? 'N' : 'Y',
                    'USER_EDIT' => Auth::user()->username,
                    'EDIT_DT' => date("Y-m-d"),
                    'STATUS_EDIT_DT' => '',
                ];

                // dd($data_product_upddate);

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

                // dd($data_product_upddate);
                // อัปเดตข้อมูล
                Product1::where('PRODUCT', $PRODUCT)->update($data_product_upddate);

                // ดึงข้อมูลล่าสุดหลังจากอัปเดต
                $productUpddate = Product1::where('PRODUCT', $PRODUCT)->first();

                // dd($productUpddate);
                // Phase 2
                // ตรวจสอบว่าพบข้อมูลหรือไม่ ก่อนใช้งานตัวแปร
                if ($productUpddate && $productUpddate->BRAND == 'CPS') {
                    // ค้นหาข้อมูลเดิมจาก ProductDetail
                    $data_old_product_detail = ProductDetail::where('product_id', $PRODUCT)->first();

                    // ตรวจสอบว่าเจอข้อมูลหรือไม่
                    if ($data_old_product_detail) {
                        $data_product_detail_old_arr = $data_old_product_detail->toArray();

                        // เพิ่ม Log ถ้ามีค่าที่ต้องการอัปเดต
                        $log = [
                            'update_dt' => date("Y/m/d H:i:s"),
                            'user_update' => Auth::user()->username,
                        ];

                        $data_product_detail_old_arr = array_merge($data_product_detail_old_arr, $log);
                        ProductDetailLog::create($data_product_detail_old_arr);
                    }
                    // อัปเดตหรือสร้างข้อมูลใหม่
                    $upddateProductDetail = ProductDetail::updateOrCreate(
                        ['product_id' => $PRODUCT],
                        [
                            'corporation_id' => $productUpddate->BRAND,
                            'fad' => $productUpddate->REGISTER ?? '',
                            'inner_barcode' => $productUpddate->BAR_PACK1 ?? '',
                            'inner_pack_size' => $productUpddate->PACK_SIZE1 ?? '',
                            'case_barcode' => $productUpddate->BAR_PACK2 ?? '',
                            'case_pack_size' => $productUpddate->PACK_SIZE2 ?? '',
                            'upd_user' => Auth::user()->username,
                            'upd_date' => date("Y/m/d H:i:s"),
                        ]
                    );

                    // ค้นหาข้อมูลเดิมจาก ProductOther
                    $data_old_product_other = ProductOther::where('product_id', $PRODUCT)->first();

                    // ตรวจสอบว่าเจอข้อมูลหรือไม่
                    if ($data_old_product_other) {
                        $data_product_other_old_arr = $data_old_product_other->toArray();

                        // เพิ่ม Log ถ้ามีค่าที่ต้องการอัปเดต
                        $log = [
                            'update_dt' => date("Y/m/d H:i:s"),
                            'user_update' => Auth::user()->username,
                        ];

                        $data_product_other_old_arr = array_merge($data_product_other_old_arr, $log);
                        ProductOtherLog::create($data_product_other_old_arr);
                    }
                    // อัปเดตหรือสร้างข้อมูลใหม่
                    $updateProductOther = ProductOther::updateOrCreate(['product_id' => $PRODUCT],
                        [
                            'corporation_id' => $productUpddate->BRAND,
                            'item_name'      => $productUpddate->NAME_ENG ?? '',
                            'cat_name'       => $productUpddate->CATEGORY ?? '',
                            'upd_user'       => Auth::user()->username,
                            'upd_date'       => date("Y/m/d H:i:s"),
                        ]
                    );
                    // ค้นหาข้อมูลเดิมจาก ComProduct
                    // --- Log ของ com_products (แหล่ง) ---
                    if ($old = Com_product::where('product_id', $PRODUCT)->first()) {
                        ComProductLog::create(array_merge($old->toArray(), [
                            'update_dt'   => $now->format('Y-m-d H:i:s'),
                            'user_update' => Auth::user()->username,
                        ]));
                    }

                    // --- อัปเดตแหล่ง (mysql) ---
                    $updateComProduct = Com_product::updateOrCreate(
                        ['product_id' => $PRODUCT],
                        [
                            'company_id'        => $productUpddate->BRAND,
                            'barcode'           => $productUpddate->BARCODE,
                            'vendor_id'         => $productUpddate->VENDOR ?? '',
                            'name_thai'         => $productUpddate->NAME_THAI ?? '',
                            'name_eng'          => $productUpddate->NAME_ENG ?? '',
                            'short_thai'        => $productUpddate->SHORT_THAI ?? '',
                            'short_eng'         => $productUpddate->SHORT_ENG ?? '',
                            'price'             => $productUpddate->PRICE ?? '',
                            'cost'              => $productUpddate->COST ?? '',
                            'unit_id'       => $productUpddate->UNIT ?? '',
                            'capacity'       => $productUpddate->UNIT_Q ?? '',
                            'non_vat'       => $productUpddate->NON_VAT ?? '',
                            'status'       => $productUpddate->STATUS ?? '',
                            'gp'       => $productUpddate->GP ?? '',
                            'return'       => $productUpddate->RETURN ?? '',
                            'o_product'       => $productUpddate->O_PRODUCT ?? '',
                            // 'shelf_life'       => $productUpddate->AGE ?? '',
                            'acc_type'       => $productUpddate->ACC_TYPE ?? '',
                            'group2'       => $productUpddate->TYPE_G ?? '',
                            'series'       => $productUpddate->SERIES ?? '',
                            'solution'       => $productUpddate->SOLUTION ?? '',
                            'category'       => $productUpddate->CATEGORY ?? '',
                            'upd_user'          => Auth::user()->username . '(' . $userpermission . ')',
                            'status_tranfer_km' => '',
                            'update_dt'         => $now->format('Y-m-d H:i:s'),
                        ]
                    );

                    // dd($updateComProduct);

                    // --- เตรียม payload เฉพาะคอลัมน์ที่ปลายทางมีจริง ---
                    $payloadExternal = [
                        'product_id'        => $PRODUCT,
                        'company_id'        => $productUpddate->BRAND,
                        'barcode'           => $productUpddate->BARCODE,
                        'vendor_id'         => $productUpddate->VENDOR ?? '',
                        'name_thai'         => $productUpddate->NAME_THAI ?? '',
                        'name_eng'          => $productUpddate->NAME_ENG ?? '',
                        'short_thai'        => $productUpddate->SHORT_THAI ?? '',
                        'short_eng'         => $productUpddate->SHORT_ENG ?? '',
                        'price'             => $productUpddate->PRICE ?? '',
                        'cost'              => $productUpddate->COST ?? '',
                        'unit_id'       => $productUpddate->UNIT ?? '',
                        'capacity'       => $productUpddate->UNIT_Q ?? '',
                        'non_vat'       => $productUpddate->NON_VAT ?? '',
                        'status'       => $productUpddate->STATUS ?? '',
                        'gp'       => $productUpddate->GP ?? '',
                        'return'       => $productUpddate->RETURN ?? '',
                        'o_product'       => $productUpddate->O_PRODUCT ?? '',
                        // 'shelf_life'       => $productUpddate->AGE ?? '',
                        'acc_type'       => $productUpddate->ACC_TYPE ?? '',
                        'group2'       => $productUpddate->TYPE_G ?? '',
                        'series'       => $productUpddate->SERIES ?? '',
                        'solution'       => $productUpddate->SOLUTION ?? '',
                        'category'       => $productUpddate->CATEGORY ?? '',
                        'upd_user'          => Auth::user()->username . '(' . $userpermission . ')',
                        'status_tranfer_km' => '',
                        'update_dt'         => $now->format('Y-m-d H:i:s'),
                    ];

                    // dd($payloadExternal);

                    // --- เขียนปลายทาง (mysql_external) แบบ transaction ---
                    DB::connection('mysql_external')->transaction(function () use ($payloadExternal) {
                        ComProductExternal::updateOrCreate(
                            ['product_id' => $payloadExternal['product_id']],
                            $payloadExternal
                        );
                    });

                    $images = ComProductImage::updateOrCreate(['product_id' => $PRODUCT], [
                        'brand' => $productUpddate->BRAND,
                    ]);

                } else {

                    // ค้นหาข้อมูลเดิมจาก ComProduct
                    // --- Log ของ com_products (แหล่ง) ---
                    if ($old = Com_product::where('product_id', $PRODUCT)->first()) {
                        ComProductLog::create(array_merge($old->toArray(), [
                            'update_dt'   => $now->format('Y-m-d H:i:s'),
                            'user_update' => Auth::user()->username,
                        ]));
                    }

                    // dd($productUpddate->PRICE);
                    // --- อัปเดตแหล่ง (mysql) ---
                    $updateComProduct = Com_product::updateOrCreate(
                        ['product_id' => $PRODUCT],
                        [
                            'company_id' => $productUpddate->BRAND,
                            'barcode'    => $productUpddate->BARCODE,
                            'vendor_id'  => $productUpddate->VENDOR ?? '',
                            'name_thai'  => $productUpddate->NAME_THAI ?? '',
                            'name_eng'   => $productUpddate->NAME_ENG ?? '',
                            'short_thai' => $productUpddate->SHORT_THAI ?? '',
                            'short_eng'  => $productUpddate->SHORT_ENG ?? '',
                            'price'      => $productUpddate->PRICE ?? '',
                            'cost'       => $productUpddate->COST ?? '',
                            'unit_id'       => $productUpddate->UNIT ?? '',
                            'capacity'       => $productUpddate->UNIT_Q ?? '',
                            'non_vat'       => $productUpddate->NON_VAT ?? '',
                            'status'       => $productUpddate->STATUS ?? '',
                            'gp'       => $productUpddate->GP ?? '',
                            'return'       => $productUpddate->RETURN ?? '',
                            'o_product'       => $productUpddate->O_PRODUCT ?? '',
                            // 'shelf_life'       => $productUpddate->AGE ?? '',
                            'acc_type'       => $productUpddate->ACC_TYPE ?? '',
                            'group2'       => $productUpddate->TYPE_G ?? '',
                            'series'       => $productUpddate->SERIES ?? '',
                            'solution'       => $productUpddate->SOLUTION ?? '',
                            'category'       => $productUpddate->CATEGORY ?? '',
                            'upd_user'   => Auth::user()->username . '(' . $userpermission . ')',
                            'status_tranfer_km' => '',
                            'update_dt'  => $now->format('Y-m-d H:i:s'),
                        ]
                    );

                    // --- เตรียม payload เฉพาะคอลัมน์ที่ปลายทางมีจริง ---
                    $payloadExternal = [
                        'product_id' => $PRODUCT,
                        'company_id' => $productUpddate->BRAND,
                        'barcode'    => $productUpddate->BARCODE,
                        'vendor_id'  => $productUpddate->VENDOR ?? '',
                        'name_thai'  => $productUpddate->NAME_THAI ?? '',
                        'name_eng'   => $productUpddate->NAME_ENG ?? '',
                        'short_thai' => $productUpddate->SHORT_THAI ?? '',
                        'short_eng'  => $productUpddate->SHORT_ENG ?? '',
                        'price'      => $productUpddate->PRICE ?? '',
                        'cost'       => $productUpddate->COST ?? '',
                        'unit_id'       => $productUpddate->UNIT ?? '',
                        'capacity'       => $productUpddate->UNIT_Q ?? '',
                        'non_vat'       => $productUpddate->NON_VAT ?? '',
                        'status'       => $productUpddate->STATUS ?? '',
                        'gp'       => $productUpddate->GP ?? '',
                        'return'       => $productUpddate->RETURN ?? '',
                        'o_product'       => $productUpddate->O_PRODUCT ?? '',
                        // 'shelf_life'       => $productUpddate->AGE ?? '',
                        'acc_type'       => $productUpddate->ACC_TYPE ?? '',
                        'group2'       => $productUpddate->TYPE_G ?? '',
                        'series'       => $productUpddate->SERIES ?? '',
                        'solution'       => $productUpddate->SOLUTION ?? '',
                        'category'       => $productUpddate->CATEGORY ?? '',
                        'upd_user'   => Auth::user()->username . '(' . $userpermission . ')',
                        'status_tranfer_km' => '',
                        'update_dt'  => $now->format('Y-m-d H:i:s'),
                    ];

                    // --- เขียนปลายทาง (mysql_external) แบบ transaction ---
                    DB::connection('mysql_external')->transaction(function () use ($payloadExternal) {
                        ComProductExternal::updateOrCreate(
                            ['product_id' => $payloadExternal['product_id']],
                            $payloadExternal
                        );
                    });

                    $images = ComProductImage::updateOrCreate(['product_id' => $PRODUCT], [
                        'brand' => $productUpddate->BRAND,
                    ]);
                }
    
                //     $craeteProductAccountSchedule = ProductPriceSchedule::updateOrCreate(['product_id' => $data_product['PRODUCT']], [
                //         // 'price' => $productMaster->COST,
                //         'price' => 0,
                //         'status' => 0,
                //         'status_edit_dt' => '',
                //         'created_by' => Auth::user()->username,
                //         'created_at' => date("Y/m/d H:i:s")
                //     ]);

                // dd($attributes = [
                //     'productUpddate' => $productUpddate->toArray(),
                //     // 'craeteProductAccount' => $craeteProductAccount->toArray(),
                //     'upddateProductDetail' => $upddateProductDetail->toArray(),
                //     'updateProductOther' => $updateProductOther->toArray(),
                //     'updateComProduct' => $updateComProduct->toArray(),
                //     // 'craeteProductAccountSchedule' => $craeteProductAccountSchedule->toArray(),
                // ]);

                // dd(1);
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
        // $limit = $request->input('length'); // limit per page
        // $request->merge([
        //     'page' => ceil(($request->input('start') + 1) / $limit),
        // ]);
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $BRAND = $request->input('brand_id');
        $searchAll = $request->input('search', '');

        $data = Product1::select(
            'BRAND',
            'GRP_P',
            'PRODUCT',
            'BARCODE',
            'NAME_THAI'
        )
        // ->orderBy('PRODUCT', 'DESC');
        ->orderBy('EDIT_DT', 'DESC');

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
            ->orderBy('EDIT_DT', 'DESC');
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
            ->orderBy('EDIT_DT', 'DESC');

        } else if ($userpermission == 'CPS') {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->where('BRAND', 'CPS')
            ->orderBy('EDIT_DT', 'DESC');
        } else if ($userpermission == 'ACC') {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->whereIn('BRAND', ['OP', 'CPS', 'KTY', 'GNC', 'BB', 'LL', 'KM'])
            ->orderBy('EDIT_DT', 'DESC');
        } else {
            $data = Product1::select(
                'BRAND',
                'GRP_P',
                'PRODUCT',
                'BARCODE',
                'NAME_THAI'
            )
            ->where('BRAND', $userpermission)
            ->orderBy('EDIT_DT', 'DESC');
        }

        if ($userpermission == 'OP') {
            // dd($data);
            if ($BRAND != null) {
                $data->where('product1s.GRP_P', $BRAND);
            }
        } else {
            // dd($data);
            if ($BRAND != null) {
                $data->where('product1s.BRAND', $BRAND);
            }
        }

        // กรองข้อมูลถ้ามีคำค้นหา
        if (!empty($searchAll)) {
            $data->where(function ($q) use ($searchAll) {
                $q->orWhere('PRODUCT', 'like', '%' . $searchAll . '%')
                ->orWhere('NAME_THAI', 'like', '%' . $searchAll . '%')
                ->orWhere('BARCODE', 'like', '%' . $searchAll . '%');
            });
        }

        // Sorting - Mapping column index to database column name
        $sortableColumns = [
            // 0 => 'BRAND',
            // 1 => 'GRP_P',
            2 => 'PRODUCT',
            // 3 => 'NAME_THAI',
            // 4 => 'BARCODE',
        ];

        if (isset($request->order[0])) {
            $columnIndex = $request->order[0]['column'];
            $sortDirection = $request->order[0]['dir'];

            if (isset($sortableColumns[$columnIndex])) {
                $data->reorder($sortableColumns[$columnIndex], $sortDirection);
            }
        }

        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        // 🔹 ตรวจสอบ limit
        if ($limit > 0) {
            $data->limit($limit)->offset($start);
        }
        // 🔹 ดึงข้อมูลตาม limit และ offset
        $records = $data->get();

        return response()->json([
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
            'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
            'aaData' => $records,
        ]);
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
