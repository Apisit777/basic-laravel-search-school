<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Task; 
use Carbon\Carbon;

class RunMidnightTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-midnight-task {task}';
    // protected $signature = 'app:run-midnight-task';

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
        $task = $this->argument('task');

        try {
            switch ($task) {
                case 'transfer_data_task':
                    $this->transfer_data_task();
                    break;
                default:
                    $this->error('Unknown task. Available tasks: 🚀 transfer_data_task');
                    break;
            }
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }

    // public function handle()
    public function transfer_data_task()
    {
        $now = now();
        $start = $now->copy()->setTime(18, 30); // 18:30
        $end = $now->copy()->setTime(20, 0);  // 20:00

        if (now()->isWeekday() === true && $now->between($start, $end)) {

            $incompleteTasks = Task::where('is_completed', false)
                ->whereDate('scheduled_date', Carbon::today()) // Only today's tasks
                ->get();

            if ($incompleteTasks->isEmpty()) {

                info('RunMidnightTask');
                set_time_limit(0);
                $url_dot_30 = config('app.dot_30');
                $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";

                $test_database = [
                    'dbBBMAS|BB|8|9|6' => ['NEW_PRODUCT1', 'NEW_PRODUCT2', 'NEW_PRODUCT1_DES'],
                    'dbCPMAS|CPS|8|9|7' => ['NEW_PRODUCT1', 'NEW_PRODUCT2', 'NEW_PRODUCT1_DES'],
                    'dbGNCMAS|GNC|8|9' => ['NEW_PRODUCT1', 'NEW_PRODUCT2', 'NEW_PRODUCT1_DES'],
                    'dbKSHOPMAS|KTY|8|9|1' => ['NEW_PRODUCT1', 'NEW_PRODUCT2', 'NEW_PRODUCT1_DES'],
                    'dbLLMAS|LL|8|9|3' => ['NEW_PRODUCT1', 'NEW_PRODUCT2', 'NEW_PRODUCT1_DES'],
                    'dbOPMAS|OP|8|9|2' => ['NEW_PRODUCT1', 'NEW_PRODUCT2', 'NEW_PRODUCT1_DES']
                ];

                $dataProducts1 = DB::table('product_channels')
                    ->select('product1s.*', 'product_channels.BRAND', 'product_channels.PRODUCT')
                    ->leftJoin('product1s', 'product_channels.PRODUCT', '=', 'product1s.PRODUCT')
                    ->whereRaw('product_channels.PRODUCT NOT REGEXP "^[A-Z]"')
                    ->get();

                $diff_count = count($dataProducts1);
                $this->info("Transferring product_channels data back to dot1");
                $this->output->progressStart($diff_count);

                foreach ($test_database as $key => $value) {
                    $exploded_key = explode('|', $key);
                    $dbName = $exploded_key[0];
                    $brand = $exploded_key[1];
                    $key_parts_number_1 = $exploded_key[2] ?? null;
                    $key_parts_number_2 = $exploded_key[3] ?? null;
                    $key_parts_number_3 = $exploded_key[4] ?? null;

                    $brand_value = $brand;
                    foreach ($dataProducts1 as $rs) {

                        if ($dbName == 'dbCPMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                            $brand_value = 'KM';
                            if ($rs->PRODUCT[0] == $key_parts_number_3 || ($rs->PRODUCT[0] == 1 && strlen((string)$rs->PRODUCT) == 7) || ($rs->PRODUCT[0] == 2 && strlen((string)$rs->PRODUCT) == 7)) {
                                $brand_value = $brand;
                            } else if ($rs->PRODUCT[0] == 0 && strlen($rs->PRODUCT) === 5) {
                                $brand_value = $brand;
                            } else if ($rs->PRODUCT[0] == 1 && strlen($rs->PRODUCT) === 5) {
                                $brand_value = 'KM';
                            }
                        
                            // dd($brand_value);
                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);
                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;
                        
                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();
                        
                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else {
                            //     print_r($rs);
                            // exit;
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;
                        
                                $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                ]);
                                $origin_data_product = json_decode($origin_data_product, true);
                        
                                if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                    $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                    $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                    $sql_insert .= "'" . $brand_value . "',
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
                                        'statement' => $sql_insert
                                    ]);
                                    $this->output->progressAdvance();
                                }
                        
                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";
                        
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);
                        
                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";
                        
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);
                        
                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }
                        } 
                        else 
                        // dd($brand);
                        // if ($dbName == 'dbCPMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string) $rs->PRODUCT) >= 7) {
                        if ($dbName == 'dbCPMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string) $rs->PRODUCT) >= 7) {
                            // dd ($brand);
                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);
                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                        
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;
                        
                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();
                        
                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else {
                                // dd ($brand);
                                $dataproduct = DB::table('product1s')
                                    ->select('*')
                                    ->where('PRODUCT', '=', $rs->PRODUCT)
                                    ->first();
                                if ($dataproduct) {
                                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;
                            
                                    $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                        'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                    ]);
                                    $origin_data_product = json_decode($origin_data_product, true);
                            
                                    if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                        $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                        $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                        $sql_insert .= "'" . $dataproduct->BRAND . "',
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
                                            'statement' => $sql_insert
                                        ]);
                                        $this->output->progressAdvance();
                                    }
                                }
                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";
                            
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);
                            
                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";
                            
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);
                            
                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }
                        }
                            // if ($dbName == 'dbCPMAS' && $rs->BRAND == $brand && $rs->PRODUCT[0] >= 8 && strlen((string) $rs->PRODUCT) >= 7) {
                            // if ($dbName == 'dbCPMAS' && $rs->PRODUCT[0] >= 8 && strlen((string) $rs->PRODUCT) >= 7) {
                            // print_r($rs->BRAND);
                            // exit;
                            // dd ($brand);
                            // dd ($rs->PRODUCT);

                        if ($dbName == 'dbBBMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                            $brand_value = 'KM';
                            if ($rs->PRODUCT[0] == $key_parts_number_3) {
                                $brand_value = $brand;
                            }

                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);

                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                ]);
                                $origin_data_product = json_decode($origin_data_product, true);

                                if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                    $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                    $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                    $sql_insert .= "'" . $brand_value . "',
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
                                        'statement' => $sql_insert
                                    ]);
                                    $this->output->progressAdvance();
                                }

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }       
                        } else if ($dbName == 'dbBBMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);

                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else if ($dbName == 'dbBBMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                                $dataproduct = DB::table('product1s')
                                    ->select('*')     
                                    ->where('PRODUCT', '=', $rs->PRODUCT)  
                                    ->first();
                                if($dataproduct) {
                                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                    $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                        'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                    ]);
                                    $origin_data_product = json_decode($origin_data_product, true);
            
                                    if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                        $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                        $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                        $sql_insert .= "'" . $dataproduct->BRAND . "',
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
                                            'statement' => $sql_insert
                                        ]); 
                                        $this->output->progressAdvance();
                                    }
                                }

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }  
                        }

                        if ($dbName == 'dbGNCMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                            $brand_value = 'KM';
                            if ($rs->PRODUCT[0] == $key_parts_number_3) {
                                $brand_value = $brand;
                            }
                            
                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);

                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                ]);
                                $origin_data_product = json_decode($origin_data_product, true);

                                if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                    $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                    $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                    $sql_insert .= "'" . $brand_value . "',
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
                                        'statement' => $sql_insert
                                    ]);
                                    $this->output->progressAdvance();
                                }

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }       
                        } else if ($dbName == 'dbGNCMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);

                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) { 
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else if ($dbName == 'dbGNCMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                                $dataproduct = DB::table('product1s')
                                    ->select('*')     
                                    ->where('PRODUCT', '=', $rs->PRODUCT)  
                                    ->first();
                                if($dataproduct) {
                                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                    $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                        'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                    ]);
                                    $origin_data_product = json_decode($origin_data_product, true);
            
                                    if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                        $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                        $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                        $sql_insert .= "'" . $dataproduct->BRAND . "',
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
                                            'statement' => $sql_insert
                                        ]);
                                        $this->output->progressAdvance();
                                    }
                                }

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }  
                        }
                        if ($dbName == 'dbKSHOPMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                            $brand_value = 'KM';
                            if ($rs->PRODUCT[0] == $key_parts_number_3 && strlen($rs->PRODUCT) === 5) {
                                $brand_value = 'KSHOP';
                            } else if ($rs->PRODUCT[0] == 1 && strlen($rs->PRODUCT) === 6) {
                                $brand_value = 'KM';
                            }

                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);

                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                ]);
                                $origin_data_product = json_decode($origin_data_product, true);

                                if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                    $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                    $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                    $sql_insert .= "'" . $brand_value . "',
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
                                        'statement' => $sql_insert
                                    ]);
                                    $this->output->progressAdvance();
                                }

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }       
                        } else if ($dbName == 'dbKSHOPMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);

                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else if ($dbName == 'dbKSHOPMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                                $dataproduct = DB::table('product1s')
                                    ->select('*')     
                                    ->where('PRODUCT', '=', $rs->PRODUCT)  
                                    ->first();
                                if($dataproduct) {
                                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                    $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                        'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                    ]);
                                    $origin_data_product = json_decode($origin_data_product, true);
            
                                    if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                        $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                        $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                        $sql_insert .= "'" . $dataproduct->BRAND . "',
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
                                            'statement' => $sql_insert
                                        ]);
                                        $this->output->progressAdvance();
                                    }
                                }

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }  
                        }
                        if ($dbName == 'dbLLMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                            $brand_value = 'KM';
                            if ($rs->PRODUCT[0] == $key_parts_number_3) {
                                $brand_value = $brand;
                            }

                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);

                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                ]);
                                $origin_data_product = json_decode($origin_data_product, true);

                                if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                    $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                    $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                    $sql_insert .= "'" . $brand_value . "',
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
                                        'statement' => $sql_insert
                                    ]);
                                    $this->output->progressAdvance();
                                }

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }       
                        } else if ($dbName == 'dbLLMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);

                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else if ($dbName == 'dbLLMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                                $dataproduct = DB::table('product1s')
                                    ->select('*')     
                                    ->where('PRODUCT', '=', $rs->PRODUCT)  
                                    ->first();
                                if($dataproduct) {
                                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                    $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                        'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                    ]);
                                    $origin_data_product = json_decode($origin_data_product, true);
            
                                    if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                        $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                        $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                        $sql_insert .= "'" . $dataproduct->BRAND . "',
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
                                            'statement' => $sql_insert
                                        ]);
                                        $this->output->progressAdvance();
                                    }
                                }

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }  
                        }
                        if ($dbName == 'dbOPMAS' && $brand == $rs->BRAND && $rs->PRODUCT[0] != $key_parts_number_1 && $rs->PRODUCT[0] != $key_parts_number_2) {
                            $brand_value = 'KM';
                            if ($rs->PRODUCT[0] == $key_parts_number_3 || ($rs->PRODUCT[0] == 1 && strlen((string)$rs->PRODUCT) == 7) || ($rs->PRODUCT[0] == 2 && strlen((string)$rs->PRODUCT) == 7)) {
                                $brand_value = $brand;
                            }

                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);

                            // dd($rs->BRAND);
                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);

                            } else {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                ]);
                                $origin_data_product = json_decode($origin_data_product, true);

                                if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                    $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                    $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                    $sql_insert .= "'" . $brand_value . "',
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
                                        'statement' => $sql_insert
                                    ]);
                                    $this->output->progressAdvance();
                                }

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $brand_value . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }       
                        } else if ($dbName == 'dbOPMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                            $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                            ]);
                            $origin_data_product = json_decode($origin_data_product, true);

                            // dd($rs->BRAND);
                            if ($rs->STATUS_EDIT_DT == '' && !empty($origin_data_product) == true) {
                                $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                $sql_update = "
                                    UPDATE [$dbName].[dbo].[$value[0]] SET
                                    [BRAND] = '{$brand_value}',
                                    [PRODUCT] = '{$rs->PRODUCT}',
                                    [BARCODE] = '{$rs->BARCODE}',
                                    [COLOR] = '{$rs->COLOR}',
                                    [GRP_P] = '{$rs->GRP_P}',
                                    [SUPPLIER] = '{$rs->SUPPLIER}',
                                    [NAME_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_THAI) . "',
                                    [NAME_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->NAME_ENG) . "',
                                    [SHORT_THAI] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_THAI) . "',
                                    [SHORT_ENG] = N'" . iconv('UTF-8', 'TIS-620', $rs->SHORT_ENG) . "',
                                    [VENDOR] = '{$rs->VENDOR}',
                                    [PRICE] = '{$rs->PRICE}',
                                    [COST] = '{$rs->COST}',
                                    [UNIT] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT) . "',
                                    [UNIT_Q] = '{$rs->UNIT_Q}',
                                    [SOLUTION] = '{$rs->SOLUTION}',
                                    [SERIES] = '{$rs->SERIES}',
                                    [CATEGORY] = '{$rs->CATEGORY}',
                                    [STATUS] = '{$rs->STATUS}',
                                    [S_CAT] = '{$rs->S_CAT}',
                                    [PDM_GROUP] = '{$rs->PDM_GROUP}',
                                    [BRAND_P] = '{$rs->BRAND_P}',
                                    [REGISTER] = '{$rs->REGISTER}',
                                    [OPT_TXT1] = '{$rs->OPT_TXT1}',
                                    [CONDITION_SALE] = '{$rs->CONDITION_SALE}',
                                    [WHOLE_SALE] = '{$rs->WHOLE_SALE}',
                                    [GP] = '{$rs->GP}',
                                    [O_PRODUCT] = '{$rs->O_PRODUCT}',
                                    [BAR_PACK1] = '{$rs->BAR_PACK1}',
                                    [BAR_PACK2] = '{$rs->BAR_PACK2}',
                                    [BAR_PACK3] = '{$rs->BAR_PACK3}',
                                    [BAR_PACK4] = '{$rs->BAR_PACK4}',
                                    [PACK_SIZE1] = '{$rs->PACK_SIZE1}',
                                    [PACK_SIZE2] = '{$rs->PACK_SIZE2}',
                                    [PACK_SIZE3] = '{$rs->PACK_SIZE3}',
                                    [PACK_SIZE4] = '{$rs->PACK_SIZE4}',
                                    [REG_DATE] = '{$REG_DATE_RP}',
                                    [AGE] = '{$rs->AGE}',
                                    [WIDTH] = '{$rs->WIDTH}',
                                    [HEIGHT] = '{$rs->HEIGHT}',
                                    [WIDE] = '{$rs->WIDE}',
                                    [NAME_EXP] = '{$rs->NAME_EXP}',
                                    [NET_WEIGHT] = '{$rs->NET_WEIGHT}',
                                    [UNIT_TYPE] = N'" . iconv('UTF-8', 'TIS-620', $rs->UNIT_TYPE) . "',
                                    [TYPE_G] = '{$rs->TYPE_G}',
                                    [OPT_DATE1] = '{$OPT_DATE1_RP}',
                                    [OPT_DATE2] =  '{$OPT_DATE2_RP}',
                                    [OPT_TXT2] = '{$rs->OPT_TXT2}',
                                    [OPT_NUM1] = '{$rs->OPT_NUM1}',
                                    [OPT_NUM2] = '{$rs->OPT_NUM2}',
                                    [ACC_TYPE] = '{$rs->ACC_TYPE}',
                                    [ACC_DT] = '{$ACC_DT_RP}',
                                    [RETURN] = '{$rs->RETURN}',
                                    [NON_VAT] = '{$rs->NON_VAT}',
                                    [STORAGE_TEMP] = '{$rs->STORAGE_TEMP}',
                                    [CONTROL_STK] = '{$rs->CONTROL_STK}',
                                    [TESTER] = '{$rs->TESTER}',
                                    [USER_EDIT] = '{$rs->USER_EDIT}',
                                    [EDIT_DT] = '{$rs->EDIT_DT}'
                                    WHERE [PRODUCT] = '{$rs->PRODUCT}';
                                ";
                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_update
                                ]);
                                $this->output->progressAdvance();

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            } else if ($dbName == 'dbOPMAS' && $rs->PRODUCT[0] >= 8 && $brand == $rs->BRAND && strlen((string)$rs->PRODUCT) >= 7) {
                                $dataproduct = DB::table('product1s')
                                    ->select('*')     
                                    ->where('PRODUCT', '=', $rs->PRODUCT)  
                                    ->first();
                                if($dataproduct) {
                                    $REG_DATE_RP = $rs->REG_DATE === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->REG_DATE;
                                    $OPT_DATE1_RP = $rs->OPT_DATE1 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE1;
                                    $OPT_DATE2_RP = $rs->OPT_DATE2 === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->OPT_DATE2;
                                    $ACC_DT_RP = $rs->ACC_DT === '0000-00-00 00:00:00' ? '1900-01-01 00:00:00' : $rs->ACC_DT;

                                    $origin_data_product = Http::asForm()->withHeaders([])->post($endpoint, [
                                        'statement' => 'select product from [' . $dbName . '].[dbo].[' . $value[0] . '] where product = ' . $rs->PRODUCT
                                    ]);
                                    $origin_data_product = json_decode($origin_data_product, true);
            
                                    if ($rs->STATUS_EDIT_DT == '' && empty($origin_data_product) == true) {
                                        $sql_insert = "INSERT INTO [$dbName].[dbo].[$value[0]] (";
                                        $sql_insert .= "[BRAND], [PRODUCT], [BARCODE], [COLOR], [GRP_P], [SUPPLIER], [NAME_THAI], [NAME_ENG], [SHORT_THAI], [SHORT_ENG], [VENDOR], [PRICE], [COST], [UNIT], [UNIT_Q], [SOLUTION], [SERIES], [CATEGORY], [STATUS], [S_CAT], [PDM_GROUP], [BRAND_P], [REGISTER], [OPT_TXT1], [CONDITION_SALE], [WHOLE_SALE], [GP], [O_PRODUCT], [BAR_PACK1], [BAR_PACK2], [BAR_PACK3], [BAR_PACK4], [PACK_SIZE1], [PACK_SIZE2], [PACK_SIZE3], [PACK_SIZE4], [REG_DATE], [AGE], [WIDTH], [HEIGHT], [WIDE], [NAME_EXP], [NET_WEIGHT], [UNIT_TYPE], [TYPE_G], [OPT_DATE1], [OPT_DATE2], [OPT_TXT2], [OPT_NUM1], [OPT_NUM2], [ACC_TYPE], [ACC_DT], [RETURN], [NON_VAT], [STORAGE_TEMP], [CONTROL_STK], [TESTER], [USER_EDIT], [EDIT_DT]) VALUES (";
                                        $sql_insert .= "'" . $dataproduct->BRAND . "',
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
                                            'statement' => $sql_insert
                                        ]);
                                        $this->output->progressAdvance();
                                    }
                                }

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT2] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $sql_insert = "INSERT INTO [$dbName].[dbo].[NEW_PRODUCT1_DES] (";
                                $sql_insert .= "[BRAND], [PRODUCT]) VALUES (";
                                $sql_insert .= "'" . $dataproduct->BRAND . "',
                                    '" . $rs->PRODUCT . "'
                                )";

                                Http::asForm()->withHeaders([])->post($endpoint, [
                                    'statement' => $sql_insert
                                ]);

                                $product1_STATUS_EDIT_DT = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->update([
                                    'EDIT_DT' => $rs->EDIT_DT,
                                    'STATUS_EDIT_DT' => $rs->EDIT_DT
                                ]);
                            }  
                        }
                    }
                }
                $Task = Task::create([
                    'task_name' => __FUNCTION__,
                    'is_completed' => true,
                    'scheduled_date' => Carbon::now(),
                    'completed_at' => Carbon::now()
                ]);
                $this->output->progressFinish();
            }
        } else {
            $task = Task::create([
                'task_name' => __METHOD__,
                'is_completed' => false,
                'scheduled_date' => Carbon::now(),
                'completed_at' => null, // Task ยังไม่เสร็จ
            ]);
            \Log::info('No incomplete tasks for today. Created Task ID: ' . $task->id);
        }
    }
}
