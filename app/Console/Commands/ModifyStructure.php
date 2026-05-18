<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ModifyStructure extends Command
{
    protected $signature = 'app:modify-structure {task}';
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $task = $this->argument('task');

        try {
            switch ($task) {
                case 'transfer_modify_structure_brand': $this->transfer_modify_structure_brand();
                    break;
                default: $this->error('Unknown task. Available tasks: transfer_modify_structure_brand');
                    break;
            }
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }

    public function transfer_modify_structure_brand()
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $this->info('Starting transfer: laravel_product_master.product1s → laravel_product_master_external.product1s');

        $total = DB::table('product1s')->count();
        $this->info("Source records: {$total}");

        try {
            DB::connection('mysql_external')->table('product1s')->truncate();
            $this->info('Destination table truncated.');
        } catch (\Exception $e) {
            $this->error('Truncate failed: ' . $e->getMessage());
            return;
        }

        DB::connection('mysql_external')->beginTransaction();

        $processed = 0;
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $firstRecord = DB::table('product1s')->orderBy('PRODUCT')->first();
        $this->info("Count: {$total}");
        // dd($firstRecord);

        DB::table('product1s')->orderBy('PRODUCT')->chunk(500, function ($rows) use (&$processed, $bar) {
            $insert = [];

            foreach ($rows as $data) {
                $code = (int) $data->PRODUCT;

                if (\strlen((string) $data->PRODUCT) === 5) {
                    if ($code >= 20000 && $code <= 28999) {
                        $brand = 'OP';
                    } elseif ($code >= 29000 && $code <= 29699) {
                        $brand = 'RE';
                    } elseif ($code >= 29700 && $code <= 29999) {
                        $brand = 'CM';
                    } elseif ($code >= 10000 && $code <= 14999) {
                        $brand = 'KTY';
                    } elseif ($code >= 15000 && $code <= 19999) {
                        $brand = 'FR';
                    } else {
                        $brand = $data->BRAND;
                    }
                } else {
                    $brand = $data->BRAND;
                }

                $insert[] = [
                    'brand'          => $brand,
                    'product'        => $data->PRODUCT,
                    'barcode'        => $data->BARCODE,
                    'color'          => $data->COLOR,
                    'grp_p'          => $data->GRP_P,
                    'supplier'       => $data->SUPPLIER,
                    'name_thai'      => $data->NAME_THAI,
                    'name_eng'       => $data->NAME_ENG,
                    'short_thai'     => $data->SHORT_THAI,
                    'short_eng'      => $data->SHORT_ENG,
                    'vendor'         => $data->VENDOR,
                    'price'          => $data->PRICE,
                    'cost'           => $data->COST,
                    'unit'           => $data->UNIT,
                    'unit_q'         => $data->UNIT_Q,
                    'solution'       => $data->SOLUTION,
                    'series'         => $data->SERIES,
                    'category'       => $data->CATEGORY,
                    'non_vat'        => $data->NON_VAT,
                    'status'         => $data->STATUS,
                    's_cat'          => $data->S_CAT,
                    'pdm_group'      => $data->PDM_GROUP,
                    'brand_p'        => $data->BRAND_P,
                    'register'       => $data->REGISTER,
                    'condition_sale' => $data->CONDITION_SALE,
                    'whole_sale'     => $data->WHOLE_SALE,
                    'gp'             => $data->GP,
                    'return'         => $data->RETURN,
                    'o_product'      => $data->O_PRODUCT,
                    'bar_pack1'      => $data->BAR_PACK1,
                    'bar_pack2'      => $data->BAR_PACK2,
                    'bar_pack3'      => $data->BAR_PACK3,
                    'bar_pack4'      => $data->BAR_PACK4,
                    'pack_size1'     => $data->PACK_SIZE1,
                    'pack_size2'     => $data->PACK_SIZE2,
                    'pack_size3'     => $data->PACK_SIZE3,
                    'pack_size4'     => $data->PACK_SIZE4,
                    'reg_date'       => $data->REG_DATE,
                    'age'            => $data->AGE,
                    'storage_temp'   => $data->STORAGE_TEMP,
                    'width'          => $data->WIDTH,
                    'height'         => $data->HEIGHT,
                    'wide'           => $data->WIDE,
                    'name_exp'       => $data->NAME_EXP,
                    'net_weight'     => $data->NET_WEIGHT,
                    'unit_type'      => $data->UNIT_TYPE,
                    'type_g'         => $data->TYPE_G,
                    'control_stk'    => $data->CONTROL_STK,
                    'tester'         => $data->TESTER,
                    'opt_date1'      => $data->OPT_DATE1,
                    'opt_date2'      => $data->OPT_DATE2,
                    'opt_txt1'       => $data->OPT_TXT1,
                    'opt_txt2'       => $data->OPT_TXT2,
                    'opt_num1'       => $data->OPT_NUM1,
                    'opt_num2'       => $data->OPT_NUM2,
                    'acc_type'       => $data->ACC_TYPE,
                    'acc_dt'         => $data->ACC_DT,
                    'user_edit'      => $data->USER_EDIT,
                    'edit_dt'        => $data->EDIT_DT,
                    'status_edit_dt' => $data->STATUS_EDIT_DT,
                ];

                $processed++;
            }

            try {
                DB::connection('mysql_external')->table('product1s')->insert($insert);
            } catch (\Exception $e) {
                DB::connection('mysql_external')->rollBack();
                $this->newLine();
                $this->error('Insert failed: ' . $e->getMessage());
                return false; // stop chunk
            }
            $bar->advance(count($rows));
        });

        $bar->finish();
        $this->newLine();

        DB::connection('mysql_external')->commit();
        $this->info("Transfer complete. Processed: {$processed} records.");
    }
}
