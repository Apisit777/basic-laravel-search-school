<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

        $images = Food::all();

        // dd($images);
        return view('imagesUpload', compact('product_images', 'images'));
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
        // dd($request);
        // dd($request->file('images'));
        // dd($request->file('files'));
        // $validator = $request->validate([

        DB::beginTransaction();
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'images' => 'required|array',
                'images.*' => 'mimes:jpg,png,jpeg,gif,svg|max:2048'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status' => 'failed',
                    'errors' => $validator->errors()
                ]);
            }

            if ($request->hasFile('images')) {
                $year = date('Y');
                $month = date('m');
                foreach ($request->file('images') as $file) {
                    $filename = 'img_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $img_path = "uploads/warehouse/$year/$month/";
                    $file->move(public_path($img_path), $filename);
                    Food::create([
                        'path' => $img_path . $filename
                    ]);
                }
            }

            DB::commit();
            session()->flash('status', 'อัปเดตข้อมูลสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('status', 'อัปเดตข้อมูลไม่สำเร็จ!');
            return response()->json([
                'success' => false,
                'status' => 'failed',
                'message' => 'Line ' . $e->getLine() . ': ' . $e->getMessage()
            ]);
        }
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
