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
use App\Models\ProDevelopLog;
use App\Models\Barcode;
use App\Models\Document;
use App\Models\menu;
use App\Models\Account;
use App\Models\AccountLog;
use App\Models\Product1;
use App\Models\MasterBrand;
use App\Models\Type_g;
use App\Models\Acctype;
use App\Models\Owner;
use App\Models\Grp_p;
use App\Models\TestNewBarcode;
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
        // $product_seq = Product::select('seq')
        //     ->where('seq', '=', 'P00001')
        //     ->first();

        $data = Pro_develops::select(
            'BRAND',
            'REF_DOC',
            'DOC_NO',
            'BARCODE'
        )
        ->orderBy('BARCODE', 'ASC');
        $productCodes = $data->select('BARCODE')->pluck('BARCODE')->toArray();

        $getSelect2ProDevelops = Pro_develops::select(
            'PRODUCT'
        )
        ->get();

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

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        if ($userpermission == $isSuperAdmin) {
            $brands = Barcode::select(
                'BRAND')
            // ->whereNotIn('STATUS', ['ALL'])
            ->pluck('BRAND')
            ->toArray();
        } else if ($userpermission == 'OP') {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
                ->whereIn('STATUS', ['OP', 'RE'])
            ->pluck('BRAND')
            ->toArray();

            $getSelect2ProDevelops = Pro_develops::select(
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

            $getSelect2ProDevelops = Pro_develops::select(
                'PRODUCT')
                ->whereIn('BRAND', ['CPS'])
                ->pluck('PRODUCT')
                ->toArray();

        } else if (in_array($userpermission, ['Procurement - KTY'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['KTY'])
            ->pluck('BRAND')
            ->toArray();
        } else if (in_array($userpermission, ['BB'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['BB'])
            ->pluck('BRAND')
            ->toArray();
        } else if (in_array($userpermission, ['LL'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['LL'])
            ->pluck('BRAND')
            ->toArray();
        }

        return view('new_product_develop.index', compact('user', 'productCodeArr', 'brands', 'getSelect2ProDevelops'));
    }

    public function duplicateNpdRequest(Request $request, $id_barcode)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $data = Pro_develops::select(
                'pro_develops.*',
                DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
                'npd_cos.ID AS ID_NPD',
                'npd_pdms.ID AS ID_PDM',
                'npd_categorys.ID AS ID_CATEGORY',
                'npd_textures.ID AS ID_TEXTURE',
            )
            ->leftJoin('npd_cos', 'pro_develops.NPD', '=', 'npd_cos.ID')
            ->leftJoin('npd_pdms', 'pro_develops.PDM', '=', 'npd_pdms.ID')
            ->leftJoin('npd_categorys', 'pro_develops.CATEGORY', '=', 'npd_categorys.ID')
            ->leftJoin('npd_textures', 'pro_develops.TEXTURE', '=', 'npd_textures.ID')
            ->firstWhere('BARCODE', '=', $id_barcode);

            // dd($data->Code);
            if($data->Code) {
                $lastElementBarcode = Barcode::max('NUMBER');
                if ($data->Code >= 20000 && $data->Code <= 28999) {
                    $lastElementBarcode = Barcode::where('STATUS', '=', 'OP')->max('NUMBER');
                }
                if ($data->Code >= 29000 && $data->Code <= 29699) {
                    $lastElementBarcode = Barcode::where('STATUS', '=', 'RE')->max('NUMBER');
                }
                if ($data->Code >= 29700 && $data->Code <= 29999) {
                    $lastElementBarcode = Barcode::where('STATUS', '=', 'CM')->max('NUMBER');
                }
                if ($data->BRAND == 'CPS') {
                    $lastElementBarcode = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'CPS')->max('NUMBER');
                }
                if ($data->BRAND == 'KTY') {
                    $lastElementBarcode = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'KTY')->max('NUMBER');
                }
                // if ($data->BRAND == 'GNC') {
                //     $lastElementBarcode = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'GNC')->max('NUMBER');
                // }
                if ($data->BRAND == 'BB') {
                    $lastElementBarcode = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'BB')->max('NUMBER');
                }
                if ($data->BRAND == 'LL') {
                    $lastElementBarcode = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'LL')->max('NUMBER');
                }
                // if ($data->BRAND == 'KM') {
                //     $lastElementBarcode = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'KM')->max('NUMBER');
                // }

                $productCodeNumber =  (int) preg_replace('/[^0-9]/', '', $lastElementBarcode) + 1;
                $productCodeBarcode = $productCodeNumber;

                if ($data->Code >= 20000 && $data->Code <= 28999) {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $data->BRAND, 'STATUS' => 'OP'],
                        ['NUMBER' => $productCodeBarcode]
                    );
                } elseif ($data->Code >= 29000 && $data->Code <= 29699) {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $data->BRAND, 'STATUS' => 'RE'],
                        ['NUMBER' => $productCodeBarcode]
                    );
                } elseif ($data->Code >= 29700 && $data->Code <= 29999) {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $data->BRAND, 'STATUS' => 'CM'],
                        ['NUMBER' => $productCodeBarcode]
                    );
                } elseif ($data->Code == 'CPS') {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $data->BRAND, 'BRAND' => 'CPS', 'STATUS' => 'CPS'],
                        ['NUMBER' => $productCodeBarcode]
                    );
                } elseif ($data->Code == 'KTY') {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $data->BRAND, 'BRAND' => 'KTY', 'STATUS' => 'KTY'],
                        ['NUMBER' => $productCodeBarcode]
                    );
                } elseif ($data->Code == 'BB') {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $data->BRAND, 'BRAND' => 'BB', 'STATUS' => 'BB'],
                        ['NUMBER' => $productCodeBarcode]
                    );
                } elseif ($data->Code == 'LL') {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $data->BRAND, 'BRAND' => 'LL', 'STATUS' => 'LL'],
                        ['NUMBER' => $productCodeBarcode]
                    );
                } 
                // elseif ($data->Code == 'KM') {
                //     $data_BRAND_Barcode = Barcode::updateOrCreate(
                //         ['COMPANY' => $data->BRAND, 'BRAND' => 'KM', 'STATUS' => 'KM'],
                //         ['NUMBER' => $productCodeBarcode]
                //     );
                // }
            }
            
            if($data->Code) {
                $productCodeMax = Document::max('NUMBER');
                if ($data->Code >= 20000 && $data->Code <= 28999) {
                    $productCodeMax = Document::where('STATUS', '=', 'OP')->max('NUMBER');
                }
                if ($data->Code >= 29000 && $data->Code <= 29699) {
                    $productCodeMax = Document::where('STATUS', '=', 'RE')->max('NUMBER');
                }
                if ($data->Code >= 29700 && $data->Code <= 29999) {
                    $productCodeMax = Document::where('STATUS', '=', 'CM')->max('NUMBER');
                }
                if ($data->BRAND == 'CPS') {
                    $productCodeMax = Document::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'CPS')->max('NUMBER');
                }
                if ($data->BRAND == 'KTY') {
                    $productCodeMax = Document::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'KTY')->max('NUMBER');
                }
                // if ($data->BRAND == 'GNC') {
                //     $productCodeMax = Document::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'KTY')->max('NUMBER');
                // }
                if ($data->BRAND == 'BB') {
                    $productCodeMax = Document::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'BB')->max('NUMBER');
                }
                if ($data->BRAND == 'LL') {
                    $productCodeMax = Document::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'LL')->max('NUMBER');
                }
                // if ($data->BRAND == 'KM') {
                //     $productCodeMax = Document::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'KM')->max('NUMBER');
                // }

                $productCodeNumberDocument =  (int) preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
                $productCodeDocument = $productCodeNumberDocument;

                // dd($productCodeDocument);
                if ($data->Code >= 20000 && $data->Code <= 28999) {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $data->BRAND, 'STATUS' => 'OP'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($data->Code >= 29000 && $data->Code <= 29699) {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $data->BRAND, 'STATUS' => 'RE'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($data->Code >= 29700 && $data->Code <= 29999) {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $data->BRAND, 'STATUS' => 'CM'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($data->Code == 'CPS') {
                    // dd(4);
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'CPS', 'STATUS' => 'CPS'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($data->Code == 'KTY') {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'KTY', 'STATUS' => 'KTY'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($data->Code == 'BB') {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'BB', 'STATUS' => 'BB'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($data->Code == 'LL') {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'LL', 'STATUS' => 'LL'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } 
                // elseif ($data->Code == 'KM') {
                //     $data_BRAND_Document = Document::updateOrCreate(
                //         ['COMPANY' => $request->BRAND, 'BRAND' => 'KM', 'STATUS' => 'KM'],
                //         ['NUMBER' => $productCodeDocument]
                //     );
                // }
            }

            // dd($data_BRAND_Document->NUMBER);
            $lastElement = Barcode::max('NUMBER');
            if ($data->Code >= 1 && $data->Code <= 8999) {
                $lastElement = Barcode::where('BRAND', '=', 'OP')->where('STATUS', '=', 'OP')->max('NUMBER');
            }
            if ($data->Code >= 9000 && $data->Code <= 9699) {
                $lastElement = Barcode::where('STATUS', '=', 'RE')->max('NUMBER');
            }
            if ($data->Code >= 9700 && $data->Code <= 9999) {
                $lastElement = Barcode::where('STATUS', '=', 'CM')->max('NUMBER');
            }
            if ($data->BRAND == 'CPS') {
                $lastElement = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'CPS')->max('NUMBER');
            }
            if ($data->BRAND == 'KTY') {
                $lastElement = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'KTY')->max('NUMBER');
            }
            if ($data->BRAND == 'BB') {
                $lastElement = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'BB')->max('NUMBER');
            }
            if ($data->BRAND == 'LL') {
                $lastElement = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'LL')->max('NUMBER');
            }
            // if ($data->BRAND == 'KM') {
            //     $lastElement = Barcode::where('COMPANY', '=', $data->BRAND)->where('STATUS', '=', 'KM')->max('NUMBER');
            // }
            // dd(5);
            $barcodeMax = $lastElement;
            // $barcodeNumber =  (int) preg_replace('/[^0-9]/', '', $barcodeMax) + 1;
            $barcodeNumber =  (int) preg_replace('/[^0-9]/', '', $barcodeMax) + 1;
            $prefixBarcode = Barcode::select('B_CODE')->where('BRAND', $data->BRAND)->pluck('B_CODE')->toArray();

            // if ($request->BRAND == 'KTY') {
            //     $suffixBarcode = sprintf('%03d', $barcodeNumber);
            //     $barcode = $prefixBarcode[0].$suffixBarcode;

            //     $digits = (string)$barcode;
            //     $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
            //     $even_sum_three = $even_sum * 3;
            //     $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
            //     $total_sum = $even_sum_three + $odd_sum;
            //     $next_ten = (ceil($total_sum/10))*10;
            //     $check_digit = $next_ten - $total_sum;
            // } else {
            //     $suffixBarcode = sprintf('%04d', $barcodeNumber);
            //     $barcode = $prefixBarcode[0].$suffixBarcode;

            //     $digits =(string)$barcode;
            //     $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
            //     $even_sum_three = $even_sum * 3;
            //     $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
            //     $total_sum = $even_sum_three + $odd_sum;
            //     $next_ten = (ceil($total_sum/10))*10;
            //     $check_digit = $next_ten - $total_sum;
            // }

            $suffixBarcode = sprintf('%04d', $barcodeNumber);
            $barcode = $prefixBarcode[0].$suffixBarcode;

            $digits =(string)$barcode;
            $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
            $even_sum_three = $even_sum * 3;
            $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
            $total_sum = $even_sum_three + $odd_sum;
            $next_ten = (ceil($total_sum/10))*10;
            $check_digit = $next_ten - $total_sum;

            $digits_barcode = $digits . $check_digit;
            // dd($digits_barcode);
            $digits_code = substr($digits_barcode, 7, 5);

            $dataDuplicateNpdRequest = [
                'BRAND' => $data->BRAND,
                // 'DOC_NO' => $data->DOC_NO,
                'REF_DOC' => 'IBH-F155',
                'STATUS' => $data->STATUS,
                'PRODUCT' => $digits_code,
                'BARCODE' => $digits_barcode,
                'JOB_REFNO' => $data->JOB_REFNO,
                'DOC_DT' => $data->DOC_DT,
                'CUST_OEM' => $data->CUST_OEM,
                'NPD' => $data->NPD,
                'PDM' => $data->PDM,
                'NAME_ENG' => $data->NAME_ENG,
                'CATEGORY' => $data->CATEGORY,
                'CAPACITY' => $data->CAPACITY,
                'Q_SMELL' => $data->Q_SMELL,
                'Q_COLOR' => $data->Q_COLOR,
                'TARGET_GRP' => $data->TARGET_GRP,
                'TARGET_STK' => $data->TARGET_STK,
                'PRICE_FG' => $data->PRICE_FG,
                'PRICE_COST' => $data->PRICE_COST,
                'PRICE_BULK' => $data->PRICE_BULK,
                'FIRST_ORD' => $data->FIRST_ORD,
                'P_CONCEPT' => $data->P_CONCEPT,
                'P_BENEFIT' => $data->P_BENEFIT,
                'TEXTURE' => $data->TEXTURE,
                'TEXTURE_OT' => $data->TEXTURE_OT,
                'COLOR1' => $data->COLOR1,
                'FRANGRANCE' => $data->FRANGRANCE,
                'INGREDIENT' => $data->INGREDIENT,
                'STD' => $data->STD,
                'PK' => $data->PK,
                'OTHER' => $data->OTHER,
                'DOCUMENT' => $data->DOCUMENT,
                'OEM' => is_null($data->OEM) ? 'N' : 'Y',
                'REASON1' => is_null($data->REASON1) ? 'N' : 'Y',
                'REASON1_DES' => $data->REASON1_DES,
                'REASON2' => is_null($data->REASON2) ? 'N' : 'Y',
                'REASON2_DES' => $data->REASON2_DES,
                'REASON3' => is_null($data->REASON3) ? 'N' : 'Y',
                'REASON3_DES' => $data->REASON3_DES,
                'PACKAGE_BOX' => is_null($data->PACKAGE_BOX) ? 'N' : 'Y',
                'REF_COLOR' => $data->REF_COLOR,
                'REF_FRAGRANCE' => $data->REF_FRAGRANCE,
                'OEM_STD' => $data->OEM_STD,
                'USER_EDIT' => Auth::user()->username,
                'EDIT_DT' => date("Y/m/d h:i:s")
            ];

            $dataNpdRequest = Pro_develops::create($dataDuplicateNpdRequest);

            DB::commit();
            $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }

    public function indexAccount()
    {
        $brands = MasterBrand::select('BRAND')->pluck('BRAND')->toArray();

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

        $getSelect2ProDevelops = Pro_develops::select(
            'PRODUCT')
            ->whereIn('BRAND', ['OP', 'CPS'])
            ->pluck('PRODUCT')
            ->toArray();

        return view('account.index', compact('productCodeArr', 'brands', 'getSelect2ProDevelops'));
    }
    public function createAccount(Request $request)
    {
        // dd($productCode);
        return view('account.create');
    }
    public function editAccount(Request $request)
    {
        $data = Account::select(
            // 'id',
            'accounts.product AS product',
            'accounts.cost AS cost',
            'sale_tp',
            'cost_km',
            'perfume_tax',
            'cost_perfume_tax',
            'cost5percent',
            'cost10percent',
            'cost_other',
            'sale_km',
            'sale_km20percent',
            'sale_km_other',
            'price_start_date',
            'note',
            'product1s.BRAND AS BRAND',
            'product1s.NAME_THAI AS NAME_THAI',
            'product1s.NAME_ENG AS NAME_ENG',
            'product1s.SHORT_THAI AS SHORT_THAI',
            'product1s.SHORT_ENG AS SHORT_ENG',
            'type_gs.ID AS TYPE_G',
            'acctypes.ID AS ACC_TYPE',
            'owners.OWNER AS VENDOR',
            'grp_ps.GRP_P AS GRP_P',
            'product1s.PRICE AS PRICE',
            'product1s.REG_DATE AS REG_DATE',
        )
        ->leftJoin('product1s', 'accounts.product', '=', 'product1s.PRODUCT')
        ->leftJoin('owners', 'product1s.VENDOR', '=', 'owners.OWNER')
        ->leftJoin('grp_ps', 'product1s.GRP_P', '=', 'grp_ps.GRP_P')
        ->leftJoin('type_gs', 'product1s.TYPE_G', '=', 'type_gs.ID')
        ->leftJoin('acctypes', 'product1s.ACC_TYPE', '=', 'acctypes.ID')
        ->where('accounts.product', $request->product)
        ->first();

        $data->REG_DATE = date('Y-m-d', strtotime($data->REG_DATE));
        // dd($data);

        $owners = Owner::select('OWNER AS VENDOR', 'REMARK')->get();
        $grp_ps = Grp_p::select('GRP_P AS GRP_P', 'REMARK')->get();        
        $type_gs = Type_g::select('ID AS TYPE_G', 'DESCRIPTION')->get();
        $acctypes = Acctype::select('ID AS ACC_TYPE', 'DESCRIPTION')->get();

        // dd($data);
        return view('account.edit', compact('data', 'owners', 'grp_ps', 'type_gs', 'acctypes'));
    }

    public function updateAccount(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            $data_account_old = Account::select(
            'product',
            'cost',
            'sale_tp',
            'cost_km',
            'perfume_tax',
            'cost_perfume_tax',
            'cost5percent',
            'cost10percent',
            'cost_other',
            'sale_km',
            'sale_km20percent',
            'sale_km_other',
            'price_start_date',
            'note',
            )
            ->firstWhere('product', '=', $request->product);

            $data_account_old_arr = $data_account_old->toArray();

            if ($request) {
                $log = [
                    'UPDATE_DT' => date("Y/m/d H:i:s"),
                    'USER_UPDATE' => Auth::user()->username
                ];

                $data_account_old_arr = array_merge($data_account_old_arr, $log);
                // dd($data_consumables_old_arr);
                $logAccountUpddate = AccountLog::create($data_account_old_arr);
            }

            // dd($request);
            $data_product_account_upddate = [
                'COST' => $request->COST,
                'NAME_THAI' => $request->NAME_THAI,
                'SHORT_THAI' => $request->SHORT_THAI,
                'NAME_ENG' => $request->NAME_ENG,
                'SHORT_ENG' => $request->SHORT_ENG,
                'TYPE_G' => $request->TYPE_G,
                'ACC_TYPE' => $request->ACC_TYPE,
            ];

            $productCostUpddate = Product1::where('PRODUCT', $request->product)->update($data_product_account_upddate);

            $updateProductAccount = Account::updateOrCreate(['product' => $request->product], [
                'COST' => $request->COST,
                'sale_tp' => $request->sale_tp,
                'cost_km' => $request->cost_km,
                'perfume_tax' => $request->perfume_tax,
                'cost_perfume_tax' => $request->cost_perfume_tax,
                'cost5percent' => $request->cost5percent,
                'cost10percent' => $request->cost10percent,
                'cost_other' => $request->cost_other,
                'sale_km' => $request->sale_km,
                'sale_km20percent' => $request->sale_km20percent,
                'sale_km_other' => $request->sale_km_other,
                'price_start_date' => $request->price_start_date,
                'note' => $request->note,
                'updated_at' => date("Y/m/d H:i:s")
            ]);

            // dd($updateProductAccount);
            DB::commit();
            $request->session()->flash('status', 'อัปเดตข้อมูลสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'อัปเดตข้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
        }
    }
    public function listAjaxAccount(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $BRAND = $request->input('brand_id');
        $PRODUCT = $request->input('PRODUCT');
        $DOC_NO = $request->search;
        $field_detail = [
            'product1s.PRODUCT',
            'product1s.NAME_THAI',
            'product1s.NAME_ENG',
        ];

        $data = Account::select(
            'accounts.id as id',
            'accounts.product AS product',
            'accounts.cost AS cost',
            'sale_tp',
            'perfume_tax',
            'cost_perfume_tax',
            'cost5percent',
            'cost10percent',
            'cost_other',
            'sale_km',
            'sale_km20percent',
            'sale_km_other',
            'product1s.BRAND AS BRAND',
            // 'product1s.NAME_THAI AS NAME_THAI',
            // 'product1s.NAME_ENG AS NAME_ENG',
            // 'product1s.NAME_ENG AS NAME_ENG',
            'product1s.SHORT_ENG AS SHORT_ENG',
            'acctypes.DESCRIPTION AS ACC_DESCRIPTION',
            'type_gs.DESCRIPTION AS DESCRIPTION',

        )
        ->leftJoin('product1s', 'accounts.product', '=', 'product1s.PRODUCT')
        ->leftJoin('type_gs', 'product1s.TYPE_G', '=', 'type_gs.ID')
        ->leftJoin('acctypes', 'product1s.ACC_TYPE', '=', 'acctypes.ID')
        ->orderBy('accounts.updated_at', 'DESC');

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

    private function ean13_check_digit()
    {
        $request = request();
        // $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        // $userpermission = Auth::user()->getUserPermission->name_position;
        $lastElement = Barcode::max('NUMBER');
            if ($request->BRAND == 'OP') {
                $lastElement = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'OP')->max('NUMBER');
            }
            if ($request->BRAND == 'RE') {
                $lastElement = Barcode::where('COMPANY', '=', 'OP')->where('STATUS', '=', 'RE')->max('NUMBER');
            }
            if ($request->BRAND == 'CM') {
                $lastElement = Barcode::where('COMPANY', '=', 'OP')->where('STATUS', '=', 'CM')->max('NUMBER');
            }
            if ($request->BRAND == 'CPS') {
                $lastElement = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'CPS')->max('NUMBER');
            }
            if ($request->BRAND == 'KTY') {
                $lastElement = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'KTY')->max('NUMBER');
            }
            if ($request->BRAND == 'BB') {
                $lastElement = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'BB')->max('NUMBER');
            }
            if ($request->BRAND == 'LL') {
                $lastElement = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'LL')->max('NUMBER');
            }
            // if ($request->BRAND == 'KM') {
            //     $lastElement = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'KM')->max('NUMBER');
            // }

            $barcodeMax = $lastElement;
            // $barcodeMax = substr_replace($lastElement, '', -1);
            $barcodeNumber =  (int) preg_replace('/[^0-9]/', '', $barcodeMax) + 1;

            if ($request->BRAND) {
                $prefixBarcode = Barcode::select('B_CODE')->where('BRAND', $request->BRAND)->pluck('B_CODE')->toArray();
            } else {
                $prefixBarcode = Barcode::select('B_CODE')->where('BRAND', 'OP')->pluck('B_CODE')->toArray();
            }

            // if ($request->BRAND == 'KTY') {
            //     $suffixBarcode = sprintf('%03d', $barcodeNumber);
            //     $barcode = $prefixBarcode[0].$suffixBarcode;

            //     $digits = (string)$barcode;
            //     $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
            //     $even_sum_three = $even_sum * 3;
            //     $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
            //     $total_sum = $even_sum_three + $odd_sum;
            //     $next_ten = (ceil($total_sum/10))*10;
            //     $check_digit = $next_ten - $total_sum;
            // } else {
            //     $suffixBarcode = sprintf('%04d', $barcodeNumber);
            //     $barcode = $prefixBarcode[0].$suffixBarcode;

            //     $digits = (string)$barcode;
            //     $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
            //     $even_sum_three = $even_sum * 3;
            //     $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
            //     $total_sum = $even_sum_three + $odd_sum;
            //     $next_ten = (ceil($total_sum/10))*10;
            //     $check_digit = $next_ten - $total_sum;
            // }

            $suffixBarcode = sprintf('%04d', $barcodeNumber);
            $barcode = $prefixBarcode[0].$suffixBarcode;

            $digits = (string)$barcode;
            $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
            $even_sum_three = $even_sum * 3;
            $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
            $total_sum = $even_sum_three + $odd_sum;
            $next_ten = (ceil($total_sum/10))*10;
            $check_digit = $next_ten - $total_sum;

        // $lastElement = Pro_develops::where('BRAND', '=', 'CPS')->max('BARCODE');
        // $barcodeMax = substr_replace($lastElement, '', -1);
        // $barcodeNumber =  preg_replace('/[^0-9]/', '', $barcodeMax) + 1;
        // $barcode = sprintf('%04d', $barcodeNumber);

        // CPS = 8850080700015;
        // RI = 885008029001;
        // $barcode = (string)'885008029001';
        // //first change digits to a string so that we can access individual numbers
        // $digits =(string)$barcode;
        // // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        // $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        // // 2. Multiply this result by 3.
        // $even_sum_three = $even_sum * 3;
        // // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        // $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        // // 4. Sum the results of steps 2 and 3.
        // $total_sum = $even_sum_three + $odd_sum;
        // // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        // $next_ten = (ceil($total_sum/10))*10;
        // $check_digit = $next_ten - $total_sum;

        return $digits . $check_digit;
    }

    public function getBrandListAjax(Request $request)
    {
        $productCodes = Pro_develops::select(
                'pro_develops.*',
                DB::raw('SUBSTRING(BARCODE, 8, 6) AS Code')
            )
            ->where('BRAND', $request->input('BRAND'))
            ->orderby('Code')
            ->get();

        $digits_barcode = $this->ean13_check_digit($request);

        $data = Pro_develops::select('PRODUCT')
            ->where('BARCODE', $digits_barcode)
            ->count();

        // dd($digits_barcode);
        return response()->json(['productCodes' => $productCodes, 'digits_barcode' => $digits_barcode, 'data' => $data > 0 ? false : true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $digits_barcode = $this->ean13_check_digit($request);
        // dd($digits_barcode);
        // $productCodeMax = Document::max('NUMBER');
        // $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        // $productCode = '2'.sprintf('%04d', $productCodeNumber);

        $list_position = position::select('id', 'name_position')->get();
        $product_co_ordimators = Npd_cos::all();
        $marketing_managers = Npd_pdms::all();
        $type_categorys = Npd_categorys::all();
        $textures = Npd_textures::all();

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
        } else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP', 'Senior Executive - Product Development-OP', 'Assistant-Product-Manager-OP', 'Assistant Manager - Product Development-OP', 'Product Manager-OP'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['OP', 'RE', 'CM'])
            // ->whereIn('STATUS', ['OP'])
            ->pluck('BRAND')
            ->toArray();
        } else if (in_array($userpermission, ['Marketing - CPS', 'Division Manager- Strategy & New Product Development-CPS', 'Department Manager - New Product Development Manager-CPS', 'Senior Executive - New Product Development-CPS', 'Senior Executive - Packaging Development-CPS', 'Senior Executive - Product Designer-CPS', 'Executive - New Product Development-CPS', 'MARKETING DIRECTOR-CPS', 'Department Manager - Marketing Support & Executive Assistant to Marketing Director-CPS', 'Department Manager - Category Manager-CPS'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['CPS'])
            ->pluck('BRAND')
            ->toArray();
        } else if (in_array($userpermission, ['Procurement - KTY'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['KTY'])
            ->pluck('BRAND')
            ->toArray();
        } 
        // else if (in_array($userpermission, ['Regional Operation Manager-GNC'])) {
        //     $brands = Barcode::select(
        //         'BRAND',
        //         'STATUS')
        //     ->whereIn('STATUS', ['GNC'])
        //     ->pluck('BRAND')
        //     ->toArray();
        // }
        else if (in_array($userpermission, ['BB'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['BB'])
            ->pluck('BRAND')
            ->toArray();
        } else if (in_array($userpermission, ['LL'])) {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['LL'])
            ->pluck('BRAND')
            ->toArray();
        }


        $testBarcode = Barcode::all();

        // dd($brands);
        return view('new_product_develop.create', compact( 'digits_barcode', 'list_position', 'brands', 'testBarcode', 'product_co_ordimators', 'marketing_managers', 'type_categorys', 'textures'));
    }

    public function checkCode(Request $request)
    {
        // dd($request);
        $data = Pro_develops::select('PRODUCT')
            ->where('PRODUCT', $request->code)
            ->count();

        return response()->json($data > 0 ? false : true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        // dd((int) $request->code);
        DB::beginTransaction();
        try {
            $digits_barcode = $this->ean13_check_digit();
            // dd($digits_barcode);
            $digits_code = substr($digits_barcode, 7, 5);

            $data_product = [
                'BRAND' => $request->input('BRAND') == 'OP' || $request->input('BRAND') == 'RE' || $request->input('BRAND') == 'CM' ? 'OP' : $request->input('BRAND'),
                'DOC_NO' => $request->input('DOC_NO'),
                'REF_DOC' => $request->input('REF_DOC'),
                'STATUS' => $request->input('STATUS'),
                'PRODUCT' => $digits_code,
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
                'OEM' => is_null($request->input('OEM')) ? 'N' : 'Y',
                'REASON1' => is_null($request->input('REASON1')) ? 'N' : 'Y',
                'REASON1_DES' => $request->input('REASON1_DES'),
                'REASON2' => is_null($request->input('REASON2')) ? 'N' : 'Y',
                'REASON2_DES' => $request->input('REASON2_DES'),
                'REASON3' => is_null($request->input('REASON3')) ? 'N' : 'Y',
                'REASON3_DES' => $request->input('REASON3_DES'),
                'PACKAGE_BOX' => is_null($request->input('PACKAGE_BOX')) ? 'N' : 'Y',
                'REF_COLOR' => $request->input('REF_COLOR'),
                'REF_FRAGRANCE' => $request->input('REF_FRAGRANCE'),
                'OEM_STD' => $request->input('OEM_STD'),
                'USER_EDIT' => Auth::user()->username,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ];

            //     $arr_barcode = [];
            //     for ($i = 1564; $i <= 8412; $i++) {

            //         if ($request->BRAND == 'KU') {
            //             $barcode = '885008011'.str_pad((string)$i, 3, '0', STR_PAD_LEFT);
            //         }
            //         if ($request->BRAND == 'OP') {
            //             $barcode = '88500802'.str_pad((string)$i, 4, '0', STR_PAD_LEFT);
            //         }
            //         if ($request->BRAND == 'RE') {
            //             $barcode = '885008029'.str_pad((string)$i, 3, '0', STR_PAD_LEFT);
            //         }

            //         $digits = (string)$barcode;
            //         $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
            //         $even_sum_three = $even_sum * 3;
            //         $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
            //         $total_sum = $even_sum_three + $odd_sum;
            //         $next_ten = (ceil($total_sum/10))*10;
            //         $check_digit = $next_ten - $total_sum;

            //         // array_push($arr_barcode, $barcode.$check_digit);
            //         $full_barcode = $barcode . $check_digit;
            //         $PRODUCT = substr($full_barcode, 7, 5);
            //         $arr_barcode[$i] = $full_barcode;

            //         $updateData = [
            //             'BRAND' => 'OP',
            //             'PRODUCT' => $PRODUCT,
            //         ];

            //         TestNewBarcode::updateOrCreate(
            // ['BARCODE' => $full_barcode],
            //         $updateData
            //         );
            //     }

            $code = Pro_develops::select('PRODUCT')
                ->where('PRODUCT', $request->code)
                ->count();

            $barcode = Pro_develops::select('BARCODE')
                ->where('BARCODE', $request->barcodeTest)
                ->count();

            $npdRequest = Pro_develops::create($data_product);

            if ($request) {
                $log = [
                    'UPDATE_DT' => date("Y/m/d H:i:s"),
                    'USER_UPDATE' => Auth::user()->username
                ];

                $data_product = array_merge($data_product, $log);
                // dd($data_product);
                $logProduct = ProDevelopLog::create($data_product);
            }

            if($request->code) {
                $lastElementBarcode = Barcode::max('NUMBER');
                if ((int) $request->code >= 20000 && (int) $request->code <= 28999) {
                    $lastElementBarcode = Barcode::where('STATUS', '=', 'OP')->max('NUMBER');
                }
                if ((int) $request->code >= 29000 && (int) $request->code <= 29699) {
                    $lastElementBarcode = Barcode::where('STATUS', '=', 'RE')->max('NUMBER');
                }
                if ((int) $request->code >= 29700 && (int) $request->code <= 29999) {
                    $lastElementBarcode = Barcode::where('STATUS', '=', 'CM')->max('NUMBER');
                }
                if ($request->BRAND == 'CPS') {
                    $lastElementBarcode = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'CPS')->max('NUMBER');
                }
                if ($request->BRAND == 'KTY') {
                    $lastElementBarcode = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'KTY')->max('NUMBER');
                }
                if ($request->BRAND == 'BB') {
                    $lastElementBarcode = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'BB')->max('NUMBER');
                }
                if ($request->BRAND == 'LL') {
                    $lastElementBarcode = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'LL')->max('NUMBER');
                }
                // if ($request->BRAND == 'KM') {
                //     $lastElementBarcode = Barcode::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'KM')->max('NUMBER');
                // }

                $productCodeNumber =  (int) preg_replace('/[^0-9]/', '', $lastElementBarcode) + 1;
                $productCodeDocument = $productCodeNumber;

                if ((int) $request->code >= 20000 && (int) $request->code <= 28999) {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'STATUS' => 'OP'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ((int) $request->code >= 29000 && (int) $request->code <= 29699) {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => 'OP', 'BRAND' => 'RE', 'STATUS' => 'RE'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ((int) $request->code >= 29700 && (int) $request->code <= 29999) {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => 'OP', 'BRAND' => 'CM', 'STATUS' => 'CM'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($request->BRAND == 'CPS') {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'CPS', 'STATUS' => 'CPS'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($request->BRAND == 'KTY') {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'KTY', 'STATUS' => 'KTY'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($request->BRAND == 'BB') {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'BB', 'STATUS' => 'BB'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($request->BRAND == 'LL') {
                    $data_BRAND_Barcode = Barcode::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'LL', 'STATUS' => 'LL'],
                        ['NUMBER' => $productCodeDocument]
                    );
                }
            }

            if($request->code) {
                $lastElementDocument = Document::max('NUMBER');
                if ((int) $request->code >= 20000 && (int) $request->code <= 28999) {
                    $lastElementDocument = Document::where('STATUS', '=', 'OP')->max('NUMBER');
                }
                if ((int) $request->code >= 29000 && (int) $request->code <= 29699) {
                    $lastElementDocument = Document::where('STATUS', '=', 'RE')->max('NUMBER');
                }
                if ((int) $request->code >= 29700 && (int) $request->code <= 29999) {
                    $lastElementDocument = Document::where('STATUS', '=', 'CM')->max('NUMBER');
                }
                if ($request->BRAND == 'CPS') {
                    $lastElementDocument = Document::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'CPS')->max('NUMBER');
                }
                if ($request->BRAND == 'KTY') {
                    $lastElementDocument = Document::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'KTY')->max('NUMBER');
                }
                if ($request->BRAND == 'BB') {
                    $lastElementDocument = Document::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'BB')->max('NUMBER');
                }
                if ($request->BRAND == 'LL') {
                    $lastElementDocument = Document::where('COMPANY', '=', $request->BRAND)->where('STATUS', '=', 'LL')->max('NUMBER');
                }
                $productCodeNumber =  (int) preg_replace('/[^0-9]/', '', $lastElementDocument) + 1;
                $productCodeDocument = $productCodeNumber;

                if ((int) $request->code >= 20000 && (int) $request->code <= 28999) {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'STATUS' => 'OP'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ((int) $request->code >= 29000 && (int) $request->code <= 29699) {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => 'OP', 'BRAND' => 'RE', 'STATUS' => 'RE'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ((int) $request->code >= 29700 && (int) $request->code <= 29999) {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => 'OP', 'BRAND' => 'CM', 'STATUS' => 'CM'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($request->BRAND == 'CPS') {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'CPS', 'STATUS' => 'CPS'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($request->BRAND == 'KTY') {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'KTY', 'STATUS' => 'KTY'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($request->BRAND == 'BB') {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'BB', 'STATUS' => 'LL'],
                        ['NUMBER' => $productCodeDocument]
                    );
                } elseif ($request->BRAND == 'LL') {
                    $data_BRAND_Document = Document::updateOrCreate(
                        ['COMPANY' => $request->BRAND, 'BRAND' => 'LL', 'STATUS' => 'LL'],
                        ['NUMBER' => $productCodeDocument]
                    );
                }
            }

            DB::commit();
            $request->session()->flash('status', 'เพิ่มขู้อมูลสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('status', 'เพิ่มขู้อมูลไม่สำเร็จ!');
            return response()->json(['success' => false, 'code' => $code > 0 ? false : true, 'barcode' => $barcode > 0 ? false : true, 'message' => 'Line '.$e->getLine().': '.$e->getMessage()]);
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

        $textures = Npd_textures::all();
        $type_categorys = Npd_categorys::all();

        $dataIBSH = Pro_develops::select(
            'pro_develops.*',
            'npd_textures.DESCRIPTION AS T_DESCRIPTION',
            'npd_categorys.DESCRIPTION AS C_DESCRIPTION',
            DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'))
        ->leftJoin('npd_categorys', 'pro_develops.CATEGORY', '=', 'npd_categorys.ID')
        ->leftJoin('npd_textures', 'pro_develops.TEXTURE', '=', 'npd_textures.ID')
        ->firstWhere('BARCODE', '=', $id_barcode);

        // $dataIBSH->TARGET_STK = date('Y-m-d', strtotime($data->TARGET_STK));

        // dd($dataIBSH);
        return view('new_product_develop.show', compact('dataIBSH', 'productCodeArr'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_barcode)
    {
        // dd($id_barcode);
        $data = Pro_develops::select(
            'pro_develops.*'
            // DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
            // 'npd_cos.ID AS ID_NPD',
            // 'npd_pdms.ID AS ID_PDM',
            // 'npd_categorys.ID AS ID_CATEGORY',
            // 'npd_textures.ID AS ID_TEXTURE',
        )
            // ->leftJoin('npd_cos', 'pro_develops.NPD', '=', 'npd_cos.ID')
            // ->leftJoin('npd_pdms', 'pro_develops.PDM', '=', 'npd_pdms.ID')
            // ->leftJoin('npd_categorys', 'pro_develops.CATEGORY', '=', 'npd_categorys.ID')
            // ->leftJoin('npd_textures', 'pro_develops.TEXTURE', '=', 'npd_textures.ID')
            // ->join('npd_cos', 'pro_develops.NPD', '=', 'npd_cos.ID')
            // ->join('npd_pdms', 'pro_develops.PDM', '=', 'npd_pdms.ID')
            // ->join('npd_categorys', 'pro_develops.CATEGORY', '=', 'npd_categorys.ID')
            // ->join('npd_textures', 'pro_develops.TEXTURE', '=', 'npd_textures.ID')
            ->where('BARCODE', $id_barcode)
            ->first();

            // dd($data);

            $data->DOC_DT = date('Y-m-d', strtotime($data->DOC_DT));
            $data->TARGET_STK = date('Y-m-d', strtotime($data->TARGET_STK));
        // $data1 = Pro_develops::find($id_barcode);
        // $data = Product1::select(
        //     'product1s.*',
        //     DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code')
        // )
        //     ->firstWhere('BARCODE', $id_barcode);

        // $data = Pro_develops::all();
        // dd($data);

        $product_co_ordimators = Npd_cos::select('ID AS NPD', 'DESCRIPTION')->get()->toArray();

        if (!in_array($data->NPD, array_column($product_co_ordimators, 'NPD')))
            {
                $product_co_ordimators[] =  [
                    'NPD' => $data->NPD,
                    'DESCRIPTION' => $data->NPD,
                ];
            } 

        $marketing_managers = Npd_pdms::select('ID AS PDM', 'DESCRIPTION')->get()->toArray();

        if (!in_array($data->PDM, array_column($marketing_managers, 'PDM')))
        {
            $marketing_managers[] =  [
                'PDM' => $data->PDM,
                'DESCRIPTION' => $data->PDM,
            ];
        }

        $type_categorys = Npd_categorys::select('ID AS CATEGORY', 'DESCRIPTION')->get()->toArray();

        if (!in_array($data->CATEGORY, array_column($type_categorys, 'CATEGORY')))
        {
            $type_categorys[] =  [
                'CATEGORY' => $data->CATEGORY,
                'DESCRIPTION' => $data->CATEGORY,
            ];
        }

        $textures = Npd_textures::select('ID AS TEXTURE', 'DESCRIPTION')->get()->toArray();

        if (!in_array($data->TEXTURE, array_column($textures, 'TEXTURE')))
        {
            $textures[] =  [
                'TEXTURE' => $data->TEXTURE,
                'DESCRIPTION' => $data->TEXTURE,
            ];
        }

        // dd($data->TEXTURE);
        return view('new_product_develop.edit', compact('data', 'product_co_ordimators', 'marketing_managers', 'type_categorys', 'textures'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_barcode)
    {
        // dd($request);
        DB::beginTransaction();
        try {

            $data_npd_old = Pro_develops::select(
                'pro_develops.*',
            )
            ->firstWhere('pro_develops.BARCODE', '=', $id_barcode);

            $data_npd_old_arr = $data_npd_old->toArray();

            if ($request) {
                $log = [
                    'UPDATE_DT' => date("Y/m/d H:i:s"),
                    'USER_UPDATE' => Auth::user()->username
                ];

                $data_npd_old_arr = array_merge($data_npd_old_arr, $log);
                // dd($data_npd_old_arr);
                $logNpd = ProDevelopLog::create($data_npd_old_arr);
            }

            $data_product = [
                'BRAND' => $request->input('BRAND'),
                'DOC_NO' => $request->input('DOC_NO'),
                'REF_DOC' => $request->input('REF_DOC'),
                'PRODUCT' => $request->input('PRODUCT'),
                'BARCODE' => $request->input('BARCODE'),
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
                'OEM' => is_null($request->input('OEM')) ? 'N' : 'Y',
                'REASON1' => is_null($request->input('REASON1')) ? 'N' : 'Y',
                'REASON1_DES' => $request->input('REASON1_DES'),
                'REASON2' => is_null($request->input('REASON2')) ? 'N' : 'Y',
                'REASON2_DES' => $request->input('REASON2_DES'),
                'REASON3' => is_null($request->input('REASON3')) ? 'N' : 'Y',
                'REASON3_DES' => $request->input('REASON3_DES'),
                'PACKAGE_BOX' => is_null($request->input('PACKAGE_BOX')) ? 'N' : 'Y',
                'REF_COLOR' => $request->input('REF_COLOR'),
                'REF_FRAGRANCE' => $request->input('REF_FRAGRANCE'),
                'OEM_STD' => $request->input('OEM_STD'),
                'USER_EDIT' => Auth::user()->username,
                'EDIT_DT' => date("Y/m/d H:i:s")
            ];

            $npdRequest = Pro_develops::where('BARCODE', $id_barcode)->update($data_product);

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

        $BRAND = $request->input('brand_id');
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
        ->orderBy('EDIT_DT', 'DESC');

        $userpermission = Auth::user()->getUserPermission->name_position;
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        if (in_array($userpermission, [$isSuperAdmin, 'Admin'])) {
                $data = Pro_develops::select(
                    'BRAND',
                DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
                'BARCODE',
                'NAME_ENG'
            )
            ->orderBy('BARCODE', 'DESC');
        } else if (in_array($userpermission, ['Category - OP', 'Product - OP', 'E-Commerce - OP', 'Senior Executive - Product Development-OP', 'Assistant-Product-Manager-OP', 'Assistant Manager - Product Development-OP', 'Product Manager-OP'])) {
            $data = Pro_develops::select(
                    'pro_develops.BRAND AS BRAND',
                    DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
                    'pro_develops.PRODUCT AS PRODUCT',
                    'pro_develops.BARCODE AS BARCODE',
                    'pro_develops.NAME_ENG AS NAME_ENG'
                )
                ->join('barcodes', 'pro_develops.BRAND', '=', 'barcodes.BRAND')
                ->whereIn('barcodes.BRAND', ['OP', 'RE'])
                ->orderBy('BARCODE', 'DESC');
        } else if (in_array($userpermission, ['Marketing - CPS', 'Division Manager- Strategy & New Product Development-CPS', 'Department Manager - New Product Development Manager-CPS', 'Senior Executive - New Product Development-CPS', 'Senior Executive - Packaging Development-CPS', 'Senior Executive - Product Designer-CPS', 'Executive - New Product Development-CPS', 'MARKETING DIRECTOR-CPS', 'Department Manager - Marketing Support & Executive Assistant to Marketing Director-CPS', 'Department Manager - Category Manager-CPS'])) {
            $data = Pro_develops::select(
                'pro_develops.BRAND AS BRAND',
                DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
                'pro_develops.PRODUCT AS PRODUCT',
                'pro_develops.BARCODE AS BARCODE',
                'pro_develops.NAME_ENG AS NAME_ENG'
            )
            ->join('barcodes', 'pro_develops.BRAND', '=', 'barcodes.BRAND')
            ->whereIn('barcodes.BRAND', ['CPS'])
            ->orderBy('BARCODE', 'DESC');
        } else if (in_array($userpermission, ['Procurement - KTY'])) {
            $data = Pro_develops::select(
                'pro_develops.BRAND AS BRAND',
                DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
                'pro_develops.PRODUCT AS PRODUCT',
                'pro_develops.BARCODE AS BARCODE',
                'pro_develops.NAME_ENG AS NAME_ENG'
            )
            ->join('barcodes', 'pro_develops.BRAND', '=', 'barcodes.BRAND')
            ->whereIn('barcodes.BRAND', ['KTY'])
            ->orderBy('BARCODE', 'DESC');
        } 
        // else if (in_array($userpermission, ['Regional Operation Manager-GNC'])) {
        //     $data = Pro_develops::select(
        //         'pro_develops.BRAND AS BRAND',
        //         // DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
        //         'pro_develops.BARCODE AS BARCODE',
        //         'pro_develops.NAME_ENG AS NAME_ENG'
        //     )
        //     ->join('barcodes', 'pro_develops.BRAND', '=', 'barcodes.BRAND')
        //     ->whereIn('barcodes.BRAND', ['GNC'])
        //     ->orderBy('BARCODE', 'DESC');
        // } 
        else if (in_array($userpermission, ['BB'])) {
            $data = Pro_develops::select(
                'pro_develops.BRAND AS BRAND',
                DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
                'pro_develops.PRODUCT AS PRODUCT',
                'pro_develops.BARCODE AS BARCODE',
                'pro_develops.NAME_ENG AS NAME_ENG'
            )
            ->join('barcodes', 'pro_develops.BRAND', '=', 'barcodes.BRAND')
            ->whereIn('barcodes.BRAND', ['BB'])
            ->orderBy('BARCODE', 'DESC');
        } else if (in_array($userpermission, ['LL'])) {
            $data = Pro_develops::select(
                'pro_develops.BRAND AS BRAND',
                DB::raw('SUBSTRING(BARCODE, 8, 5) AS Code'),
                'pro_develops.PRODUCT AS PRODUCT',
                'pro_develops.BARCODE AS BARCODE',
                'pro_develops.NAME_ENG AS NAME_ENG'
            )
            ->join('barcodes', 'pro_develops.BRAND', '=', 'barcodes.BRAND')
            ->whereIn('barcodes.BRAND', ['LL'])
            ->orderBy('BARCODE', 'DESC');
        }

        if ($BRAND != null) {
            $data->where('pro_develops.BRAND', $BRAND);
        }

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
