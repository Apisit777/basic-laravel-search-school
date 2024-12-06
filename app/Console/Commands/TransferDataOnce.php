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
    protected $signature = 'app:transfer-data-once';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
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
        
        set_time_limit(0);
        $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";
        $test_database = [
            'dbBBMAS|BB'=>['PRODUCT1', 'PRO_DEVELOP'],
            'dbCPMAS|CPS'=>['PRODUCT1', 'PRO_DEVELOP'],
            'dbGNCMAS|GNC'=>['PRODUCT1'],
            'dbKSHOPMAS|KTY'=>['PRODUCT1', 'PRO_DEVELOP'],
            'dbLLMAS|LL'=>['PRODUCT1', 'PRO_DEVELOP'],
            'dbOPMAS|OP'=>['PRODUCT1', 'PRO_DEVELOP'],
        ];

        // dd($result);
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
                                    // DB::table('product1s_all')->insert([
                                    DB::table('product1s')->insert([
                                        // 'BRAND_ORIGINAL' => $brand,
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
                                    // DB::table('pro_develops_all')->insert([
                                    DB::table('pro_develops')->insert([
                                        // 'BRAND_ORIGINAL' => $brand,
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

        // set_time_limit(0);
        // $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        // $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";
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
    }

    function convertDateStrToDate($date_str)
    {
        $date = \Carbon\Carbon::createFromFormat('M d Y h:iA', $date_str)->format('Y-m-d');
        return $date;
    }
}