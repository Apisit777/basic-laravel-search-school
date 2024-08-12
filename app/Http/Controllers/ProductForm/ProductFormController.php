<?php

namespace App\Http\Controllers\ProductForm;

use App\Models\Product;
use App\Models\position;
use App\Models\User;
use App\Models\Brand;
use App\Models\Npd_cos;
use App\Models\Npd_pdms;
use App\Models\Npd_categorys;
use App\Models\Npd_textures;
use App\Models\Pro_develops;
use App\Models\Barcode;
use App\Models\Document;
use App\Models\menu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use stdClass;
class ProductFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::toSql();
        $product_seq = Product::select('seq')->get();

        $data = Pro_develops::select(
            'BRAND',
            'REF_DOC',
            'DOC_NO',
            'BARCODE'
        )
        ->orderBy('BARCODE', 'ASC');
        $productCodes = $data->select('BARCODE')->pluck('BARCODE')->toArray();

        // $productCodes = Pro_develops::select('BARCODE')->pluck('BARCODE')->toArray();
        $productCodeArr = [];
        foreach($productCodes as $productCodeLast) {
            $productCodeArrLast = [];
            $productCodeArrLast[] = substr_replace($productCodeLast, '', -1);
            foreach($productCodeArrLast as $productCodeFirst) {
                $productCodeArr[] = substr($productCodeFirst, 7, 11);
            }
        }

        $authPosition = Auth::user()->getUserPermission->position_id;
        $menusAuthPosition = menu::with('submenus')
            ->with('getMenuRelation')
            ->whereHas('getMenuRelation', function ($query) use ($authPosition){
                $query->where('menu_relations.position_id', $authPosition);
                // ->whereNotNull('position_id');
            })
        ->get();

        // Permission
        // $Permissions = new STDClass();
        // $Permissions->create = Auth::user()->hasPermission('create');
        // dd($postComment);
        
        return view('new_product_develop.index', compact('user', 'product_seq', 'productCodeArr'));
    }

    private function ean13_check_digit()
    {
        $lastElement = Pro_develops::max('BARCODE');
        $barcodeMax = substr_replace($lastElement, '', -1);
        $barcodeNumber =  preg_replace('/[^0-9]/', '', $barcodeMax) + 1;
        $barcode = sprintf('%04d', $barcodeNumber);
        // $lastElement = (string)'8850080200010';
        //first change digits to a string so that we can access individual numbers
        $digits =(string)$barcode;
        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        // 2. Multiply this result by 3.
        $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        // 4. Sum the results of steps 2 and 3.
        $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;
        return $digits . $check_digit;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        // $odd_numbers = array_filter($numbers, function($number) {
        //     return $number % 2 != 0;
        // });
        // dd($odd_numbers);

        $digits_barcode = $this->ean13_check_digit();
        $productCodeMax = Document::max('NUMBER');
        $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        $productCode = '2'.sprintf('%04d', $productCodeNumber);

        $list_position = position::select('id', 'name_position')->get();
        $product_co_ordimators = Npd_cos::all();
        $marketing_managers = Npd_pdms::all();
        $type_categorys = Npd_categorys::all();
        $textures = Npd_textures::all();

        $brands = Barcode::select('BRAND')->pluck('BRAND')->toArray();
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        // dd($userpermission);
        if (in_array($userpermission, [$isSuperAdmin])) {
            $brands = Barcode::select(
                'BRAND')
            ->pluck('BRAND')
            ->toArray();
        } else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['OP', 'ALL'])
            ->pluck('BRAND')
            ->toArray();
        } else if (in_array($userpermission, ['Marketing - CPS'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['CP', 'ALL'])
            ->pluck('BRAND')
            ->toArray();
        }
        $testBarcode = Barcode::all();
        // dd($brands);


        return view('new_product_develop.create', compact('productCode', 'digits_barcode', 'list_position', 'brands', 'testBarcode', 'product_co_ordimators', 'marketing_managers', 'type_categorys', 'textures'));
    }

    public function getBrandListAjax(Request $request)
    {
        // $productCodes = Pro_develops::select('BARCODE')->pluck('BARCODE')->toArray();
        // $productCodeArr = [];
        // foreach($productCodes as $productCodeLast) {
        //     $productCodeArrLast = [];
        //     $productCodeArrLast[] = substr_replace($productCodeLast, '', -1);
        //     foreach($productCodeArrLast as $productCodeFirst) {
        //         $productCodeArr[] = substr($productCodeFirst, 7, 11);
        //     }
        // }

        $Pro_develops = new Pro_develops();
        $codeArr = $Pro_develops->listBrandProDevelops(['BRAND' => (int) $request->input('BRAND'), 'orderby' => 'BARCODE']);
        // $productCodesObject = json_decode(json_encode($productCodes));
        // $arr = json_decode(json_encode($productCodeArr));
        // $codeArr = $productCodesObject->listBrandProDevelops(['BRAND' => (int) $request->input('BRAND'), 'orderby' => $arr]);
        dd($codeArr);
        return response()->json($codeArr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            if($request->DOC_TP == "OP") {
                $productCodeMax = Document::max('NUMBER');
                $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
                $productCode = $productCodeNumber;

                $data_number = Document::updateOrCreate(['DOC_TP' => $request->DOC_TP], [
                    'NUMBER' => $productCode
                ]);
            }
            if($request->BRAND == "OP") {
                $productOPCodeMax = Barcode::where('BRAND', '=', 'OP')->max('NUMBER');
                $productCodeNumber =  preg_replace('/[^0-9]/', '', $productOPCodeMax) + 1;
                $productCode = $productCodeNumber;

                $data_number = Barcode::updateOrCreate(['BRAND' => $request->BRAND], [
                    'NUMBER' => $productCode
                ]);
            }

            $digits_barcode = $this->ean13_check_digit();

            $data_product = [
                'BRAND' => $request->input('BRAND'),
                'DOC_NO' => $request->input('DOC_NO'),
                'REF_DOC' => 'IBH-F155',
                'BARCODE' => $digits_barcode,
                'JOB_REFNO' => $request->input('JOB_REFNO'),
                'DOC_DT' => $request->input('DOC_DT'),
                'CUST_OEM' => $request->input('CUST_OEM'),
                'NPD' => $request->input('NPD'),
                'PDM' => $request->input('PDM'),
                'NAME_ENG' => $request->input('NAME_ENG'),
                'CATEGORY' => $request->input('CATEGORY'),
                'CAPACITY' => $request->input('CAPACITY'),
                'Q_SMELL' => $request->input('Q_SMELL'),
                'Q_COLOR' => $request->input('Q_COLOR'),
                'TARGET_GRP' => $request->input('TARGET_GRP'),
                'TARGET_STK' => $request->input('TARGET_STK'),
                'PRICE_FG' => $request->input('PRICE_FG'),
                'PRICE_COST' => $request->input('PRICE_COST'),
                'PRICE_BULK' => $request->input('PRICE_BULK'),
                'FIRST_ORD' => $request->input('FIRST_ORD'),
                'P_CONCEPT' => $request->input('P_CONCEPT'),
                'P_BENEFIT' => $request->input('P_BENEFIT'),
                'TEXTURE' => $request->input('TEXTURE'),
                'TEXTURE_OT' => $request->input('TEXTURE_OT'),
                'COLOR1' => $request->input('COLOR1'),
                'FRANGRANCE' => $request->input('FRANGRANCE'),
                'INGREDIENT' => $request->input('INGREDIENT'),
                'STD' => $request->input('STD'),
                'PK' => $request->input('PK'),
                'OTHER' => $request->input('OTHER'),
                'DOCUMENT' => $request->input('DOCUMENT'),
                'OEM' => $request->input('OEM'),
                'REASON1' => is_null($request->input('REASON1')) ? 'N' : 'Y',
                'REASON2' => is_null($request->input('REASON2')) ? 'N' : 'Y',
                'REASON2_DES' => $request->input('REASON2_DES'),
                'REASON3' => is_null($request->input('REASON3')) ? 'N' : 'Y',
                'REASON3_DES' => $request->input('REASON3_DES'),
                'PACKAGE_BOX' => $request->input('PACKAGE_BOX'),
                'REF_COLOR' => $request->input('REF_COLOR'),
                'REF_FRAGRANCE' => $request->input('REF_FRAGRANCE'),
                'OEM_STD' => $request->input('OEM_STD'),
            ];

            $product = Pro_develops::create($data_product);

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
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function checkname_brand(Request $request) {

        $data = User::select('id')
            ->where('name', $request->name)
            ->count();

        return response()->json($data > 0 ? false : true);
    }
}
