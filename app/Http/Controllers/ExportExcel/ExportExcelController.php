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
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
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
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
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
                $ProDevelops = Product1::select('product1s.BRAND', 'product1s.PRODUCT', 'product1s.BARCODE', 'product1s.NAME_THAI', 'product1s.NAME_ENG', 'product1s.SHORT_THAI', 'product1s.SHORT_ENG', 'product1s.PRICE', 'solutions.DESCRIPTION AS SOLUTION', 'series.DESCRIPTION AS SERIES', 'categories.DESCRIPTION AS CATEGORY', 'sub_categories.DESCRIPTION AS SUB_CATEGORY')
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
        }
        
        $columns = [];

        if ($userpermission == 'GNC') {
            $columns = array('Brand', 'Product ID', 'Barcode', 'Name Thai', 'Name English', 'Short Name Thai', 'Short Name English', 'Retail Price', 'Cost', 'Product Status');
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