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

        return view('new_product_develop.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $productCodeMax = Product::max('seq');
        $productCodeNumber =  preg_replace('/[^0-9]/', '', $productCodeMax) + 1;
        $productCode = 'P'.sprintf('%05d', $productCodeNumber);

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
        return view('new_product_develop.create', compact('productCode', 'list_position', 'brands', 'product_co_ordimators', 'marketing_managers', 'type_categorys', 'textures'));
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
