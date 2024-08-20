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
use App\Models\Account;
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

    public function indexAccount() 
    {
        $data = Pro_develops::select(
            'BRAND',
            'REF_DOC',
            'DOC_NO',
            'BARCODE'
        )
        ->orderBy('BARCODE', 'ASC');
        $productCodes = $data->select('BARCODE')->pluck('BARCODE')->toArray();
        $productCodeArr = [];
        foreach($productCodes as $productCodeLast) {
            $productCodeArrLast = [];
            $productCodeArrLast[] = substr_replace($productCodeLast, '', -1);
            foreach($productCodeArrLast as $productCodeFirst) {
                $productCodeArr[] = substr($productCodeFirst, 7, 11);
            }
        }

        return view('account.index', compact('productCodeArr'));
    }
    public function createAccount(Request $request)
    {
        // dd($productCode);
        return view('account.create');
    }
    public function editAccount(Request $request)
    {
        // dd($productCode);
        return view('account.edit');
    }
    public function listAjaxAccount(Request $request) 
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $data = Account::select(
                'id',
                'account1',
                'account2',
                'account3',
                'account4',
                'account5',
                'account6',
                'account7',
                'account8',
        )
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

        // $productOPCodeMax = Barcode::where('BRAND', '=', 'OP')->max('NUMBER');
        // $productOPCodeMax = Barcode::whereIn('BRAND', ['OP', 'OTHER', 'RI', 'BD', 'CPS', 'HOUSE HOLD', 'MM', 'OT', 'SPICES', 'VN'])->pluck('BRAND')->toArray();

        // dd($productOPCodeMax);

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
            ->whereIn('STATUS', ['OP'])
            ->pluck('BRAND')
            ->toArray();
        } else if (in_array($userpermission, ['Marketing - CPS'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['CP'])
            ->pluck('BRAND')
            ->toArray();
        }
        $testBarcode = Barcode::all();
        // dd($brands);

        return view('new_product_develop.create', compact('productCode', 'digits_barcode', 'list_position', 'brands', 'testBarcode', 'product_co_ordimators', 'marketing_managers', 'type_categorys', 'textures'));
    }

    public function getBrandListAjax(Request $request)
    {
        $productCodes = Pro_develops::select(
                DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
                'JOB_REFNO',
                'NAME_ENG'
            )
            ->where('BRAND', $request->input('BRAND'))
            ->orderby('Code')
            ->get();
        // dd($productCodes);
        return response()->json($productCodes);
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

                $data_DOC_TP = Document::updateOrCreate(['DOC_TP' => $request->DOC_TP], [
                    'NUMBER' => $productCode
                ]);
            }
            if($request->BRAND == "OP") {
                $productOPCodeMax = Barcode::where('BRAND', '=', 'OP')->max('NUMBER');
                $productCodeNumber =  preg_replace('/[^0-9]/', '', $productOPCodeMax) + 1;
                $productCode = $productCodeNumber;

                $data_BRAND = Barcode::updateOrCreate(['BRAND' => $request->BRAND], [
                    'NUMBER' => $productCode
                ]);
            }

            $digits_barcode = $this->ean13_check_digit();

            // dd($request);
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
    public function show(Request $request, $id_barcode)
    {
        $data = Pro_develops::select(
            'BRAND',
            'REF_DOC',
            'DOC_NO',
            'BARCODE'
        )
        ->orderBy('BARCODE', 'ASC');
        $productCodes = $data->select('BARCODE')->pluck('BARCODE')->toArray();
        $productCodeArr = [];
        foreach($productCodes as $productCodeLast) {
            $productCodeArrLast = [];
            $productCodeArrLast[] = substr_replace($productCodeLast, '', -1);
            foreach($productCodeArrLast as $productCodeFirst) {
                $productCodeArr[] = substr($productCodeFirst, 7, 11);
            }
        }

        $dataIBSH = Pro_develops::select(
            'pro_develops.*')
        ->firstWhere('BARCODE', '=', $id_barcode);
        // dd($dataIBSH);

        return view('new_product_develop.show', compact('dataIBSH', 'productCodeArr'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id_barcode)
    {
        $data = Pro_develops::select(
            'pro_develops.*',
            DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
            )
            ->firstWhere('BARCODE', '=', $id_barcode);

        // dd($data);

        return view('new_product_develop.edit', compact('data'));
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

    public function list_npd(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $BARCODE = $request->input('BARCODE');
        $DOC_NO = $request->search;
        $field_detail = [
            'pro_develops.DOC_NO',
            'pro_develops.NAME_ENG',
            'pro_develops.BARCODE', 
        ];
        $data = Pro_develops::select(
                'BRAND',
                DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
                'BARCODE',
                'NAME_ENG'
            )
            ->orderBy('BARCODE', 'DESC');

        if (null != $DOC_NO) {
            $data = $data->where(function ($data) use ($DOC_NO, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$DOC_NO.'%');
                }
            });
        }

        if (null != $BARCODE) {
            $productCodes = $data->where(DB::raw('SUBSTRING(BARCODE, 8, 5)'), $request->input('BARCODE'))->pluck('BARCODE');
            // $productCodeArr = [];
            // foreach($productCodes as $productCodeLast) {
            //     $productCodeArrLast = [];
            //     $productCodeArrLast[] = substr_replace($productCodeLast, '', -1);
            //     foreach($productCodeArrLast as $productCodeFirst) {
            //         $productCodeArr[] = substr($productCodeFirst, 7, 11);
            //     }
            // }
            // $productCodesObject = json_decode(json_encode($productCodes));
            // $data->where($productCodeArr, $BARCODE);
            // $data= collect($productCodes);
            // if (null != $productCodeArr) {
            // }

            // $obj->where('pro_develops.BARCODE', function ($barcode) use ($request) {
            //     $barcode->orWhere('BARCODE', $request->BARCODE);
            // });
        }

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
}
