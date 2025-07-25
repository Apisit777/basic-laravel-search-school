<?php

namespace App\Http\Controllers\ExportExcel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pro_develops;
use App\Models\Product1;
use App\Models\Account;
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

    public function exportExcelProductDetail(Request $request)
    {
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        // dd($request->all(), $userpermission);

        if ($userpermission == 'CPS') {
            if (!isset($request->start_product) || $request->start_product == null) {
                $ProDevelops = Product1::select(
                                        'product1s.BRAND', 
                                                 'product1s.PRODUCT', 
                                                 'product1s.BARCODE', 
                                                 'product1s.STATUS',
                                                 'product1s.AGE',
                                                 'product1s.GRP_P',
                                                 'product1s.SUPPLIER',
                                                 'product1s.NAME_THAI', 
                                                 'product1s.NAME_ENG', 
                                                 'product1s.SHORT_THAI', 
                                                 'product1s.SHORT_ENG', 
                                                 'product_details.launch',
                                                 'product_details.country',
                                                 'product_details.ingredients',
                                                 'product_details.after_open_m',
                                                 'product_details.description_th',
                                                 'product_details.description_en',
                                                 'product_details.usage_direction_th',
                                                 'product_details.usage_direction_en',
                                                 'product_details.color_code_th',
                                                 'product_details.color_code_en',
                                                 'product_details.case_width',
                                                 'product_details.case_length',
                                                 'product_details.case_height',
                                                 'product_details.case_barcode',
                                                 'product_details.case_weight',
                                                 'product_details.case_pack_size',
                                                 'product_details.inner_width',
                                                 'product_details.inner_length',
                                                 'product_details.inner_height',
                                                 'product_details.inner_barcode',
                                                 'product_details.inner_pack_size',
                                                 'product_details.inner_weight',
                                                 'product_details.unit_barcode',
                                                 'product_details.unit_weight',
                                                 'product_details.unit_pak_size',
                                                 'product_details.fad',
                                                 'product_others.channel',
                                                 'product_others.item_name',
                                                 'product_others.cat_name',
                                                 'product_others.product_line',
                                                 'product_others.product_type',
                                                 'product_others.skin_type',
                                                 'product_others.finish',
                                                 'product_others.package',
                                                 'product_others.package2',
                                                 'product_others.usage_area',
                                                 'product_others.texture',
                                                 'product_others.coverage',
                                                 'product_others.color_name_th',
                                                 'product_others.color_name_en',
                                                 'product_others.suppiler_th',
                                                 'product_others.suppiler_en',
                                                 'product_others.color_code',
                                                 'product_others.other_detail',
                                                 'product_others.sls_free',
                                                 'product_others.silicone_free',
                                                 'product_others.mineral_free',
                                                 'product_others.colorant_free',
                                                 'product_others.phthalate_free',
                                                 'product_others.cruelty_free',
                                                 'product_others.talc_free',
                                                 'product_others.oil_free',
                                                 'product_others.triethanolamin_free',
                                                 'product_others.petroleum_free',
                                                 'product_others.petrolatum_free',
                                                 'product_others.natural_alcohol',
                                                 'product_others.certified_food',
                                                 'product_others.certified_organic',
                                                 'product_others.hypoallergenic',
                                                 'product_others.tested',
                                                 'product_others.non_comedogenic',
                                                 'product_others.synthetic_colorant',
                                                 'product_others.synthetic_fragrance',
                                                 'product_others.ph_balance',
                                                 'product_others.chil_over_6year',
                                                 'product_others.fragrance_free',
                                                 'product_others.paraben_free',
                                                 'product_others.alcohol_free',
                                                 'product1s.PRICE', 
                                                 'product1s.COST',
                                                 'solutions.DESCRIPTION AS SOLUTION', 
                                                 'series.DESCRIPTION AS SERIES', 
                                                 'categories.DESCRIPTION AS CATEGORY', 
                                                 'sub_categories.DESCRIPTION AS SUB_CATEGORY',
                                                 'product1s.REG_DATE',
                                                 'product1s.USER_EDIT',
                                                 'product1s.EDIT_DT',
                                                )
                                        ->leftJoin('product_details', 'product1s.PRODUCT', '=', 'product_details.product_id')
                                        ->leftJoin('product_others', 'product1s.PRODUCT', '=', 'product_others.product_id')
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
                                                 'product1s.STATUS',
                                                 'product1s.AGE',
                                                 'product1s.GRP_P',
                                                 'product1s.SUPPLIER',
                                                 'product1s.NAME_THAI', 
                                                 'product1s.NAME_ENG', 
                                                 'product1s.SHORT_THAI', 
                                                 'product1s.SHORT_ENG', 
                                                 'product_details.launch',
                                                 'product_details.country',
                                                 'product_details.ingredients',
                                                 'product_details.after_open_m',
                                                 'product_details.description_th',
                                                 'product_details.description_en',
                                                 'product_details.usage_direction_th',
                                                 'product_details.usage_direction_en',
                                                 'product_details.color_code_th',
                                                 'product_details.color_code_en',
                                                 'product_details.case_width',
                                                 'product_details.case_length',
                                                 'product_details.case_height',
                                                 'product_details.case_barcode',
                                                 'product_details.case_weight',
                                                 'product_details.case_pack_size',
                                                 'product_details.inner_width',
                                                 'product_details.inner_length',
                                                 'product_details.inner_height',
                                                 'product_details.inner_barcode',
                                                 'product_details.inner_pack_size',
                                                 'product_details.inner_weight',
                                                 'product_details.unit_barcode',
                                                 'product_details.unit_weight',
                                                 'product_details.unit_pak_size',
                                                 'product_details.fad',
                                                 'product_others.channel',
                                                 'product_others.item_name',
                                                 'product_others.cat_name',
                                                 'product_others.product_line',
                                                 'product_others.product_type',
                                                 'product_others.skin_type',
                                                 'product_others.finish',
                                                 'product_others.package',
                                                 'product_others.package2',
                                                 'product_others.usage_area',
                                                 'product_others.texture',
                                                 'product_others.coverage',
                                                 'product_others.color_name_th',
                                                 'product_others.color_name_en',
                                                 'product_others.suppiler_th',
                                                 'product_others.suppiler_en',
                                                 'product_others.color_code',
                                                 'product_others.other_detail',
                                                 'product_others.sls_free',
                                                 'product_others.silicone_free',
                                                 'product_others.mineral_free',
                                                 'product_others.colorant_free',
                                                 'product_others.phthalate_free',
                                                 'product_others.cruelty_free',
                                                 'product_others.talc_free',
                                                 'product_others.oil_free',
                                                 'product_others.triethanolamin_free',
                                                 'product_others.petroleum_free',
                                                 'product_others.petrolatum_free',
                                                 'product_others.natural_alcohol',
                                                 'product_others.certified_food',
                                                 'product_others.certified_organic',
                                                 'product_others.hypoallergenic',
                                                 'product_others.tested',
                                                 'product_others.non_comedogenic',
                                                 'product_others.synthetic_colorant',
                                                 'product_others.synthetic_fragrance',
                                                 'product_others.ph_balance',
                                                 'product_others.chil_over_6year',
                                                 'product_others.fragrance_free',
                                                 'product_others.paraben_free',
                                                 'product_others.alcohol_free',
                                                 'product1s.PRICE', 
                                                 'product1s.COST',
                                                 'solutions.DESCRIPTION AS SOLUTION', 
                                                 'series.DESCRIPTION AS SERIES', 
                                                 'categories.DESCRIPTION AS CATEGORY', 
                                                 'sub_categories.DESCRIPTION AS SUB_CATEGORY',
                                                 'product1s.REG_DATE',
                                                 'product1s.USER_EDIT',
                                                 'product1s.EDIT_DT',
                                                )
                                        ->leftJoin('product_details', 'product1s.PRODUCT', '=', 'product_details.product_id')
                                        ->leftJoin('product_others', 'product1s.PRODUCT', '=', 'product_others.product_id')
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
                                                 'product1s.STATUS',
                                                 'product1s.AGE',
                                                 'product1s.GRP_P',
                                                 'product1s.SUPPLIER',
                                                 'product1s.NAME_THAI', 
                                                 'product1s.NAME_ENG', 
                                                 'product1s.SHORT_THAI', 
                                                 'product1s.SHORT_ENG', 
                                                 'product_details.launch',
                                                 'product_details.country',
                                                 'product_details.ingredients',
                                                 'product_details.after_open_m',
                                                 'product_details.description_th',
                                                 'product_details.description_en',
                                                 'product_details.usage_direction_th',
                                                 'product_details.usage_direction_en',
                                                 'product_details.color_code_th',
                                                 'product_details.color_code_en',
                                                 'product_details.case_width',
                                                 'product_details.case_length',
                                                 'product_details.case_height',
                                                 'product_details.case_barcode',
                                                 'product_details.case_weight',
                                                 'product_details.case_pack_size',
                                                 'product_details.inner_width',
                                                 'product_details.inner_length',
                                                 'product_details.inner_height',
                                                 'product_details.inner_barcode',
                                                 'product_details.inner_pack_size',
                                                 'product_details.inner_weight',
                                                 'product_details.unit_barcode',
                                                 'product_details.unit_weight',
                                                 'product_details.unit_pak_size',
                                                 'product_details.fad',
                                                 'product_others.channel',
                                                 'product_others.item_name',
                                                 'product_others.cat_name',
                                                 'product_others.product_line',
                                                 'product_others.product_type',
                                                 'product_others.skin_type',
                                                 'product_others.finish',
                                                 'product_others.package',
                                                 'product_others.package2',
                                                 'product_others.usage_area',
                                                 'product_others.texture',
                                                 'product_others.coverage',
                                                 'product_others.color_name_th',
                                                 'product_others.color_name_en',
                                                 'product_others.suppiler_th',
                                                 'product_others.suppiler_en',
                                                 'product_others.color_code',
                                                 'product_others.other_detail',
                                                 'product_others.sls_free',
                                                 'product_others.silicone_free',
                                                 'product_others.mineral_free',
                                                 'product_others.colorant_free',
                                                 'product_others.phthalate_free',
                                                 'product_others.cruelty_free',
                                                 'product_others.talc_free',
                                                 'product_others.oil_free',
                                                 'product_others.triethanolamin_free',
                                                 'product_others.petroleum_free',
                                                 'product_others.petrolatum_free',
                                                 'product_others.natural_alcohol',
                                                 'product_others.certified_food',
                                                 'product_others.certified_organic',
                                                 'product_others.hypoallergenic',
                                                 'product_others.tested',
                                                 'product_others.non_comedogenic',
                                                 'product_others.synthetic_colorant',
                                                 'product_others.synthetic_fragrance',
                                                 'product_others.ph_balance',
                                                 'product_others.chil_over_6year',
                                                 'product_others.fragrance_free',
                                                 'product_others.paraben_free',
                                                 'product_others.alcohol_free',
                                                 'product1s.PRICE',
                                                 'product1s.COST', 
                                                 'solutions.DESCRIPTION AS SOLUTION', 
                                                 'series.DESCRIPTION AS SERIES', 
                                                 'categories.DESCRIPTION AS CATEGORY', 
                                                 'sub_categories.DESCRIPTION AS SUB_CATEGORY',
                                                 'product1s.REG_DATE',
                                                 'product1s.USER_EDIT',
                                                 'product1s.EDIT_DT',
                                                )
                                        ->leftJoin('product_details', 'product1s.PRODUCT', '=', 'product_details.product_id')
                                        ->leftJoin('product_others', 'product1s.PRODUCT', '=', 'product_others.product_id')
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
        }
        
        $columns = array(
            'Brand', 
            'Product ID', 
            'Barcode', 
            'Status', 
            'อายุสินค้า', 
            'สินค้าของบริษัท', 
            'ผู้ขาย/ผู้ผลิต', 
            'Name Thai', 
            'Name English',
            'Short Name Thai', 
            'Short Name English',
            'Launch',
            'ผลิตประเทศ',
            'ingredients',
            'ระยะเก็บรักษา(หลังเปิด)',
            'description_th',
            'description_en',
            'usage_direction_th',
            'usage_direction_en',
            'color_code_th',
            'color_code_en',
            'case_width',
            'case_length',
            'case_height',
            'case_barcode',
            'case_weight',
            'case_pack_size',
            'inner_width',
            'inner_length',
            'inner_height',
            'inner_barcode',
            'inner_pack_size',
            'inner_weight',
            'unit_barcode',
            'unit_weight',
            'unit_pak_size',
            'FDA',
            'channel',
            'item_name',
            'cat_name',
            'product_line',
            'product_type',
            'skin_type',
            'finish',
            'package',
            'package2',
            'usage_area',
            'texture',
            'coverage',
            'color_name_th',
            'color_name_en',
            'suppiler_th',
            'suppiler_en',
            'รหัสสี',
            'อื่นๆ',
            'sls_free',
            'silicone_free',
            'mineral_free',
            'colorant_free',
            'phthalate_free',
            'cruelty_free',
            'talc_free',
            'oil_free',
            'triethanolamin_free',
            'petroleum_free',
            'petrolatum_free',
            'natural_alcohol',
            'certified_food',
            'certified_organic',
            'hypoallergenic',
            'tested',
            'non_comedogenic',
            'synthetic_colorant',
            'synthetic_fragrance',
            'ph_balance',
            'chil_over_6year',
            'fragrance_free',
            'paraben_free',
            'alcohol_free',
            'Retail Price', 
            'Cost', 
            'Solution', 
            'Series', 
            'Category', 
            'Sub Category',
            'REG_DATE',
            'USER_EDIT',
            'EDIT_DT',
        );
        
        // dd($columns);

        // $ProDevelops = $ProDevelops->toArray();

        $outFileName = 'Excel - CPS.xlsx';

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