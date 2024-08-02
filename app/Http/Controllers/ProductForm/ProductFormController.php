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

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
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
            // $data_product = [
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            //     'name' => $request->input('123'),
            // ];

            // $productCodeMax = Document::max('NUMBER');
            // $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
            // $productCode = $productCodeNumber;            
            // dd($productCode);

            if($request->DOC_TP == "OP") {
                $productCodeMax = Document::max('NUMBER');
                $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
                $productCode = $productCodeNumber;

                $data_number = Document::updateOrCreate(['DOC_TP' => $request->DOC_TP], [
                    'NUMBER' => $productCode
                ]);
            } 
            if($request->BRAND == "OP") {
                $productCodeMax = Barcode::max('NUMBER');
                $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
                $productCode = $productCodeNumber;

                $data_number = Barcode::updateOrCreate(['BRAND' => $request->BRAND], [
                    'NUMBER' => $productCode
                ]);
            }
            // dd($request);
            // $product = Pro_develops::create($data_product);

            $productCodeMax = Document::max('NUMBER');
            $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
            $productCode = sprintf('%04d', $productCodeNumber);

            $barcodeMax = Pro_develops::max('BARCODE');
            $barcodeNumber =  preg_replace('/[^0-9]/', '', $barcodeMax) + 1;
            $barcode = sprintf('%04d', $barcodeNumber);

            // $response = Pro_develops::where('id', $product->id)->update([
            //     'DOC_NO' => $productCode,
            //     'BARCODE' => $barcode,
            // ]);
            
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
