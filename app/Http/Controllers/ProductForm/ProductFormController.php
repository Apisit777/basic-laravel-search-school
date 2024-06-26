<?php

namespace App\Http\Controllers\ProductForm;

use App\Models\Product;
use App\Models\position;
use App\Models\User;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

        return view('product_form.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $productCodeMax = Product::max('seq');
        $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        $productCode = 'P'.sprintf('%05d', $productCodeNumber);

        $list_position = position::select('id_position', 'name_position')->get();

        $brands = Brand::listBrand();
        // dd($brands->all());

        $Products = Product::orderBy('name');

        $Products = $Products->get();

        return view('product_form.create', compact('productCode', 'list_position', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
