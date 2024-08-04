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
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\UpdateOrCreateOnNull;

class ProductFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

        return view('new_product_develop.index', compact('user'));
    }

    private function ean13_check_digit() {

        $barcodeMax = Pro_develops::max('BARCODE');
        $barcodeNumber =  preg_replace('/[^0-9]/', '', $barcodeMax) + 1;
        $barcode = sprintf('%04d', $barcodeNumber);
        
        //first change digits to a string so that we can access individual numbers
        // $digits =(string)$digits;
        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        // $even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
        // 2. Multiply this result by 3.
        // $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        // $odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
        // 4. Sum the results of steps 2 and 3.
        // $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        // $next_ten = (ceil($total_sum/10))*10;
        // $check_digit = $next_ten - $total_sum;
        // return $digits . $check_digit;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $digits = $this->ean13_check_digit();
        // dd($digits);
        // $productOPCodeMax = Barcode::where('BRAND', '=', 'OP')->max('NUMBER');
        // $productRICodeMax = Barcode::where('BRAND', '=', 'RI')->max('NUMBER');
        // $productCodeNumber =  preg_replace('/[^0-9]/', '', $productRICodeMax) + 1;
        // $productCode = $productCodeNumber;

        // dd($productCode);

        $productCodeMax = Document::max('NUMBER');
        $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        $productCode = '2'.sprintf('%04d', $productCodeNumber);

        $barcodeMax = Pro_develops::max('BARCODE');
        $barcodeNumber =  preg_replace('/[^0-9]/', '', $barcodeMax) + 1;
        $barcode = sprintf('%04d', $barcodeNumber);

        // dd($productCode);

        $list_position = position::select('id', 'name_position')->get();

        $brands = Brand::listBrand();
        // dd($brands->all());

        $Products = Product::orderBy('name');

        $Products = $Products->get();

        $product_co_ordimators = Npd_cos::all();
        $marketing_managers = Npd_pdms::all();
        $type_categorys = Npd_categorys::all();
        $textures = Npd_textures::all();
        // dd($textures);
        return view('new_product_develop.create', compact('productCode', 'barcode', 'list_position', 'brands', 'product_co_ordimators', 'marketing_managers', 'type_categorys', 'textures'));
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
            $barcodeMax = Pro_develops::max('BARCODE');
            $barcodeNumber =  preg_replace('/[^0-9]/', '', $barcodeMax) + 1;
            $barcode = sprintf('%04d', $barcodeNumber);

            $data_product = [
                'BARCODE' => $barcode,
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
