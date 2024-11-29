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
        set_time_limit(0);

        $dot1_db = config('app.odbc_dot1_db'); // ดึงค่า URL จาก config/app.php  
        $product_db = config('app.product_db'); // ดึงค่า URL จาก config/app.php
        $url_dot_30 = config('app.dot_30'); // ดึงค่า URL จาก config/app.php
        // $endpoint = $url_dot_30 . "/ims/joke/transfer_databased_30/transfer/dl_mid_query_dot1.php";
        $endpoint = $url_dot_30 . "/ims/dealer_transfer_service/dl_mid_query_dot1.php";
        // $sql_group = "select Brand,COUNT(*) as KeyCount from dbCPMAS.dbo.PRODUCT1 group by Brand";


        $test_database = [
            'dbCPMAS'=>['PRODUCT1','PRO_DEVELOP', 'CATEGORY'],
            'dbOPMAS'=>['PRODUCT1','PRO_DEVELOP'],
            'dbBBMAS'=>['PRODUCT1','PRO_DEVELOP'],
        ];



        foreach($test_database as $key => $value) {
            foreach($value as $table_name) {
                // $sql_group =  'select Brand,COUNT(*) as KeyCount from '.$key.'.dbo.'.$table_name.' group by Brand';
                $sql_group = "select Brand,COUNT(*) as KeyCount from '.$key.'.dbo.PRODUCT1 group by Brand";

        $group_data_origin = Http::asForm()->withHeaders([])->post($endpoint, [
            'statement' =>  $sql_group,
        ]);

        // print_r($group_data_origin['result']);
        //             exit;

        // $query = DB::connection($product_db)->table('com_product')->selectRaw('corporation_id, COUNT(*) as KeyCount')
        //     ->groupBy('corporation_id')
        //     ->havingRaw('COUNT(*) > 0')
        //     ->orderBy('corporation_id', 'asc')
        //     ->where('corporation_id', 'Ssup')
        //     ->get();


        $result1 = $group_data_origin['result'];
        // $result2 = json_decode($query, true);

        $diff_result = [];

        // foreach ($result1 as $r1) {
        //     $found = false;
        //     foreach ($result2 as $r2) {
        //         if (strtolower($r1['Brand']) == strtolower($r2['corporation_id'])) {
        //             $found = true;
        //             if ($r1['KeyCount'] > $r2['KeyCount']) {
        //                 $diff_result[] = $r1;
        //             }
        //             break;
        //         }
        //     }
        //     if (!$found) {
        //         $diff_result[] = $r1;
        //     }
        // }

        $diff_count = array();
        foreach ($result1 as $item){
            array_push($diff_count, $item['KeyCount']);
        }

        $diff_count = array_sum($diff_count);
        $this->output->progressStart($diff_count);

        try {
            // $group = $diff_result;
            $group = $result1;
            // print_r($group);
            // exit;
            if (!empty($group)) {
            foreach ($group as  $gp) {
                $sql = "select *, replace(convert(varchar,EDIT_DT,102),'.','-') as EDIT_DT_FORMAT from '.$key.'.dbo.PRODUCT1 where Brand = '" . $gp['Brand'] . "'";
                $response_insert = Http::asForm()->withHeaders([])->post($endpoint, [
                    'statement' =>  $sql,
                ]);
                $result_data = $response_insert['result'];

                foreach ($result_data as $rs) {
                    DB::table($table_name)->insert(
                        
                        [
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
                            'EDIT_DT' => $this->convertDateStrToDate($rs['EDIT_DT']),
                        ],
                    );
                    $this->output->progressAdvance();
                }

                /////////////////////////////////////////////////////////////////

                // foreach ($result_data as $rs) {
                //     DB::table('pro_develops')->insert(
                //         [
                //             'BRAND' => $request->input('BRAND'),
                //             'DOC_NO' => $request->input('DOC_NO'),
                //             'REF_DOC' => 'IBH-F155',
                //             'STATUS' => $request->input('STATUS'),
                //             'PRODUCT' => $digits_code,
                //             'BARCODE' => $digits_barcode,
                //             'JOB_REFNO' => $request->input('JOB_REFNO'),
                //             'DOC_DT' => $request->input('DOC_DT'),
                //             'CUST_OEM' => $request->input('CUST_OEM'),
                //             'NPD' => $request->input('NPD'),
                //             'PDM' => $request->input('PDM'),
                //             'NAME_ENG' => $request->input('NAME_ENG'),
                //             'CATEGORY' => $request->input('CATEGORY'),
                //             'CAPACITY' => $request->input('CAPACITY'),
                //             'Q_SMELL' => $request->input('Q_SMELL'),
                //             'Q_COLOR' => $request->input('Q_COLOR'),
                //             'TARGET_GRP' => $request->input('TARGET_GRP'),
                //             'TARGET_STK' => $request->input('TARGET_STK'),
                //             'PRICE_FG' => $request->input('PRICE_FG'),
                //             'PRICE_COST' => $request->input('PRICE_COST'),
                //             'PRICE_BULK' => $request->input('PRICE_BULK'),
                //             'FIRST_ORD' => $request->input('FIRST_ORD'),
                //             'P_CONCEPT' => $request->input('P_CONCEPT'),
                //             'P_BENEFIT' => $request->input('P_BENEFIT'),
                //             'TEXTURE' => $request->input('TEXTURE'),
                //             'TEXTURE_OT' => $request->input('TEXTURE_OT'),
                //             'COLOR1' => $request->input('COLOR1'),
                //             'FRANGRANCE' => $request->input('FRANGRANCE'),
                //             'INGREDIENT' => $request->input('INGREDIENT'),
                //             'STD' => $request->input('STD'),
                //             'PK' => $request->input('PK'),
                //             'OTHER' => $request->input('OTHER'),
                //             'DOCUMENT' => $request->input('DOCUMENT'),
                //             'OEM' => is_null($request->input('OEM')) ? 'N' : 'Y',
                //             'REASON1' => is_null($request->input('REASON1')) ? 'N' : 'Y',
                //             'REASON1_DES' => $request->input('REASON1_DES'),
                //             'REASON2' => is_null($request->input('REASON2')) ? 'N' : 'Y',
                //             'REASON2_DES' => $request->input('REASON2_DES'),
                //             'REASON3' => is_null($request->input('REASON3')) ? 'N' : 'Y',
                //             'REASON3_DES' => $request->input('REASON3_DES'),
                //             'PACKAGE_BOX' => is_null($request->input('PACKAGE_BOX')) ? 'N' : 'Y',
                //             'REF_COLOR' => $request->input('REF_COLOR'),
                //             'REF_FRAGRANCE' => $request->input('REF_FRAGRANCE'),
                //             'OEM_STD' => $request->input('OEM_STD'),
                //             'USER_EDIT' => Auth::user()->username,
                //             'EDIT_DT' => date("Y/m/d H:i:s")
                //         ],
                //     );
                //     $this->output->progressAdvance();
                // }
            }
        }
                

        } catch (\Exception $e) {

            // Log::channel('transfer_product')->error('เกิดข้อผิดพลาดระหว่างโอนข้อมูลสินค้า', [
            //     'error' => $e->getMessage(),
            //     'function' => __FUNCTION__
            // ]);
            // return response()->json([
            //     'status' => 'error',
            //     'message' => $e->getMessage()
            // ]);
        }

        // return response()->json([
        //     'status' => 'insert success',
        // ]);
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
