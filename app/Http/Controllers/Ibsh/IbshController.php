<?php

namespace App\Http\Controllers\Ibsh;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Barcode;
use App\Models\Product1;
use App\Models\ProductChannel;
use App\Models\ProductDetail;
use App\Models\Com_product;
use App\Models\ComProductImage;
use App\Models\ComProduct;
use App\Models\ProductOther;
use App\Models\CoreIbshFiel;
use App\Models\MasterBrandChannel;
use App\Models\ProductChannelBrand;
use App\Models\MasterBrand;
use App\Models\Series;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\ProductLine;
use App\Models\ProductType;
use App\Models\CpsSkinType;
use App\Models\CpsCoverageBenefit;
use App\Models\CpsUsageArea;
use App\Models\CpsTextureFormula;
use App\Models\CpsFinish;
use App\Models\CpsPackageType1;
use App\Models\CpsPackageType2;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use DateTime; // ✅ เพิ่มบรรทัดนี้
use Illuminate\Support\Facades\Cache;
use App\Models\Countrie;
use Illuminate\Http\Request;

class IbshController extends Controller
{
    
    public function index()
    {

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $userDepartment = Auth::user()->getUserDepartment->department;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        // dd($userpermission);

        $getSelect2ProDevelops = []; // ✅ กันไว้ก่อนเลย

        if ($userpermission == 'CPS' || $userDepartment == 'IBSH') {
            $brands = Barcode::select(
                'BRAND',
                'STATUS')
            ->whereIn('STATUS', ['CPS'])
            ->pluck('BRAND')
            ->toArray();

            $dataProductMasterArr = Product1::select(
            'PRODUCT')
            ->whereNotIn('BRAND', ['OP', 'KM', 'KTY', 'BB', 'LL'])
            ->pluck('PRODUCT')
            ->toArray();

            // ดึง PRODUCT ทั้งหมดที่มีอยู่ใน product1s ก่อน
            $validProducts = DB::table('product1s')
                ->pluck('PRODUCT')
                ->toArray();

            // จากนั้นดึงข้อมูลจาก ProductChannel ที่ brand = 'CPS' และมี PRODUCT อยู่ใน product1s.PRODUCT
            $getSelect2ProDevelops = ProductChannel::select('PRODUCT')
                ->whereIn('BRAND', ['CPS'])
                ->whereIn('PRODUCT', $validProducts)
                ->orderBy('PRODUCT', 'asc')
                ->pluck('PRODUCT')
                ->toArray();    
        }

        return view('ibhs.index', compact('brands', 'dataProductMasterArr', 'getSelect2ProDevelops'));
    }

    public function edit(Request $request, $id)
    {
        // dd($id);
        $data = ProductDetail::select(
            'product_details.*',
            'com_products.barcode AS barcode',
            'com_products.ref_barcode_real AS ref_barcode_real',
        )
        ->leftJoin('com_products', 'product_details.product_id', '=', 'com_products.product_id')
        ->firstWhere('product_details.product_id', '=', $id);

        // แปลงวันที่เฉพาะตอนที่มีค่า
        if (!empty($data) && !empty($data->launch)) {
            $raw = trim($data->launch);

            // รองรับทั้ง m-Y และ Y-m
            $dt = DateTime::createFromFormat('m-Y', $raw) ?: DateTime::createFromFormat('Y-m', $raw);

            if ($dt instanceof DateTime) {
                $data->launch = $dt->format('Y-m');   // ได้ 2019-09
            } else {
                // ถ้า parse ไม่ได้: เลือกจัดการตามต้องการ
                $data->launch = null; // หรือคงค่าเดิม $data->launch = $raw;
            }
        }
        // dd($data);

        $countriesDatas = Countrie::select('id AS country', 'name_country')->orderBy('name_country', 'ASC')->get()->toArray();
        if (!in_array($data->country, array_column($countriesDatas, 'country')))
            {
                $countriesDatas[] =  [
                    'id' => $data->country,
                    'name_country' => $data->country,
                ];
            }

        $dataComProduct = Com_product::select(
            'com_products.product_id as product_id',
            'com_products.name_thai as name_thai',
            'com_products.barcode as barcode',
            'com_products.ref_barcode_real as ref_barcode_real',
            
            'com_products.unit_net_weight as unit_net_weight',
            'com_products.unit_gross_weight as unit_gross_weight',
            'com_products.inner_net_weight as inner_net_weight',
            'com_products.inner_gross_weight as inner_gross_weight',
            'com_products.case_net_weight as case_net_weight',
            'com_products.case_gross_weight as case_gross_weight',

            'com_products.km_inner_width as km_inner_width',
            'com_products.km_inner_long as km_inner_long',
            'com_products.km_inner_height as km_inner_height',
            'com_products.km_case_width as km_case_width',
            'com_products.km_case_long as km_case_long',
            'com_products.km_case_height as km_case_height',

            'com_products.width as width',
            'com_products.long as long',
            'com_products.height as height',
            'com_products.area as area',
            'com_products.box_qty as box_qty',
            'com_products.pallet_qty as pallet_qty',
            'com_products.weight as weight',
            
            'product_details.unit_weight AS unit_weight',
            'product_details.unit_pak_size AS unit_pak_size',
            'product_details.case_weight AS case_weight',
            'product_details.case_pack_size AS case_pack_size',
            'product_details.case_width AS case_width',
            'product_details.case_length AS case_length',
            'product_details.case_height AS case_height',
            'product_details.case_barcode AS case_barcode',
            'product_details.inner_width AS inner_width',
            'product_details.inner_length AS inner_length',
            'product_details.inner_height AS inner_height',
            'product_details.inner_barcode AS inner_barcode',
            'product_details.inner_weight AS inner_weight',
            'product_details.inner_pack_size AS inner_pack_size',
            'product1s.PACK_SIZE1 AS PACK_SIZE1',
            'product1s.BAR_PACK1 AS BAR_PACK1',
        )
        ->leftJoin('product_details', 'com_products.product_id', '=', 'product_details.product_id')
        ->leftJoin('product1s', 'com_products.product_id', '=', 'product1s.PRODUCT')
        ->firstWhere('com_products.product_id', '=', $id);

        $scheme = request()->getScheme(); // http หรือ https
        $host   = request()->getHost();   // localhost หรือ pdmaster.ssup.co.th

        $images = ComProductImage::select(
            'id', 
            'product_id', 
            'seq', 
            DB::raw("CASE
                        WHEN com_product_images.path LIKE 'https%' 
                        THEN com_product_images.path
                        ELSE com_product_images.path
                    END 
                    AS path"
            ),
        )
        ->where('product_id', $id)
            ->orderBy('seq', 'asc')
            ->get();
        if ($images->isEmpty()) {
            // fallback ไปที่ com_products (ใช้ img_url แทน path และไม่มี seq)
            $images = ComProduct::select(
                    'id',
                    'product_id',
                    // DB::raw('0 as seq'),
                    DB::raw("img_url as path")
                )
                ->where('product_id', $id)
                ->orderBy('id', 'asc')   // หรือจะตัดบรรทัดนี้ออกก็ได้
                ->get();
        }

        $product_id = $images->first()->product_id ?? null;

        // ดึงรูปจาก API Oriental Princess (ใช้ cache เดียวกับ listWarehouse)
        $opApiImage = null;
        $opImages = Cache::remember('op_product_images', 60 * 60, function () {
            try {
                $response = Http::timeout(10)->get('https://orientalprincess.com/api/getProductImage.php');
                if ($response->successful()) {
                    return collect($response->json())->whereNotNull('image')->pluck('image', 'sku')->toArray();
                }
            } catch (\Exception $e) {
                \Log::warning('OP API getProductImage failed: ' . $e->getMessage());
            }
            return [];
        });
        if (isset($opImages[$product_id])) {
            $opApiImage = $opImages[$product_id];
        }

        // dd($dataComProduct);
        // $errorText = collect($dataComProduct);
        // dd(response()->json([
        //     'errorMessage' => $errorText,
        // ]));

        $dataFreeForm = ProductOther::select(
            'product_others.*',
            'product_others.product_id AS product_id',
            'product1s.NAME_THAI AS NAME_THAI',
            'product_others.item_name AS item_name',
            'product_others.cat_name AS cat_name',
            'product_others.product_line AS product_line',
            'product_others.product_type AS product_type',
            'product_others.color_name_th AS color_name_th',
            'product_others.color_name_en AS color_name_en',
            'product_others.suppiler_th AS suppiler_th',
            'product_others.suppiler_en AS suppiler_en',
            'product_others.other_detail AS other_detail',
            'categories.ID AS category_id',
            'product_lines.ID AS product_line_id',
            'product_types.ID AS product_type_id',
            'cps_skin_types.ID AS skin_type_id',
            'cps_coverage_benefits.ID AS coverage_id',
            'cps_usage_areas.ID AS usage_area_id',
            'cps_texture_formulas.ID AS texture_id',
            'cps_finishes.ID AS finish_id',
            'cps_package_type1s.ID AS package_type1_id',
            'cps_package_type2s.ID AS package_type2_id',
            'inner_barcode'
        )
        ->leftjoin('product1s', 'product1s.PRODUCT', '=', 'product_others.product_id')
        ->leftjoin('categories', 'categories.ID', '=', 'product1s.CATEGORY')
        ->leftjoin('product_lines', 'product_lines.ID', '=', 'product_others.product_line') // แก้จุดนี้
        ->leftjoin('product_types', 'product_types.ID', '=', 'product_others.product_type') // แก้จุดนี้ด้วย
        ->leftjoin('product_details', 'product_details.product_id', '=', 'product_others.product_id')
        ->leftjoin('cps_skin_types', 'cps_skin_types.ID', '=', 'product_others.skin_type')
        ->leftjoin('cps_coverage_benefits', 'cps_coverage_benefits.ID', '=', 'product_others.coverage')
        ->leftjoin('cps_usage_areas', 'cps_usage_areas.ID', '=', 'product_others.usage_area')
        ->leftjoin('cps_texture_formulas', 'cps_texture_formulas.ID', '=', 'product_others.texture')
        ->leftjoin('cps_finishes', 'cps_finishes.ID', '=', 'product_others.finish')
        ->leftjoin('cps_package_type1s', 'cps_package_type1s.ID', '=', 'product_others.package')
        ->leftjoin('cps_package_type2s', 'cps_package_type2s.ID', '=', 'product_others.package2')
        ->firstWhere('product_others.product_id', '=', $id);
        
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        // ดึง channel ทั้งหมดที่มีอยู่ (เพื่อ populate select2)
        $allChannels = MasterBrandChannel::select('CHANNEL_NAME')->where('BRAND', '=', 'CPS')->pluck('CHANNEL_NAME')->toArray();

        // ดึงค่าที่เคยเลือกไว้จาก product_channel_brands
        $defaultChannel = ProductChannelBrand::where('PRODUCT', '=', $id)
            ->pluck('CHANNEL')
            ->map(function ($item) {
                $lower = strtolower(trim($item));
                if (strlen($lower) <= 2) {
                    return strtoupper($lower); // MT → MT
                }
                return ucwords(str_replace('_', ' ', $lower)); // shop_ecom → Shop Ecom
            })
            ->toArray();

        // ล้างค่าว่างออก
        $cleanedChannel = array_filter($defaultChannel, function ($value) {
            return trim($value) !== '';
        });

        // ถ้าเจอ all ให้แสดง 'all' อย่างเดียว
        if (in_array('all', array_map('strtolower', $cleanedChannel))) {
            $defaultAllChannels = ['all'];
        } else {
            $defaultAllChannels = $cleanedChannel;
        }

        // dd($defaultAllChannels);

        $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
        $series = Series::select(
            'ID',
            'DESCRIPTION',
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        // ดึงเฉพาะ Category ที่มี Product Line อยู่จริง และ BRAND = CPS
        $categorys = Category::select('categories.ID', 'categories.DESCRIPTION', 'categories.BRAND')
            ->join('product_lines', 'product_lines.CATEGORY_ID', '=', 'categories.ID')
            ->where('categories.BRAND', 'CPS')
            ->where('product_lines.BRAND', 'CPS')
            ->groupBy('categories.ID', 'categories.DESCRIPTION', 'categories.BRAND')
            ->orderBy('categories.DESCRIPTION')
            ->get();

        // ถ้ามี Category เดิมที่ไม่อยู่ใน list ให้เพิ่มเข้าไป (รักษาค่าเดิม)
        if ($dataFreeForm && $dataFreeForm->category_id) {
            $existingIds = $categorys->pluck('ID')->toArray();
            if (!in_array($dataFreeForm->category_id, $existingIds)) {
                $oldCategory = Category::select('ID', 'DESCRIPTION', 'BRAND')
                    ->where('ID', $dataFreeForm->category_id)
                    ->where('BRAND', 'CPS')
                    ->first();
                if ($oldCategory) {
                    $categorys->push($oldCategory);
                }
            }
        }

        $dataProductDetail = ProductOther::select(
            'product_others.*',
            'product_others.product_id AS product_id',
            'product1s.NAME_THAI AS NAME_THAI',
            'product_others.item_name AS item_name',
            'product_others.cat_name AS cat_name',
            'product_others.product_line AS product_line',
            'product_others.product_type AS product_type',
            'product_others.color_name_th AS color_name_th',
            'product_others.color_name_en AS color_name_en',
            'product_others.suppiler_th AS suppiler_th',
            'product_others.suppiler_en AS suppiler_en',
            'product_others.other_detail AS other_detail',
            'categories.ID AS category_id',
            'product_lines.ID AS product_line_id',
            'product_types.ID AS product_type_id',
            'cps_skin_types.ID AS skin_type_id',
            'cps_coverage_benefits.ID AS coverage_id',
            'cps_usage_areas.ID AS usage_area_id',
            'cps_texture_formulas.ID AS texture_id',
            'cps_finishes.ID AS finish_id',
            'cps_package_type1s.ID AS package_type1_id',
            'cps_package_type2s.ID AS package_type2_id',
            'inner_barcode'
        )
        ->leftjoin('product1s', 'product1s.PRODUCT', '=', 'product_others.product_id')
        ->leftjoin('categories', 'categories.ID', '=', 'product1s.CATEGORY')
        ->leftjoin('product_lines', 'product_lines.ID', '=', 'product_others.product_line') // แก้จุดนี้
        ->leftjoin('product_types', 'product_types.ID', '=', 'product_others.product_type') // แก้จุดนี้ด้วย
        ->leftjoin('product_details', 'product_details.product_id', '=', 'product_others.product_id')
        ->leftjoin('cps_skin_types', 'cps_skin_types.ID', '=', 'product_others.skin_type')
        ->leftjoin('cps_coverage_benefits', 'cps_coverage_benefits.ID', '=', 'product_others.coverage')
        ->leftjoin('cps_usage_areas', 'cps_usage_areas.ID', '=', 'product_others.usage_area')
        ->leftjoin('cps_texture_formulas', 'cps_texture_formulas.ID', '=', 'product_others.texture')
        ->leftjoin('cps_finishes', 'cps_finishes.ID', '=', 'product_others.finish')
        ->leftjoin('cps_package_type1s', 'cps_package_type1s.ID', '=', 'product_others.package')
        ->leftjoin('cps_package_type2s', 'cps_package_type2s.ID', '=', 'product_others.package2')
        ->firstWhere('product_others.product_id', '=', $id);
        
        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));

        // ดึง channel ทั้งหมดที่มีอยู่ (เพื่อ populate select2)
        $allChannels = MasterBrandChannel::select('CHANNEL_NAME')->where('BRAND', '=', 'CPS')->pluck('CHANNEL_NAME')->toArray();

        // ดึงค่าที่เคยเลือกไว้จาก product_channel_brands
        $defaultChannel = ProductChannelBrand::where('PRODUCT', '=', $id)
            ->pluck('CHANNEL')
            ->map(function ($item) {
                $lower = strtolower(trim($item));
                if (strlen($lower) <= 2) {
                    return strtoupper($lower); // MT → MT
                }
                return ucwords(str_replace('_', ' ', $lower)); // shop_ecom → Shop Ecom
            })
            ->toArray();

        // ล้างค่าว่างออก
        $cleanedChannel = array_filter($defaultChannel, function ($value) {
            return trim($value) !== '';
        });

        // ถ้าเจอ all ให้แสดง 'all' อย่างเดียว
        if (in_array('all', array_map('strtolower', $cleanedChannel))) {
            $defaultAllChannels = ['all'];
        } else {
            $defaultAllChannels = $cleanedChannel;
        }

        // dd($defaultAllChannels);

        $brands = MasterBrand::select(
                'BRAND')
            ->where('BRAND', 'CPS')
            ->get();
        $series = Series::select(
            'ID',
            'DESCRIPTION',
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        // ดึงเฉพาะ Category ที่มี Product Line อยู่จริง และ BRAND = CPS
        $categorys = Category::select('categories.ID', 'categories.DESCRIPTION', 'categories.BRAND')
            ->join('product_lines', 'product_lines.CATEGORY_ID', '=', 'categories.ID')
            ->where('categories.BRAND', 'CPS')
            ->where('product_lines.BRAND', 'CPS')
            ->groupBy('categories.ID', 'categories.DESCRIPTION', 'categories.BRAND')
            ->orderBy('categories.DESCRIPTION')
            ->get();

        // ถ้ามี Category เดิมที่ไม่อยู่ใน list ให้เพิ่มเข้าไป (รักษาค่าเดิม)
        if ($dataProductDetail && $dataProductDetail->category_id) {
            $existingIds = $categorys->pluck('ID')->toArray();
            if (!in_array($dataProductDetail->category_id, $existingIds)) {
                $oldCategory = Category::select('ID', 'DESCRIPTION', 'BRAND')
                    ->where('ID', $dataProductDetail->category_id)
                    ->where('BRAND', 'CPS')
                    ->first();
                if ($oldCategory) {
                    $categorys->push($oldCategory);
                }
            }
        }

        $sub_categorys = Sub_category::select(
            'ID',
            'CATEGORY_ID',
            'DESCRIPTION',
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();

        $product_lines = ProductLine::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $product_types = ProductType::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $skinTypes = CpsSkinType::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $coverageBenefits = CpsCoverageBenefit::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $usageAreas = CpsUsageArea::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $textureFormulas = CpsTextureFormula::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $finishs = CpsFinish::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $packageType1s = CpsPackageType1::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();
        $packageType2s = CpsPackageType2::select(
            'ID',
            'DESCRIPTION',            
            'BRAND')
        ->where('BRAND', 'CPS')
        ->get();


        $ibshSpecial = CoreIbshFiel::where('product_id', $id)
            ->where('form_type', 'special_ingredients')
            ->orderBy('id', 'desc')
            ->get();

        $ibshCharacteristic = CoreIbshFiel::where('product_id', $id)
            ->where('form_type', 'characteristic')
            ->orderBy('id', 'desc')
            ->get();

        return view('ibhs.edit', 
               compact( 'data', 'dataProductDetail', 'dataFreeForm', 'countriesDatas', 'brands', 'series', 'categorys', 'product_lines', 
               'product_types', 'skinTypes', 'coverageBenefits', 'usageAreas', 'textureFormulas', 'finishs', 'packageType1s', 'packageType2s', 
               'sub_categorys', 'allChannels', 'defaultAllChannels', 'defaultChannel', 'dataComProduct', 'images', 'product_id', 'ibshSpecial', 'ibshCharacteristic'));
    }

    public function listIbsh(Request $request)
    {
        $limit = (int) $request->input('length'); // จำนวนต่อหน้า
        $start = (int) $request->input('start', 0);

        $BRAND = $request->input('brand_id');
        $searchAll = $request->input('search', '');

        $data = ProductDetail::select(
            'corporation_id',
            'product_id',
            'inner_barcode',
            'product1s.NAME_THAI AS NAME_THAI',
            'product1s.BARCODE AS BARCODE',
            'pro_develops.JOB_REFNO as JOB_REFNO'
        )
        ->leftJoin('product1s', 'product_details.product_id', '=', 'product1s.PRODUCT')
        ->leftJoin('pro_develops', 'product_details.product_id', '=', 'pro_develops.PRODUCT')
        ->orderBy('product_details.upd_date', 'DESC');

        // dd($data->toSql());
        if ($BRAND != null) {
            $data->where('product_details.corporation_id', $BRAND);
        }
        // กรองข้อมูลถ้ามีคำค้นหา
        if (!empty($searchAll)) {
            $data->where(function ($q) use ($searchAll) {
                $q->orWhere('product_details.product_id', 'like', '%' . $searchAll . '%')
                ->orWhere('product1s.NAME_THAI', 'like', '%' . $searchAll . '%')
                ->orWhere('product1s.BARCODE', 'like', '%' . $searchAll . '%');
            });
        }

        // 🔹 นับจำนวนรายการทั้งหมดก่อน `LIMIT`
        $totalRecords = $data->count();
        // 🔹 ตรวจสอบ limit
        if ($limit > 0) {
            $data->limit($limit)->offset($start);
        }
        // 🔹 ดึงข้อมูลตาม limit และ offset
        $records = $data->get();

        return response()->json([
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecords, // จำนวนทั้งหมด (ก่อน limit)
            'iTotalDisplayRecords' => $totalRecords, // ควรตรงกับ iTotalRecords
            'aaData' => $records,
        ]);
    }
}
