<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferDataOnce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transfer-data-once {task}';
    // protected $signature = 'app:transfer-data-once';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $task = $this->argument('task');

        try {
            switch ($task) {
                case 'tranfer_data':
                    $this->tranfer_data();
                    break;
                case 'pro_develops_all':
                    $this->tranfer_pro_develops_all();
                    break;
                case 'products_all':
                    $this->tranfer_products_all();
                    break;
                case 'products_clean':
                    $this->tranfer_products_clean();
                    break;
                case 'consumsbles_duplicate_to_product1s':
                    $this->tranfer_consumsbles_to_product1s_duplicate();
                    break;
                // case 'tranfer_consumsbles_to_product1s_not_duplicate':
                //     $this->tranfer_consumsbles_to_product1s_not_duplicate();
                //     break;
                case 'tranfer_to_products_channels':
                    $this->tranfer_to_products_channels();
                    break;
                case 'product_category':
                    $this->tranfer_product_category();
                    break;
                case 'tranfer_data_back':
                    $this->tranfer_data_back();
                    break;
                case 'tranfer_data_back_product2':
                    $this->tranfer_data_back_product2();
                    break;
                case 'tranfer_data_back_product1_des':
                    $this->tranfer_data_back_product1_des();
                    break;
                case 'transfer_data_task':
                    $this->transfer_data_task();
                    break;
                case 'transfer_product_original':
                    $this->transfer_product_original();
                    break;
                // case 'full_tranfer':
                //     $this->tranfer_data();
                //     $this->tranfer_pro_develops_all();
                //     $this->tranfer_products_all();
                //     $this->tranfer_products_clean();
                //     $this->tranfer_consumsbles_to_product1s_duplicate();
                //     $this->tranfer_to_products_channels();
                //     $this->tranfer_product_category();
                //     break;
                default:
                    $this->error('Unknown task. Available tasks: 🚀 full_tranfer, tranfer_data, pro_develops_all, products_all, products_clean, consumsbles_duplicate_to_product1s, tranfer_to_products_channels, product_category');
                    break;
            }
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }

    /**
     * Execute the console command.
     */
    public function tranfer_data()
    {
        // set_time_limit(0);
        // $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        // $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";
        // // $test_database = [
        // //     'dbCPMAS'=>['PRODUCT1','PRO_DEVELOP', 'CATEGORY'],
        // //     'dbOPMAS'=>['PRODUCT1','PRO_DEVELOP'],
        // //     'dbBBMAS'=>['PRODUCT1','PRO_DEVELOP'],
        // // ];
        // $test_database = [
        //     'dbOPMAS'=>['PRODUCT1', 'PRO_DEVELOP'],
        // ];

        // foreach ($test_database as $key => $value) {
        //     foreach ($value as $table_name) {
        //         // dd($table_name);
        //         if ($table_name == 'PRO_DEVELOP') {
        //             $sql_group = "select Brand,COUNT(*) as KeyCount from $key.dbo.PRO_DEVELOP group by Brand";
        //         } else {
        //             $sql_group = "select Brand,COUNT(*) as KeyCount from $key.dbo.PRODUCT1 group by Brand";
        //         }
        //         $group_data_origin = Http::asForm()->withHeaders([])->post($endpoint, [
        //             'statement' => $sql_group,
        //         ]);
        //         // print_r($group_data_origin);
        //         // exit;
        //         $result1 = $group_data_origin['result'];
        //         $diff_count = array_sum(array_column($result1, 'KeyCount'));
        //         $this->info($key.'-'.$table_name);
        //         $this->output->progressStart($diff_count);

        //         try {
        //             if (!empty($result1)) {
        //                 foreach ($result1 as $gp) {
        //                     if ($table_name == 'PRO_DEVELOP') {
        //                         $sql = "select *, replace(convert(varchar,EDIT_DT,102),'.','-') as EDIT_DT_FORMAT from $key.dbo.PRO_DEVELOP where Brand = '" . $gp['Brand'] . "'";
        //                     } else {
        //                         $sql = "select *, replace(convert(varchar,EDIT_DT,102),'.','-') as EDIT_DT_FORMAT from $key.dbo.PRODUCT1 where Brand = '" . $gp['Brand'] . "'";
        //                     }
        //                     $response_insert = Http::asForm()->withHeaders([])->post($endpoint, [
        //                         'statement' => $sql,
        //                     ]);
        //                     $result_data = $response_insert['result'];
        //                     // dd($result_data);
        //                     if ($table_name == 'PRODUCT1') {
        //                         foreach ($result_data as $rs) {
        //                             DB::table('product1s')->insertOrIgnore([
        //                                 'BRAND' => $rs['BRAND'],
        //                                 'PRODUCT' => $rs['PRODUCT'],
        //                                 'BARCODE' => $rs['BARCODE'],
        //                                 'COLOR' => $rs['COLOR'],
        //                                 'GRP_P' => $rs['GRP_P'],
        //                                 'SUPPLIER' => $rs['SUPPLIER'],
        //                                 'NAME_THAI' => $rs['NAME_THAI'],
        //                                 'NAME_ENG' => $rs['NAME_ENG'],
        //                                 'SHORT_THAI' => $rs['SHORT_THAI'],
        //                                 'SHORT_ENG' => $rs['SHORT_ENG'],
        //                                 'VENDOR' => $rs['VENDOR'],
        //                                 'PRICE' => $rs['PRICE'],
        //                                 'COST' => $rs['COST'],
        //                                 'UNIT' => $rs['UNIT'],
        //                                 'UNIT_Q' => $rs['UNIT_Q'],
        //                                 'SOLUTION' => $rs['SOLUTION'],
        //                                 'SERIES' => $rs['SERIES'],
        //                                 'CATEGORY' => $rs['CATEGORY'],
        //                                 'STATUS' => $rs['STATUS'],
        //                                 'S_CAT' => $rs['S_CAT'],
        //                                 'PDM_GROUP' => $rs['PDM_GROUP'],
        //                                 'BRAND_P' => $rs['BRAND_P'],
        //                                 'REGISTER' => $rs['REGISTER'],
        //                                 'OPT_TXT1' => $rs['OPT_TXT1'],
        //                                 'CONDITION_SALE' => $rs['CONDITION_SALE'],
        //                                 'WHOLE_SALE' => $rs['WHOLE_SALE'],
        //                                 'GP' => $rs['GP'],
        //                                 'O_PRODUCT' => $rs['O_PRODUCT'],
        //                                 'BAR_PACK1' => $rs['BAR_PACK1'],
        //                                 'BAR_PACK2' => $rs['BAR_PACK2'],
        //                                 'BAR_PACK3' => $rs['BAR_PACK3'],
        //                                 'BAR_PACK4' => $rs['BAR_PACK4'],
        //                                 'PACK_SIZE1' => $rs['PACK_SIZE1'],
        //                                 'PACK_SIZE2' => $rs['PACK_SIZE2'],
        //                                 'PACK_SIZE3' => $rs['PACK_SIZE3'],
        //                                 'PACK_SIZE4' => $rs['PACK_SIZE4'],
        //                                 'REG_DATE' => $this->convertDateStrToDate($rs['REG_DATE']),
        //                                 'AGE' => $rs['AGE'],
        //                                 'WIDTH' => $rs['WIDTH'],
        //                                 'HEIGHT' => $rs['HEIGHT'],
        //                                 'WIDE' => $rs['WIDE'],
        //                                 'NAME_EXP' => $rs['NAME_EXP'],
        //                                 'NET_WEIGHT' => $rs['NET_WEIGHT'],
        //                                 'UNIT_TYPE' => $rs['UNIT_TYPE'],
        //                                 'TYPE_G' => $rs['TYPE_G'],
        //                                 'OPT_DATE1' => $this->convertDateStrToDate($rs['OPT_DATE1']),
        //                                 'OPT_DATE2' => $this->convertDateStrToDate($rs['OPT_DATE2']),
        //                                 'OPT_TXT2' => $rs['OPT_TXT2'],
        //                                 'OPT_NUM1' => $rs['OPT_NUM1'],
        //                                 'OPT_NUM2' => $rs['OPT_NUM2'],
        //                                 'ACC_TYPE' => $rs['ACC_TYPE'],
        //                                 'ACC_DT' => $this->convertDateStrToDate($rs['ACC_DT']),
        //                                 'RETURN' => $rs['RETURN'],
        //                                 'NON_VAT' => $rs['NON_VAT'],
        //                                 'STORAGE_TEMP' => $rs['STORAGE_TEMP'],
        //                                 'CONTROL_STK' => $rs['CONTROL_STK'],
        //                                 'TESTER' => $rs['TESTER'],
        //                                 'USER_EDIT' => $rs['USER_EDIT'],
        //                                 'EDIT_DT' => $this->convertDateStrToDate($rs['EDIT_DT'])
        //                             ]);
        //                             $this->output->progressAdvance();
        //                         }
        //                     }
        //                     if ($table_name == 'PRO_DEVELOP') {
        //                         foreach ($result_data as $rs) {
        //                             DB::table('pro_develops')->insertOrIgnore([
        //                                 'BRAND' => $rs['BRAND'],
        //                                 'DOC_NO' => $rs['DOC_NO'],
        //                                 'REF_DOC' => $rs['REF_DOC'],
        //                                 'STATUS' => $rs['STATUS'],
        //                                 'PRODUCT' => $rs['PRODUCT'],
        //                                 'BARCODE' => $rs['BARCODE'],
        //                                 'JOB_REFNO' => $rs['JOB_REFNO'],
        //                                 'DOC_DT' => $rs['DOC_DT'],
        //                                 'CUST_OEM' => $rs['CUST_OEM'],
        //                                 'NPD' => $rs['NPD'],
        //                                 'PDM' => $rs['PDM'],
        //                                 'NAME_ENG' => $rs['NAME_ENG'],
        //                                 'CATEGORY' => $rs['CATEGORY'],
        //                                 'CAPACITY' => $rs['CAPACITY'],
        //                                 'Q_SMELL' => $rs['Q_SMELL'],
        //                                 'Q_COLOR' => $rs['Q_COLOR'],
        //                                 'TARGET_GRP' => $rs['TARGET_GRP'],
        //                                 'TARGET_STK' => $rs['TARGET_STK'],
        //                                 'PRICE_FG' => $rs['PRICE_FG'],
        //                                 'PRICE_COST' => $rs['PRICE_COST'],
        //                                 'PRICE_BULK' => $rs['PRICE_BULK'],
        //                                 'FIRST_ORD' => $rs['FIRST_ORD'],
        //                                 'P_CONCEPT' => $rs['P_CONCEPT'],
        //                                 'P_BENEFIT' => $rs['P_BENEFIT'],
        //                                 'TEXTURE' => $rs['TEXTURE'],
        //                                 'TEXTURE_OT' => $rs['TEXTURE_OT'],
        //                                 'COLOR1' => $rs['COLOR1'],
        //                                 'FRANGRANCE' => $rs['FRANGRANCE'],
        //                                 'INGREDIENT' => $rs['INGREDIENT'],
        //                                 'STD' => $rs['STD'],
        //                                 'PK' => $rs['PK'],
        //                                 'OTHER' => $rs['OTHER'],
        //                                 'DOCUMENT' => $rs['DOCUMENT'],
        //                                 'OEM' => $rs['OEM'],
        //                                 'REASON1' => $rs['REASON1'],
        //                                 'REASON1_DES' => $rs['REASON1_DES'],
        //                                 'REASON2' => $rs['REASON2'],
        //                                 'REASON2_DES' => $rs['REASON2_DES'],
        //                                 'REASON3' => $rs['REASON3'],
        //                                 'REASON3_DES' => $rs['REASON3_DES'],
        //                                 'PACKAGE_BOX' => $rs['PACKAGE_BOX'],
        //                                 'REF_COLOR' => $rs['REF_COLOR'],
        //                                 'REF_FRAGRANCE' => $rs['REF_FRAGRANCE'],
        //                                 'OEM_STD' => $rs['OEM_STD'],
        //                                 'USER_EDIT' => $rs['USER_EDIT'],
        //                                 'EDIT_DT' => $this->convertDateStrToDate($rs['EDIT_DT'])
        //                             ]);
        //                             $this->output->progressAdvance();
        //                         }
        //                     }
        //                 }
        //             }
        //         } catch (\Exception $e) {
        //             // return response()->json([
        //             //     'status' => 'error',
        //             //     'message' => $e->getMessage(),
        //             // ]);
        //         }

        //         $this->output->progressFinish();
        //         // return response()->json([
        //         //     'status' => 'insert success',
        //         // ]);
        //     }
        // }

        // set_time_limit(600);
        ini_set('max_execution_time', 600);
        $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";
        $test_database = [
            'dbBBMAS|BB' => ['PRODUCT1', 'PRO_DEVELOP'],
            'dbCPMAS|CPS' => ['PRODUCT1', 'PRO_DEVELOP'],
            'dbGNCMAS|GNC' => ['PRODUCT1'],
            'dbKSHOPMAS|KTY' => ['PRODUCT1', 'PRO_DEVELOP'],
            'dbLLMAS|LL' => ['PRODUCT1', 'PRO_DEVELOP'],
            'dbOPMAS|OP' => ['PRODUCT1', 'PRO_DEVELOP'],
        ];

        // dd($test_database);

        foreach ($test_database as $key => $value) {
            $exploded_key = explode('|', $key);
            $dbName = $exploded_key[0];
            $brand = $exploded_key[1];
            foreach ($value as $table_name) {
                if ($table_name == 'PRO_DEVELOP') {
                    $sql_group = "SELECT Brand, COUNT(*) as KeyCount FROM $dbName.dbo.PRO_DEVELOP GROUP BY Brand";
                } else {
                    $sql_group = "SELECT Brand, COUNT(*) as KeyCount FROM $dbName.dbo.PRODUCT1 GROUP BY Brand";
                }

                $group_data_origin = Http::asForm()->withHeaders([])->post($endpoint, [
                    'statement' => $sql_group,
                ]);

                $result1 = $group_data_origin['result'];
                $diff_count = array_sum(array_column($result1, 'KeyCount'));
                $this->info("$dbName - $table_name");
                $this->output->progressStart($diff_count);

                try {
                    if (!empty($result1)) {
                        foreach ($result1 as $gp) {
                            if ($table_name == 'PRO_DEVELOP') {
                                $sql = "SELECT *
                                        FROM $dbName.dbo.PRO_DEVELOP WHERE Brand = '" . $gp['Brand'] . "'";
                            } else {
                                $sql = "SELECT *
                                        FROM $dbName.dbo.PRODUCT1 WHERE Brand = '" . $gp['Brand'] . "'";
                            }

                            $response_insert = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => $sql,
                            ]);

                            $result_data = $response_insert['result'];
                            if ($table_name == 'PRODUCT1') {
                                foreach ($result_data as $rs) {
                                    DB::table('product1s_all')->insert([
                                        // DB::table('product1s')->insert([
                                        'BRAND_ORIGINAL' => $brand,
                                        'BRAND' => $rs['BRAND'],
                                        'PRODUCT' => $rs['PRODUCT'],
                                        'BARCODE' => $rs['BARCODE'],
                                        'COLOR' => $rs['COLOR'],
                                        'GRP_P' => $rs['GRP_P'],
                                        'SUPPLIER' => $rs['SUPPLIER'],
                                        'NAME_THAI' => $rs['NAME_THAI'],
                                        'NAME_ENG' => $rs['NAME_ENG'],
                                        'SHORT_THAI' => $rs['SHORT_THAI'],
                                        'SHORT_ENG' => $rs['SHORT_ENG'],
                                        'VENDOR' => $rs['VENDOR'],
                                        'PRICE' => $rs['PRICE'],
                                        'COST' => $rs['COST'],
                                        'UNIT' => $rs['UNIT'],
                                        'UNIT_Q' => $rs['UNIT_Q'],
                                        'SOLUTION' => $rs['SOLUTION'],
                                        'SERIES' => $rs['SERIES'],
                                        'CATEGORY' => $rs['CATEGORY'],
                                        'STATUS' => $rs['STATUS'],
                                        'S_CAT' => $rs['S_CAT'],
                                        'PDM_GROUP' => $rs['PDM_GROUP'],
                                        'BRAND_P' => $rs['BRAND_P'],
                                        'REGISTER' => $rs['REGISTER'],
                                        'OPT_TXT1' => $rs['OPT_TXT1'],
                                        'CONDITION_SALE' => $rs['CONDITION_SALE'],
                                        'WHOLE_SALE' => $rs['WHOLE_SALE'],
                                        'GP' => $rs['GP'],
                                        'O_PRODUCT' => $rs['O_PRODUCT'],
                                        'BAR_PACK1' => $rs['BAR_PACK1'],
                                        'BAR_PACK2' => $rs['BAR_PACK2'],
                                        'BAR_PACK3' => $rs['BAR_PACK3'],
                                        'BAR_PACK4' => $rs['BAR_PACK4'],
                                        'PACK_SIZE1' => $rs['PACK_SIZE1'],
                                        'PACK_SIZE2' => $rs['PACK_SIZE2'],
                                        'PACK_SIZE3' => $rs['PACK_SIZE3'],
                                        'PACK_SIZE4' => $rs['PACK_SIZE4'],
                                        'REG_DATE' => $this->convertDateStrToDate($rs['REG_DATE']),
                                        'AGE' => $rs['AGE'],
                                        'WIDTH' => $rs['WIDTH'],
                                        'HEIGHT' => $rs['HEIGHT'],
                                        'WIDE' => $rs['WIDE'],
                                        'NAME_EXP' => $rs['NAME_EXP'],
                                        'NET_WEIGHT' => $rs['NET_WEIGHT'],
                                        'UNIT_TYPE' => $rs['UNIT_TYPE'],
                                        'TYPE_G' => $rs['TYPE_G'],
                                        'OPT_DATE1' => $this->convertDateStrToDate($rs['OPT_DATE1']),
                                        'OPT_DATE2' => $this->convertDateStrToDate($rs['OPT_DATE2']),
                                        'OPT_TXT2' => $rs['OPT_TXT2'],
                                        'OPT_NUM1' => $rs['OPT_NUM1'],
                                        'OPT_NUM2' => $rs['OPT_NUM2'],
                                        'ACC_TYPE' => $rs['ACC_TYPE'],
                                        'ACC_DT' => $this->convertDateStrToDate($rs['ACC_DT']),
                                        'RETURN' => $rs['RETURN'],
                                        'NON_VAT' => $rs['NON_VAT'],
                                        'STORAGE_TEMP' => $rs['STORAGE_TEMP'],
                                        'CONTROL_STK' => $rs['CONTROL_STK'],
                                        'TESTER' => $rs['TESTER'],
                                        'USER_EDIT' => $rs['USER_EDIT'],
                                        'EDIT_DT' => $this->convertDateStrToDate($rs['EDIT_DT'])
                                    ]);
                                    $this->output->progressAdvance();
                                }
                            }
                            if ($table_name == 'PRO_DEVELOP') {
                                foreach ($result_data as $rs) {
                                    DB::table('pro_develops_all')->insert([
                                        // DB::table('pro_develops')->insert([
                                        'BRAND_ORIGINAL' => $brand,
                                        'BRAND' => $rs['BRAND'],
                                        'DOC_NO' => $rs['DOC_NO'],
                                        'REF_DOC' => $rs['REF_DOC'],
                                        'STATUS' => $rs['STATUS'],
                                        'PRODUCT' => $rs['PRODUCT'],
                                        'BARCODE' => $rs['BARCODE'],
                                        'JOB_REFNO' => $rs['JOB_REFNO'],
                                        'DOC_DT' => $rs['DOC_DT'],
                                        'CUST_OEM' => $rs['CUST_OEM'],
                                        'NPD' => $rs['NPD'],
                                        'PDM' => $rs['PDM'],
                                        'NAME_ENG' => $rs['NAME_ENG'],
                                        'CATEGORY' => $rs['CATEGORY'],
                                        'CAPACITY' => $rs['CAPACITY'],
                                        'Q_SMELL' => $rs['Q_SMELL'],
                                        'Q_COLOR' => $rs['Q_COLOR'],
                                        'TARGET_GRP' => $rs['TARGET_GRP'],
                                        'TARGET_STK' => $rs['TARGET_STK'],
                                        'PRICE_FG' => $rs['PRICE_FG'],
                                        'PRICE_COST' => $rs['PRICE_COST'],
                                        'PRICE_BULK' => $rs['PRICE_BULK'],
                                        'FIRST_ORD' => $rs['FIRST_ORD'],
                                        'P_CONCEPT' => $rs['P_CONCEPT'],
                                        'P_BENEFIT' => $rs['P_BENEFIT'],
                                        'TEXTURE' => $rs['TEXTURE'],
                                        'TEXTURE_OT' => $rs['TEXTURE_OT'],
                                        'COLOR1' => $rs['COLOR1'],
                                        'FRANGRANCE' => $rs['FRANGRANCE'],
                                        'INGREDIENT' => $rs['INGREDIENT'],
                                        'STD' => $rs['STD'],
                                        'PK' => $rs['PK'],
                                        'OTHER' => $rs['OTHER'],
                                        'DOCUMENT' => $rs['DOCUMENT'],
                                        'OEM' => $rs['OEM'],
                                        'REASON1' => $rs['REASON1'],
                                        'REASON1_DES' => $rs['REASON1_DES'],
                                        'REASON2' => $rs['REASON2'],
                                        'REASON2_DES' => $rs['REASON2_DES'],
                                        'REASON3' => $rs['REASON3'],
                                        'REASON3_DES' => $rs['REASON3_DES'],
                                        'PACKAGE_BOX' => $rs['PACKAGE_BOX'],
                                        'REF_COLOR' => $rs['REF_COLOR'],
                                        'REF_FRAGRANCE' => $rs['REF_FRAGRANCE'],
                                        'OEM_STD' => $rs['OEM_STD'],
                                        'USER_EDIT' => $rs['USER_EDIT'],
                                        'EDIT_DT' => $this->convertDateStrToDate($rs['EDIT_DT'])
                                    ]);
                                    $this->output->progressAdvance();
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error: ' . $e->getMessage());
                }
                $this->output->progressFinish();
            }
        }
    }

    private function tranfer_pro_develops_all()
    {
        try {
            $prodDecelopsAll =  DB::table(DB::raw('(SELECT * FROM pro_develops_all WHERE ((BRAND_ORIGINAL != "CPS" AND PRODUCT != "" AND BARCODE != "") OR (BRAND_ORIGINAL = "CPS" AND PRODUCT NOT IN (SELECT PRODUCT FROM pro_develops_all WHERE BRAND_ORIGINAL = "LL") AND PRODUCT != "" AND BARCODE != ""))) AS pro_develops'))
            ->whereNotIn('pro_develops.PRODUCT', function ($query) {
                $query->select('PRODUCT')
                      ->from('pro_develops_all')
                      ->where('BRAND_ORIGINAL', '=', 'OP')
                      ->where('PRODUCT', 'NOT REGEXP', '^2')
                      ->where('PRODUCT', 'NOT REGEXP', '^1')
                      ->where('PRODUCT', 'NOT REGEXP', '^6');
            })
            ->get();

            $diff_count = count($prodDecelopsAll);
            $this->info("Transferring data from 'pro_develops_all' to 'pro_develops'");
            $this->output->progressStart($diff_count);

            foreach ($prodDecelopsAll as $rs) {
                DB::table('pro_develops')->insert([
                    'BRAND' => $rs->BRAND_ORIGINAL,
                    'DOC_NO' => $rs->DOC_NO,
                    'REF_DOC' => $rs->REF_DOC,
                    'STATUS' => $rs->STATUS,
                    'PRODUCT' => $rs->PRODUCT,
                    'BARCODE' => $rs->BARCODE,
                    'JOB_REFNO' => $rs->JOB_REFNO,
                    'DOC_DT' => $rs->DOC_DT,
                    'CUST_OEM' => $rs->CUST_OEM,
                    'NPD' => $rs->NPD,
                    'PDM' => $rs->PDM,
                    'NAME_ENG' => $rs->NAME_ENG,
                    'CATEGORY' => $rs->CATEGORY,
                    'CAPACITY' => $rs->CAPACITY,
                    'Q_SMELL' => $rs->Q_SMELL,
                    'Q_COLOR' => $rs->Q_COLOR,
                    'TARGET_GRP' => $rs->TARGET_GRP,
                    'TARGET_STK' => $rs->TARGET_STK,
                    'PRICE_FG' => $rs->PRICE_FG,
                    'PRICE_COST' => $rs->PRICE_COST,
                    'PRICE_BULK' => $rs->PRICE_BULK,
                    'FIRST_ORD' => $rs->FIRST_ORD,
                    'P_CONCEPT' => $rs->P_CONCEPT,
                    'P_BENEFIT' => $rs->P_BENEFIT,
                    'TEXTURE' => $rs->TEXTURE,
                    'TEXTURE_OT' => $rs->TEXTURE_OT,
                    'COLOR1' => $rs->COLOR1,
                    'FRANGRANCE' => $rs->FRANGRANCE,
                    'INGREDIENT' => $rs->INGREDIENT,
                    'STD' => $rs->STD,
                    'PK' => $rs->PK,
                    'OTHER' => $rs->OTHER,
                    'DOCUMENT' => $rs->DOCUMENT,
                    'OEM' => $rs->OEM,
                    'REASON1' => $rs->REASON1,
                    'REASON1_DES' => $rs->REASON1_DES,
                    'REASON2' => $rs->REASON2,
                    'REASON2_DES' => $rs->REASON2_DES,
                    'REASON3' => $rs->REASON3,
                    'REASON3_DES' => $rs->REASON3_DES,
                    'PACKAGE_BOX' => $rs->PACKAGE_BOX,
                    'REF_COLOR' => $rs->REF_COLOR,
                    'REF_FRAGRANCE' => $rs->REF_FRAGRANCE,
                    'OEM_STD' => $rs->OEM_STD,
                    'USER_EDIT' => $rs->USER_EDIT,
                    'EDIT_DT' => $rs->EDIT_DT
                ]);
                $this->output->progressAdvance();
            }
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
        $this->output->progressFinish();
    }
    private function tranfer_products_all()
    {
        try {
            // $productsAll = DB::table('product1s_all')
            //     ->where(function ($query) {
            //         // OP Brand
            //         $query->where('BRAND_ORIGINAL', 'OP')
            //             ->where(function ($subQuery) {
            //                 $subQuery->where(function ($innerQuery) {
            //                     $innerQuery->where('PRODUCT', 'REGEXP', '^[2]')
            //                         ->whereRaw('LENGTH(PRODUCT) = 5');
            //                 })->orWhere(function ($innerQuery) {
            //                     $innerQuery->where('PRODUCT', 'REGEXP', '^[1]')
            //                         ->whereRaw('LENGTH(PRODUCT) = 7');
            //                 })->orWhere(function ($specialQuery) {
            //                     $specialQuery->whereRaw("PRODUCT REGEXP '^[8-9]'")
            //                         ->groupBy('PRODUCT')
            //                         ->havingRaw('COUNT(*) = 1');
            //                 });
            //             });

            //         // CPS Brand
            //         $query->orWhere(function ($subQuery) {
            //             $subQuery->where('BRAND_ORIGINAL', 'CPS')
            //                 ->where(function ($innerQuery) {
            //                     $innerQuery->where(function ($deepQuery) {
            //                         $deepQuery->where('PRODUCT', 'REGEXP', '^[3]')
            //                             ->whereRaw('LENGTH(PRODUCT) = 5');
            //                     })->orWhere(function ($deepQuery) {
            //                         $deepQuery->where('PRODUCT', 'REGEXP', '^[7]')
            //                             ->whereRaw('LENGTH(PRODUCT) = 5');
            //                     })->orWhere(function ($deepQuery) {
            //                         $deepQuery->where('PRODUCT', 'REGEXP', '^[1]')
            //                             ->whereRaw('LENGTH(PRODUCT) = 7');
            //                     })->orWhere(function ($specialQuery) {
            //                         $specialQuery->whereRaw("PRODUCT REGEXP '^[8-9]'")
            //                             ->groupBy('PRODUCT')
            //                             ->havingRaw('COUNT(*) = 1');
            //                     });
            //                 });
            //         });

            //         // GNC Brand
            //         $query->orWhere(function ($subQuery) {
            //             $subQuery->where('BRAND_ORIGINAL', 'GNC')
            //                 ->where(function ($innerQuery) {
            //                     $innerQuery->whereRaw('LENGTH(PRODUCT) = 6')
            //                         ->orWhere(function ($deepQuery) {
            //                             $deepQuery->whereRaw('LENGTH(PRODUCT) = 10')
            //                                 ->where('barcode', '!=', 'CANCEL');
            //                         })->orWhere(function ($specialQuery) {
            //                             $specialQuery->whereRaw("PRODUCT REGEXP '^[8-9]'")
            //                                 ->groupBy('PRODUCT')
            //                                 ->havingRaw('COUNT(*) = 1');
            //                         });
            //                 });
            //         });

            //         // BB Brand
            //         $query->orWhere(function ($subQuery) {
            //             $subQuery->where('BRAND_ORIGINAL', 'BB')
            //                 ->where('PRODUCT', 'REGEXP', '^[6]')
            //                 ->whereRaw('LENGTH(PRODUCT) = 5');
            //         })->orWhere(function ($specialQuery) {
            //             $specialQuery->whereRaw("PRODUCT REGEXP '^[8-9]'")
            //                 ->groupBy('PRODUCT')
            //                 ->havingRaw('COUNT(*) = 1');
            //         });

            //         // LL Brand
            //         $query->orWhere(function ($subQuery) {
            //             $subQuery->where('BRAND_ORIGINAL', 'LL')
            //                 ->where('PRODUCT', 'REGEXP', '^[3]')
            //                 ->whereRaw('LENGTH(PRODUCT) = 5');
            //         })->orWhere(function ($specialQuery) {
            //             $specialQuery->whereRaw("PRODUCT REGEXP '^[8-9]'")
            //                 ->groupBy('PRODUCT')
            //                 ->havingRaw('COUNT(*) = 1');
            //         });

            //         // KTY Brand
            //         $query->orWhere(function ($subQuery) {
            //             $subQuery->where('BRAND_ORIGINAL', 'KTY')
            //                 ->where('PRODUCT', 'REGEXP', '^[1]')
            //                 ->whereRaw('LENGTH(PRODUCT) = 5');
            //         })->orWhere(function ($specialQuery) {
            //             $specialQuery->whereRaw("PRODUCT REGEXP '^[8-9]'")
            //                 ->groupBy('PRODUCT')
            //                 ->havingRaw('COUNT(*) = 1');
            //         });
            //     })
            //     ->orderBy('PRODUCT', 'ASC')
            //     ->get();

            $productsAll = DB::select("SELECT * FROM (SELECT *
                                                FROM `product1s_all`
                                                WHERE
                                                    (

                                                        (BRAND_ORIGINAL = 'OP' AND (
                                                            (PRODUCT REGEXP '^[2]' AND LENGTH(PRODUCT) = 5)
                                                            OR (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 7)

                                                        ))
                                                        OR

                                                        (BRAND_ORIGINAL = 'CPS' AND (
                                                            (PRODUCT REGEXP '^[3]' AND LENGTH(PRODUCT) = 5)
                                                            OR (PRODUCT REGEXP '^[7]' AND LENGTH(PRODUCT) = 5)
                                                            OR (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 7)
                                                            OR (PRODUCT REGEXP '^[0]' AND LENGTH(PRODUCT) = 5)

                                                        ))
                                                        OR

                                                        -- (BRAND_ORIGINAL = 'GNC' AND ((LENGTH(PRODUCT) = 6 AND PRODUCT not REGEXP '^[A-Z]' AND PRODUCT not REGEXP '^[8-9]') AND (PRODUCT not REGEXP '^[8-9]') OR
                                                        (BRAND_ORIGINAL = 'GNC' AND ((LENGTH(PRODUCT) = 6 AND PRODUCT not REGEXP '^[A-Z]') OR
                                                            LENGTH(PRODUCT) = 10 AND
                                                            barcode != 'CANCEL') )
                                                        OR

                                                        (BRAND_ORIGINAL = 'BB' AND (
                                                            (PRODUCT REGEXP '^[6]' AND LENGTH(PRODUCT) = 5)

                                                        ))
                                                        OR

                                                        (BRAND_ORIGINAL = 'LL' AND (
                                                            (PRODUCT REGEXP '^[3]' AND LENGTH(PRODUCT) = 5)

                                                        ))
                                                        OR

                                                        (BRAND_ORIGINAL = 'KTY' AND (
                                                            (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 5)

                                                        ))
                                                    )  AND BARCODE not REGEXP '^[A-Z]'
                                                UNION ALL
                                                SELECT *
                                                    FROM `product1s_all`
                                                    WHERE BRAND_ORIGINAL IN  ('CPS','OP','BB','LL','GNC','KTY') AND (PRODUCT REGEXP '^[8-9]') AND LENGTH(PRODUCT) >= 7 AND BARCODE not REGEXP '^[A-Z]'
                                                    GROUP BY PRODUCT
                                                    HAVING COUNT(*) = 1) AS data GROUP BY data.product

                                                ");

            $diff_count = count($productsAll);
            $this->info("Transferring data from 'product1s_all' to 'product1s_clean'");
            $this->output->progressStart($diff_count);

            // print_r($productsAll);
            // exit;
            // dd($productsAll);

            foreach ($productsAll as $rs) {
                DB::table('product1s_clean')->insert([
                    'BRAND' => $rs->BRAND_ORIGINAL,
                    'PRODUCT' => $rs->PRODUCT,
                    'BARCODE' => $rs->BARCODE,
                    'COLOR' => $rs->COLOR,
                    'GRP_P' => $rs->GRP_P,
                    'SUPPLIER' => $rs->SUPPLIER,
                    'NAME_THAI' => $rs->NAME_THAI,
                    'NAME_ENG' => $rs->NAME_ENG,
                    'SHORT_THAI' => $rs->SHORT_THAI,
                    'SHORT_ENG' => $rs->SHORT_ENG,
                    'VENDOR' => $rs->VENDOR,
                    'PRICE' => $rs->PRICE,
                    'COST' => $rs->COST,
                    'UNIT' => $rs->UNIT,
                    'UNIT_Q' => $rs->UNIT_Q,
                    'SOLUTION' => $rs->SOLUTION,
                    'SERIES' => $rs->SERIES,
                    'CATEGORY' => $rs->CATEGORY,
                    'STATUS' => $rs->STATUS,
                    'S_CAT' => $rs->S_CAT,
                    'PDM_GROUP' => $rs->PDM_GROUP,
                    'BRAND_P' => $rs->BRAND_P,
                    'REGISTER' => $rs->REGISTER,
                    'OPT_TXT1' => $rs->OPT_TXT1,
                    'CONDITION_SALE' => $rs->CONDITION_SALE,
                    'WHOLE_SALE' => $rs->WHOLE_SALE,
                    'GP' => $rs->GP,
                    'O_PRODUCT' => $rs->O_PRODUCT,
                    'BAR_PACK1' => $rs->BAR_PACK1,
                    'BAR_PACK2' => $rs->BAR_PACK2,
                    'BAR_PACK3' => $rs->BAR_PACK3,
                    'BAR_PACK4' => $rs->BAR_PACK4,
                    'PACK_SIZE1' => $rs->PACK_SIZE1,
                    'PACK_SIZE2' => $rs->PACK_SIZE2,
                    'PACK_SIZE3' => $rs->PACK_SIZE3,
                    'PACK_SIZE4' => $rs->PACK_SIZE4,
                    'REG_DATE' => $rs->REG_DATE,
                    'AGE' => $rs->AGE,
                    'WIDTH' => $rs->WIDTH,
                    'HEIGHT' => $rs->HEIGHT,
                    'WIDE' => $rs->WIDE,
                    'NAME_EXP' => $rs->NAME_EXP,
                    'NET_WEIGHT' => $rs->NET_WEIGHT,
                    'UNIT_TYPE' => $rs->UNIT_TYPE,
                    'TYPE_G' => $rs->TYPE_G,
                    'OPT_DATE1' => $rs->OPT_DATE1,
                    'OPT_DATE2' => $rs->OPT_DATE2,
                    'OPT_TXT2' => $rs->OPT_TXT2,
                    'OPT_NUM1' => $rs->OPT_NUM1,
                    'OPT_NUM2' => $rs->OPT_NUM2,
                    'ACC_TYPE' => $rs->ACC_TYPE,
                    'ACC_DT' => $rs->ACC_DT,
                    'RETURN' => $rs->RETURN,
                    'NON_VAT' => $rs->NON_VAT,
                    'STORAGE_TEMP' => $rs->STORAGE_TEMP,
                    'CONTROL_STK' => $rs->CONTROL_STK,
                    'TESTER' => $rs->TESTER,
                    'USER_EDIT' => $rs->USER_EDIT,
                    'EDIT_DT' => $rs->EDIT_DT,
                    'DATA_TYPE' => (string) 'S',
                ]);
                $this->output->progressAdvance();
            }
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
        $this->output->progressFinish();
    }

    private function tranfer_products_clean()
    {
        $dataProducts = DB::table('product1s_clean')
            ->get();

        $diff_count = count($dataProducts);
        $this->info("Transferring data from 'product1s_clean' to 'product1s'");
        $this->output->progressStart($diff_count);

        try {
            foreach ($dataProducts as $rs) {
                DB::table('product1s')->insert([
                    'BRAND' => $rs->BRAND,
                    'PRODUCT' => $rs->PRODUCT,
                    'BARCODE' => $rs->BARCODE,
                    'COLOR' => $rs->COLOR,
                    'GRP_P' => $rs->GRP_P,
                    'SUPPLIER' => $rs->SUPPLIER,
                    'NAME_THAI' => $rs->NAME_THAI,
                    'NAME_ENG' => $rs->NAME_ENG,
                    'SHORT_THAI' => $rs->SHORT_THAI,
                    'SHORT_ENG' => $rs->SHORT_ENG,
                    'VENDOR' => $rs->VENDOR,
                    'PRICE' => $rs->PRICE,
                    'COST' => $rs->COST,
                    'UNIT' => $rs->UNIT,
                    'UNIT_Q' => $rs->UNIT_Q,
                    'SOLUTION' => $rs->SOLUTION,
                    'SERIES' => $rs->SERIES,
                    'CATEGORY' => $rs->CATEGORY,
                    'STATUS' => $rs->STATUS,
                    'S_CAT' => $rs->S_CAT,
                    'PDM_GROUP' => $rs->PDM_GROUP,
                    'BRAND_P' => $rs->BRAND_P,
                    'REGISTER' => $rs->REGISTER,
                    'OPT_TXT1' => $rs->OPT_TXT1,
                    'CONDITION_SALE' => $rs->CONDITION_SALE,
                    'WHOLE_SALE' => $rs->WHOLE_SALE,
                    'GP' => $rs->GP,
                    'O_PRODUCT' => $rs->O_PRODUCT,
                    'BAR_PACK1' => $rs->BAR_PACK1,
                    'BAR_PACK2' => $rs->BAR_PACK2,
                    'BAR_PACK3' => $rs->BAR_PACK3,
                    'BAR_PACK4' => $rs->BAR_PACK4,
                    'PACK_SIZE1' => $rs->PACK_SIZE1,
                    'PACK_SIZE2' => $rs->PACK_SIZE2,
                    'PACK_SIZE3' => $rs->PACK_SIZE3,
                    'PACK_SIZE4' => $rs->PACK_SIZE4,
                    'REG_DATE' => $rs->REG_DATE,
                    'AGE' => $rs->AGE,
                    'WIDTH' => $rs->WIDTH,
                    'HEIGHT' => $rs->HEIGHT,
                    'WIDE' => $rs->WIDE,
                    'NAME_EXP' => $rs->NAME_EXP,
                    'NET_WEIGHT' => $rs->NET_WEIGHT,
                    'UNIT_TYPE' => $rs->UNIT_TYPE,
                    'TYPE_G' => $rs->TYPE_G,
                    'OPT_DATE1' => $rs->OPT_DATE1,
                    'OPT_DATE2' => $rs->OPT_DATE2,
                    'OPT_TXT2' => $rs->OPT_TXT2,
                    'OPT_NUM1' => $rs->OPT_NUM1,
                    'OPT_NUM2' => $rs->OPT_NUM2,
                    'ACC_TYPE' => $rs->ACC_TYPE,
                    'ACC_DT' => $rs->ACC_DT,
                    'RETURN' => $rs->RETURN,
                    'NON_VAT' => $rs->NON_VAT,
                    'STORAGE_TEMP' => $rs->STORAGE_TEMP,
                    'CONTROL_STK' => $rs->CONTROL_STK,
                    'TESTER' => $rs->TESTER,
                    'USER_EDIT' => $rs->USER_EDIT,
                    'EDIT_DT' => $rs->EDIT_DT,
                    'STATUS_EDIT_DT' => $rs->EDIT_DT,
                ]);
                $this->output->progressAdvance();
            }
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
        $this->output->progressFinish();
    }

    private function tranfer_to_products_channels()
    {
        try {
            $productCleans = DB::table('product1s_all')->get();
            $diff_count = count($productCleans);

            $this->info("Transferring data from 'product1s_clean' to 'product_channels'");
            $this->output->progressStart($diff_count);

            foreach ($productCleans as $rs) {
                DB::table('product_channels')->insert([
                    'PRODUCT' => $rs->PRODUCT,
                    'BRAND' => $rs->BRAND_ORIGINAL,
                    'UPDATED_AT' => date("Y/m/d h:i:s")
                ]);
                $this->output->progressAdvance();
            }
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
        $this->output->progressFinish();
    }

    // private function tranfer_consumsbles_to_product1s_not_duplicate()
    // {
    //     try {
    //         $productConsumsblesAll = DB::table('product1s_all')
    //             ->select('*', DB::raw('COUNT(*) as count'))
    //             ->whereRaw("PRODUCT REGEXP '^[8-9]'")
    //             ->groupBy('PRODUCT')
    //             ->having('count', '=', 1)
    //             ->orderBy('PRODUCT', 'ASC')
    //             ->get();

    //         $diff_count = count($productConsumsblesAll);
    //         $this->info("Transferring consumsbles data from 'product1s_all' to 'product1s not duplicate'");
    //         $this->output->progressStart($diff_count);

    //         foreach ($productConsumsblesAll as $rs) {
    //             DB::table('product1s')->insert([
    //                 'BRAND' => $rs->BRAND_ORIGINAL,
    //                 'PRODUCT' => $rs->PRODUCT,
    //                 'BARCODE' => $rs->BARCODE,
    //                 'COLOR' => $rs->COLOR,
    //                 'GRP_P' => $rs->GRP_P,
    //                 'SUPPLIER' => $rs->SUPPLIER,
    //                 'NAME_THAI' => $rs->NAME_THAI,
    //                 'NAME_ENG' => $rs->NAME_ENG,
    //                 'SHORT_THAI' => $rs->SHORT_THAI,
    //                 'SHORT_ENG' => $rs->SHORT_ENG,
    //                 'VENDOR' => $rs->VENDOR,
    //                 'PRICE' => $rs->PRICE,
    //                 'COST' => $rs->COST,
    //                 'UNIT' => $rs->UNIT,
    //                 'UNIT_Q' => $rs->UNIT_Q,
    //                 'SOLUTION' => $rs->SOLUTION,
    //                 'SERIES' => $rs->SERIES,
    //                 'CATEGORY' => $rs->CATEGORY,
    //                 'STATUS' => $rs->STATUS,
    //                 'S_CAT' => $rs->S_CAT,
    //                 'PDM_GROUP' => $rs->PDM_GROUP,
    //                 'BRAND_P' => $rs->BRAND_P,
    //                 'REGISTER' => $rs->REGISTER,
    //                 'OPT_TXT1' => $rs->OPT_TXT1,
    //                 'CONDITION_SALE' => $rs->CONDITION_SALE,
    //                 'WHOLE_SALE' => $rs->WHOLE_SALE,
    //                 'GP' => $rs->GP,
    //                 'O_PRODUCT' => $rs->O_PRODUCT,
    //                 'BAR_PACK1' => $rs->BAR_PACK1,
    //                 'BAR_PACK2' => $rs->BAR_PACK2,
    //                 'BAR_PACK3' => $rs->BAR_PACK3,
    //                 'BAR_PACK4' => $rs->BAR_PACK4,
    //                 'PACK_SIZE1' => $rs->PACK_SIZE1,
    //                 'PACK_SIZE2' => $rs->PACK_SIZE2,
    //                 'PACK_SIZE3' => $rs->PACK_SIZE3,
    //                 'PACK_SIZE4' => $rs->PACK_SIZE4,
    //                 'REG_DATE' => $rs->REG_DATE,
    //                 'AGE' => $rs->AGE,
    //                 'WIDTH' => $rs->WIDTH,
    //                 'HEIGHT' => $rs->HEIGHT,
    //                 'WIDE' => $rs->WIDE,
    //                 'NAME_EXP' => $rs->NAME_EXP,
    //                 'NET_WEIGHT' => $rs->NET_WEIGHT,
    //                 'UNIT_TYPE' => $rs->UNIT_TYPE,
    //                 'TYPE_G' => $rs->TYPE_G,
    //                 'OPT_DATE1' => $rs->OPT_DATE1,
    //                 'OPT_DATE2' => $rs->OPT_DATE2,
    //                 'OPT_TXT2' => $rs->OPT_TXT2,
    //                 'OPT_NUM1' => $rs->OPT_NUM1,
    //                 'OPT_NUM2' => $rs->OPT_NUM2,
    //                 'ACC_TYPE' => $rs->ACC_TYPE,
    //                 'ACC_DT' => $rs->ACC_DT,
    //                 'RETURN' => $rs->RETURN,
    //                 'NON_VAT' => $rs->NON_VAT,
    //                 'STORAGE_TEMP' => $rs->STORAGE_TEMP,
    //                 'CONTROL_STK' => $rs->CONTROL_STK,
    //                 'TESTER' => $rs->TESTER,
    //                 'USER_EDIT' => $rs->USER_EDIT,
    //                 'EDIT_DT' => $rs->EDIT_DT,
    //             ]);
    //             $this->output->progressAdvance();
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Error: ' . $e->getMessage());
    //     }
    //     $this->output->progressFinish();
    // }

    private function tranfer_consumsbles_to_product1s_duplicate()
    {
        try {
            $productConsumsblesAll = DB::table('product1s_all')
                ->select('*', DB::raw('COUNT(*) as count'))
                ->whereRaw("PRODUCT REGEXP '^[8-9]' AND LENGTH(PRODUCT) >= 7")
                ->groupBy('PRODUCT')
                ->having('count', '>', 1)
                ->orderBy('PRODUCT', 'ASC')
                ->get();

            // print_r($productConsumsblesAll);
            // exit;
            // dd($productConsumsblesAll);

            $diff_count = count($productConsumsblesAll);
            $this->info("Transferring consumsbles data from 'product1s_all' to 'product1s duplicate'");
            $this->output->progressStart($diff_count);

            foreach ($productConsumsblesAll as $rs) {
                DB::table('product1s')->insert([
                    'BRAND' => 'KM',
                    'PRODUCT' => $rs->PRODUCT,
                    'BARCODE' => $rs->BARCODE,
                    'COLOR' => $rs->COLOR,
                    'GRP_P' => $rs->GRP_P,
                    'SUPPLIER' => $rs->SUPPLIER,
                    'NAME_THAI' => $rs->NAME_THAI,
                    'NAME_ENG' => $rs->NAME_ENG,
                    'SHORT_THAI' => $rs->SHORT_THAI,
                    'SHORT_ENG' => $rs->SHORT_ENG,
                    'VENDOR' => $rs->VENDOR,
                    'PRICE' => $rs->PRICE,
                    'COST' => $rs->COST,
                    'UNIT' => $rs->UNIT,
                    'UNIT_Q' => $rs->UNIT_Q,
                    'SOLUTION' => $rs->SOLUTION,
                    'SERIES' => $rs->SERIES,
                    'CATEGORY' => $rs->CATEGORY,
                    'STATUS' => $rs->STATUS,
                    'S_CAT' => $rs->S_CAT,
                    'PDM_GROUP' => $rs->PDM_GROUP,
                    'BRAND_P' => $rs->BRAND_P,
                    'REGISTER' => $rs->REGISTER,
                    'OPT_TXT1' => $rs->OPT_TXT1,
                    'CONDITION_SALE' => $rs->CONDITION_SALE,
                    'WHOLE_SALE' => $rs->WHOLE_SALE,
                    'GP' => $rs->GP,
                    'O_PRODUCT' => $rs->O_PRODUCT,
                    'BAR_PACK1' => $rs->BAR_PACK1,
                    'BAR_PACK2' => $rs->BAR_PACK2,
                    'BAR_PACK3' => $rs->BAR_PACK3,
                    'BAR_PACK4' => $rs->BAR_PACK4,
                    'PACK_SIZE1' => $rs->PACK_SIZE1,
                    'PACK_SIZE2' => $rs->PACK_SIZE2,
                    'PACK_SIZE3' => $rs->PACK_SIZE3,
                    'PACK_SIZE4' => $rs->PACK_SIZE4,
                    'REG_DATE' => $rs->REG_DATE,
                    'AGE' => $rs->AGE,
                    'WIDTH' => $rs->WIDTH,
                    'HEIGHT' => $rs->HEIGHT,
                    'WIDE' => $rs->WIDE,
                    'NAME_EXP' => $rs->NAME_EXP,
                    'NET_WEIGHT' => $rs->NET_WEIGHT,
                    'UNIT_TYPE' => $rs->UNIT_TYPE,
                    'TYPE_G' => $rs->TYPE_G,
                    'OPT_DATE1' => $rs->OPT_DATE1,
                    'OPT_DATE2' => $rs->OPT_DATE2,
                    'OPT_TXT2' => $rs->OPT_TXT2,
                    'OPT_NUM1' => $rs->OPT_NUM1,
                    'OPT_NUM2' => $rs->OPT_NUM2,
                    'ACC_TYPE' => $rs->ACC_TYPE,
                    'ACC_DT' => $rs->ACC_DT,
                    'RETURN' => $rs->RETURN,
                    'NON_VAT' => $rs->NON_VAT,
                    'STORAGE_TEMP' => $rs->STORAGE_TEMP,
                    'CONTROL_STK' => $rs->CONTROL_STK,
                    'TESTER' => $rs->TESTER,
                    'USER_EDIT' => $rs->USER_EDIT,
                    'EDIT_DT' => $rs->EDIT_DT,
                    'STATUS_EDIT_DT' => $rs->EDIT_DT,
                ]);
                $this->output->progressAdvance();
            }
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
        $this->output->progressFinish();
    }

    // private function tranfer_data_to_product_channels()
    // {
    //     try {
    //         $productConsumsblesAll = DB::table('product1s_all')
    //             ->select('BRAND_ORIGINAL', 'PRODUCT')
    //             ->where('PRODUCT', 'REGEXP', '^[8-9]')
    //             ->get();

    //         $diff_count = count($productConsumsblesAll);
    //         $this->info("Transferring data from 'product1s_all' to 'product1s_clean'");
    //         $this->output->progressStart($diff_count);

    //         foreach ($productConsumsblesAll as $rs) {
    //             DB::table('product_channels')->insert([
    //                 'PRODUCT' => $rs->PRODUCT,
    //                 'BRAND' => $rs->BRAND_ORIGINAL,
    //                 'UPDATED_AT' => date("Y/m/d h:i:s")
    //             ]);
    //             $this->output->progressAdvance();
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Error: ' . $e->getMessage());
    //     }
    //     $this->output->progressFinish();
    // }

    public function tranfer_product_category()
    {
        set_time_limit(0);
        $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";
        $test_database = [
            'dbBBMAS|BB' => ['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
            'dbCPMAS|CPS' => ['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
            'dbGNCMAS|GNC' => ['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
            'dbKSHOPMAS|KTY' => ['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
            'dbLLMAS|LL' => ['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
            'dbOPMAS|OP' => ['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
        ];

        foreach ($test_database as $key => $value) {
            $exploded_key = explode('|', $key);
            $dbName = $exploded_key[0];
            $brand = $exploded_key[1];
            foreach ($value as $table_name) {
                $sql_group = "SELECT COUNT(*) as KeyCount FROM $dbName.dbo.$table_name";

                $group_data_origin = Http::asForm()->withHeaders([])->post($endpoint, [
                    'statement' => $sql_group,
                ]);

                $result1 = $group_data_origin['result'];
                $diff_count = array_sum(array_column($result1, 'KeyCount'));
                $this->info("$dbName - $table_name");
                $this->output->progressStart($diff_count);

                try {
                    if (!empty($result1)) {
                        $sql = "SELECT * FROM $dbName.dbo.$table_name";
                        $response_insert = Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql,
                        ]);

                        $result_data = $response_insert['result'];
                        if ($table_name == 'SOLUTION') {
                            foreach ($result_data as $rs) {
                                DB::table('solutions')->insert([
                                    'ID' => $rs['ID'],
                                    'DESCRIPTION' => $rs['DESCRIPTION'],
                                    'BRAND' => $brand,
                                    'EDIT_DT' => date('Y-m-d H:i:s'),
                                    'STATUS_EDIT_DT' => date('Y-m-d H:i:s')
                                ]);
                                $this->output->progressAdvance();
                            }
                        }
                        $result_data = $response_insert['result'];
                        if ($table_name == 'CATEGORY') {
                            foreach ($result_data as $rs) {
                                DB::table('categories')->insert([
                                    'ID' => $rs['ID'],
                                    'DESCRIPTION' => $rs['DESCRIPTION'],
                                    'BRAND' => $brand,
                                    'EDIT_DT' => date('Y-m-d H:i:s'),
                                    'STATUS_EDIT_DT' => date('Y-m-d H:i:s')
                                ]);
                                $this->output->progressAdvance();
                            }
                        }
                        if ($table_name == 'SERIES') {
                            foreach ($result_data as $rs) {
                                DB::table('series')->insert([
                                    'ID' => $rs['ID'],
                                    'DESCRIPTION' => $rs['DESCRIPTION'],
                                    'BRAND' => $brand,
                                    'EDIT_DT' => date('Y-m-d H:i:s'),
                                    'STATUS_EDIT_DT' => date('Y-m-d H:i:s')
                                ]);
                                $this->output->progressAdvance();
                            }
                        }
                        if ($table_name == 'SUB_CATEGORY') {
                            foreach ($result_data as $rs) {
                                DB::table('sub_categories')->insert([
                                    'ID' => $rs['ID'],
                                    'DESCRIPTION' => $rs['DESCRIPTION'],
                                    'CATEGORY_ID' => $rs['CATEGORY_ID'],
                                    'BRAND' => $brand,
                                    'EDIT_DT' => date('Y-m-d H:i:s'),
                                    'STATUS_EDIT_DT' => date('Y-m-d H:i:s')
                                ]);
                                $this->output->progressAdvance();
                            }
                        }
                        if ($table_name == 'PDM') {
                            foreach ($result_data as $rs) {
                                DB::table('pdms')->insert([
                                    'ID' => $rs['ID'],
                                    'REMARK' => $rs['REMARK'],
                                    'BRAND' => $brand,
                                    'EDIT_DT' => date('Y-m-d H:i:s'),
                                    'STATUS_EDIT_DT' => date('Y-m-d H:i:s')
                                ]);
                                $this->output->progressAdvance();
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error: ' . $e->getMessage());
                }
                $this->output->progressFinish();
            }
        }
    }

    // public function tranfer_back()
    // {
    //     set_time_limit(0);
    //     $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
    //     $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";
    //     $test_database = [
    //         'dbBBMAS|BB'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
    //         'dbCPMAS|CPS'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
    //         'dbGNCMAS|GNC'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
    //         'dbKSHOPMAS|KTY'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
    //         'dbLLMAS|LL'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
    //         'dbOPMAS|OP'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
    //     ];

    //     foreach ($test_database as $key => $value) {
    //         $exploded_key = explode('|', $key);
    //         $dbName = $exploded_key[0];
    //         $brand = $exploded_key[1];

    //         foreach ($value as $table_name) {
    //             $sql_group = "SELECT COUNT(*) as KeyCount FROM $dbName.dbo.$table_name";

    //             $group_data_origin = Http::asForm()->withHeaders([])->post($endpoint, [
    //                 'statement' => $sql_group,
    //             ]);

    //             $result1 = $group_data_origin['result'];
    //             $diff_count = array_sum(array_column($result1, 'KeyCount'));
    //             $this->info("$dbName - $table_name");
    //             $this->output->progressStart($diff_count);

    //             try {
    //                 if (!empty($result1)) {
    //                     $sql = "SELECT * FROM $dbName.dbo.$table_name";
    //                     $response_insert = Http::asForm()->withHeaders([])->post($endpoint, [
    //                         'statement' => $sql,
    //                     ]);

    //                     $result_data = $response_insert['result'];
    //                     if ($table_name == 'NEW_PRODUCT1') {
    //                         foreach ($result_data as $rs) {
    //                             DB::table('NEW_PRODUCT1')->insert([
    //                                 'ID' => $rs['ID'],
    //                                 'DESCRIPTION' => $rs['DESCRIPTION'],
    //                                 'BRAND' => $brand
    //                             ]);
    //                             $this->output->progressAdvance();
    //                         }
    //                     }
    //                 }
    //             } catch (\Exception $e) {
    //                 Log::error('Error: ' . $e->getMessage());
    //             }
    //             $this->output->progressFinish();
    //         }
    //     }
    // }

    public function tranfer_data_back()
    {
        set_time_limit(0);
        $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";

        $test_database = [
            'dbBBMAS|BB|8|9|6' => ['NEW_PRODUCT1'],
            'dbCPMAS|CPS|8|9|7' => ['NEW_PRODUCT1'],
            'dbGNCMAS|GNC|8|9' => ['NEW_PRODUCT1'],
            'dbKSHOPMAS|KTY|8|9|1' => ['NEW_PRODUCT1'],
            'dbLLMAS|LL|8|9|3' => ['NEW_PRODUCT1'],
            'dbOPMAS|OP|8|9|2' => ['NEW_PRODUCT1']
        ];

        // $check_junk_8 = DB::table('product_channels')
        // ->select('product_channels.PRODUCT')
        // ->whereRaw("product_channels.PRODUCT REGEXP '^[8]' AND LENGTH(product_channels.PRODUCT) >= 7")
        // ->groupBy('product_channels.PRODUCT')
        // ->havingRaw('COUNT(*) > 1')
        // ->get();

        // $check_junk_8 = $check_junk_8->where('product_channels.PRODUCT', 'REGEXP', '^[8]')->count();
        // $check_junk_8 = $check_junk_8->whereRaw("product_channels.PRODUCT REGEXP '^[8]' AND LENGTH(product_channels.PRODUCT) >= 8")->count();

        $dataProducts1 = DB::table('product_channels')
            ->select('product1s.*', 'product_channels.BRAND', 'product_channels.PRODUCT')
            ->leftJoin('product1s', 'product_channels.PRODUCT', '=', 'product1s.PRODUCT')
            // ->whereNotNull('product1s.STATUS_EDIT_DT')
            ->whereRaw( 'product_channels.PRODUCT NOT REGEXP "^[A-Z]"')
            ->get();


        $check_junk_8 = DB::table('product_channels')
        ->select('product1s.*', 'product_channels.BRAND', 'product_channels.PRODUCT')
        ->leftJoin('product1s', 'product_channels.PRODUCT', '=', 'product1s.PRODUCT');

        $check_junk_8 = $check_junk_8->whereRaw("product_channels.PRODUCT REGEXP '^[8]' AND LENGTH(product_channels.PRODUCT) >= 7")->count();
        $check_junk_8 = ['title'=>8, 'count'=>$check_junk_8];

        // dd($check_junk_8);

        $check_junk_9 = DB::table('product_channels')
            ->select('product1s.*', 'product_channels.BRAND', 'product_channels.PRODUCT')
            ->leftJoin('product1s', 'product_channels.PRODUCT', '=', 'product1s.PRODUCT');

        $check_junk_9 = $check_junk_9->whereRaw("product_channels.PRODUCT REGEXP '^[9]' AND LENGTH(product_channels.PRODUCT) >= 7")->count();
        $check_junk_9 = ['title'=>9, 'count'=>$check_junk_9];

        // dd($check_junk_9);

        $diff_count = count($dataProducts1);

        // print_r($diff_count);
        // exit;
        $this->info("Transferring product_channels data back to dot1");
        $this->output->progressStart($diff_count);

        foreach ($test_database as $key => $value) {
            $exploded_key = explode('|', $key);
            $dbName = $exploded_key[0];
            $brand = $exploded_key[1];
            $key_parts_number_1 = $exploded_key[2] ?? null;
            $key_parts_number_2 = isset($exploded_key[3]) ? $exploded_key[3] : null;
            $key_parts_number_3 = isset($exploded_key[4]) ? $exploded_key[4] : null;

            foreach ($dataProducts1 as $rs) {
                // dd($rs->PRODUCT[0]);
                // dd($key_parts_number_1);
                if ($dbName == 'dbCPMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                    $brand_value = 'KM';
                    if ($rs->PRODUCT[0] == $key_parts_number_3 || ($rs->PRODUCT[0] == 1 && strlen((string)$rs->PRODUCT) == 7) || ($rs->PRODUCT[0] == 2 && strlen((string)$rs->PRODUCT) == 7)) {
                        $brand_value = $brand;
                    } elseif ($rs->PRODUCT[0] == 0 && strlen($rs->PRODUCT) === 5) {
                        $brand_value = $brand;
                    } elseif ($rs->PRODUCT[0] == 1 && strlen($rs->PRODUCT) === 5) {
                        $brand_value = 'KM';
                    }

                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                    $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                    $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                    $sql .= "'" . $brand_value . "',
                    '" . $rs->PRODUCT . "',
                    '" . $rs->BARCODE . "',
                    '" . $rs->COLOR . "',
                    '" . $rs->GRP_P . "',
                    '" . $rs->SUPPLIER . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                    '" . $rs->VENDOR . "',
                    '" . $rs->PRICE . "',
                    '" . $rs->COST . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                    '" . $rs->UNIT_Q . "',
                    '" . $rs->SOLUTION . "',
                    '" . $rs->SERIES . "',
                    '" . $rs->CATEGORY . "',
                    '" . $rs->STATUS . "',
                    '" . $rs->S_CAT . "',
                    '" . $rs->PDM_GROUP . "',
                    '" . $rs->BRAND_P . "',
                    '" . $rs->REGISTER . "',
                    '" . $rs->OPT_TXT1 . "',
                    '" . $rs->CONDITION_SALE . "',
                    '" . $rs->WHOLE_SALE . "',
                    '" . $rs->GP . "',
                    '" . $rs->O_PRODUCT . "',
                    '" . $rs->BAR_PACK1 . "',
                    '" . $rs->BAR_PACK2 . "',
                    '" . $rs->BAR_PACK3 . "',
                    '" . $rs->BAR_PACK4 . "',
                    '" . $rs->PACK_SIZE1 . "',
                    '" . $rs->PACK_SIZE2 . "',
                    '" . $rs->PACK_SIZE3 . "',
                    '" . $rs->PACK_SIZE4 . "',
                    '" . $REG_DATE_RP . "',
                    '" . $rs->AGE . "',
                    '" . $rs->WIDTH . "',
                    '" . $rs->HEIGHT . "',
                    '" . $rs->WIDE . "',
                    '" . $rs->NAME_EXP . "',
                    '" . $rs->NET_WEIGHT . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                    '" . $rs->TYPE_G . "',
                    '" . $OPT_DATE1_RP . "',
                    '" . $OPT_DATE2_RP . "',
                    '" . $rs->OPT_TXT2 . "',
                    '" . $rs->OPT_NUM1 . "',
                    '" . $rs->OPT_NUM2 . "',
                    '" . $rs->ACC_TYPE . "',
                    '" . $ACC_DT_RP . "',
                    '" . $rs->RETURN . "',
                    '" . $rs->NON_VAT . "',
                    '" . $rs->STORAGE_TEMP . "',
                    '" . $rs->CONTROL_STK . "',
                    '" . $rs->TESTER . "',
                    '" . $rs->USER_EDIT . "',
                    '" . $rs->EDIT_DT . "'
                )";

                    // dd($sql);
                    Http::asForm()->withHeaders([])->post($endpoint, [
                        'statement' => $sql,
                    ]);

                    $this->output->progressAdvance();
                }
                else
                    if ($dbName == 'dbCPMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                        $dataproduct = DB::table('product1s')
                        ->select('*')     
                        ->where('PRODUCT', '=', $rs->PRODUCT)  
                        ->first();

                        if($dataproduct){
                            $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                            $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                            $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                            $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                            $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                            $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                            $sql .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "',
                                    '" . $rs->BARCODE . "',
                                    '" . $rs->COLOR . "',
                                    '" . $rs->GRP_P . "',
                                    '" . $rs->SUPPLIER . "',
                                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    '" . $rs->VENDOR . "',
                                    '" . $rs->PRICE . "',
                                    '" . $rs->COST . "',
                                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    '" . $rs->UNIT_Q . "',
                                    '" . $rs->SOLUTION . "',
                                    '" . $rs->SERIES . "',
                                    '" . $rs->CATEGORY . "',
                                    '" . $rs->STATUS . "',
                                    '" . $rs->S_CAT . "',
                                    '" . $rs->PDM_GROUP . "',
                                    '" . $rs->BRAND_P . "',
                                    '" . $rs->REGISTER . "',
                                    '" . $rs->OPT_TXT1 . "',
                                    '" . $rs->CONDITION_SALE . "',
                                    '" . $rs->WHOLE_SALE . "',
                                    '" . $rs->GP . "',
                                    '" . $rs->O_PRODUCT . "',
                                    '" . $rs->BAR_PACK1 . "',
                                    '" . $rs->BAR_PACK2 . "',
                                    '" . $rs->BAR_PACK3 . "',
                                    '" . $rs->BAR_PACK4 . "',
                                    '" . $rs->PACK_SIZE1 . "',
                                    '" . $rs->PACK_SIZE2 . "',
                                    '" . $rs->PACK_SIZE3 . "',
                                    '" . $rs->PACK_SIZE4 . "',
                                    '" . $REG_DATE_RP . "',
                                    '" . $rs->AGE . "',
                                    '" . $rs->WIDTH . "',
                                    '" . $rs->HEIGHT . "',
                                    '" . $rs->WIDE . "',
                                    '" . $rs->NAME_EXP . "',
                                    '" . $rs->NET_WEIGHT . "',
                                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    '" . $rs->TYPE_G . "',
                                    '" . $OPT_DATE1_RP . "',
                                    '" . $OPT_DATE2_RP . "',
                                    '" . $rs->OPT_TXT2 . "',
                                    '" . $rs->OPT_NUM1 . "',
                                    '" . $rs->OPT_NUM2 . "',
                                    '" . $rs->ACC_TYPE . "',
                                    '" . $ACC_DT_RP . "',
                                    '" . $rs->RETURN . "',
                                    '" . $rs->NON_VAT . "',
                                    '" . $rs->STORAGE_TEMP . "',
                                    '" . $rs->CONTROL_STK . "',
                                    '" . $rs->TESTER . "',
                                    '" . $rs->USER_EDIT . "',
                                    '" . $rs->EDIT_DT . "'
                                )";
                        }
                        Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql,
                        ]);

                        $this->output->progressAdvance();
                    }
                if ($dbName == 'dbBBMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                    $brand_value = 'KM';
                    if ($rs->PRODUCT[0] == $key_parts_number_3) {
                        $brand_value = $brand;
                    }
                    // elseif ($rs->PRODUCT[0] == 1 && strlen($rs->PRODUCT) === 5) {
                    //     $brand_value = 'KM';
                    // }
                    // $brand_value = ($rs->PRODUCT[0] == $key_parts_number_3) ? $brand : 'KM';

                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                    $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                    $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                    $sql .= "'" . $brand_value . "',
                                '" . $rs->PRODUCT . "',
                                '" . $rs->BARCODE . "',
                                '" . $rs->COLOR . "',
                                '" . $rs->GRP_P . "',
                                '" . $rs->SUPPLIER . "',
                                N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                '" . $rs->VENDOR . "',
                                '" . $rs->PRICE . "',
                                '" . $rs->COST . "',
                                N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                '" . $rs->UNIT_Q . "',
                                '" . $rs->SOLUTION . "',
                                '" . $rs->SERIES . "',
                                '" . $rs->CATEGORY . "',
                                '" . $rs->STATUS . "',
                                '" . $rs->S_CAT . "',
                                '" . $rs->PDM_GROUP . "',
                                '" . $rs->BRAND_P . "',
                                '" . $rs->REGISTER . "',
                                '" . $rs->OPT_TXT1 . "',
                                '" . $rs->CONDITION_SALE . "',
                                '" . $rs->WHOLE_SALE . "',
                                '" . $rs->GP . "',
                                '" . $rs->O_PRODUCT . "',
                                '" . $rs->BAR_PACK1 . "',
                                '" . $rs->BAR_PACK2 . "',
                                '" . $rs->BAR_PACK3 . "',
                                '" . $rs->BAR_PACK4 . "',
                                '" . $rs->PACK_SIZE1 . "',
                                '" . $rs->PACK_SIZE2 . "',
                                '" . $rs->PACK_SIZE3 . "',
                                '" . $rs->PACK_SIZE4 . "',
                                '" . $REG_DATE_RP . "',
                                '" . $rs->AGE . "',
                                '" . $rs->WIDTH . "',
                                '" . $rs->HEIGHT . "',
                                '" . $rs->WIDE . "',
                                '" . $rs->NAME_EXP . "',
                                '" . $rs->NET_WEIGHT . "',
                                N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                '" . $rs->TYPE_G . "',
                                '" . $OPT_DATE1_RP . "',
                                '" . $OPT_DATE2_RP . "',
                                '" . $rs->OPT_TXT2 . "',
                                '" . $rs->OPT_NUM1 . "',
                                '" . $rs->OPT_NUM2 . "',
                                '" . $rs->ACC_TYPE . "',
                                '" . $ACC_DT_RP . "',
                                '" . $rs->RETURN . "',
                                '" . $rs->NON_VAT . "',
                                '" . $rs->STORAGE_TEMP . "',
                                '" . $rs->CONTROL_STK . "',
                                '" . $rs->TESTER . "',
                                '" . $rs->USER_EDIT . "',
                                '" . $rs->EDIT_DT . "'
                            )";
                    Http::asForm()->withHeaders([])->post($endpoint, [
                        'statement' => $sql,
                    ]);
                    $this->output->progressAdvance();
                } else
                    if ($dbName == 'dbBBMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                        // if($rs->PRODUCT[0] == $check_junk_8['title'] && ($check_junk_8['count'] > 1)){
                        //     $brand_value = 'KM';
                        // }else if($rs->PRODUCT[0] == $check_junk_9['title'] && ($check_junk_9['count'] > 1)){
                        //     $brand_value = 'KM';
                        // }else{
                        //     $brand_value = ($rs->PRODUCT[0] == $key_parts_number_1 || $rs->PRODUCT[0] == $key_parts_number_2) ? $brand : null;
                        // }

                        $dataproduct = DB::table('product1s')
                            ->select('*')     
                            ->where('PRODUCT', '=', $rs->PRODUCT)  
                            ->first();

                        if($dataproduct){
                            $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                            $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                            $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                            $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                            $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                            $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                            $sql .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "',
                    '" . $rs->BARCODE . "',
                    '" . $rs->COLOR . "',
                    '" . $rs->GRP_P . "',
                    '" . $rs->SUPPLIER . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                    '" . $rs->VENDOR . "',
                    '" . $rs->PRICE . "',
                    '" . $rs->COST . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                    '" . $rs->UNIT_Q . "',
                    '" . $rs->SOLUTION . "',
                    '" . $rs->SERIES . "',
                    '" . $rs->CATEGORY . "',
                    '" . $rs->STATUS . "',
                    '" . $rs->S_CAT . "',
                    '" . $rs->PDM_GROUP . "',
                    '" . $rs->BRAND_P . "',
                    '" . $rs->REGISTER . "',
                    '" . $rs->OPT_TXT1 . "',
                    '" . $rs->CONDITION_SALE . "',
                    '" . $rs->WHOLE_SALE . "',
                    '" . $rs->GP . "',
                    '" . $rs->O_PRODUCT . "',
                    '" . $rs->BAR_PACK1 . "',
                    '" . $rs->BAR_PACK2 . "',
                    '" . $rs->BAR_PACK3 . "',
                    '" . $rs->BAR_PACK4 . "',
                    '" . $rs->PACK_SIZE1 . "',
                    '" . $rs->PACK_SIZE2 . "',
                    '" . $rs->PACK_SIZE3 . "',
                    '" . $rs->PACK_SIZE4 . "',
                    '" . $REG_DATE_RP . "',
                    '" . $rs->AGE . "',
                    '" . $rs->WIDTH . "',
                    '" . $rs->HEIGHT . "',
                    '" . $rs->WIDE . "',
                    '" . $rs->NAME_EXP . "',
                    '" . $rs->NET_WEIGHT . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                    '" . $rs->TYPE_G . "',
                    '" . $OPT_DATE1_RP . "',
                    '" . $OPT_DATE2_RP . "',
                    '" . $rs->OPT_TXT2 . "',
                    '" . $rs->OPT_NUM1 . "',
                    '" . $rs->OPT_NUM2 . "',
                    '" . $rs->ACC_TYPE . "',
                    '" . $ACC_DT_RP . "',
                    '" . $rs->RETURN . "',
                    '" . $rs->NON_VAT . "',
                    '" . $rs->STORAGE_TEMP . "',
                    '" . $rs->CONTROL_STK . "',
                    '" . $rs->TESTER . "',
                    '" . $rs->USER_EDIT . "',
                    '" . $rs->EDIT_DT . "'
                                )";
                        }
                        Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql,
                        ]);
                        $this->output->progressAdvance();
                    }

                if ($dbName == 'dbGNCMAS' && $brand == $rs->BRAND && (strlen($rs->PRODUCT) != 7)) {
                    $brand_value = 'KM';
                    if ((strlen($rs->PRODUCT) === 6 && $rs->PRODUCT[0] <= 9) || (strlen($rs->PRODUCT) === 10 && $rs->PRODUCT[0] <= 9)  ) {
                        $brand_value = $brand;
                    } else {
                        $brand_value = 'KM';
                    }

                    // if ($dbName == 'dbGNCMAS' && $brand == $rs->BRAND) {
                    //     $brand_value = (strlen((string)$rs->PRODUCT) == 6 || strlen((string)$rs->PRODUCT) == 10) ? $brand : 'KM';
                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                    $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                    $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                    $sql .= "'" . $brand_value . "',
                                '" . $rs->PRODUCT . "',
                    '" . $rs->BARCODE . "',
                    '" . $rs->COLOR . "',
                    '" . $rs->GRP_P . "',
                    '" . $rs->SUPPLIER . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                    '" . $rs->VENDOR . "',
                    '" . $rs->PRICE . "',
                    '" . $rs->COST . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                    '" . $rs->UNIT_Q . "',
                    '" . $rs->SOLUTION . "',
                    '" . $rs->SERIES . "',
                    '" . $rs->CATEGORY . "',
                    '" . $rs->STATUS . "',
                    '" . $rs->S_CAT . "',
                    '" . $rs->PDM_GROUP . "',
                    '" . $rs->BRAND_P . "',
                    '" . $rs->REGISTER . "',
                    '" . $rs->OPT_TXT1 . "',
                    '" . $rs->CONDITION_SALE . "',
                    '" . $rs->WHOLE_SALE . "',
                    '" . $rs->GP . "',
                    '" . $rs->O_PRODUCT . "',
                    '" . $rs->BAR_PACK1 . "',
                    '" . $rs->BAR_PACK2 . "',
                    '" . $rs->BAR_PACK3 . "',
                    '" . $rs->BAR_PACK4 . "',
                    '" . $rs->PACK_SIZE1 . "',
                    '" . $rs->PACK_SIZE2 . "',
                    '" . $rs->PACK_SIZE3 . "',
                    '" . $rs->PACK_SIZE4 . "',
                    '" . $REG_DATE_RP . "',
                    '" . $rs->AGE . "',
                    '" . $rs->WIDTH . "',
                    '" . $rs->HEIGHT . "',
                    '" . $rs->WIDE . "',
                    '" . $rs->NAME_EXP . "',
                    '" . $rs->NET_WEIGHT . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                    '" . $rs->TYPE_G . "',
                    '" . $OPT_DATE1_RP . "',
                    '" . $OPT_DATE2_RP . "',
                    '" . $rs->OPT_TXT2 . "',
                    '" . $rs->OPT_NUM1 . "',
                    '" . $rs->OPT_NUM2 . "',
                    '" . $rs->ACC_TYPE . "',
                    '" . $ACC_DT_RP . "',
                    '" . $rs->RETURN . "',
                    '" . $rs->NON_VAT . "',
                    '" . $rs->STORAGE_TEMP . "',
                    '" . $rs->CONTROL_STK . "',
                    '" . $rs->TESTER . "',
                    '" . $rs->USER_EDIT . "',
                    '" . $rs->EDIT_DT . "'
                            )";
                    Http::asForm()->withHeaders([])->post($endpoint, [
                        'statement' => $sql,
                    ]);
                    $this->output->progressAdvance();
                } else
                    if ($dbName == 'dbGNCMAS' && (strlen($rs->PRODUCT) === 7 && $rs->PRODUCT[0] >= 8) && $brand == $rs->BRAND) {
                        // if($rs->PRODUCT[0] == $check_junk_8['title'] && ($check_junk_8['count'] > 1)){
                        //     $brand_value = 'KM';
                        // }else if($rs->PRODUCT[0] == $check_junk_9['title'] && ($check_junk_9['count'] > 1)){
                        //     $brand_value = 'KM';
                        // }else{
                        //     $brand_value = ($rs->PRODUCT[0] == $key_parts_number_1 || $rs->PRODUCT[0] == $key_parts_number_2) ? $brand : null;
                        // }

                        $dataproduct = DB::table('product1s')
                            ->select('*')     
                            ->where('PRODUCT', '=', $rs->PRODUCT)  
                            ->first();

                        if($dataproduct){

                            $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                            $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                            $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                            $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                            $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                            $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                            $sql .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "',
                    '" . $rs->BARCODE . "',
                    '" . $rs->COLOR . "',
                    '" . $rs->GRP_P . "',
                    '" . $rs->SUPPLIER . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                    '" . $rs->VENDOR . "',
                    '" . $rs->PRICE . "',
                    '" . $rs->COST . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                    '" . $rs->UNIT_Q . "',
                    '" . $rs->SOLUTION . "',
                    '" . $rs->SERIES . "',
                    '" . $rs->CATEGORY . "',
                    '" . $rs->STATUS . "',
                    '" . $rs->S_CAT . "',
                    '" . $rs->PDM_GROUP . "',
                    '" . $rs->BRAND_P . "',
                    '" . $rs->REGISTER . "',
                    '" . $rs->OPT_TXT1 . "',
                    '" . $rs->CONDITION_SALE . "',
                    '" . $rs->WHOLE_SALE . "',
                    '" . $rs->GP . "',
                    '" . $rs->O_PRODUCT . "',
                    '" . $rs->BAR_PACK1 . "',
                    '" . $rs->BAR_PACK2 . "',
                    '" . $rs->BAR_PACK3 . "',
                    '" . $rs->BAR_PACK4 . "',
                    '" . $rs->PACK_SIZE1 . "',
                    '" . $rs->PACK_SIZE2 . "',
                    '" . $rs->PACK_SIZE3 . "',
                    '" . $rs->PACK_SIZE4 . "',
                    '" . $REG_DATE_RP . "',
                    '" . $rs->AGE . "',
                    '" . $rs->WIDTH . "',
                    '" . $rs->HEIGHT . "',
                    '" . $rs->WIDE . "',
                    '" . $rs->NAME_EXP . "',
                    '" . $rs->NET_WEIGHT . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                    '" . $rs->TYPE_G . "',
                    '" . $OPT_DATE1_RP . "',
                    '" . $OPT_DATE2_RP . "',
                    '" . $rs->OPT_TXT2 . "',
                    '" . $rs->OPT_NUM1 . "',
                    '" . $rs->OPT_NUM2 . "',
                    '" . $rs->ACC_TYPE . "',
                    '" . $ACC_DT_RP . "',
                    '" . $rs->RETURN . "',
                    '" . $rs->NON_VAT . "',
                    '" . $rs->STORAGE_TEMP . "',
                    '" . $rs->CONTROL_STK . "',
                    '" . $rs->TESTER . "',
                    '" . $rs->USER_EDIT . "',
                    '" . $rs->EDIT_DT . "'
                                )";
                        }
                        Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql,
                        ]);
                        $this->output->progressAdvance();
                    }
                if ($dbName == 'dbKSHOPMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                    $brand_value = 'KM';
                    if ($rs->PRODUCT[0] == $key_parts_number_3 && strlen($rs->PRODUCT) === 5) {
                        $brand_value = 'KSHOP';
                    } else if ($rs->PRODUCT[0] == 1 && strlen($rs->PRODUCT) === 6) {
                        $brand_value = 'KM';
                    }

                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                    $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                    $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                    $sql .= "'" . $brand_value . "',
                                '" . $rs->PRODUCT . "',
                    '" . $rs->BARCODE . "',
                    '" . $rs->COLOR . "',
                    '" . $rs->GRP_P . "',
                    '" . $rs->SUPPLIER . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                    '" . $rs->VENDOR . "',
                    '" . $rs->PRICE . "',
                    '" . $rs->COST . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                    '" . $rs->UNIT_Q . "',
                    '" . $rs->SOLUTION . "',
                    '" . $rs->SERIES . "',
                    '" . $rs->CATEGORY . "',
                    '" . $rs->STATUS . "',
                    '" . $rs->S_CAT . "',
                    '" . $rs->PDM_GROUP . "',
                    '" . $rs->BRAND_P . "',
                    '" . $rs->REGISTER . "',
                    '" . $rs->OPT_TXT1 . "',
                    '" . $rs->CONDITION_SALE . "',
                    '" . $rs->WHOLE_SALE . "',
                    '" . $rs->GP . "',
                    '" . $rs->O_PRODUCT . "',
                    '" . $rs->BAR_PACK1 . "',
                    '" . $rs->BAR_PACK2 . "',
                    '" . $rs->BAR_PACK3 . "',
                    '" . $rs->BAR_PACK4 . "',
                    '" . $rs->PACK_SIZE1 . "',
                    '" . $rs->PACK_SIZE2 . "',
                    '" . $rs->PACK_SIZE3 . "',
                    '" . $rs->PACK_SIZE4 . "',
                    '" . $REG_DATE_RP . "',
                    '" . $rs->AGE . "',
                    '" . $rs->WIDTH . "',
                    '" . $rs->HEIGHT . "',
                    '" . $rs->WIDE . "',
                    '" . $rs->NAME_EXP . "',
                    '" . $rs->NET_WEIGHT . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                    '" . $rs->TYPE_G . "',
                    '" . $OPT_DATE1_RP . "',
                    '" . $OPT_DATE2_RP . "',
                    '" . $rs->OPT_TXT2 . "',
                    '" . $rs->OPT_NUM1 . "',
                    '" . $rs->OPT_NUM2 . "',
                    '" . $rs->ACC_TYPE . "',
                    '" . $ACC_DT_RP . "',
                    '" . $rs->RETURN . "',
                    '" . $rs->NON_VAT . "',
                    '" . $rs->STORAGE_TEMP . "',
                    '" . $rs->CONTROL_STK . "',
                    '" . $rs->TESTER . "',
                    '" . $rs->USER_EDIT . "',
                    '" . $rs->EDIT_DT . "'
                            )";
                    Http::asForm()->withHeaders([])->post($endpoint, [
                        'statement' => $sql,
                    ]);
                    $this->output->progressAdvance();
                } else
                    if ($dbName == 'dbKSHOPMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {

                        $dataproduct = DB::table('product1s')
                            ->select('*')     
                            ->where('PRODUCT', '=', $rs->PRODUCT)  
                            ->first();

                        if($dataproduct){

                            $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                            $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                            $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                            $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                            $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                            $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                            $sql .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "',
                    '" . $rs->BARCODE . "',
                    '" . $rs->COLOR . "',
                    '" . $rs->GRP_P . "',
                    '" . $rs->SUPPLIER . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                    '" . $rs->VENDOR . "',
                    '" . $rs->PRICE . "',
                    '" . $rs->COST . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                    '" . $rs->UNIT_Q . "',
                    '" . $rs->SOLUTION . "',
                    '" . $rs->SERIES . "',
                    '" . $rs->CATEGORY . "',
                    '" . $rs->STATUS . "',
                    '" . $rs->S_CAT . "',
                    '" . $rs->PDM_GROUP . "',
                    '" . $rs->BRAND_P . "',
                    '" . $rs->REGISTER . "',
                    '" . $rs->OPT_TXT1 . "',
                    '" . $rs->CONDITION_SALE . "',
                    '" . $rs->WHOLE_SALE . "',
                    '" . $rs->GP . "',
                    '" . $rs->O_PRODUCT . "',
                    '" . $rs->BAR_PACK1 . "',
                    '" . $rs->BAR_PACK2 . "',
                    '" . $rs->BAR_PACK3 . "',
                    '" . $rs->BAR_PACK4 . "',
                    '" . $rs->PACK_SIZE1 . "',
                    '" . $rs->PACK_SIZE2 . "',
                    '" . $rs->PACK_SIZE3 . "',
                    '" . $rs->PACK_SIZE4 . "',
                    '" . $REG_DATE_RP . "',
                    '" . $rs->AGE . "',
                    '" . $rs->WIDTH . "',
                    '" . $rs->HEIGHT . "',
                    '" . $rs->WIDE . "',
                    '" . $rs->NAME_EXP . "',
                    '" . $rs->NET_WEIGHT . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                    '" . $rs->TYPE_G . "',
                    '" . $OPT_DATE1_RP . "',
                    '" . $OPT_DATE2_RP . "',
                    '" . $rs->OPT_TXT2 . "',
                    '" . $rs->OPT_NUM1 . "',
                    '" . $rs->OPT_NUM2 . "',
                    '" . $rs->ACC_TYPE . "',
                    '" . $ACC_DT_RP . "',
                    '" . $rs->RETURN . "',
                    '" . $rs->NON_VAT . "',
                    '" . $rs->STORAGE_TEMP . "',
                    '" . $rs->CONTROL_STK . "',
                    '" . $rs->TESTER . "',
                    '" . $rs->USER_EDIT . "',
                    '" . $rs->EDIT_DT . "'
                                )";
                        }
                        Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql,
                        ]);
                        $this->output->progressAdvance();
                    }
                if ($dbName == 'dbLLMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                    $brand_value = 'KM';
                    if ($rs->PRODUCT[0] == $key_parts_number_3) {
                        $brand_value = $brand;
                    }

                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                    $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                    $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                    $sql .= "'" . $brand_value . "',
                                '" . $rs->PRODUCT . "',
                    '" . $rs->BARCODE . "',
                    '" . $rs->COLOR . "',
                    '" . $rs->GRP_P . "',
                    '" . $rs->SUPPLIER . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                    '" . $rs->VENDOR . "',
                    '" . $rs->PRICE . "',
                    '" . $rs->COST . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                    '" . $rs->UNIT_Q . "',
                    '" . $rs->SOLUTION . "',
                    '" . $rs->SERIES . "',
                    '" . $rs->CATEGORY . "',
                    '" . $rs->STATUS . "',
                    '" . $rs->S_CAT . "',
                    '" . $rs->PDM_GROUP . "',
                    '" . $rs->BRAND_P . "',
                    '" . $rs->REGISTER . "',
                    '" . $rs->OPT_TXT1 . "',
                    '" . $rs->CONDITION_SALE . "',
                    '" . $rs->WHOLE_SALE . "',
                    '" . $rs->GP . "',
                    '" . $rs->O_PRODUCT . "',
                    '" . $rs->BAR_PACK1 . "',
                    '" . $rs->BAR_PACK2 . "',
                    '" . $rs->BAR_PACK3 . "',
                    '" . $rs->BAR_PACK4 . "',
                    '" . $rs->PACK_SIZE1 . "',
                    '" . $rs->PACK_SIZE2 . "',
                    '" . $rs->PACK_SIZE3 . "',
                    '" . $rs->PACK_SIZE4 . "',
                    '" . $REG_DATE_RP . "',
                    '" . $rs->AGE . "',
                    '" . $rs->WIDTH . "',
                    '" . $rs->HEIGHT . "',
                    '" . $rs->WIDE . "',
                    '" . $rs->NAME_EXP . "',
                    '" . $rs->NET_WEIGHT . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                    '" . $rs->TYPE_G . "',
                    '" . $OPT_DATE1_RP . "',
                    '" . $OPT_DATE2_RP . "',
                    '" . $rs->OPT_TXT2 . "',
                    '" . $rs->OPT_NUM1 . "',
                    '" . $rs->OPT_NUM2 . "',
                    '" . $rs->ACC_TYPE . "',
                    '" . $ACC_DT_RP . "',
                    '" . $rs->RETURN . "',
                    '" . $rs->NON_VAT . "',
                    '" . $rs->STORAGE_TEMP . "',
                    '" . $rs->CONTROL_STK . "',
                    '" . $rs->TESTER . "',
                    '" . $rs->USER_EDIT . "',
                    '" . $rs->EDIT_DT . "'
                            )";
                    Http::asForm()->withHeaders([])->post($endpoint, [
                        'statement' => $sql,
                    ]);
                    $this->output->progressAdvance();
                } else
                    if ($dbName == 'dbLLMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {

                        $dataproduct = DB::table('product1s')
                            ->select('*')     
                            ->where('PRODUCT', '=', $rs->PRODUCT)  
                            ->first();

                        if($dataproduct){

                            $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                            $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                            $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                            $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                            $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                            $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                            $sql .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "',
                    '" . $rs->BARCODE . "',
                    '" . $rs->COLOR . "',
                    '" . $rs->GRP_P . "',
                    '" . $rs->SUPPLIER . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                    '" . $rs->VENDOR . "',
                    '" . $rs->PRICE . "',
                    '" . $rs->COST . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                    '" . $rs->UNIT_Q . "',
                    '" . $rs->SOLUTION . "',
                    '" . $rs->SERIES . "',
                    '" . $rs->CATEGORY . "',
                    '" . $rs->STATUS . "',
                    '" . $rs->S_CAT . "',
                    '" . $rs->PDM_GROUP . "',
                    '" . $rs->BRAND_P . "',
                    '" . $rs->REGISTER . "',
                    '" . $rs->OPT_TXT1 . "',
                    '" . $rs->CONDITION_SALE . "',
                    '" . $rs->WHOLE_SALE . "',
                    '" . $rs->GP . "',
                    '" . $rs->O_PRODUCT . "',
                    '" . $rs->BAR_PACK1 . "',
                    '" . $rs->BAR_PACK2 . "',
                    '" . $rs->BAR_PACK3 . "',
                    '" . $rs->BAR_PACK4 . "',
                    '" . $rs->PACK_SIZE1 . "',
                    '" . $rs->PACK_SIZE2 . "',
                    '" . $rs->PACK_SIZE3 . "',
                    '" . $rs->PACK_SIZE4 . "',
                    '" . $REG_DATE_RP . "',
                    '" . $rs->AGE . "',
                    '" . $rs->WIDTH . "',
                    '" . $rs->HEIGHT . "',
                    '" . $rs->WIDE . "',
                    '" . $rs->NAME_EXP . "',
                    '" . $rs->NET_WEIGHT . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                    '" . $rs->TYPE_G . "',
                    '" . $OPT_DATE1_RP . "',
                    '" . $OPT_DATE2_RP . "',
                    '" . $rs->OPT_TXT2 . "',
                    '" . $rs->OPT_NUM1 . "',
                    '" . $rs->OPT_NUM2 . "',
                    '" . $rs->ACC_TYPE . "',
                    '" . $ACC_DT_RP . "',
                    '" . $rs->RETURN . "',
                    '" . $rs->NON_VAT . "',
                    '" . $rs->STORAGE_TEMP . "',
                    '" . $rs->CONTROL_STK . "',
                    '" . $rs->TESTER . "',
                    '" . $rs->USER_EDIT . "',
                    '" . $rs->EDIT_DT . "'
                                )";
                        }
                        Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql,
                        ]);
                        $this->output->progressAdvance();
                    }
                if ($dbName == 'dbOPMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                    $brand_value = 'KM';
                    if ($rs->PRODUCT[0] == $key_parts_number_3 || ($rs->PRODUCT[0] == 1 && strlen((string)$rs->PRODUCT) == 7) || ($rs->PRODUCT[0] == 2 && strlen((string)$rs->PRODUCT) == 7)) {
                        $brand_value = $brand;
                    }

                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                    $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                    $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                    $sql .= "'" . $brand_value . "',
                                '" . $rs->PRODUCT . "',
                    '" . $rs->BARCODE . "',
                    '" . $rs->COLOR . "',
                    '" . $rs->GRP_P . "',
                    '" . $rs->SUPPLIER . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                    '" . $rs->VENDOR . "',
                    '" . $rs->PRICE . "',
                    '" . $rs->COST . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                    '" . $rs->UNIT_Q . "',
                    '" . $rs->SOLUTION . "',
                    '" . $rs->SERIES . "',
                    '" . $rs->CATEGORY . "',
                    '" . $rs->STATUS . "',
                    '" . $rs->S_CAT . "',
                    '" . $rs->PDM_GROUP . "',
                    '" . $rs->BRAND_P . "',
                    '" . $rs->REGISTER . "',
                    '" . $rs->OPT_TXT1 . "',
                    '" . $rs->CONDITION_SALE . "',
                    '" . $rs->WHOLE_SALE . "',
                    '" . $rs->GP . "',
                    '" . $rs->O_PRODUCT . "',
                    '" . $rs->BAR_PACK1 . "',
                    '" . $rs->BAR_PACK2 . "',
                    '" . $rs->BAR_PACK3 . "',
                    '" . $rs->BAR_PACK4 . "',
                    '" . $rs->PACK_SIZE1 . "',
                    '" . $rs->PACK_SIZE2 . "',
                    '" . $rs->PACK_SIZE3 . "',
                    '" . $rs->PACK_SIZE4 . "',
                    '" . $REG_DATE_RP . "',
                    '" . $rs->AGE . "',
                    '" . $rs->WIDTH . "',
                    '" . $rs->HEIGHT . "',
                    '" . $rs->WIDE . "',
                    '" . $rs->NAME_EXP . "',
                    '" . $rs->NET_WEIGHT . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                    '" . $rs->TYPE_G . "',
                    '" . $OPT_DATE1_RP . "',
                    '" . $OPT_DATE2_RP . "',
                    '" . $rs->OPT_TXT2 . "',
                    '" . $rs->OPT_NUM1 . "',
                    '" . $rs->OPT_NUM2 . "',
                    '" . $rs->ACC_TYPE . "',
                    '" . $ACC_DT_RP . "',
                    '" . $rs->RETURN . "',
                    '" . $rs->NON_VAT . "',
                    '" . $rs->STORAGE_TEMP . "',
                    '" . $rs->CONTROL_STK . "',
                    '" . $rs->TESTER . "',
                    '" . $rs->USER_EDIT . "',
                    '" . $rs->EDIT_DT . "'
                            )";
                    Http::asForm()->withHeaders([])->post($endpoint, [
                        'statement' => $sql,
                    ]);
                    $this->output->progressAdvance();
                } else
                    if ($dbName == 'dbOPMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {

                        $dataproduct = DB::table('product1s')
                        ->select('*')     
                        ->where('PRODUCT', '=', $rs->PRODUCT)  
                        ->first();
    
                        if($dataproduct){

                            $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                            $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                            $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                            $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                            $sql = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                            $sql .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                            $sql .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "',
                    '" . $rs->BARCODE . "',
                    '" . $rs->COLOR . "',
                    '" . $rs->GRP_P . "',
                    '" . $rs->SUPPLIER . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                    '" . $rs->VENDOR . "',
                    '" . $rs->PRICE . "',
                    '" . $rs->COST . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                    '" . $rs->UNIT_Q . "',
                    '" . $rs->SOLUTION . "',
                    '" . $rs->SERIES . "',
                    '" . $rs->CATEGORY . "',
                    '" . $rs->STATUS . "',
                    '" . $rs->S_CAT . "',
                    '" . $rs->PDM_GROUP . "',
                    '" . $rs->BRAND_P . "',
                    '" . $rs->REGISTER . "',
                    '" . $rs->OPT_TXT1 . "',
                    '" . $rs->CONDITION_SALE . "',
                    '" . $rs->WHOLE_SALE . "',
                    '" . $rs->GP . "',
                    '" . $rs->O_PRODUCT . "',
                    '" . $rs->BAR_PACK1 . "',
                    '" . $rs->BAR_PACK2 . "',
                    '" . $rs->BAR_PACK3 . "',
                    '" . $rs->BAR_PACK4 . "',
                    '" . $rs->PACK_SIZE1 . "',
                    '" . $rs->PACK_SIZE2 . "',
                    '" . $rs->PACK_SIZE3 . "',
                    '" . $rs->PACK_SIZE4 . "',
                    '" . $REG_DATE_RP . "',
                    '" . $rs->AGE . "',
                    '" . $rs->WIDTH . "',
                    '" . $rs->HEIGHT . "',
                    '" . $rs->WIDE . "',
                    '" . $rs->NAME_EXP . "',
                    '" . $rs->NET_WEIGHT . "',
                    N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                    '" . $rs->TYPE_G . "',
                    '" . $OPT_DATE1_RP . "',
                    '" . $OPT_DATE2_RP . "',
                    '" . $rs->OPT_TXT2 . "',
                    '" . $rs->OPT_NUM1 . "',
                    '" . $rs->OPT_NUM2 . "',
                    '" . $rs->ACC_TYPE . "',
                    '" . $ACC_DT_RP . "',
                    '" . $rs->RETURN . "',
                    '" . $rs->NON_VAT . "',
                    '" . $rs->STORAGE_TEMP . "',
                    '" . $rs->CONTROL_STK . "',
                    '" . $rs->TESTER . "',
                    '" . $rs->USER_EDIT . "',
                    '" . $rs->EDIT_DT . "'
                                )";
                        }
                        Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql,
                        ]);
                        $this->output->progressAdvance();
                    }
            }
        }
        $this->output->progressFinish();
    }

    public function tranfer_data_back_product2()
    {
        set_time_limit(0);
        $url_dot_30 = config('app.dot_30'); // Get URL from config
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";

        $test_database = [
            'dbBBMAS|BB' => ['NEW_PRODUCT1'],
            'dbCPMAS|CPS' => ['NEW_PRODUCT1'],
            'dbGNCMAS|GNC' => ['NEW_PRODUCT1'],
            'dbKSHOPMAS|KTY' => ['NEW_PRODUCT1'],
            'dbLLMAS|LL' => ['NEW_PRODUCT1'],
            'dbOPMAS|OP' => ['NEW_PRODUCT1']
        ];

        foreach ($test_database as $key => $value) {
            $exploded_key = explode('|', $key);
            $dbName = $exploded_key[0];
            $brand = $exploded_key[1];

            $this->info("Processing database back to product2: $dbName for brand: $brand");

            foreach ($value as $table_name) {
                $sql = "SELECT * FROM [$dbName].[dbo].[$table_name]";
                $response = Http::asForm()->post($endpoint, [
                    'statement' => $sql,
                ]);

                if ($response->failed() || !isset($response['result'])) {
                    $this->error("Failed to fetch data from $dbName - $table_name.");
                    continue;
                }

                $result = $response['result'];
                $diff_count = count($result);
                $this->info("🚀 Transferring $diff_count records from $table_name.");
                $this->output->progressStart($diff_count);

                foreach ($result as $rs) {
                    $brand_value = $brand;
                    $sql_product2 = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                    $sql_product2 .= "[BRAND], [PRODUCT]) VALUES (";
                    $sql_product2 .= "'" . $brand_value . "',
                                '" . $rs['PRODUCT'] . "'
                    )";

                    Http::asForm()->post($endpoint, [
                        'statement' => $sql_product2,
                        'params' => json_encode([$brand_value, $rs['PRODUCT']]),
                    ]);
                    $this->output->progressAdvance();
                }
                $this->output->progressFinish();
                $this->info("✅ Completed transfer for $table_name.");
            }
            $this->info("");
        }
        $this->info("All databases processed.");
    }

    public function tranfer_data_back_product1_des()
    {
        set_time_limit(0);
        $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";

        $test_database = [
            'dbBBMAS|BB' => ['NEW_PRODUCT1'],
            'dbCPMAS|CPS' => ['NEW_PRODUCT1'],
            'dbGNCMAS|GNC' => ['NEW_PRODUCT1'],
            'dbKSHOPMAS|KTY' => ['NEW_PRODUCT1'],
            'dbLLMAS|LL' => ['NEW_PRODUCT1'],
            'dbOPMAS|OP' => ['NEW_PRODUCT1']
        ];

        foreach ($test_database as $key => $value) {
            $exploded_key = explode('|', $key);
            $dbName = $exploded_key[0];
            $brand = $exploded_key[1];

            $this->info("Processing database back to product1_des: $dbName for brand: $brand");

            foreach ($value as $table_name) {
                $sql = "SELECT * FROM [$dbName].[dbo].[$table_name]";
                $response = Http::asForm()->post($endpoint, [
                    'statement' => $sql,
                ]);

                if ($response->failed() || !isset($response['result'])) {
                    $this->error("Failed to fetch data from $dbName - $table_name.");
                    continue;
                }

                $result = $response['result'];
                $diff_count = count($result);
                $this->info("🚀 Transferring $diff_count records from $table_name.");
                $this->output->progressStart($diff_count);

                foreach ($result as $rs) {
                    $brand_value = $brand;
                    $sql_product2 = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                    $sql_product2 .= "[BRAND], [PRODUCT]) VALUES (";
                    $sql_product2 .= "'" . $brand_value . "',
                                '" . $rs['PRODUCT'] . "'
                    )";

                    Http::asForm()->post($endpoint, [
                        'statement' => $sql_product2,
                        'params' => json_encode([$brand_value, $rs['PRODUCT']]),
                    ]);
                    $this->output->progressAdvance();
                }
                $this->output->progressFinish();
                $this->info("✅ Completed transfer for $table_name.");
            }
            $this->info("");
        }
        $this->info("All databases processed.");
    }

    function convertDateStrToDate($date_str)
    {
        $date = \Carbon\Carbon::createFromFormat('M d Y h:iA', $date_str)->format('Y-m-d');
        return $date;
    }
}
