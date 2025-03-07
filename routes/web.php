<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductForm\ProductFormController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProductDetail\ProductDetailController;
use App\Http\Controllers\ProductOther\ProductOtherController;
use App\Http\Controllers\ProductChannel\ProductChannelController;
use App\Http\Controllers\Managemenu\ManageMenuController;
use App\Http\Controllers\Warehouse\ComProductController;
use App\Http\Controllers\Tool\ToolController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ExportExcel\ExportExcelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Login
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/checkLogin', [AuthController::class, 'checkLogin'])->name('checkLogin');
Route::get('/post', [AuthController::class, 'index'])->name('post');

// Users login
// Route::get('/api_bypass_login_user', [AuthController::class, 'apiByPassLoginUser'])->name('api_bypass_login_user');
Route::post('/api_bypass_login_user', [AuthController::class, 'apiByPassLoginUser'])->name('api_bypass_login_user');
// By pass login for developer
Route::get('/api_bypass_login', [AuthController::class, 'apiByPassLogin'])->name('api_bypass_login');

// Switch role
Route::get('/switch_role', [HomeController::class, 'role'])->name('switch_role');
Route::post('/role_bypass', [HomeController::class, 'roleByPass'])->name('role_bypass');

// Route::middleware('auth')->group(function() {
Route::group(['middleware' => ['auth', 'check.permission']], function () {

    // Route::get('/check_token', [AuthController::class, 'tokenExpired'])->name('tokenExpired');

    // npd
    Route::group(['prefix' => 'new_product_develop', 'as' => 'new_product_develop.'], function () {
        // Export Excel New Product Develop
        Route::get('/pro_develops_get_select2', [ExportExcelController::class, 'getSelect2NewProductDevelop'])->name('pro_develops_get_select2');
        Route::post('/export_excel_new_product_develop', [ExportExcelController::class, 'exportExcelNewProductDevelop'])->name('export_excel_new_product_develop');

        // Export Excel Account
        Route::get('/account_get_select2', [ExportExcelController::class, 'getSelect2Account'])->name('account_get_select2');
        Route::post('/export_excel_account', [ExportExcelController::class, 'exportExcelAccount'])->name('export_excel_account');

        Route::get('', [ProductFormController::class, 'index'])->name('index');
        Route::post('/list_npd', [ProductFormController::class, 'list_npd'])->name('list_npd');
        Route::post('/', [ProductFormController::class, 'store'])->name('store');
        Route::get('/create', [ProductFormController::class, 'create'])->name('create');
        Route::post('/check_code', [ProductFormController::class, 'checkCode'])->name('check_code');
        Route::get('/show/{id_barcode}', [ProductFormController::class, 'show'])->name('show');
        Route::post('/duplicate_npd_request/{id_barcode}', [ProductFormController::class, 'duplicateNpdRequest'])->name('show_barcode');
        Route::get('/edit/{id_barcode}', [ProductFormController::class, 'edit'])->name('edit');
        Route::post('/update/{id_barcode}', [ProductFormController::class, 'update'])->name('update');
    });

    // Account
    Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
        Route::get('', [ProductFormController::class, 'indexAccount'])->name('index');
        Route::post('/list_ajax_account', [ProductFormController::class, 'listAjaxAccount'])->name('list_ajax_account');
        Route::get('/create', [ProductFormController::class, 'createAccount'])->name('create');
        Route::get('/show/{product}', [ProductFormController::class, 'showAccount'])->name('show'); 
        Route::get('/edit/{product}', [ProductFormController::class, 'editAccount'])->name('edit'); 
        Route::post('/update_account/{product}', [ProductFormController::class, 'updateAccount'])->name('update_account');

        // Schedule
        Route::post('/list_account_schedule', [ProductFormController::class, 'listAccountSchedule'])->name('list_account_schedule');
        Route::post('/list_account_schedule_log', [ProductFormController::class, 'listAccountScheduleLog'])->name('list_account_schedule_log');
        Route::post('/update_account_schedule/{product}', [ProductFormController::class, 'updateAccountSchedule'])->name('update_account_schedule');
    });

    // product
    Route::group(['prefix' => 'product_master', 'as' => 'product_master.'], function () {
        // Export Excel Product Master
        Route::get('/product_master_get_select2', [ExportExcelController::class, 'getSelect2ProductMaster'])->name('product_master_get_select2');
        Route::post('/export_excel_product_master', [ExportExcelController::class, 'exportExcelProductMaster'])->name('export_excel_product_master');

        Route::get('/pd_master', [ProductController::class, 'index'])->name('index');
        // Solution
        Route::get('/solution', [ToolController::class, 'solution'])->name('solution');
        Route::post('/solution_check_id', [ToolController::class, 'solutionCheckId'])->name('solution_check_id');
        Route::post('/solution_check_name', [ToolController::class, 'solutionCheckName'])->name('solution_check_name');
        Route::post('/solution_create', [ToolController::class, 'solutionCreate'])->name('solution_create');
        Route::post('/solution_update/{id}', [ToolController::class, 'solutionUpdate'])->name('solution_update');
        Route::post('/list_solution', [ToolController::class, 'listSolution'])->name('list_solution');
        
        // Series
        Route::get('/series', [ToolController::class, 'series'])->name('series');
        Route::post('/series_check_id', [ToolController::class, 'seriesCheckId'])->name('series_check_id');
        Route::post('/series_check_name', [ToolController::class, 'seriesCheckName'])->name('series_check_name');
        Route::post('/series_create', [ToolController::class, 'seriesCreate'])->name('series_create');
        Route::post('/series_update/{id}', [ToolController::class, 'seriesUpdate'])->name('series_update');
        Route::post('/list_series', [ToolController::class, 'listSeries'])->name('list_series');

        // Category
        Route::get('/category', [ToolController::class, 'category'])->name('category');
        Route::post('/category_check_id', [ToolController::class, 'categoryCheckId'])->name('category_check_id');
        Route::post('/category_check_name', [ToolController::class, 'categoryCheckName'])->name('category_check_name');
        Route::post('/category_create', [ToolController::class, 'categoryCreate'])->name('category_create');
        Route::post('/category_update/{id}', [ToolController::class, 'categoryUpdate'])->name('category_update');
        Route::post('/list_category', [ToolController::class, 'listCategory'])->name('list_category');

        // Sub Category
        Route::get('/sub_category', [ToolController::class, 'subCategory'])->name('sub_category');
        Route::get('/manage_sub_category', [ToolController::class, 'manageSubCategory'])->name('manage_sub_category');
        Route::post('/sub_category_checkname', [ToolController::class, 'subCategoryCheckName'])->name('sub_category_checkname');
        Route::post('/sub_category_create', [ToolController::class, 'subCategoryCreate'])->name('sub_category_create');
        Route::post('/sub_category_update/{id}', [ToolController::class, 'subCategoryUpdate'])->name('sub_category_update');
        Route::post('/list_sub_category', [ToolController::class, 'listSubCategory'])->name('list_sub_category');

        // Product Group
        Route::get('/product_group', [ToolController::class, 'productGroup'])->name('product_group');
        Route::post('/productgroup_check_id', [ToolController::class, 'productGroupCheckId'])->name('productgroup_check_id');
        Route::post('/productgroup_checkname', [ToolController::class, 'productGroupCheckName'])->name('productgroup_checkname');
        Route::post('/product_group_create', [ToolController::class, 'productGroupCreate'])->name('product_group_create');
        Route::post('/product_group_update/{id}', [ToolController::class, 'productGroupUpdate'])->name('product_group_update');
        Route::post('/list_product_group', [ToolController::class, 'listProductGroup'])->name('list_product_group');

        // Product co-ordinator
        Route::get('/product_co_ordinator', [ToolController::class, 'productCoOrdinator'])->name('product_co_ordinator');
        Route::post('/product_co_ordinator_checkname', [ToolController::class, 'productCoOrdinatorCheckName'])->name('product_co_ordinator_checkname');
        Route::post('/product_co_ordinator_create', [ToolController::class, 'productCoOrdinatorCreate'])->name('product_co_ordinator_create');
        Route::post('/product_co_ordinator_update/{id}', [ToolController::class, 'productCoOrdinatorUpdate'])->name('product_co_ordinator_update');
        Route::post('/list_product_co_ordinator', [ToolController::class, 'listProductCoOrdinator'])->name('list_product_co_ordinator');

        // Marketing Manager 
        Route::get('/marketing_manager', [ToolController::class, 'marketingManager'])->name('marketing_manager');
        // Route::post('/productgroup_check_id', [ToolController::class, 'productGroupCheckId'])->name('productgroup_check_id');
        // Route::post('/productgroup_checkname', [ToolController::class, 'productGroupCheckName'])->name('productgroup_checkname');
        // Route::post('/product_group_create', [ToolController::class, 'productGroupCreate'])->name('product_group_create');
        // Route::post('/product_group_update/{id}', [ToolController::class, 'productGroupUpdate'])->name('product_group_update');
        Route::post('/list_marketing_manager', [ToolController::class, 'listMarketingManager'])->name('list_marketing_manager');

        //
        Route::get('/supplier', [ToolController::class, 'supplier'])->name('supplier');

        Route::get('/get_barcode', [ProductController::class, 'getBarcode'])->name('get_barcode');
        Route::get('/checkproduct', [ProductController::class, 'check_product'])->name('checkproduct');
        Route::post('/check_code_gnc', [ProductController::class, 'checkCode'])->name('check_code_gnc');
        Route::post('/check_barcode', [ProductController::class, 'checkBarcode'])->name('check_barcode');
        Route::get('/checkproduct_consumables', [ProductController::class, 'check_product_consumables'])->name('checkproduct_consumables');
        Route::post('/list_products', [ProductController::class, 'list_products'])->name('list_products');
        Route::get('/product_master_get_brand_list_ajax', [ProductController::class, 'productMasterGetBrandListAjax'])->name('product_master_get_brand_list_ajax');
        // Ean13 Barcode GNC
        Route::post('/generate_barcode_gnc/{baocode}', [ProductController::class, 'generatebarcodeGNC'])->name('generate_barcode_gnc');
        // Ean14 CheckDigit
        Route::get('/calculate_ean14_check_digit/{baocodeCheckDigit}', [ProductController::class, 'calculateEAN14CheckDigit'])->name('calculate_ean14_check_digit');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::post('/store_consumables', [ProductController::class, 'storeConsumables'])->name('store_consumables');
        Route::post('/create_copy', [ProductController::class, 'createCopy'])->name('create_copy');
        Route::post('/create_copy_consumables', [ProductController::class, 'createCopyConsumables'])->name('create_copy_consumables');
        Route::get('/pd_master/create', [ProductController::class, 'create'])->name('create');
        Route::get('/pd_master/create_consumables', [ProductController::class, 'createConsumables'])->name('create_consumables');
        Route::get('/pd_master/edit/{PRODUCT}', [ProductController::class, 'edit'])->name('edit');
        Route::post('/update/{PRODUCT}', [ProductController::class, 'update'])->name('update');
        Route::delete('/update_product_status/{id}', [ProductController::class, 'upate_product_status'])->name('update_product_status');
    });

    // Main Menu Product Detail
    Route::group(['prefix' => 'product_detail', 'as' => 'product_detail.'], function () {
        // Sub Menu Product Detail1(Product Detail)
        Route::get('/pd_detail', [ProductDetailController::class, 'index'])->name('pd_detail_index');
        Route::get('/pd_detail/create', [ProductDetailController::class, 'create'])->name('pd_detail_create');
        Route::post('/list_product_detail', [ProductDetailController::class, 'listProductDetail'])->name('list_product_detail');
        Route::get('/pd_detail/edit/{product_id}', [ProductDetailController::class, 'edit'])->name('pd_detail_edit');
        
        // Sub Menu Product Detail2(Product Other)
        Route::get('/pd_other', [ProductOtherController::class, 'index'])->name('pd_other_index');
        Route::get('/pd_other/create', [ProductOtherController::class, 'create'])->name('pd_other_create');
        Route::get('/product_Other_category', [ProductOtherController::class, 'productOtherCategory'])->name('product_Other_category');
        Route::get('/product_Other_sub_category', [ProductOtherController::class, 'productOtherSubCategory'])->name('product_Other_sub_category');
        Route::get('/product_line', [ProductOtherController::class, 'productLine'])->name('product_line');
        Route::get('/product_type', [ProductOtherController::class, 'productType'])->name('product_type');
        Route::post('/pd_other_update', [ProductOtherController::class, 'update'])->name('pd_other_update');
        // Route::post('/pd_other_update/{id}', [ProductOtherController::class, 'update'])->name('pd_other_update');
    });

    // product_channel
    Route::group(['prefix' => 'channel', 'as' => 'channel.'], function () {
        Route::get('/', [ProductChannelController::class, 'index'])->name('index');
        Route::post('/list_product_channel', [ProductChannelController::class, 'list_product_channel'])->name('list_product_channel');
    });

    // Km
    Route::group(['prefix' => 'warehouse', 'as' => 'warehouse.'], function () {
        Route::get('/dimension', [ComProductController::class, 'index'])->name('index');

        Route::get('/filter-cards', [ComProductController::class, 'filter'])->name('filter.cards');

        Route::get('/document', [ComProductController::class, 'indexDocument'])->name('document');
        Route::post('/list_warehouse', [ComProductController::class, 'listWarehouse'])->name('list_warehouse');
        Route::get('/dimension/create', [ComProductController::class, 'create'])->name('create');
        Route::post('/', [ComProductController::class, 'store'])->name('store');
        Route::post('/update_image_sequence', [ComProductController::class, 'updateImageSequence'])->name('update_image_sequence');
        Route::get('/dimension/edit/{product_id}', [ComProductController::class, 'edit'])->name('edit');
        Route::post('/update_image/{product_id}', [ProductImageController::class, 'updateImage'])->name('update_image');
        Route::delete('/delete_img/{product_id}', [ProductImageController::class, 'deleteImg'])->name('delete_img');
        Route::post('/update/{product_id}', [ComProductController::class, 'update'])->name('update');
    });

    // Manage general information
    Route::group(['prefix' => 'manage_general_information', 'as' => 'manage_general_information.'], function () {
        Route::get('/tool', [ToolController::class, 'index'])->name('index');
        Route::get('/images', [ProductImageController::class, 'index'])->name('indexImage');
        Route::get('/camera', [ProductImageController::class, 'show'])->name('camera');
    });

    // Logout
    Route::get('/logout', [AuthController::class, 'apiByPassLogout'])->name('logout');
});

// search_school
Route::get('/home', [HomeController::class, 'home']);
Route::get('/search_school', [HomeController::class, 'index'])->name('search_school');
Route::post('/search_school', [HomeController::class, 'search_school']);

// Brand OP
Route::post('/list_brand_op', [HomeController::class, 'listBrandOp'])->name('list_brand_op');
// Brand CPS
Route::post('/list_brand_cps', [HomeController::class, 'listBrandCps'])->name('list_brand_cps');
// Brand SSUP
Route::post('/list_brand_ssup', [HomeController::class, 'listBrandSsup'])->name('list_brand_ssup');
// Brand GNC
Route::post('/list_brand_gnc', [HomeController::class, 'listBrandGnc'])->name('list_brand_gnc');
// Brand KM
Route::post('/list_brand_km', [HomeController::class, 'listBrandKm'])->name('list_brand_km');
// Brand KSHOP
Route::post('/list_brand_kshop', [HomeController::class, 'listBrandKshop'])->name('list_brand_kshop');
// Brand KSHOPCR
Route::post('/list_brand_kshopcr', [HomeController::class, 'listBrandKshopcr'])->name('list_brand_kshopcr');
// Brand KMCR
Route::post('/list_brand_kmcr', [HomeController::class, 'listBrandKmcr'])->name('list_brand_kmcr');
// Brand DEALER
Route::post('/list_brand_dealer', [HomeController::class, 'listBrandDealer'])->name('list_brand_dealer');
// Brand BB
Route::post('/list_brand_bb', [HomeController::class, 'listBrandBb'])->name('list_brand_bb');
// Brand LL
Route::post('/list_brand_ll', [HomeController::class, 'listBrandLl'])->name('list_brand_ll');
// Brand EMPTY
Route::post('/list_brand_empty', [HomeController::class, 'listBrandEmpty'])->name('list_brand_empty');

Route::get('/get_users', [ProductController::class, 'get_users'])->name('get_users');

// Route::get('/product_detail_create', [ProductController::class, 'productDetailCreate'])->name('product_detail_create');
Route::post('/checknamebrand', [ProductController::class, 'checkname_brand'])->name('checknamebrand');
// Route::post('/checkproduct', [ProductController::class, 'check_product'])->name('checkproduct');

Route::get('/get_brand_list_ajax', [ProductFormController::class, 'getBrandListAjax'])->name('get_brand_list_ajax');

Route::post('/list_approve_products', [ProductController::class, 'list_approve_products'])->name('list_approve_products');

// manage_menu
Route::get('/manage_menu', [ManageMenuController::class, 'index'])->name('manage_menu');
Route::post('/list_menu', [ManageMenuController::class, 'listMenu'])->name('list_menu');

// Route::get('/create_menu', [ManageMenuController::class, 'createMenu'])->name('create_menu');
Route::post('/create_menu', [ManageMenuController::class, 'store'])->name('create_menu');

Route::get('/menu_access', [ManageMenuController::class, 'menuAccess'])->name('menu_access');
Route::post('/create_access', [ManageMenuController::class, 'createAccess'])->name('create_access');
Route::post('/delete_access', [ManageMenuController::class, 'deleteAccess'])->name('delete_access');

// Route::get('/tool', [ToolController::class, 'index'])->name('tool');

// Notify
Route::get('/test', [PusherController::class, 'index']);
Route::post('/broadcast', [PusherController::class, 'broadcast'])->name('broadcast');
Route::get('/get_receive', [PusherController::class, 'receive'])->name('get_receive');
Route::post('/receive', [PusherController::class, 'receive'])->name('receive');

Route::post('/broadcast_npd', [PusherController::class, 'broadcastNPD'])->name('broadcast_npd');
Route::get('/get_receive_pm', [PusherController::class, 'receivePM'])->name('get_receive_pm');

Route::get('/getBrandIdListAjax', [BrandController::class, 'getBrandIdListAjax'])->name('ajax_brand_id');

// images
Route::group(['prefix' => 'images', 'as' => 'images.'], function () {
    Route::get('', [ProductImageController::class, 'index'])->name('index');
    Route::post('/images_upload', [ProductImageController::class, 'store'])->name('store');
});

// Language
// Route::get('/greeting/{locale}', function ($locale) {
//     if (! in_array($locale, ['en', 'th'])) {
//         return response()->json([
//             'status' => 400
//         ]);
//     }
//     session()->put('locale', $locale);

//     return response()->json([
//         'status' => 200
//     ]);
// })->name('setLocale');

Route::get('/greeting/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'th'])) {
        return response()->json([
            'status' => 400,
            'message' => 'Invalid language',
            'session_locale' => session()->get('locale')
        ]);
    }

    session()->put('locale', $locale);
    session()->save(); // บังคับบันทึกค่าใน Session

    return response()->json([
        'status' => 200,
        'message' => "Language changed to $locale",
        'session_locale' => session()->get('locale')
    ]);
})->name('setLocale');