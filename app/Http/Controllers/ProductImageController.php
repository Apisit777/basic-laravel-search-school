<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
                $seq = Food::max('seq') + 1; // ค้นหาค่า seq สูงสุดแล้วเพิ่ม 1
                foreach ($request->file('images') as $file) {
                    $img_path = "uploads/warehouse/$year/$month/";
                    $filename = 'img_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                    // สร้างโฟลเดอร์ถ้ายังไม่มี
                    if (!file_exists(public_path($img_path))) {
                        mkdir(public_path($img_path), 0777, true);
                    }
                    $file->move(public_path($img_path), $filename);
                    Food::updateOrCreate(
                        ['seq' => $seq], // ตรวจสอบ seq ในฐานข้อมูล
                        [
                            'path' => $img_path . $filename,
                            'seq' => $seq // บันทึกค่า seq ใหม่
                        ]
                    );
                    $seq++; // เพิ่มค่า seq สำหรับรายการถัดไป
                }
            }

            DB::commit();
            session()->flash('message', 'อัปเดตข้อมูลสำเร็จ');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('message', 'อัปเดตข้อมูลไม่สำเร็จ!');
            return response()->json([
                'success' => false,
                'status' => 'failed',
                'message' => 'Line ' . $e->getLine() . ': ' . $e->getMessage()
            ]);
        }
    }

    public function deleteImg($id) 
    {
        // ค้นหาข้อมูล
        $data = Food::select('path')->where('id', $id)->first();

        // เช็คว่าพบข้อมูลหรือไม่
        if (!$data) {
            return response()->json(['message' => 'Image not found in database.'], 404);
        }

        $fullpath = public_path($data->path);

        // เช็คว่าไฟล์มีอยู่จริงหรือไม่
        if (File::exists($fullpath)) { 
            File::delete($fullpath); // ลบไฟล์จริง
        } else { 
            return response()->json(['message' => 'File does not exist.'], 404);
        } 

        // ลบข้อมูลออกจากฐานข้อมูล
        Food::where('id', $id)->delete();

        return response()->json(['message' => 'Image deleted successfully.'], 200);
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
