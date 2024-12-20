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
                case 'products_all':
                    $this->tranfer_products_all();
                    break;
                case 'products_clean':
                    $this->tranfer_products_clean();
                    break;
                case 'product1s_clean_to_products_channels':
                    $this->tranfer_product1s_clean_to_products_channels();
                    break;
                case 'product_category':
                    $this->tranfer_product_category();
                    break;
                case 'full_tranfer':
                    $this->tranfer_data();
                    $this->tranfer_products_all();
                    $this->tranfer_products_clean();
                    $this->tranfer_product1s_clean_to_products_channels();
                    $this->tranfer_product_category();
                    break;
                default:
                    $this->error('Unknown task. Available tasks: full_tranfer, tranfer_data, products_all, products_clean, products_all_to_products_channels');
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

    private function tranfer_products_all()
    {
        try {
            $productsAll = DB::table('product1s_all')
                ->where(function ($query) {
                    $query->where('BRAND_ORIGINAL', 'OP')
                        ->where(function ($subQuery) {
                            $subQuery->where(function ($innerQuery) {
                                $innerQuery->where('PRODUCT', 'REGEXP', '^[2]')
                                        ->whereRaw('LENGTH(PRODUCT) = 5');
                            })->orWhere(function ($innerQuery) {
                                $innerQuery->where('PRODUCT', 'REGEXP', '^[1]')
                                        ->whereRaw('LENGTH(PRODUCT) = 7');
                            });
                        });
                    $query->orWhere(function ($subQuery) {
                        $subQuery->where('BRAND_ORIGINAL', 'CPS')
                            ->where(function ($innerQuery) {
                                $innerQuery->where(function ($deepQuery) {
                                    $deepQuery->where('PRODUCT', 'REGEXP', '^[3]')
                                            ->whereRaw('LENGTH(PRODUCT) = 5');
                                })->orWhere(function ($deepQuery) {
                                    $deepQuery->where('PRODUCT', 'REGEXP', '^[7]')
                                            ->whereRaw('LENGTH(PRODUCT) = 5');
                                })->orWhere(function ($deepQuery) {
                                    $deepQuery->where('PRODUCT', 'REGEXP', '^[1]')
                                            ->whereRaw('LENGTH(PRODUCT) = 7');
                                });
                            });
                    });
                    $query->orWhere(function ($subQuery) {
                        $subQuery->where('BRAND_ORIGINAL', 'GNC')
                            ->where(function ($innerQuery) {
                                $innerQuery->whereRaw('LENGTH(PRODUCT) = 6')
                                        ->orWhere(function ($deepQuery) {
                                            $deepQuery->whereRaw('LENGTH(PRODUCT) = 10')
                                                        ->where('barcode', '!=', 'CANCEL');
                                        });
                            });
                    });
                    $query->orWhere(function ($subQuery) {
                        $subQuery->where('BRAND_ORIGINAL', 'BB')
                            ->where('PRODUCT', 'REGEXP', '^[6]')
                            ->whereRaw('LENGTH(PRODUCT) = 5');
                    });
                    $query->orWhere(function ($subQuery) {
                        $subQuery->where('BRAND_ORIGINAL', 'LL')
                            ->where('PRODUCT', 'REGEXP', '^[3]')
                            ->whereRaw('LENGTH(PRODUCT) = 5');
                    });
                    $query->orWhere(function ($subQuery) {
                        $subQuery->where('BRAND_ORIGINAL', 'KTY')
                            ->where('PRODUCT', 'REGEXP', '^[1]')
                            ->whereRaw('LENGTH(PRODUCT) = 5');
                    });
                })
                ->orderBy('PRODUCT', 'ASC')
                ->get();

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
                ]);
                $this->output->progressAdvance();
            }
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
        $this->output->progressFinish();
    }

    private function tranfer_product1s_clean_to_products_channels()
    {
        try {
                $productCleans  = DB::table('product1s_all')->get();
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
    
    public function tranfer_product_category()
    {
        set_time_limit(0);
        $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";
        $test_database = [
            'dbBBMAS|BB'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
            'dbCPMAS|CPS'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
            'dbGNCMAS|GNC'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
            'dbKSHOPMAS|KTY'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
            'dbLLMAS|LL'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
            'dbOPMAS|OP'=>['SOLUTION', 'CATEGORY', 'SERIES', 'SUB_CATEGORY', 'PDM'],
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
                                    'BRAND' => $brand
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
                                    'BRAND' => $brand
                                ]);
                                $this->output->progressAdvance();
                            }
                        }
                        if ($table_name == 'SERIES') {
                            foreach ($result_data as $rs) {
                                DB::table('series')->insert([
                                    'ID' => $rs['ID'],
                                    'DESCRIPTION' => $rs['DESCRIPTION'],
                                    'BRAND' => $brand
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
                                    'BRAND' => $brand
                                ]);
                                $this->output->progressAdvance();
                            }
                        }
                        if ($table_name == 'PDM') {
                            foreach ($result_data as $rs) {
                                DB::table('pdms')->insert([
                                    'ID' => $rs['ID'],
                                    'REMARK' => $rs['REMARK'],
                                    'BRAND' => $brand
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

    function convertDateStrToDate($date_str)
    {
        $date = \Carbon\Carbon::createFromFormat('M d Y h:iA', $date_str)->format('Y-m-d');
        return $date;
    }
}