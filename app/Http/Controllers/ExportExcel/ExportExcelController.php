<?php

namespace App\Http\Controllers\ExportExcel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pro_develops;
use App\Models\Product1;
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

            $getSelect2ProDevelops = Product1::where('PRODUCT', '>', $PRODUCT)
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
        return [
            // 'Brand',
            'PRODUCT' => 'Product ID',
            'BARCODE' => 'Barcode',
            'STATUS' => 'Status',
            'AGE' => 'อายุสินค้า',
            'GRP_P' => 'สินค้าของบริษัท',
            'SUPPLIER' => 'ผู้ขาย/ผู้ผลิต',
            'NAME_THAI' => 'ชื่อภาษาไทย',
            'NAME_ENG' => 'ชื่อภาษาอังกฤษ',
            'SHORT_THAI' => 'ชื่อย่อไทย',
            'SHORT_ENG' => 'ชื่อย่ออังกฤษ',
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
            'price' => 'Retail Price',
            'cost' => 'Cost',
            'solution' => 'Solution',
            'series' => 'Series',
            'category' => 'Category',
            'sub_category' => 'Sub Category',
            'reg_date' => 'REG_DATE',
            'user_edit' => 'USER_EDIT',
            'edit_dt' => 'EDIT_DT',
            // เพิ่มได้ตามต้องการ...
        ];
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

        // กำหนดคอลัมน์ที่ไม่ต้องแสดงผล
        $exclude = ['id', 'brand', 'position_id', 'created_at', 'updated_at'];

        // คัดเอาเฉพาะ field ที่มีสิทธิ์ (value == 1) และไม่อยู่ใน $exclude
        $fieldsCanSee = array_keys(array_filter($allowedFields, function ($v, $k) use ($exclude) {
            return $v == 1 && !in_array($k, $exclude);
        }, ARRAY_FILTER_USE_BOTH));

        // dd($fieldsCanSee);

        // ฟังก์ชันค้นหา table ที่ field สังกัดอยู่
        function resolveFieldWithTablePrefix($field) {
            if (Schema::hasColumn('product1s', strtoupper($field))) {
                return "product1s." . strtoupper($field);
            } elseif (Schema::hasColumn('product_details', $field)) {
                return "product_details." . $field;
            } elseif (Schema::hasColumn('product_others', $field)) {
                return "product_others." . $field;
            }
            return null; // ไม่เจอ field ใน schema
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

            // ✅ สร้าง base query ครั้งเดียว และ “บังคับ” ให้ permission = 'Y'
            $base = Product1::select($selectFields)
                ->leftJoin('product_details', DB::raw('LOWER(product1s.PRODUCT)'), '=', DB::raw('LOWER(product_details.product_id)'))
                ->leftJoin('product_others', 'product1s.PRODUCT', '=', 'product_others.product_id')
                ->leftJoin('solutions', 'product1s.SOLUTION', '=', 'solutions.ID')
                ->leftJoin('series', 'product1s.SERIES', '=', 'series.ID')
                ->leftJoin('categories', 'product1s.CATEGORY', '=', 'categories.ID')
                ->leftJoin('sub_categories', 'product1s.S_CAT', '=', 'sub_categories.ID')
                ->where('product1s.BRAND', 'CPS')
                // 🔒 เอาเฉพาะที่อนุญาตเท่านั้น
                ->whereRaw('UPPER(product_details.permission) = "Y"');

            // --- ตัวกรองตามช่วงรหัส (ถ้าอยาก “ไม่สนใจช่วงรหัส” ก็ไม่ต้องใส่เงื่อนไขพวกนี้) ---
            if (!isset($request->start_product) || $request->start_product == null) {
                // ไม่กรองรหัส
                $query = clone $base;
            } elseif (!isset($request->end_product) || $request->end_product == null) {
                // กรอง = รหัสเดียว
                $query = (clone $base)->where('product1s.PRODUCT', $request->start_product);
            } else {
                // กรองช่วงรหัส
                $query = (clone $base)
                    ->whereBetween('product1s.PRODUCT', [$request->start_product, $request->end_product]);
            }

            $ProDevelops = $query
                ->groupBy('product1s.PRODUCT')
                ->orderBy('product1s.PRODUCT', 'asc')
                ->get()
                ->toArray();
        }

        $columns = [];
        $fieldNameMap = $this->getFieldNameMapping();

        // Create Excel workbook
        $excel = Excel::create();

        // Get the first sheet;
        $sheet = $excel->getSheet();

        // Begin an area for direct write
        $area = $sheet->beginArea();

        foreach ($selectFields as $field) {
            $fieldParts = explode('.', $field);
            $fieldName = end($fieldParts);

            $columns[] = $fieldNameMap[$fieldName] ?? $fieldName;
        }

        $outFileName = 'Excel - CPS.xlsx';

        $header = $columns;
        $rowOptions = ['font-style' => 'bold'];

        $sheet->writeHeader($header, $rowOptions);

        foreach ($ProDevelops as $row) {
            $sheet->writeRow((array)$row);
        }

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