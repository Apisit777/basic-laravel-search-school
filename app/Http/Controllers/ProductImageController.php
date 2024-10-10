<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product_images = ProductImage::select(
            'id',
            'name',
            'seq',
            'status',
        )
        ->get();

        // dd($product_images);
        return view('imagesUpload', compact('product_images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
        // dd($request->file('files'));
        // $validator = $request->validate([
        $validator = Validator::make($request->all(), [
            'files' => 'required|mimes:jpg,png,jpeg,gif,svg'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'message' => $validator->errors()]);
        }

        // if ($image_files = $request->file('image_files')) {
        //     $year = date('Y');
        //     $month = date('m');
        //     foreach ($image_files as $image_file) {
        //         $name = 'img_'.rand().'.'.$image_file->getClientOriginalExtension();
        //         $img_path = "$year/$month";
        //         if ($image_file->move(public_path($img_path), $name)) {
        //             $save_image_files = addimage::create([
        //                 'name' => $name,
        //                 'image_path' => $img_path.'/'.$name,
        //                 'seq' => $id_car,
        //             ]);
        //         }
        //     }
        // }
        return back()->with('success', 'เพิ่มข้อมูลเรียบร้อยแล้ว.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductImage $productImage)
    {
        return view('warehouse.camera');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductImage $productImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductImage $productImage)
    {
        //
    }
}
