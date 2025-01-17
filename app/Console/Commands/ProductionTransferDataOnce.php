<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductionTransferDataOnce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:production-transfer-data-once {task}';

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
                case 'production_tranfer_data':
                    $this->production_tranfer_data();
                    break;
                case 'production_tranfer_pro_develops_all':
                    $this->production_tranfer_pro_develops_all();
                    break;
                case 'production_tranfer_products_all':
                    $this->production_tranfer_products_all();
                    break;
                case 'production_tranfer_products_clean':
                    $this->production_tranfer_products_clean();
                    break;
                case 'production_tranfer_consumsbles_duplicate_to_product1s':
                    $this->production_tranfer_consumsbles_duplicate_to_product1s();
                    break;
                case 'production_tranfer_to_products_channels':
                    $this->production_tranfer_to_products_channels();
                    break;
                case 'production_tranfer_product_category':
                    $this->production_tranfer_product_category();
                    break;
                case 'production_tranfer_data_back':
                    $this->production_tranfer_data_back();
                    break;
                case 'production_tranfer_data_back_product2':
                    $this->production_tranfer_data_back_product2();
                    break;
                case 'production_tranfer_data_back_product1_des':
                    $this->production_tranfer_data_back_product1_des();
                    break;
                // case 'full_tranfer':
                //     $this->production_tranfer_data();
                //     $this->production_tranfer_pro_develops_all();
                //     $this->production_tranfer_products_all();
                //     $this->production_tranfer_products_clean();
                //     $this->production_tranfer_consumsbles_duplicate_to_product1s();
                //     $this->production_tranfer_to_products_channels();
                //     $this->production_tranfer_product_category();
                //     $this->production_tranfer_data_back_product2();
                //     $this->production_tranfer_data_back_product1_des();
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
    public function production_tranfer_data()
    {
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

    private function production_tranfer_pro_develops_all()
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
    private function production_tranfer_products_all()
    {
        try {
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
                                                    WHERE BRAND_ORIGINAL IN  ('CPS','OP','BB','LL','GNC','KTY') AND (PRODUCT REGEXP '^[8-9]') AND LENGTH(PRODUCT) = 7 AND BARCODE not REGEXP '^[A-Z]'
                                                    GROUP BY PRODUCT
                                                    HAVING COUNT(*) = 1) AS data GROUP BY data.product

                                                ");

            $diff_count = count($productsAll);
            $this->info("Transferring data from 'product1s_all' to 'product1s_clean'");
            $this->output->progressStart($diff_count);

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

    private function production_tranfer_products_clean()
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

    private function production_tranfer_to_products_channels()
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

    private function production_tranfer_consumsbles_duplicate_to_product1s()
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

    public function production_tranfer_product_category()
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

    public function production_tranfer_data_back()
    {
        set_time_limit(0);
        $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";

        $test_database = [
            'dbBBMAS|BB|8|9|6' => ['PRODUCT1'],
            'dbCPMAS|CPS|8|9|7' => ['PRODUCT1'],
            'dbGNCMAS|GNC|8|9' => ['PRODUCT1'],
            'dbKSHOPMAS|KTY|8|9|1' => ['PRODUCT1'],
            'dbLLMAS|LL|8|9|3' => ['PRODUCT1'],
            'dbOPMAS|OP|8|9|2' => ['PRODUCT1']
        ];

        $dataProducts1 = DB::table('product_channels')
            ->select('product1s.*', 'product_channels.BRAND', 'product_channels.PRODUCT')
            ->leftJoin('product1s', 'product_channels.PRODUCT', '=', 'product1s.PRODUCT')
            ->whereRaw( 'product_channels.PRODUCT NOT REGEXP "^[A-Z]"')
            ->get();

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

    public function production_tranfer_data_back_product2()
    {
        set_time_limit(0);
        $url_dot_30 = config('app.dot_30'); // Get URL from config
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";

        $test_database = [
            'dbBBMAS|BB' => ['PRODUCT1'],
            'dbCPMAS|CPS' => ['PRODUCT1'],
            'dbGNCMAS|GNC' => ['PRODUCT1'],
            'dbKSHOPMAS|KTY' => ['PRODUCT1'],
            'dbLLMAS|LL' => ['PRODUCT1'],
            'dbOPMAS|OP' => ['PRODUCT1']
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
                    $sql_product2 = "INSERT INTO [$dbName].[dbo].[PRODUCT2] (";
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
            'dbBBMAS|BB' => ['PRODUCT1'],
            'dbCPMAS|CPS' => ['PRODUCT1'],
            'dbGNCMAS|GNC' => ['PRODUCT1'],
            'dbKSHOPMAS|KTY' => ['PRODUCT1'],
            'dbLLMAS|LL' => ['PRODUCT1'],
            'dbOPMAS|OP' => ['PRODUCT1']
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
                    $sql_product2 = "INSERT INTO [$dbName].[dbo].[PRODUCT1_DES] (";
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