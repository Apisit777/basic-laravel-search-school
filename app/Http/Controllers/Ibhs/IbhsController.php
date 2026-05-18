<?php

namespace App\Http\Controllers\Ibhs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Barcode;
use App\Models\Product1;
use App\Models\ProductChannel;
use App\Models\ProductDetail;
use App\Models\ComProductImage;
use App\Models\CoreIbshFiel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\IbhsProduct;
use Illuminate\Http\Request;

class IbhsController extends Controller
{
    
    public function index()
    {

        $isSuperAdmin = (Auth::user()->id === 26) ? true : false;
        $userpermission = Auth::user()->getUserPermission->name_position;
        $userDepartment = Auth::user()->getUserDepartment->department;
        $namePosition  = explode('-', $userpermission);
        $userpermission = trim(end($namePosition));
        // dd($userpermission);

        $getSelect2ProDevelops = []; // กันไว้ก่อนเลย

        if ($userpermission == 'CPS' || $userDepartment == 'IBHS') {
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

    public function create()
    {
        $ibshSpecial = collect([]);
        $ibshCharacteristic = collect([]);
        return view('ibhs.create', compact('ibshSpecial', 'ibshCharacteristic'));
    }

    public function show(Request $request, $bulk_id)
    {
        $data = IbhsProduct::findOrFail($bulk_id);

        $ibshSpecialImages = CoreIbshFiel::where('bulk_id', $data->bulk_id)
            ->where('form_type', 'special_ingredients')
            ->where('file_type', 'image')
            ->orderBy('id', 'desc')
            ->get();

        $ibshCharacteristicImages = CoreIbshFiel::where('bulk_id', $data->bulk_id)
            ->where('form_type', 'characteristic')
            ->where('file_type', 'image')
            ->orderBy('id', 'desc')
            ->get();

        $bomRows = [];
        $selectedBom = null;
        $fgCode = '';

        return view('ibhs.show', compact('data', 'selectedBom', 'bomRows', 'fgCode', 'ibshSpecialImages', 'ibshCharacteristicImages'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // $after_open_m = preg_replace('/\D/', '', $request->input('after_open_m'));

            $ibhsProduct = IbhsProduct::create([
                'bulk_id'                              => $request->input('bulk_id'),
                'job_ref_no'                           => $request->input('job_ref_no'),
                'corporation_id'                       => $request->input('corporation_id'),
                'product_name'                         => $request->input('product_name'),
                'appearance'                           => $request->input('appearance'),
                'category'                             => $request->input('category'),
                'shelf_life'                           => $request->input('shelf_life'),
                'fda_noti'                             => $request->input('fda_noti'),
                'warning_display'                      => $request->input('warning_display'),
                'list_substances_warning_1'            => $request->input('list_substances_warning_1'),
                'list_substances_warning_2'            => $request->input('list_substances_warning_2'),
                'list_substances_warning_3'            => $request->input('list_substances_warning_3'),
                'ingredients'                          => $request->input('ingredients'),
                'characteristic'                       => $request->input('characteristic'),
                'fragrance'                            => $request->input('fragrance'),
                'how_to_use'                           => $request->input('how_to_use'),
                'permission'                           => $request->input('permission', 'N'),
                'natural_claimed_1'                    => trim(str_replace('%', '', $request->input('natural_claimed_1'))),
                'natural_claimed_2'                    => trim(str_replace('%', '', $request->input('natural_claimed_2'))),
                'natural_claimed_3'                    => trim(str_replace('%', '', $request->input('natural_claimed_3'))),
                'ingredient_list'                      => $request->input('ingredient_list'),
                // 'after_open_m'                         => $after_open_m,
                'custom_free_forms'                    => $request->input('custom_free_forms', '[]'),
                // Qualification claimed
                'alcohol_free'                         => $request->input('alcohol_free', 'N'),
                'colorant_free'                        => $request->input('colorant_free', 'N'),
                'fragrance_free'                       => $request->input('fragrance_free', 'N'),
                'mineral_free'                         => $request->input('mineral_free', 'N'),
                'oil_free'                             => $request->input('oil_free', 'N'),
                'paraben_free'                         => $request->input('paraben_free', 'N'),
                'petrolatum_free'                      => $request->input('petrolatum_free', 'N'),
                'petroleum_free'                       => $request->input('petroleum_free', 'N'),
                'phthalate_free'                       => $request->input('phthalate_free', 'N'),
                'silicone_free'                        => $request->input('silicone_free', 'N'),
                'triethanolamin_free'                  => $request->input('triethanolamin_free', 'N'),
                'chil_over_6year'                      => $request->input('chil_over_6year', 'N'),
                'pregnancy'                            => $request->input('pregnancy', 'N'),
                'non_comedogenic'                      => $request->input('non_comedogenic', 'N'),
                'synthetic_fragrance'                  => $request->input('synthetic_fragrance', 'N'),
                'synthetic_colorant'                   => $request->input('synthetic_colorant', 'N'),
                'certified_organic'                    => $request->input('certified_organic', 'N'),
                'certified_food'                       => $request->input('certified_food', 'N'),
                'natural_alcohol'                      => $request->input('natural_alcohol', 'N'),
                'cruelty_free'                         => $request->input('cruelty_free', 'N'),
                'hypoallergenic'                       => $request->input('hypoallergenic', 'N'),
                'tested'                               => $request->input('tested', 'N'),
                'ph_balance'                           => $request->input('ph_balance', 'N'),
                'sls_free'                             => $request->input('sls_free', 'N'),
                'talc_free'                            => $request->input('talc_free', 'N'),
                'not_recommend_pregnant_checkbox'       => $request->input('not_recommend_pregnant_checkbox', 'N'),
                'not_recommend_pregnant_text'          => $request->input('not_recommend_pregnant_text'),
                'product_efficacy_test_checkbox'       => $request->input('product_efficacy_test_checkbox', 'N'),
                'product_efficacy_test_text'           => $request->input('product_efficacy_test_text'),
                'breastfeed'                           => $request->input('breastfeed', 'N'),
                'no_need_to_review_before_making_full_ingredients' => $request->input('no_need_to_review_before_making_full_ingredients'),
                'formula_free_from'                    => $request->input('formula_free_from'),
                'need_to_review_before_making_full_ingredients'    => $request->input('need_to_review_before_making_full_ingredients'),
                'upd_user'                             => Auth::user()->username,
                'upd_date'                             => date("Y/m/d H:i:s"),
            ]);

            // dd($ibhsProduct);

            // Save uploaded files to core_ibsh_fiels
            if ($request->hasFile('dz_files')) {
                $form_type = $request->input('dz_form_type', 'special_ingredients');
                $imageExts = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
                $year  = date('Y');
                $month = date('m');
                $dir   = "uploads/ibsh/$year/$month/";
                if (!file_exists(public_path($dir))) {
                    mkdir(public_path($dir), 0777, true);
                }
                foreach ($request->file('dz_files') as $file) {
                    $ext = strtolower($file->getClientOriginalExtension());
                    $file_type = \in_array($ext, $imageExts) ? 'image' : 'document';
                    $filename = Str::uuid() . '.' . $ext;
                    $file->move(public_path($dir), $filename);
                    CoreIbshFiel::create([
                        'bulk_id' => $ibhsProduct->bulk_id,
                        'form_type'  => $form_type,
                        'file_type'  => $file_type,
                        'path'       => $dir . $filename,
                        'upd_date'   => now(),
                    ]);
                }
            }

            DB::commit();
            session()->flash('status', 'เพิ่มข้อมูลสำเร็จ');
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $data = IbhsProduct::find($id);

        // ibhs_products มีทุก field ที่ blade ต้องการ (qualification checkboxes, custom_free_forms ฯลฯ)
        $dataFreeForm = $data;

        $ibshSpecial = CoreIbshFiel::where('bulk_id', $data->bulk_id)
            ->where('form_type', 'special_ingredients')
            ->orderBy('id', 'desc')
            ->get();

        $ibshCharacteristic = CoreIbshFiel::where('bulk_id', $data->bulk_id)
            ->where('form_type', 'characteristic')
            ->orderBy('id', 'desc')
            ->get();

        // ตัวแปรที่ blade อ้างอิงแต่ไม่ได้ใช้จริงใน IBHS — ส่ง safe defaults
        $images             = collect([]);
        $opApiImage         = null;
        $dataComProduct     = null;
        $allChannels        = [];
        $defaultAllChannels = [];
        $defaultChannel     = [];
        $product_id         = $data->id ?? null;

        return view('ibhs.edit',
            compact('data', 'dataFreeForm', 'images', 'opApiImage', 'dataComProduct',
                    'allChannels', 'defaultAllChannels', 'defaultChannel',
                    'product_id', 'ibshSpecial', 'ibshCharacteristic'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // $after_open_m = preg_replace('/\D/', '', $request->input('after_open_m'));

            $ibhsProduct = IbhsProduct::findOrFail($id);
            $ibhsProduct->update([
                'bulk_id'                              => $request->input('bulk_id'),
                'job_ref_no'                           => $request->input('job_ref_no'),
                'corporation_id'                       => $request->input('corporation_id'),
                'product_name'                         => $request->input('product_name'),
                'appearance'                           => $request->input('appearance'),
                'category'                             => $request->input('category'),
                'shelf_life'                           => $request->input('shelf_life'),
                'fda_noti'                             => $request->input('fda_noti'),
                'warning_display'                      => $request->input('warning_display'),
                'list_substances_warning_1'            => $request->input('list_substances_warning_1'),
                'list_substances_warning_2'            => $request->input('list_substances_warning_2'),
                'list_substances_warning_3'            => $request->input('list_substances_warning_3'),
                'ingredients'                          => $request->input('ingredients'),
                'characteristic'                       => $request->input('characteristic'),
                'fragrance'                            => $request->input('fragrance'),
                'how_to_use'                           => $request->input('how_to_use'),
                'permission'                           => $request->input('permission', 'N'),
                'natural_claimed_1'                    => trim(str_replace('%', '', $request->input('natural_claimed_1'))),
                'natural_claimed_2'                    => trim(str_replace('%', '', $request->input('natural_claimed_2'))),
                'natural_claimed_3'                    => trim(str_replace('%', '', $request->input('natural_claimed_3'))),
                'ingredient_list'                      => $request->input('ingredient_list'),
                // 'after_open_m'                         => $after_open_m,
                'custom_free_forms'                    => $request->input('custom_free_forms', '[]'),
                // Qualification claimed
                'alcohol_free'                         => $request->input('alcohol_free', 'N'),
                'colorant_free'                        => $request->input('colorant_free', 'N'),
                'fragrance_free'                       => $request->input('fragrance_free', 'N'),
                'mineral_free'                         => $request->input('mineral_free', 'N'),
                'oil_free'                             => $request->input('oil_free', 'N'),
                'paraben_free'                         => $request->input('paraben_free', 'N'),
                'petrolatum_free'                      => $request->input('petrolatum_free', 'N'),
                'petroleum_free'                       => $request->input('petroleum_free', 'N'),
                'phthalate_free'                       => $request->input('phthalate_free', 'N'),
                'silicone_free'                        => $request->input('silicone_free', 'N'),
                'triethanolamin_free'                  => $request->input('triethanolamin_free', 'N'),
                'chil_over_6year'                      => $request->input('chil_over_6year', 'N'),
                'pregnancy'                            => $request->input('pregnancy', 'N'),
                'non_comedogenic'                      => $request->input('non_comedogenic', 'N'),
                'synthetic_fragrance'                  => $request->input('synthetic_fragrance', 'N'),
                'synthetic_colorant'                   => $request->input('synthetic_colorant', 'N'),
                'certified_organic'                    => $request->input('certified_organic', 'N'),
                'certified_food'                       => $request->input('certified_food', 'N'),
                'natural_alcohol'                      => $request->input('natural_alcohol', 'N'),
                'cruelty_free'                         => $request->input('cruelty_free', 'N'),
                'hypoallergenic'                       => $request->input('hypoallergenic', 'N'),
                'tested'                               => $request->input('tested', 'N'),
                'ph_balance'                           => $request->input('ph_balance', 'N'),
                'sls_free'                             => $request->input('sls_free', 'N'),
                'talc_free'                            => $request->input('talc_free', 'N'),
                'not_recommend_pregnant_checkbox'       => $request->input('not_recommend_pregnant_checkbox', 'N'),
                'not_recommend_pregnant_text'          => $request->input('not_recommend_pregnant_text'),
                'product_efficacy_test_checkbox'       => $request->input('product_efficacy_test_checkbox', 'N'),
                'product_efficacy_test_text'           => $request->input('product_efficacy_test_text'),
                'breastfeed'                           => $request->input('breastfeed', 'N'),
                'no_need_to_review_before_making_full_ingredients' => $request->input('no_need_to_review_before_making_full_ingredients', 'N'),
                'formula_free_from'                    => $request->input('formula_free_from', 'N'),
                'need_to_review_before_making_full_ingredients'    => $request->input('need_to_review_before_making_full_ingredients', 'N'),
                'upd_user'                             => Auth::user()->username,
                'upd_date'                             => date("Y/m/d H:i:s"),
            ]);

            // dd($ibhsProduct);

            // Save uploaded files to core_ibsh_fiels
            if ($request->hasFile('dz_files')) {
                $form_type = $request->input('dz_form_type', 'special_ingredients');
                $imageExts = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
                $year  = date('Y');
                $month = date('m');
                $dir   = "uploads/ibsh/$year/$month/";
                if (!file_exists(public_path($dir))) {
                    mkdir(public_path($dir), 0777, true);
                }
                foreach ($request->file('dz_files') as $file) {
                    $ext = strtolower($file->getClientOriginalExtension());
                    $file_type = \in_array($ext, $imageExts) ? 'image' : 'document';
                    $filename = Str::uuid() . '.' . $ext;
                    $file->move(public_path($dir), $filename);
                    CoreIbshFiel::create([
                        'bulk_id' => $ibhsProduct->bulk_id,
                        'form_type'  => $form_type,
                        'file_type'  => $file_type,
                        'path'       => $dir . $filename,
                        'upd_date'   => now(),
                    ]);
                }
            }

            DB::commit();
            session()->flash('status', 'อัปเดตข้อมูลสำเร็จ');
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function listIbsh(Request $request)
    {
        $limit     = (int) $request->input('length');
        $start     = (int) $request->input('start', 0);
        $BRAND     = $request->input('brand_id');
        $searchAll = $request->input('search', '');

        $data = IbhsProduct::select(
            'id',
            'bulk_id',
            'job_ref_no',
            'corporation_id',
            'product_name',
            'category',
            'upd_user',
            'upd_date'
        )
        ->orderBy('upd_date', 'DESC');

        if ($BRAND != null) {
            $data->where('corporation_id', $BRAND);
        }

        if (!empty($searchAll)) {
            $data->where(function ($q) use ($searchAll) {
                $q->orWhere('bulk_id',      'like', '%' . $searchAll . '%')
                  ->orWhere('job_ref_no',   'like', '%' . $searchAll . '%')
                  ->orWhere('product_name', 'like', '%' . $searchAll . '%');
            });
        }

        $totalRecords = $data->count();

        if ($limit > 0) {
            $data->limit($limit)->offset($start);
        }

        $records = $data->get();

        return response()->json([
            'draw'                 => intval($request->draw),
            'iTotalRecords'        => $totalRecords,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData'               => $records,
        ]);
    }
}
