<?php

namespace App\Http\Controllers\ExportExcel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pro_develops;
use App\Models\Product1;
use App\Models\ProductChannel;
use App\Models\Account;
use App\Models\ProductDetailExportExcel;
use \avadim\FastExcelWriter\Excel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ExportExcelController extends Controller
{
    public function indexNewProductDevelop()
    {
        $ProDevelops = Pro_develops::orderBy('id', 'asc')->get();
        // dd($ProDevelops);

        return view('new_product_develop.index', compact('ProDevelops'));
    }
    public function getSelect2NewProductDevelop(Request $request)
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition)); 

        $getSelect2ProDevelops = Pro_develops::select(
            'PRODUCT'
        )
        ->get();

        if ($userpermission == $isSuperAdmin) {
            $dataProductNpdArr = Pro_develops::select(
                'PRODUCT')
                ->whereIn('BRAND', ['OP'])
                ->pluck('PRODUCT')
                ->toArray();

        } else if ($userpermission == 'OP') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Pro_develops::where('PRODUCT', '>', $PRODUCT)
                ->where('BRAND', 'OP')
                ->pluck('PRODUCT')
                ->toArray();
    
            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        } else if ($userpermission == 'CPS') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Pro_develops::where('PRODUCT', '>', $PRODUCT)
                ->where('BRAND', 'CPS')
                ->pluck('PRODUCT')
                ->toArray();
    
            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        } else if ($userpermission == 'KTY') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Pro_develops::where('PRODUCT', '>', $PRODUCT)
                ->where('BRAND', 'KTY')
                ->pluck('PRODUCT')
                ->toArray();
    
            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        } else if ($userpermission == 'BB') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Pro_develops::where('PRODUCT', '>', $PRODUCT)
                ->where('BRAND', 'BB')
                ->pluck('PRODUCT')
                ->toArray();
    
            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        } else if ($userpermission == 'LL') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Pro_develops::where('PRODUCT', '>', $PRODUCT)
                ->where('BRAND', 'LL')
                ->pluck('PRODUCT')
                ->toArray();
    
            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        }

        return response()->json($getSelect2ProDevelops);
    }
    public function exportExcelNewProductDevelop(Request $request)
    {
        // dd($request->all());

        if (!isset($request->start_product) || $request->start_product == null) {
            $ProDevelops = Pro_develops::select('BRAND', 'DOC_NO', 'PRODUCT', 'BARCODE', 'NAME_ENG')->orderBy('PRODUCT', 'asc')->get();
        } else if (!isset($request->end_product) || $request->end_product == null) {
            $ProDevelops = Pro_develops::select('BRAND', 'DOC_NO', 'PRODUCT', 'BARCODE', 'NAME_ENG')->where('PRODUCT', $request->start_product)->get();
        } else {
            $ProDevelops = Pro_develops::select('BRAND', 'DOC_NO', 'PRODUCT', 'BARCODE', 'NAME_ENG')->whereBetween('PRODUCT', [$request->start_product, $request->end_product])->get();
        }
        $columns = [];
        $columns = array('แบรนด์', 'เลขที่เอกสาร', 'รหัสสินค้า','รหัสบาร์โค้ด','ชื่อสินค้า');
        // dd($columns);

        $ProDevelops = $ProDevelops->toArray();

        $outFileName = 'Excel.xlsx';

        // // Create Excel workbook
        $excel = Excel::create();

        // // Get the first sheet;
        $sheet = $excel->getSheet();

        // Begin an area for direct write
        $area = $sheet->beginArea();
        $header = $columns;

        $rowOptions = ['font-style' => 'bold'];

        $sheet->writeHeader($header, $rowOptions);

        foreach ($ProDevelops as $row) {
            $sheet->writeRow($row);
        }

        // Save to XLSX-file
        $excel->download($outFileName);
    }

    public function getSelect2ProductMaster(Request $request)
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition)); 

        $getSelect2ProDevelops = Product1::select(
            'PRODUCT'
        )
        ->get();

        if ($userpermission == $isSuperAdmin) {
            $dataProductNpdArr = Product1::select(
                'PRODUCT')
                ->whereIn('BRAND', ['OP'])
                ->pluck('PRODUCT')
                ->toArray();

        } else if ($userpermission == 'OP') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Product1::where('PRODUCT', '>', $PRODUCT)
                ->where('BRAND', 'OP')
                ->pluck('PRODUCT')
                ->toArray();
    
            // dd($getSelect2ProDevelops);

            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        } else if ($userpermission == 'CPS') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            // ดึง PRODUCT ทั้งหมดที่มีอยู่ใน product1s ก่อน
            $validProducts = DB::table('product1s')
                ->pluck('PRODUCT')
                ->toArray();

            $getSelect2ProDevelops = ProductChannel::select('PRODUCT')
                ->where('PRODUCT', '>', $PRODUCT)
                ->whereIn('BRAND', ['CPS'])
                ->whereIn('PRODUCT', $validProducts)
                ->orderBy('PRODUCT', 'asc')
                ->pluck('PRODUCT')
                ->toArray();

            // $getSelect2ProDevelops = ProductChannel::where('PRODUCT', '>', $PRODUCT)
            //     ->where('BRAND', 'CPS')
            //     ->pluck('PRODUCT')
            //     ->toArray();

            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        } else if ($userpermission == 'KTY') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Product1::where('PRODUCT', '>', $PRODUCT)
                ->where('BRAND', 'KTY')
                ->pluck('PRODUCT')
                ->toArray();
    
            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        } else if ($userpermission == 'BB') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Product1::where('PRODUCT', '>', $PRODUCT)
                ->where('BRAND', 'BB')
                ->pluck('PRODUCT')
                ->toArray();
    
            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        } else if ($userpermission == 'LL') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Product1::where('PRODUCT', '>', $PRODUCT)
                ->where('BRAND', 'LL')
                ->pluck('PRODUCT')
                ->toArray();
    
            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        } else if ($userpermission == 'GNC') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Product1::where('PRODUCT', '>', $PRODUCT)
                ->where('BRAND', 'GNC')
                ->pluck('PRODUCT')
                ->toArray();
    
            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        } else if ($userpermission == 'BD') {
            if (!$request->has('id') || !is_numeric($request->id)) {
                return response()->json(['error' => 'Invalid ID'], 400);
            }
            $PRODUCT = intval($request->id);

            $getSelect2ProDevelops = Product1::where('PRODUCT', '>', $PRODUCT)
                ->whereIn('BRAND', ['OP', 'CPS', 'KM', 'KTY', 'GNC', 'BB', 'LL'])
                ->pluck('PRODUCT')
                ->toArray();
    
            if (empty($getSelect2ProDevelops)) {
                return response()->json(['message' => 'No data found'], 404);
            }
        }

        // dd($getSelect2ProDevelops);
        return response()->json($getSelect2ProDevelops);
    }

    public function exportExcelProductMaster(Request $request)
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        // dd($request->all(), $userpermission);

        if ($userpermission == 'OP') {
            if (!isset($request->start_product) || $request->start_product == null) {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->where('product1s.BRAND', 'OP')
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.PRODUCT', 'asc')
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else if (!isset($request->end_product) || $request->end_product == null) {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->groupBy('product1s.PRODUCT')
                                        ->where('product1s.BRAND', 'OP')
                                        ->where('PRODUCT', $request->start_product)
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->where('product1s.BRAND', 'OP')
                                        ->whereBetween('product1s.PRODUCT', [$request->start_product, $request->end_product])
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.PRODUCT', 'asc')
                                        ->get()
                                        ->toArray();
            
                                        // dd($ProDevelops);
                                        // dd($ProDevelops->toSql(), $ProDevelops->getBindings());
            }
        } else if ($userpermission == 'CPS') {
            if (!isset($request->start_product) || $request->start_product == null) {
                $ProDevelops = Product1::select(
                                        'product1s.BRAND', 
                                                 'product1s.PRODUCT', 
                                                 'product1s.BARCODE',
                                                 'product1s.PRICE', 
                                                 'solutions.DESCRIPTION AS SOLUTION', 
                                                 'series.DESCRIPTION AS SERIES', 
                                                 'categories.DESCRIPTION AS CATEGORY', 
                                                 'sub_categories.DESCRIPTION AS SUB_CATEGORY',
                                                )
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->where('product1s.BRAND', 'CPS')
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.PRODUCT', 'asc')
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else if (!isset($request->end_product) || $request->end_product == null) {
                $ProDevelops = Product1::select(
                                        'product1s.BRAND', 
                                                 'product1s.PRODUCT', 
                                                 'product1s.BARCODE',
                                                 'product1s.PRICE', 
                                                 'solutions.DESCRIPTION AS SOLUTION', 
                                                 'series.DESCRIPTION AS SERIES', 
                                                 'categories.DESCRIPTION AS CATEGORY', 
                                                 'sub_categories.DESCRIPTION AS SUB_CATEGORY',
                                                )
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->groupBy('product1s.PRODUCT')
                                        ->where('product1s.BRAND', 'CPS')
                                        ->where('PRODUCT', $request->start_product)
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else {
                $ProDevelops = Product1::select(
                                        'product1s.BRAND', 
                                                 'product1s.PRODUCT', 
                                                 'product1s.BARCODE',
                                                 'product1s.PRICE', 
                                                 'solutions.DESCRIPTION AS SOLUTION', 
                                                 'series.DESCRIPTION AS SERIES', 
                                                 'categories.DESCRIPTION AS CATEGORY', 
                                                 'sub_categories.DESCRIPTION AS SUB_CATEGORY',
                                                )
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->where('product1s.BRAND', 'CPS')
                                        ->whereBetween('product1s.PRODUCT', [$request->start_product, $request->end_product])
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.PRODUCT', 'asc')
                                        ->get()
                                        ->toArray();
            
                                        // dd($ProDevelops);
                                        // dd($ProDevelops->toSql(), $ProDevelops->getBindings());
            }
        } else if ($userpermission == 'BB') {
            if (!isset($request->start_product) || $request->start_product == null) {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->where('product1s.BRAND', 'BB')
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.PRODUCT', 'asc')
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else if (!isset($request->end_product) || $request->end_product == null) {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->groupBy('product1s.PRODUCT')
                                        ->where('product1s.BRAND', 'BB')
                                        ->where('PRODUCT', $request->start_product)
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->where('product1s.BRAND', 'BB')
                                        ->whereBetween('product1s.PRODUCT', [$request->start_product, $request->end_product])
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.PRODUCT', 'asc')
                                        ->get()
                                        ->toArray();
            
                                        // dd($ProDevelops);
                                        // dd($ProDevelops->toSql(), $ProDevelops->getBindings());
            }
        } else if ($userpermission == 'LL') {
            if (!isset($request->start_product) || $request->start_product == null) {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->where('product1s.BRAND', 'LL')
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.PRODUCT', 'asc')
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else if (!isset($request->end_product) || $request->end_product == null) {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->groupBy('product1s.PRODUCT')
                                        ->where('product1s.BRAND', 'LL')
                                        ->where('PRODUCT', $request->start_product)
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->where('product1s.BRAND', 'LL')
                                        ->whereBetween('product1s.PRODUCT', [$request->start_product, $request->end_product])
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.PRODUCT', 'asc')
                                        ->get()
                                        ->toArray();
            
                                        // dd($ProDevelops);
                                        // dd($ProDevelops->toSql(), $ProDevelops->getBindings());
            }
        } else if ($userpermission == 'GNC') {
            if (!isset($request->start_product) || $request->start_product == null) {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'product1s.COST', 'p_statuses.DESCRIPTION AS STATUS')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->leftJoin('p_statuses', 'product1s.STATUS', '=', 'p_statuses.ID')
                                        ->where('product1s.BRAND', 'GNC')
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.PRODUCT', 'asc')
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else if (!isset($request->end_product) || $request->end_product == null) {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'product1s.COST', 'p_statuses.DESCRIPTION AS STATUS')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->leftJoin('p_statuses', 'product1s.STATUS', '=', 'p_statuses.ID')
                                        ->groupBy('product1s.PRODUCT')
                                        ->where('product1s.BRAND', 'GNC')
                                        ->where('PRODUCT', $request->start_product)
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'product1s.COST', 'p_statuses.DESCRIPTION AS STATUS')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->leftJoin('p_statuses', 'product1s.STATUS', '=', 'p_statuses.ID')
                                        ->where('product1s.BRAND', 'GNC')
                                        ->whereBetween('product1s.PRODUCT', [$request->start_product, $request->end_product])
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.PRODUCT', 'asc')
                                        ->get()
                                        ->toArray();
            
                                        // dd($ProDevelops);
                                        // dd($ProDevelops->toSql(), $ProDevelops->getBindings());
            }
        } else if ($userpermission == 'BD') {
            if (!isset($request->start_product) || $request->start_product == null) {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'product1s.COST', 'p_statuses.DESCRIPTION AS STATUS', 'product_details.ingredients')
                                        ->leftJoin('product_details', 'product1s.PRODUCT', '=', 'product_details.product_id')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->leftJoin('p_statuses', 'product1s.STATUS', '=', 'p_statuses.ID')
                                        ->whereIn('product1s.BRAND', ['KTY', 'GNC', 'OP', 'LL', 'CPS', 'BB'])
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.BRAND', 'asc')
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else if (!isset($request->end_product) || $request->end_product == null) {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'product1s.COST', 'p_statuses.DESCRIPTION AS STATUS', 'product_details.ingredients')
                                        ->leftJoin('product_details', 'product1s.PRODUCT', '=', 'product_details.product_id')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->leftJoin('p_statuses', 'product1s.STATUS', '=', 'p_statuses.ID')
                                        ->groupBy('product1s.PRODUCT')
                                        ->whereIn('product1s.BRAND', ['KTY', 'GNC', 'OP', 'LL', 'CPS', 'BB'])
                                        ->where('PRODUCT', $request->start_product)
                                        ->get()
                                        ->toArray();
                                        // dd($ProDevelops);
            } else {
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'product1s.COST', 'p_statuses.DESCRIPTION AS STATUS', 'product_details.ingredients')
                                        ->leftJoin('product_details', 'product1s.PRODUCT', '=', 'product_details.product_id')
                                        ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                                        ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                                        ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                                        ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                                        ->leftJoin('p_statuses', 'product1s.STATUS', '=', 'p_statuses.ID')
                                        ->whereIn('product1s.BRAND', ['KTY', 'GNC', 'OP', 'LL', 'CPS', 'BB'])
                                        ->whereBetween('product1s.PRODUCT', [$request->start_product, $request->end_product])
                                        ->groupBy('product1s.PRODUCT')
                                        ->orderBy('product1s.BRAND', 'asc')
                                        ->get()
                                        ->toArray();
            
                                        // dd($ProDevelops);
                                        // dd($ProDevelops->toSql(), $ProDevelops->getBindings());
            }
        }
        
        $columns = [];

        if ($userpermission == 'GNC' || $userpermission == 'BD') {
            $columns = array('Brand', 'Product ID', 'Barcode', 'Name Thai', 'Name English', 'Short Name Thai', 'Short Name English', 'Retail Price', 'Cost', 'Product Status', 'ingredients');
        } else {
            $columns = array('Brand', 'Product ID', 'Barcode', 'Name Thai', 'Name English', 'Short Name Thai', 'Short Name English', 'Retail Price', 'Solution', 'Series', 'Category', 'Sub Category');
        }
        // dd($columns);

        // $ProDevelops = $ProDevelops->toArray();

        $outFileName = 'Excel.xlsx';

        // // Create Excel workbook
        $excel = Excel::create();

        // // Get the first sheet;
        $sheet = $excel->getSheet();

        // Begin an area for direct write
        $area = $sheet->beginArea();
        $header = $columns;

        $rowOptions = ['font-style' => 'bold'];

        $sheet->writeHeader($header, $rowOptions);

        foreach ($ProDevelops as $row) {
            $sheet->writeRow((array)$row);
        }
        // Save to XLSX-file
        $excel->download($outFileName);
    }

    protected function getFieldNameMapping()
    {
        if (Auth::user()->id === 32 || Auth::user()->id === 95 || Auth::user()->id === 87 || Auth::user()->id === 26) {
            return [
                // 'Brand',
                // 'product_id'        => 'Product ID',       // alias ที่ select มา
                'PRODUCT'           => 'Product ID',     // coalesce จาก p1/pc
                'barcode' => 'Barcode',
                'ref_barcode_real' => 'Barcode สินค้าจริง',
                'status' => 'Status',
                'unit_q' => 'ปริมาณการบรรจุ',
                'width' => 'กว้าง',
                'wide'            => 'ยาว',
                'height'          => 'สูง',
                'age'             => 'อายุสินค้า',
                'name_thai' => 'ชื่อภาษาไทย',
                'name_eng' => 'ชื่อภาษาอังกฤษ',
                'short_thai' => 'ชื่อย่อไทย',
                'short_eng' => 'ชื่อย่ออังกฤษ',
                'item_name' => 'item_name',
                'PRICE' => 'Retail Price',
                'cost' => 'Cost',
                'series' => 'Series',
                'category' => 'Category',
                'cat_name' => 'cat_name',
                'color_code_th' => 'color_code_th',
                'color_code_en' => 'color_code_en',
                'color_name_th' => 'color_name_th',
                'color_name_en' => 'color_name_en',
                'color_code' => 'รหัสสี',
                'product_line' => 'product_line',
                'product_type' => 'product_type',
                'skin_type' => 'skin_type',
                'finish' => 'finish',
                'package' => 'package',
                'package2' => 'package2',
                'usage_area' => 'usage_area',
                'texture' => 'texture',
                'coverage' => 'coverage',
                // 'AGE' => 'อายุสินค้า',
                'after_open_m' => 'ระยะเก็บรักษา(หลังเปิด)',
                'launch' => 'Launch',
                'channel' => 'channel',
                'ingredients' => 'ingredients',
                'description_th' => 'description_th',
                'description_en' => 'description_en',
                'usage_direction_th' => 'usage_direction_th',
                'usage_direction_en' => 'usage_direction_en',
                // 'GRP_P' => 'สินค้าของบริษัท',
                // 'SUPPLIER' => 'ผู้ขาย/ผู้ผลิต',

                'grp_p' => 'สินค้าของบริษัท',
                'supplier' => 'ผู้ขาย/ผู้ผลิต',
                'country' => 'ผลิตประเทศ',
                'suppiler_th' => 'suppiler_th',
                'suppiler_en' => 'suppiler_en',
                'fad' => 'FDA',      
                'case_width' => 'case_width',
                'case_length' => 'case_length',
                'case_height' => 'case_height',
                'case_barcode' => 'case_barcode',
                'case_weight' => 'case_weight',
                'case_pack_size' => 'case_pack_size',
                'inner_width' => 'inner_width',
                'inner_length' => 'inner_length',
                'inner_height' => 'inner_height',
                'inner_pack_size' => 'inner_pack_size',
                'inner_weight' => 'inner_weight',
                'unit_barcode' => 'unit_barcode',
                'unit_weight' => 'unit_weight',
                'unit_pak_size' => 'unit_pak_size',
                'other_detail' => 'อื่นๆ',
                'sls_free' => 'sls_free',
                'silicone_free' => 'silicone_free',
                'mineral_free' => 'mineral_free',
                'colorant_free' => 'colorant_free',
                'phthalate_free' => 'phthalate_free',
                'cruelty_free' => 'cruelty_free',
                'talc_free' => 'talc_free',
                'oil_free' => 'oil_free',
                'triethanolamin_free' => 'triethanolamin_free',
                'petroleum_free' => 'petroleum_free',
                'petrolatum_free' => 'petrolatum_free',
                'natural_alcohol' => 'natural_alcohol',
                'certified_food' => 'certified_food',
                'certified_organic' => 'certified_organic',
                'hypoallergenic' => 'hypoallergenic',
                'tested' => 'tested',
                'non_comedogenic' => 'non_comedogenic',
                'synthetic_colorant' => 'synthetic_colorant',
                'synthetic_fragrance' => 'synthetic_fragrance',
                'ph_balance' => 'ph_balance',
                'chil_over_6year' => 'chil_over_6year',
                'fragrance_free' => 'fragrance_free',
                'paraben_free' => 'paraben_free',
                'alcohol_free' => 'alcohol_free',

                'pregnancy' => 'คนท้องใช้ได้หรือไม่',                        // ใหม่
                'breastfeed' => 'ให้นมบุตรใช้ได้หรือไม่',                     // ใหม่
                
                'solution' => 'Solution',
                // 'sub_category' => 'Sub Category',
                'reg_date' => 'REG_DATE',
                'user_edit' => 'USER_EDIT',
                'edit_dt' => 'EDIT_DT',
                // เพิ่มได้ตามต้องการ...
            ];
        } else {
            return [
                // 'Brand',
                // 'product_id'        => 'Product ID',       // alias ที่ select มา
                'PRODUCT'           => 'Product ID',     // coalesce จาก p1/pc
                'barcode' => 'Barcode',
                'ref_barcode_real' => 'Barcode สินค้าจริง',
                'status' => 'Status',
                'unit_q' => 'ปริมาณการบรรจุ',
                'width' => 'กว้าง',
                'wide'            => 'ยาว',
                'height'          => 'สูง',
                'age'             => 'อายุสินค้า',
                'grp_p'           => 'สินค้าของบริษัท',
                'supplier'        => 'ผู้ขาย/ผู้ผลิต',
                'name_thai' => 'ชื่อภาษาไทย',
                'name_eng' => 'ชื่อภาษาอังกฤษ',
                'short_thai' => 'ชื่อย่อไทย',
                'short_eng' => 'ชื่อย่ออังกฤษ',
                'launch' => 'Launch',
                'country' => 'ผลิตประเทศ',
                'ingredients' => 'ingredients',
                'after_open_m' => 'ระยะเก็บรักษา(หลังเปิด)',
                'description_th' => 'description_th',
                'description_en' => 'description_en',
                'usage_direction_th' => 'usage_direction_th',
                'usage_direction_en' => 'usage_direction_en',
                'color_code_th' => 'color_code_th',
                'color_code_en' => 'color_code_en',
                'case_width' => 'case_width',
                'case_length' => 'case_length',
                'case_height' => 'case_height',
                'case_barcode' => 'case_barcode',
                'case_weight' => 'case_weight',
                'case_pack_size' => 'case_pack_size',
                'inner_width' => 'inner_width',
                'inner_length' => 'inner_length',
                'inner_height' => 'inner_height',
                'inner_barcode' => 'inner_barcode',
                'inner_pack_size' => 'inner_pack_size',
                'inner_weight' => 'inner_weight',
                'unit_barcode' => 'unit_barcode',
                'unit_weight' => 'unit_weight',
                'unit_pak_size' => 'unit_pak_size',
                'fad' => 'FDA',
                'channel' => 'channel',
                'item_name' => 'item_name',
                'cat_name' => 'cat_name',
                'product_line' => 'product_line',
                'product_type' => 'product_type',
                'skin_type' => 'skin_type',
                'finish' => 'finish',
                'package' => 'package',
                'package2' => 'package2',
                'usage_area' => 'usage_area',
                'texture' => 'texture',
                'coverage' => 'coverage',
                'color_name_th' => 'color_name_th',
                'color_name_en' => 'color_name_en',
                'suppiler_th' => 'suppiler_th',
                'suppiler_en' => 'suppiler_en',
                'color_code' => 'รหัสสี',
                'other_detail' => 'อื่นๆ',
                'sls_free' => 'sls_free',
                'silicone_free' => 'silicone_free',
                'mineral_free' => 'mineral_free',
                'colorant_free' => 'colorant_free',
                'phthalate_free' => 'phthalate_free',
                'cruelty_free' => 'cruelty_free',
                'talc_free' => 'talc_free',
                'oil_free' => 'oil_free',
                'triethanolamin_free' => 'triethanolamin_free',
                'petroleum_free' => 'petroleum_free',
                'petrolatum_free' => 'petrolatum_free',
                'natural_alcohol' => 'natural_alcohol',
                'certified_food' => 'certified_food',
                'certified_organic' => 'certified_organic',
                'hypoallergenic' => 'hypoallergenic',
                'tested' => 'tested',
                'non_comedogenic' => 'non_comedogenic',
                'synthetic_colorant' => 'synthetic_colorant',
                'synthetic_fragrance' => 'synthetic_fragrance',
                'ph_balance' => 'ph_balance',
                'chil_over_6year' => 'chil_over_6year',
                'fragrance_free' => 'fragrance_free',
                'paraben_free' => 'paraben_free',
                'alcohol_free' => 'alcohol_free',

                'pregnancy' => 'คนท้องใช้ได้หรือไม่',                        // ใหม่
                'breastfeed' => 'ให้นมบุตรใช้ได้หรือไม่',                     // ใหม่

                'PRICE' => 'PRICE',

                'UNIT_TYPE' => 'UNIT_TYPE',                              // ใหม่
                // 'cost' => 'Cost',
                'DESCRIPTION as solutions_name' => 'Solution',
                'DESCRIPTION as series_name' => 'Series',
                'DESCRIPTION as category_name' => 'Category',
                'NON_VAT' => 'NON_VAT',                                    // ใหม่
                'DESCRIPTION as sub_categories_name' => 'Sub_Categories',
                'PDM_GROUP' => 'PDM_GROUP',                                // ใหม่
                'BRAND_P' => 'BRAND_P',                                    // ใหม่
                'O_PRODUCT' => 'O_PRODUCT',                                // ใหม่
                'reg_date' => 'REG_DATE',
                'user_edit' => 'USER_EDIT',
                'edit_dt' => 'EDIT_DT',
                // เพิ่มได้ตามต้องการ...
            ];
        }
    }

    public function exportExcelProductDetail(Request $request)
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $positionId = Auth::user()->getUserPermission->id ?? null;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        // dd($request->all(), $userpermission, $positionId);

        // dd($positionId);
        // ดึงสิทธิ์ field ที่อนุญาต (value == 1)
        $allowedFields = ProductDetailExportExcel::where('position_id', $positionId)->first();
        $allowedFields = $allowedFields ? $allowedFields->toArray() : [];

        // dd($allowedFields);
        // กำหนดคอลัมน์ที่ไม่ต้องแสดงผล
        $exclude = ['id', 'brand', 'position_id', 'created_at', 'updated_at'];

        // คัดเอาเฉพาะ field ที่มีสิทธิ์ (value == 1) และไม่อยู่ใน $exclude
        $fieldsCanSee = array_keys(array_filter($allowedFields, function ($v, $k) use ($exclude) {
            return $v == 1 && !in_array($k, $exclude);
        }, ARRAY_FILTER_USE_BOTH));

        // ตรวจสอบข้อมูลที่ได้จากฐานข้อมูล
        // dd($allowedFields, $fieldsCanSee); // ดูว่า $allowedFields มีข้อมูลครบถ้วนหรือไม่

        // ฟังก์ชันค้นหา table ที่ field สังกัดอยู่
        // function resolveFieldWithTablePrefix($field) {
        //     // ตรวจสอบว่า field คือ SOLUTION หรือไม่
        //     if (strtoupper($field) === 'SOLUTION') {
        //         // ถ้าเป็น SOLUTION ให้เลือก DESCRIPTION จาก SOLUTION
        //         return 'solutions.DESCRIPTION as solutions_name';
        //     }
        //     // ตรวจสอบว่า field คือ SERIES หรือไม่
        //     if (strtoupper($field) === 'SERIES') {
        //         // ถ้าเป็น SERIES ให้เลือก DESCRIPTION จาก SERIES
        //         return 'series.DESCRIPTION as series_name';
        //     }
        //     // ตรวจสอบว่า field คือ CATEGORY หรือไม่
        //     if (strtoupper($field) === 'CATEGORY') {
        //         // ถ้าเป็น CATEGORY ให้เลือก DESCRIPTION จาก categories
        //         return 'categories.DESCRIPTION as category_name';
        //     }
        //     // ตรวจสอบว่า field คือ S_CAT หรือไม่
        //     if (strtoupper($field) === 'SUB_CATEGORY') {
        //         // dd($field);
        //         // ถ้าเป็น S_CAT ให้เลือก DESCRIPTION จาก S_CAT
        //         return 'sub_categories.DESCRIPTION as sub_categories_name';
        //     }

        //     if (Schema::hasColumn('product1s', strtoupper($field))) {
        //         return "product1s." . strtoupper($field);
        //     } elseif (Schema::hasColumn('product_details', $field)) {
        //         return "product_details." . $field;
        //     } elseif (Schema::hasColumn('product_others', $field)) {
        //         return "product_others." . $field;
        //     } elseif (Schema::hasColumn('com_products', $field)) {
        //         return "com_products." . $field;
        //     } 
        //     return null; // ไม่เจอ field ใน schema
        // }

        function resolveFieldWithTablePrefix(string $field)
        {
            // normalize ชื่อ field แต่ไม่ใช้กับ hasColumn
            $U = strtoupper($field);

            // ===== 1) ฟิลด์อธิบายจากตารางอ้างอิง =====
            if ($U === 'SOLUTION')   return 'solutions.DESCRIPTION as solutions_name';
            if ($U === 'SERIES')     return 'series.DESCRIPTION as series_name';
            if ($U === 'CATEGORY')   return 'categories.DESCRIPTION as category_name';
            if ($U === 'SUB_CATEGORY' || $U === 'S_CAT')
                return 'sub_categories.DESCRIPTION as sub_categories_name';

            // ===== 2) ฟิลด์พิเศษที่ต้อง compose เอง =====
            if ($U === 'PRODUCT') {
                // ใช้ code เดียวชื่อ PRODUCT เสมอ เพื่อให้ง่ายต่อ group/order
                return DB::raw('COALESCE(p1.PRODUCT, pc.PRODUCT) as PRODUCT');
            }
            if ($U === 'BRAND') {
                return DB::raw('COALESCE(p1.BRAND, pc.BRAND) as BRAND');
            }
            if ($U === 'PERMISSION') {
                return 'pd.permission';
            }

            // ===== 3) ฟิลด์ทั่วไป: map table alias + hasColumn แบบชื่อจริง =====
            // หมายเหตุ: ปรับให้ใช้ชื่อตาม schema จริง ไม่บังคับ strtoupper
            $candidates = [
                ['table' => 'product1s',       'alias' => 'p1'],
                ['table' => 'product_details', 'alias' => 'pd'],
                ['table' => 'product_others',  'alias' => 'po'],
                ['table' => 'com_products',    'alias' => 'cp'],
                // สุดท้าย product_channels (pc) เฉพาะบางฟิลด์ที่รู้ว่ามี
                ['table' => 'product_channels','alias' => 'pc'],
            ];

            foreach ($candidates as $c) {
                if (Schema::hasColumn($c['table'], $field)) {
                    return "{$c['alias']}.{$field}";
                }
                // เผื่อกรณี schema เก็บเป็นตัวใหญ่/เล็กไม่ตรง
                if (Schema::hasColumn($c['table'], strtolower($field))) {
                    return "{$c['alias']}." . strtolower($field);
                }
                if (Schema::hasColumn($c['table'], strtoupper($field))) {
                    return "{$c['alias']}." . strtoupper($field);
                }
            }

            return null; // ไม่พบฟิลด์
        }

        // ดึง field เตรียม select
        $selectFields = [];
        foreach ($fieldsCanSee as $field) {
            $resolved = resolveFieldWithTablePrefix($field);
            if ($resolved) {
                $selectFields[] = $resolved;
            }
        }
        // dd($selectFields);

        // ตรวจสอบ permission ก่อน query
        if ($userpermission == 'CPS') {
            // ไม่มีสิทธิ์ดู field ใดเลย
            if (empty($selectFields)) {
                abort(403, 'You do not have permission to view any fields.');
            }

            // // ✅ สร้าง base query ครั้งเดียว และ “บังคับ” ให้ permission = 'Y'
            // $base = Product1::select($selectFields)
            //     ->leftJoin('product_details', DB::raw('LOWER(product1s.PRODUCT)'), '=', DB::raw('LOWER(product_details.product_id)'))
            //     ->leftJoin('product_others', 'product1s.PRODUCT', '=', 'product_others.product_id')
            //     ->leftJoin('com_products', 'product1s.PRODUCT', '=', 'com_products.product_id')
            //     ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
            //     ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
            //     ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
            //     ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
            //     ->where('product1s.BRAND', 'CPS')
            //     // 🔒 เอาเฉพาะที่อนุญาตเท่านั้น
            //     ->whereRaw('UPPER(product_details.permission) = "Y"');

            // // --- ตัวกรองตามช่วงรหัส (ถ้าอยาก “ไม่สนใจช่วงรหัส” ก็ไม่ต้องใส่เงื่อนไขพวกนี้) ---
            // if (!isset($request->start_product) || $request->start_product == null) {
            //     // ไม่กรองรหัส
            //     $query = clone $base;
            // } elseif (!isset($request->end_product) || $request->end_product == null) {
            //     // กรอง = รหัสเดียว
            //     $query = (clone $base)->where('product1s.PRODUCT', $request->start_product);
            // } else {
            //     // กรองช่วงรหัส
            //     $query = (clone $base)
            //         ->whereBetween('product1s.PRODUCT', [$request->start_product, $request->end_product]);
            // }

            // $ProDevelops = $query
            //     ->groupBy('product1s.PRODUCT')
            //     ->orderBy('product1s.PRODUCT', 'asc')
            //     ->get()
            //     ->toArray();

            // ✅ base query: เริ่มจาก product_channels
            $base = DB::table('product_channels as pc')
                ->select($selectFields)
                // join แบบ case-insensitive ด้วย LOWER(...)
                ->leftJoin('product1s as p1', DB::raw('LOWER(pc.PRODUCT)'), '=', DB::raw('LOWER(p1.PRODUCT)'))
                ->leftJoin('product_details as pd', DB::raw('LOWER(pc.PRODUCT)'), '=', DB::raw('LOWER(pd.product_id)'))
                ->leftJoin('product_others as po', 'pc.PRODUCT', '=', 'po.product_id')
                // (ถ้าต้องการ) โยง table อื่น ๆ ที่ผูกอยู่กับ product1s
                ->leftJoin('com_products as cp', 'p1.PRODUCT', '=', 'cp.product_id')
                ->leftJoin('solutions', 'p1.SOLUTION', '=', 'solutions.ID')
                ->leftJoin('series', 'p1.SERIES', '=', 'series.ID')
                ->leftJoin('categories', 'p1.CATEGORY', '=', 'categories.ID')
                ->leftJoin('sub_categories', 'p1.S_CAT', '=', 'sub_categories.ID')

                // 1) ช่องทางขายต้องเป็น CPS
                ->where('pc.BRAND', 'CPS')

                // 2) ถ้ารหัสขึ้นต้นด้วย 1 ⇒ ต้องเป็น 113/114/115 และยาว 5 หลัก
                //    มิฉะนั้น (ไม่ได้ขึ้นต้นด้วย 1) ⇒ ผ่านได้ทั้งหมด
                ->where(function ($q) {
                    $q->where('pc.PRODUCT', 'NOT LIKE', '1%')
                    ->orWhereRaw("pc.PRODUCT REGEXP '^(113|114|115)[0-9]{2}$'");
                })

                // 3) เงื่อนไข permission แบบมีเงื่อนไข:
                //    - ถ้าเป็นสินค้าของแบรนด์ CPS เอง (ใน p1.BRAND = CPS) => ต้อง pd.permission = 'Y'
                //    - ถ้าเป็นแบรนด์อื่น (ไม่ใช่ CPS) => ให้ผ่านแม้ pd จะว่าง/ไม่มีแถว
                ->where(function ($q) {
                    $q->where(function ($q2) {
                        $q2->whereRaw('UPPER(COALESCE(p1.BRAND, "")) = "CPS"')
                        ->whereRaw('UPPER(COALESCE(pd.permission, "N")) = "Y"');
                    })->orWhere(function ($q2) {
                        $q2->whereRaw('UPPER(COALESCE(p1.BRAND, "")) <> "CPS"')
                        ->orWhereNull('p1.BRAND'); // กรณีสินค้าอยู่ใน channel แต่ไม่มีใน product1s
                    });
                });

            // --- ตัวกรองช่วงรหัส (ออปชันเหมือนเดิม แต่ใช้รหัสจาก pc.PRODUCT) ---
            if (!isset($request->start_product) || $request->start_product == null) {
                $query = clone $base;
            } elseif (!isset($request->end_product) || $request->end_product == null) {
                $query = (clone $base)->where('pc.PRODUCT', $request->start_product);
            } else {
                $query = (clone $base)->whereBetween('pc.PRODUCT', [$request->start_product, $request->end_product]);
            }

            $ProDevelops = $query
                ->groupBy('pc.PRODUCT')
                ->orderBy('pc.PRODUCT', 'asc')
                ->get()
                ->toArray();

        }

        $columns = [];
        $fieldNameMap = $this->getFieldNameMapping();

        // dd($ProDevelops);

        // Create Excel workbook
        $excel = Excel::create();

        // Get the first sheet;
        $sheet = $excel->getSheet();

        // Begin an area for direct write
        $area = $sheet->beginArea();

        $columns     = [];
        $fieldKeys   = [];
        $fieldNameMap = $this->getFieldNameMapping();

        // 1) ดึงชื่อคอลัมน์จากผลลัพธ์จริง (เลี่ยงการแปลง Expression → string)
        if (!empty($ProDevelops)) {
            // $ProDevelops เป็น array ของ stdClass -> แปลงตัวแรกเป็น array เพื่ออ่านคีย์ตามลำดับ
            $firstRow  = (array) $ProDevelops[0];
            $fieldKeys = array_keys($firstRow);
        } else {
            // ถ้าไม่มีผลลัพธ์เลย ให้ fallback เป็นคีย์จาก selectFields แบบปลอดภัย
            $fieldKeys = []; // หรือกำหนดคีย์ที่ต้องการเอง
        }

        // 2) ทำหัวตารางจาก mapping (ถ้าไม่พบ mapping ใช้ชื่อคอลัมน์เดิม)
        foreach ($fieldKeys as $key) {
            $columns[] = $fieldNameMap[$key] ?? $key;
        }

        // 3) เขียนหัวตาราง
        $sheet->writeHeader($columns, ['font-style' => 'bold']);

        // 4) เขียนข้อมูลเรียงตาม $fieldKeys
        foreach ($ProDevelops as $row) {
            $rowArr = (array) $row;
            $line   = [];
            foreach ($fieldKeys as $k) {
                $line[] = $rowArr[$k] ?? null;
            }
            $sheet->writeRow($line);
        }

        // dd($ProDevelops);
        // ✅ กำหนดชื่อไฟล์แล้วค่อยดาวน์โหลด
        $outFileName = 'Excel - CPS.xlsx';
        $excel->download($outFileName);

    }

    public function getSelect2Account(Request $request)
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition)); 

        if (!$request->has('id') || !is_numeric($request->id)) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }
        $PRODUCT = intval($request->id);

        $getSelect2ProDevelops = Pro_develops::where('PRODUCT', '>', $PRODUCT)
            ->whereIn('BRAND', ['OP', 'CPS'])
            ->pluck('PRODUCT')
            ->toArray();

        if (empty($getSelect2ProDevelops)) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json($getSelect2ProDevelops);
    }

    public function exportExcelAccount(Request $request)
    {
        dd($request->all());

        if (!isset($request->start_product) || $request->start_product == null) {
            $ProDevelops = Account::select('product', 'cost', 'sale_tp', 'cost_km', 'NAME_ENG', 'product1s.BRAND AS BRAND', 'product1s.SHORT_ENG AS SHORT_ENG')
                ->leftJoin('product1s', 'accounts.product', '=', 'product1s.PRODUCT')
                ->orderBy('accounts.product', 'asc')->get();
        } else if (!isset($request->end_product) || $request->end_product == null) {
            $ProDevelops = Account::select('product', 'cost', 'sale_tp', 'cost_km', 'NAME_ENG', 'product1s.BRAND AS BRAND', 'product1s.SHORT_ENG AS SHORT_ENG')
                ->leftJoin('product1s', 'accounts.product', '=', 'product1s.PRODUCT')
                ->where('accounts.product', $request->start_product)->get();
        } else {
            $ProDevelops = Account::select('product', 'cost', 'sale_tp', 'cost_km', 'NAME_ENG', 'product1s.BRAND AS BRAND', 'product1s.SHORT_ENG AS SHORT_ENG')->whereBetween('PRODUCT', [$request->start_product, $request->end_product])->get();
        }
        $columns = [];
        $columns = array('แบรนด์', 'เลขที่เอกสาร', 'รหัสสินค้า','รหัสบาร์โค้ด','ชื่อสินค้า');
        // dd($columns);

        $ProDevelops = $ProDevelops->toArray();

        $outFileName = 'testExcel.xlsx';

        // // Create Excel workbook
        $excel = Excel::create();

        // // Get the first sheet;
        $sheet = $excel->getSheet();

        // Begin an area for direct write
        $area = $sheet->beginArea();
        $header = $columns;

        $rowOptions = ['font-style' => 'bold'];

        $sheet->writeHeader($header, $rowOptions);

        foreach ($ProDevelops as $row) {
            $sheet->writeRow($row);
        }

        // Save to XLSX-file
        $excel->download($outFileName);
    }
}