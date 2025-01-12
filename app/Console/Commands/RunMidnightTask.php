<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RunMidnightTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-midnight-task {task}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    // public function handle()
    // {
    //     info('RunMidnightTask');

    //     set_time_limit(0);
    //     $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
    //     $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";
    //     $test_database = [
    //         'dbBBMAS|BB' => ['PRODUCT1'],
    //         'dbCPMAS|CPS' => ['PRODUCT1'],
    //         'dbGNCMAS|GNC' => ['PRODUCT1'],
    //         'dbKSHOPMAS|KTY' => ['PRODUCT1'],
    //         'dbLLMAS|LL' => ['PRODUCT1'],
    //         'dbOPMAS|OP' => ['PRODUCT1'],
    //     ];

    //     // dd($result);
    //     foreach ($test_database as $key => $value) {
    //         $exploded_key = explode('|', $key);
    //         $dbName = $exploded_key[0];
    //         $brand = $exploded_key[1];
    //         foreach ($value as $table_name) {
    //                 $sql_group = "SELECT Brand, COUNT(*) as KeyCount FROM $dbName.dbo.PRODUCT1 GROUP BY Brand";

    //             $group_data_origin = Http::asForm()->withHeaders([])->post($endpoint, [
    //                 'statement' => $sql_group,
    //             ]);

    //             $result1 = $group_data_origin['result'];
    //             $diff_count = array_sum(array_column($result1, 'KeyCount'));
    //             $this->info("$dbName - $table_name");
    //             $this->output->progressStart($diff_count);

    //             try {
    //                 if (!empty($result1)) {
    //                     foreach ($result1 as $gp) {
    //                             $sql = "SELECT *
    //                                     FROM $dbName.dbo.PRODUCT1 WHERE Brand = '" . $gp['Brand'] . "'";

    //                         $response_insert = Http::asForm()->withHeaders([])->post($endpoint, [
    //                             'statement' => $sql,
    //                         ]);


    //                         $result_data = $response_insert['result'];
    //                         // print_r($result_data);
    //                         // exit;
    //                         if ($table_name == 'PRODUCT1') {
    //                             foreach ($result_data as $rs) {
    //                                 DB::table('product1s_all')->insert([
    //                                     'BRAND_ORIGINAL' => $brand,
    //                                     'BRAND' => $rs['BRAND'],
    //                                     'PRODUCT' => $rs['PRODUCT'],
    //                                     'BARCODE' => $rs['BARCODE'],
    //                                     'COLOR' => $rs['COLOR'],
    //                                     'GRP_P' => $rs['GRP_P'],
    //                                     'SUPPLIER' => $rs['SUPPLIER'],
    //                                     'NAME_THAI' => $rs['NAME_THAI'],
    //                                     'NAME_ENG' => $rs['NAME_ENG'],
    //                                     'SHORT_THAI' => $rs['SHORT_THAI'],
    //                                     'SHORT_ENG' => $rs['SHORT_ENG'],
    //                                     'VENDOR' => $rs['VENDOR'],
    //                                     'PRICE' => $rs['PRICE'],
    //                                     'COST' => $rs['COST'],
    //                                     'UNIT' => $rs['UNIT'],
    //                                     'UNIT_Q' => $rs['UNIT_Q'],
    //                                     'SOLUTION' => $rs['SOLUTION'],
    //                                     'SERIES' => $rs['SERIES'],
    //                                     'CATEGORY' => $rs['CATEGORY'],
    //                                     'STATUS' => $rs['STATUS'],
    //                                     'S_CAT' => $rs['S_CAT'],
    //                                     'PDM_GROUP' => $rs['PDM_GROUP'],
    //                                     'BRAND_P' => $rs['BRAND_P'],
    //                                     'REGISTER' => $rs['REGISTER'],
    //                                     'OPT_TXT1' => $rs['OPT_TXT1'],
    //                                     'CONDITION_SALE' => $rs['CONDITION_SALE'],
    //                                     'WHOLE_SALE' => $rs['WHOLE_SALE'],
    //                                     'GP' => $rs['GP'],
    //                                     'O_PRODUCT' => $rs['O_PRODUCT'],
    //                                     'BAR_PACK1' => $rs['BAR_PACK1'],
    //                                     'BAR_PACK2' => $rs['BAR_PACK2'],
    //                                     'BAR_PACK3' => $rs['BAR_PACK3'],
    //                                     'BAR_PACK4' => $rs['BAR_PACK4'],
    //                                     'PACK_SIZE1' => $rs['PACK_SIZE1'],
    //                                     'PACK_SIZE2' => $rs['PACK_SIZE2'],
    //                                     'PACK_SIZE3' => $rs['PACK_SIZE3'],
    //                                     'PACK_SIZE4' => $rs['PACK_SIZE4'],
    //                                     'REG_DATE' => $this->convertDateStrToDate($rs['REG_DATE']),
    //                                     'AGE' => $rs['AGE'],
    //                                     'WIDTH' => $rs['WIDTH'],
    //                                     'HEIGHT' => $rs['HEIGHT'],
    //                                     'WIDE' => $rs['WIDE'],
    //                                     'NAME_EXP' => $rs['NAME_EXP'],
    //                                     'NET_WEIGHT' => $rs['NET_WEIGHT'],
    //                                     'UNIT_TYPE' => $rs['UNIT_TYPE'],
    //                                     'TYPE_G' => $rs['TYPE_G'],
    //                                     'OPT_DATE1' => $this->convertDateStrToDate($rs['OPT_DATE1']),
    //                                     'OPT_DATE2' => $this->convertDateStrToDate($rs['OPT_DATE2']),
    //                                     'OPT_TXT2' => $rs['OPT_TXT2'],
    //                                     'OPT_NUM1' => $rs['OPT_NUM1'],
    //                                     'OPT_NUM2' => $rs['OPT_NUM2'],
    //                                     'ACC_TYPE' => $rs['ACC_TYPE'],
    //                                     'ACC_DT' => $this->convertDateStrToDate($rs['ACC_DT']),
    //                                     'RETURN' => $rs['RETURN'],
    //                                     'NON_VAT' => $rs['NON_VAT'],
    //                                     'STORAGE_TEMP' => $rs['STORAGE_TEMP'],
    //                                     'CONTROL_STK' => $rs['CONTROL_STK'],
    //                                     'TESTER' => $rs['TESTER'],
    //                                     'USER_EDIT' => $rs['USER_EDIT'],
    //                                     'EDIT_DT' => $this->convertDateStrToDate($rs['EDIT_DT'])
    //                                 ]);
    //                                 $this->output->progressAdvance();
    //                             }
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

    // function convertDateStrToDate($date_str)
    // {
    //     $date = \Carbon\Carbon::createFromFormat('M d Y h:iA', $date_str)->format('Y-m-d');
    //     return $date;
    // }

    public function handle()
    {
        $task = $this->argument('task');

        try {
            switch ($task) {
                case 'transfer_data_task':
                    $this->transfer_data_task();
                    break;
                // case 'full_tranfer':
                //     $this->transfer_data_task();
                //     break;
                default:
                    $this->error('Unknown task. Available tasks: 🚀 full_tranfer, tranfer_data, pro_develops_all, products_all, products_clean, consumsbles_duplicate_to_product1s, tranfer_to_products_channels, product_category');
                    break;
            }
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }

    public function transfer_data_task()
    {
        set_time_limit(0);
        $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";

        $test_database = [
            'dbBBMAS|CPS|8|9|7' => ['NEW_PRODUCT1'],
            'dbCPMAS|OP|8|9|2' => ['NEW_PRODUCT1']
        ];

        // dd($test_database);
        $dataProducts1 = DB::table('product_channels')
            ->select('product1s.*', 'product_channels.BRAND', 'product_channels.PRODUCT')
            ->leftJoin('product1s', 'product_channels.PRODUCT', '=', 'product1s.PRODUCT')
            ->whereRaw( 'product_channels.PRODUCT NOT REGEXP "^[A-Z]"')
            ->get();

        // dd($dataProducts1);
        $check_junk_8 = [
            'title' => 8,
            'count' => DB::table('product_channels')
                ->select('product1s.*', 'product_channels.BRAND', 'product_channels.PRODUCT')
                ->leftJoin('product1s', 'product_channels.PRODUCT', '=', 'product1s.PRODUCT')
                ->whereRaw("product_channels.PRODUCT REGEXP '^[8]' AND LENGTH(product_channels.PRODUCT) = 7")
                ->count()
        ];

        // dd($check_junk_8);

        $check_junk_9 = [
            'title' => 9,
            'count' => DB::table('product_channels')
                ->select('product1s.*', 'product_channels.BRAND', 'product_channels.PRODUCT')
                ->leftJoin('product1s', 'product_channels.PRODUCT', '=', 'product1s.PRODUCT')
                ->whereRaw("product_channels.PRODUCT REGEXP '^[9]' AND LENGTH(product_channels.PRODUCT) = 7")
                ->count()
        ];
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
                if ($dbName == 'product1s' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                    $brand_value = 'KM';
                    if ($rs->PRODUCT[0] == $key_parts_number_3 || ($rs->PRODUCT[0] == 1 && strlen((string)$rs->PRODUCT) == 7) || ($rs->PRODUCT[0] == 2 && strlen((string)$rs->PRODUCT) == 7)) {
                        $brand_value = $brand;
                    } elseif ($rs->PRODUCT[0] == 1 && strlen($rs->PRODUCT) === 5) {
                        $brand_value = 'KM';
                    }

                    if (in_array($product = DB::table($value[0])->where('PRODUCT', $rs->PRODUCT)->first(), $dataProducts1->toArray())) {
                        $sql_update = "UPDATE [$dbName].[dbo].[$value[0]] ";
                        $sql_update .= "SET [BRAND] = '{$brand_value}', ";
                        $sql_update .= "[PRODUCT] = '{$product->PRODUCT}', ";
                        $sql_update .= "[BARCODE] = '{$product->BARCODE}', ";
                        $sql_update .= "[COLOR] = '{$product->COLOR}', ";
                        $sql_update .= "[GRP_P] = '{$product->GRP_P}', ";
                        $sql_update .= "[SUPPLIER] = '{$product->SUPPLIER}', ";
                        $sql_update .= "[NAME_THAI] = '{$product->NAME_THAI}', ";
                        $sql_update .= "[NAME_ENG] = '{$product->NAME_ENG}', ";
                        $sql_update .= "[SHORT_THAI] = '{$product->SHORT_THAI}', ";
                        $sql_update .= "[SHORT_ENG] = '{$product->SHORT_ENG}', ";
                        $sql_update .= "[VENDOR] = '{$product->VENDOR}', ";
                        $sql_update .= "[PRICE] = '{$product->PRICE}', ";
                        $sql_update .= "[COST] = '{$product->COST}', ";
                        $sql_update .= "[UNIT] = '{$product->UNIT}', ";
                        $sql_update .= "[UNIT_Q] = '{$product->UNIT_Q}', ";
                        $sql_update .= "[SOLUTION] = '{$product->SOLUTION}', ";
                        $sql_update .= "[SERIES] = '{$product->SERIES}', ";
                        $sql_update .= "[CATEGORY] = '{$product->CATEGORY}', ";
                        $sql_update .= "[STATUS] = '{$product->STATUS}', ";
                        $sql_update .= "[S_CAT] = '{$product->S_CAT}', ";
                        $sql_update .= "[PDM_GROUP] = '{$product->PDM_GROUP}', ";
                        $sql_update .= "[BRAND_P] = '{$product->BRAND_P}', ";
                        $sql_update .= "[REGISTER] = '{$product->REGISTER}', ";
                        $sql_update .= "[OPT_TXT1] = '{$product->OPT_TXT1}', ";
                        $sql_update .= "[CONDITION_SALE] = '{$product->CONDITION_SALE}', ";
                        $sql_update .= "[WHOLE_SALE] = '{$product->WHOLE_SALE}', ";
                        $sql_update .= "[GP] = '{$product->GP}', ";
                        $sql_update .= "[O_PRODUCT] = '{$product->O_PRODUCT}', ";
                        $sql_update .= "[BAR_PACK1] = '{$product->BAR_PACK1}', ";
                        $sql_update .= "[BAR_PACK2] = '{$product->BAR_PACK2}', ";
                        $sql_update .= "[BAR_PACK3] = '{$product->BAR_PACK3}', ";
                        $sql_update .= "[BAR_PACK4] = '{$product->BAR_PACK4}', ";
                        $sql_update .= "[PACK_SIZE1] = '{$product->PACK_SIZE1}', ";
                        $sql_update .= "[PACK_SIZE2] = '{$product->PACK_SIZE2}', ";
                        $sql_update .= "[PACK_SIZE3] = '{$product->PACK_SIZE3}', ";
                        $sql_update .= "[PACK_SIZE4] = '{$product->PACK_SIZE4}', ";
                        $sql_update .= "[REG_DATE] = '{$product->REG_DATE}', ";
                        $sql_update .= "[AGE] = '{$product->AGE}', ";
                        $sql_update .= "[WIDTH] = '{$product->WIDTH}', ";
                        $sql_update .= "[HEIGHT] = '{$product->HEIGHT}', ";
                        $sql_update .= "[WIDE] = '{$product->WIDE}', ";
                        $sql_update .= "[NAME_EXP] = '{$product->NAME_EXP}', ";
                        $sql_update .= "[BARCODE_EXP] = '{$product->BARCODE_EXP}', ";
                        $sql_update .= "[NET_WEIGHT] = '{$product->NET_WEIGHT}', ";
                        $sql_update .= "[UNIT_TYPE] = '{$product->UNIT_TYPE}', ";
                        $sql_update .= "[TYPE_G] = '{$product->TYPE_G}', ";
                        $sql_update .= "[OPT_DATE1] = '{$product->OPT_DATE1}', ";
                        $sql_update .= "[OPT_DATE2] = '{$product->OPT_DATE2}', ";
                        $sql_update .= "[OPT_TXT2] = '{$product->OPT_TXT2}', ";
                        $sql_update .= "[OPT_NUM1] = '{$product->OPT_NUM1}', ";
                        $sql_update .= "[OPT_NUM2] = '{$product->OPT_NUM2}', ";
                        $sql_update .= "[ACC_TYPE] = '{$product->ACC_TYPE}', ";
                        $sql_update .= "[ACC_DT] = '{$product->ACC_DT}', ";
                        $sql_update .= "[RETURN] = '{$product->RETURN}', ";
                        $sql_update .= "[NON_VAT] = '{$product->NON_VAT}', ";
                        $sql_update .= "[STORAGE_TEMP] = '{$product->STORAGE_TEMP}', ";
                        $sql_update .= "[CONTROL_STK] = '{$product->CONTROL_STK}', ";
                        $sql_update .= "[TESTER] = '{$product->TESTER}', ";
                        $sql_update .= "[USER_EDIT] = '{$product->USER_EDIT}', ";
                        $sql_update .= "[EDIT_DT] = '{$product->EDIT_DT}', ";
                        $sql_update .= "[STATUS_EDIT_DT] = '{$product->EDIT_DT}' ";
                        $sql_update .= "WHERE [PRODUCT] = '{$product->PRODUCT}';";

                        Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql_update
                        ]);
                        $this->output->progressAdvance();
                    } else if (!in_array($rs->PRODUCT, array_column($dataProducts1->toArray(), 'PRODUCT'))) {
                        $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0] (";
                        $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT], [STATUS_EDIT_DT]) VALUES (";
                        $sql_insert .= "'" . $brand_value . "',
                                    '" . $product->PRODUCT . "',
                                    '" . $product->BARCODE . "',
                                    '" . $product->COLOR . "',
                                    '" . $product->GRP_P . "',
                                    '" . $product->SUPPLIER . "',
                                    '" . $product->NAME_THAI . "',
                                    '" . $product->NAME_ENG . "',
                                    '" . $product->SHORT_THAI . "',
                                    '" . $product->SHORT_ENG . "',
                                    '" . $product->VENDOR . "',
                                    '" . $product->PRICE . "',
                                    '" . $product->COST . "',
                                    '" . $product->UNIT . "',
                                    '" . $product->UNIT_Q . "',
                                    '" . $product->SOLUTION . "',
                                    '" . $product->SERIES . "',
                                    '" . $product->CATEGORY . "',
                                    '" . $product->STATUS . "',
                                    '" . $product->S_CAT . "',
                                    '" . $product->PDM_GROUP . "',
                                    '" . $product->BRAND_P . "',
                                    '" . $product->REGISTER . "',
                                    '" . $product->OPT_TXT1 . "',
                                    '" . $product->CONDITION_SALE . "',
                                    '" . $product->WHOLE_SALE . "',
                                    '" . $product->GP . "',
                                    '" . $product->O_PRODUCT . "',
                                    '" . $product->BAR_PACK1 . "',
                                    '" . $product->BAR_PACK2 . "',
                                    '" . $product->BAR_PACK3 . "',
                                    '" . $product->BAR_PACK4 . "',
                                    '" . $product->PACK_SIZE1 . "',
                                    '" . $product->PACK_SIZE2 . "',
                                    '" . $product->PACK_SIZE3 . "',
                                    '" . $product->PACK_SIZE4 . "',
                                    '" . $product->REG_DATE . "',
                                    '" . $product->AGE . "',
                                    '" . $product->WIDTH . "',
                                    '" . $product->HEIGHT . "',
                                    '" . $product->WIDE . "',
                                    '" . $product->NAME_EXP . "',
                                    '" . $product->NET_WEIGHT . "',
                                    '" . $product->UNIT_TYPE . "',
                                    '" . $product->TYPE_G . "',
                                    '" . $product->OPT_DATE1 . "',
                                    '" . $product->OPT_DATE2 . "',
                                    '" . $product->OPT_TXT2 . "',
                                    '" . $product->OPT_NUM1 . "',
                                    '" . $product->OPT_NUM2 . "',
                                    '" . $product->ACC_TYPE . "',
                                    '" . $product->ACC_DT . "',
                                    '" . $product->RETURN . "',
                                    '" . $product->NON_VAT . "',
                                    '" . $product->STORAGE_TEMP . "',
                                    '" . $product->CONTROL_STK . "',
                                    '" . $product->TESTER . "',
                                    '" . $product->USER_EDIT . "',
                                    '" . $product->EDIT_DT . "',
                                    '" . $product->EDIT_DT . "'
                                )";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql_insert
                        ]);
                        $this->output->progressAdvance();
                    }
                } else if ($dbName == 'product1s' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND) {
                    if(($rs->PRODUCT[0] == $check_junk_8['title'] && ($check_junk_8['count'] > 1) && strlen((string)$rs->PRODUCT) > 7)){
                        $brand_value = 'KM';
                    }else if(($rs->PRODUCT[0] == $check_junk_9['title'] && ($check_junk_9['count'] > 1) && strlen((string)$rs->PRODUCT) > 7)){
                        $brand_value = 'KM';
                    }else{
                        $brand_value = ($rs->PRODUCT[0] == $key_parts_number_1 || $rs->PRODUCT[0] == $key_parts_number_2) ? $brand : null;
                    }

                    if (in_array($product = DB::table($value[0])->where('PRODUCT', $rs->PRODUCT)->first(), $dataProducts1->toArray())) {
                        $sql_update = "UPDATE [$dbName].[dbo].[$value[0]] ";
                        $sql_update .= "SET [BRAND] = '{$brand_value}', ";
                        $sql_update .= "[PRODUCT] = '{$product->PRODUCT}', ";
                        $sql_update .= "[BARCODE] = '{$product->BARCODE}', ";
                        $sql_update .= "[COLOR] = '{$product->COLOR}', ";
                        $sql_update .= "[GRP_P] = '{$product->GRP_P}', ";
                        $sql_update .= "[SUPPLIER] = '{$product->SUPPLIER}', ";
                        $sql_update .= "[NAME_THAI] = '{$product->NAME_THAI}', ";
                        $sql_update .= "[NAME_ENG] = '{$product->NAME_ENG}', ";
                        $sql_update .= "[SHORT_THAI] = '{$product->SHORT_THAI}', ";
                        $sql_update .= "[SHORT_ENG] = '{$product->SHORT_ENG}', ";
                        $sql_update .= "[VENDOR] = '{$product->VENDOR}', ";
                        $sql_update .= "[PRICE] = '{$product->PRICE}', ";
                        $sql_update .= "[COST] = '{$product->COST}', ";
                        $sql_update .= "[UNIT] = '{$product->UNIT}', ";
                        $sql_update .= "[UNIT_Q] = '{$product->UNIT_Q}', ";
                        $sql_update .= "[SOLUTION] = '{$product->SOLUTION}', ";
                        $sql_update .= "[SERIES] = '{$product->SERIES}', ";
                        $sql_update .= "[CATEGORY] = '{$product->CATEGORY}', ";
                        $sql_update .= "[STATUS] = '{$product->STATUS}', ";
                        $sql_update .= "[S_CAT] = '{$product->S_CAT}', ";
                        $sql_update .= "[PDM_GROUP] = '{$product->PDM_GROUP}', ";
                        $sql_update .= "[BRAND_P] = '{$product->BRAND_P}', ";
                        $sql_update .= "[REGISTER] = '{$product->REGISTER}', ";
                        $sql_update .= "[OPT_TXT1] = '{$product->OPT_TXT1}', ";
                        $sql_update .= "[CONDITION_SALE] = '{$product->CONDITION_SALE}', ";
                        $sql_update .= "[WHOLE_SALE] = '{$product->WHOLE_SALE}', ";
                        $sql_update .= "[GP] = '{$product->GP}', ";
                        $sql_update .= "[O_PRODUCT] = '{$product->O_PRODUCT}', ";
                        $sql_update .= "[BAR_PACK1] = '{$product->BAR_PACK1}', ";
                        $sql_update .= "[BAR_PACK2] = '{$product->BAR_PACK2}', ";
                        $sql_update .= "[BAR_PACK3] = '{$product->BAR_PACK3}', ";
                        $sql_update .= "[BAR_PACK4] = '{$product->BAR_PACK4}', ";
                        $sql_update .= "[PACK_SIZE1] = '{$product->PACK_SIZE1}', ";
                        $sql_update .= "[PACK_SIZE2] = '{$product->PACK_SIZE2}', ";
                        $sql_update .= "[PACK_SIZE3] = '{$product->PACK_SIZE3}', ";
                        $sql_update .= "[PACK_SIZE4] = '{$product->PACK_SIZE4}', ";
                        $sql_update .= "[REG_DATE] = '{$product->REG_DATE}', ";
                        $sql_update .= "[AGE] = '{$product->AGE}', ";
                        $sql_update .= "[WIDTH] = '{$product->WIDTH}', ";
                        $sql_update .= "[HEIGHT] = '{$product->HEIGHT}', ";
                        $sql_update .= "[WIDE] = '{$product->WIDE}', ";
                        $sql_update .= "[NAME_EXP] = '{$product->NAME_EXP}', ";
                        $sql_update .= "[BARCODE_EXP] = '{$product->BARCODE_EXP}', ";
                        $sql_update .= "[NET_WEIGHT] = '{$product->NET_WEIGHT}', ";
                        $sql_update .= "[UNIT_TYPE] = '{$product->UNIT_TYPE}', ";
                        $sql_update .= "[TYPE_G] = '{$product->TYPE_G}', ";
                        $sql_update .= "[OPT_DATE1] = '{$product->OPT_DATE1}', ";
                        $sql_update .= "[OPT_DATE2] = '{$product->OPT_DATE2}', ";
                        $sql_update .= "[OPT_TXT2] = '{$product->OPT_TXT2}', ";
                        $sql_update .= "[OPT_NUM1] = '{$product->OPT_NUM1}', ";
                        $sql_update .= "[OPT_NUM2] = '{$product->OPT_NUM2}', ";
                        $sql_update .= "[ACC_TYPE] = '{$product->ACC_TYPE}', ";
                        $sql_update .= "[ACC_DT] = '{$product->ACC_DT}', ";
                        $sql_update .= "[RETURN] = '{$product->RETURN}', ";
                        $sql_update .= "[NON_VAT] = '{$product->NON_VAT}', ";
                        $sql_update .= "[STORAGE_TEMP] = '{$product->STORAGE_TEMP}', ";
                        $sql_update .= "[CONTROL_STK] = '{$product->CONTROL_STK}', ";
                        $sql_update .= "[TESTER] = '{$product->TESTER}', ";
                        $sql_update .= "[USER_EDIT] = '{$product->USER_EDIT}', ";
                        $sql_update .= "[EDIT_DT] = '{$product->EDIT_DT}', ";
                        $sql_update .= "[STATUS_EDIT_DT] = '{$product->EDIT_DT}' ";
                        $sql_update .= "WHERE [PRODUCT] = '{$product->PRODUCT}';";

                        Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql_update
                        ]);
                        $this->output->progressAdvance();
                    } else if (!in_array($rs->PRODUCT, array_column($dataProducts1->toArray(), 'PRODUCT'))) {
                        $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0] (";
                        $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT], [STATUS_EDIT_DT]) VALUES (";
                        $sql_insert .= "'" . $brand_value . "',
                                    '" . $product->PRODUCT . "',
                                    '" . $product->BARCODE . "',
                                    '" . $product->COLOR . "',
                                    '" . $product->GRP_P . "',
                                    '" . $product->SUPPLIER . "',
                                    '" . $product->NAME_THAI . "',
                                    '" . $product->NAME_ENG . "',
                                    '" . $product->SHORT_THAI . "',
                                    '" . $product->SHORT_ENG . "',
                                    '" . $product->VENDOR . "',
                                    '" . $product->PRICE . "',
                                    '" . $product->COST . "',
                                    '" . $product->UNIT . "',
                                    '" . $product->UNIT_Q . "',
                                    '" . $product->SOLUTION . "',
                                    '" . $product->SERIES . "',
                                    '" . $product->CATEGORY . "',
                                    '" . $product->STATUS . "',
                                    '" . $product->S_CAT . "',
                                    '" . $product->PDM_GROUP . "',
                                    '" . $product->BRAND_P . "',
                                    '" . $product->REGISTER . "',
                                    '" . $product->OPT_TXT1 . "',
                                    '" . $product->CONDITION_SALE . "',
                                    '" . $product->WHOLE_SALE . "',
                                    '" . $product->GP . "',
                                    '" . $product->O_PRODUCT . "',
                                    '" . $product->BAR_PACK1 . "',
                                    '" . $product->BAR_PACK2 . "',
                                    '" . $product->BAR_PACK3 . "',
                                    '" . $product->BAR_PACK4 . "',
                                    '" . $product->PACK_SIZE1 . "',
                                    '" . $product->PACK_SIZE2 . "',
                                    '" . $product->PACK_SIZE3 . "',
                                    '" . $product->PACK_SIZE4 . "',
                                    '" . $product->REG_DATE . "',
                                    '" . $product->AGE . "',
                                    '" . $product->WIDTH . "',
                                    '" . $product->HEIGHT . "',
                                    '" . $product->WIDE . "',
                                    '" . $product->NAME_EXP . "',
                                    '" . $product->NET_WEIGHT . "',
                                    '" . $product->UNIT_TYPE . "',
                                    '" . $product->TYPE_G . "',
                                    '" . $product->OPT_DATE1 . "',
                                    '" . $product->OPT_DATE2 . "',
                                    '" . $product->OPT_TXT2 . "',
                                    '" . $product->OPT_NUM1 . "',
                                    '" . $product->OPT_NUM2 . "',
                                    '" . $product->ACC_TYPE . "',
                                    '" . $product->ACC_DT . "',
                                    '" . $product->RETURN . "',
                                    '" . $product->NON_VAT . "',
                                    '" . $product->STORAGE_TEMP . "',
                                    '" . $product->CONTROL_STK . "',
                                    '" . $product->TESTER . "',
                                    '" . $product->USER_EDIT . "',
                                    '" . $product->EDIT_DT . "',
                                    '" . $product->EDIT_DT . "'
                                )";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                            'statement' => $sql_insert
                        ]);
                        $this->output->progressAdvance();
                    }
                }
            }
        }
        $this->output->progressFinish();
        $this->info("✅ Completed transfer for product_channels.");
        $this->info("");
    }
}
