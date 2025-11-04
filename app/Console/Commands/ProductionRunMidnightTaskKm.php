<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Task; 
use App\Models\TaskKm; 
use App\Models\ComProduct; 
use App\Models\ComProductExternal; 
use Carbon\Carbon;

class ProductionRunMidnightTaskKm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:production-run-midnight-task-km {task}';
    // protected $signature = 'app:production-run-midnight-task';

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
                case 'production_transfer_data_task_km':
                    $this->production_transfer_data_task_km();
                    break;
                case 'tranfer_details_to_others':
                    $this->tranfer_details_to_others();
                    break;
                case 'tranfer_product1s_to_details_others':
                    $this->tranfer_product1s_to_details_others();
                    break;
                case 'tranfer_product1s_GNC_to_com_products':
                    $this->tranfer_product1s_GNC_to_com_products();
                    break;
                default:
                    $this->error('Unknown task. Available tasks: 🚀 production_transfer_data_task_km, tranfer_details_to_others, tranfer_product1s_to_details_others');
                    break;
            }
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }

    // public function handle()
    public function production_transfer_data_task_km()
    {
        // UPDATE com_products SET status_tranfer_km = NULL;

        // SELECT product_id, update_dt FROM `com_products` ORDER BY `com_products`.`update_dt` DESC;
        // SELECT product_id, status_tranfer_km FROM `com_products` ORDER BY `com_products`.`product_id` ASC
        // SELECT c.product_id, c.company_id FROM com_products c LEFT JOIN product1s p ON c.product_id = p.PRODUCT WHERE c.company_id = 'CPS' AND p.PRODUCT IS NULL;
        // SELECT * FROM product1s_all WHERE BRAND_ORIGINAL = 'CPS' AND PRODUCT NOT REGEXP '^[A-Z]' ORDER BY PRODUCT ASC;
        
        // SELECT * FROM com_products WHERE product_id LIKE '98_____' AND LENGTH(product_id) = 7 -- ตรวจสอบความยาวให้เป็น 7 หลัก ORDER BY product_id ASC;
        // SELECT * FROM product1s WHERE BRAND = 'CPS' AND CAST(PRODUCT AS UNSIGNED) BETWEEN 9800010 AND 9800099 ORDER BY CAST(PRODUCT AS UNSIGNED) ASC;
        
        // 27298
        // CPS
        // 00d839
        // 2025-03-05 09:18:49

        $now   = now();
        $start = $now->copy()->setTime(8, 30);
        $end   = $now->copy()->setTime(20, 30);

        if (!($now->isWeekday() && $now->between($start, $end))) {
            return;
        }

        $incompleteTasks = TaskKm::where('is_completed', true)
        ->whereDate('scheduled_date', today())
        ->get();

        if (!$incompleteTasks->isEmpty()) {
            TaskKm::updateOrCreate(
                ['task_name' => __FUNCTION__, 'scheduled_date' => today()],
                ['is_completed' => false, 'completed_at' => null]
            );
            Log::info('No incomplete tasks for today.');
            return;
        }

        // เตรียม task (เริ่มงาน)
        $task = TaskKm::updateOrCreate(
            ['task_name' => __FUNCTION__, 'scheduled_date' => today()],
            ['is_completed' => false, 'start_time' => $now->format('H:i:s')]
        );

        // นับ total ให้ตรงกับเงื่อนไขจริง
        $total = ComProduct::where(function ($q) {
                $q->where('status_tranfer_km', '')
                ->orWhereNull('status_tranfer_km');
            })
            ->count();
        $this->info("Transfer $total rows from product master → external");
        $this->output->progressStart($total);

        $ok = false;           // จะตั้ง true หลัง commit สำเร็จทั้ง 2 ฝั่ง
        $ins = 0; $upd = 0; $fail = 0;
        // dd($total);

        try {
            DB::connection('mysql')->beginTransaction();
            DB::connection('mysql_external')->beginTransaction();

            ComProduct::where(function ($q) {
                    $q->where('status_tranfer_km', '')
                    ->orWhereNull('status_tranfer_km');
                })
                ->orderBy('product_id') // ใช้คีย์ที่มี index
                ->chunkById(1000, function ($rows) use (&$ins, &$upd, &$fail) {
                    foreach ($rows as $rs) {
                        try {
                            // upsert ปลายทาง
                            // เงื่อนไขตรวจซ้ำ: ใช้คีย์ตามที่ “ต้องไม่ซ้ำ”
                            $model = ComProductExternal::updateOrCreate(
                                [
                                    'corporation_id'      => $rs->corporation_id,
                                    'company_id'          => $rs->company_id,
                                    'product_id'          => (string) $rs->product_id,
                                ],
                                [
                                    'barcode'             => $rs->barcode,
                                    'ref_barcode_real'    => $rs->ref_barcode_real,
                                    'vendor_id'           => $rs->vendor_id,
                                    'name_thai'           => $rs->name_thai,
                                    'name_eng'            => $rs->name_eng,
                                    'short_thai'          => $rs->short_thai,
                                    'short_eng'           => $rs->short_eng,
                                    'price'               => $rs->price,
                                    'cost'                => $rs->cost,
                                    'unit_id'             => $rs->unit_id,
                                    'currency_id'         => $rs->currency_id,
                                    'capacity_id'         => $rs->capacity_id,
                                    'capacity'            => $rs->capacity,
                                    'non_vat'             => $rs->non_vat,
                                    'status'              => $rs->status,
                                    'warrant_no'          => $rs->warrant_no,
                                    'gp'                  => $rs->gp,
                                    'return'              => $rs->return,
                                    'o_product'           => $rs->o_product,
                                    'shelf_life'          => $rs->shelf_life,
                                    'storage_temp'        => $rs->storage_temp,
                                    'size_id'             => $rs->size_id,
                                    'width'               => $rs->width,
                                    'long'                => $rs->long,
                                    'height'              => $rs->height,
                                    'weight_id'           => $rs->weight_id,
                                    'weight'              => $rs->weight,
                                    'control_stk'         => $rs->control_stk,
                                    'make_buy'            => $rs->make_buy,
                                    'safety_stock'        => $rs->safety_stock,
                                    'lot_size_min'        => $rs->lot_size_min,
                                    'lot_size_multi'      => $rs->lot_size_multi,
                                    'buyer_id'            => $rs->buyer_id,
                                    'planner_id'          => $rs->planner_id,
                                    'lead_time_po'        => $rs->lead_time_po,
                                    'lead_time_pn'        => $rs->lead_time_pn,
                                    'lead_time_inspec'    => $rs->lead_time_inspec,
                                    'acc_type'            => $rs->acc_type,
                                    'acc_date'            => $rs->acc_date,
                                    'acc_time'            => $rs->acc_time,
                                    'acc_user'            => $rs->acc_user,
                                    'reg_date'            => $rs->reg_date,
                                    'reg_time'            => $rs->reg_time,
                                    'reg_user'            => $rs->reg_user,
                                    'upd_date'            => $rs->upd_date,
                                    'upd_time'            => $rs->upd_time,
                                    'upd_user'            => $rs->upd_user,
                                    'lock'                => $rs->lock,
                                    'area'                => $rs->area,
                                    'pick_qty'            => $rs->pick_qty,
                                    'pick_type'           => $rs->pick_type,
                                    'qty_pick'            => $rs->qty_pick,
                                    'box_qty'             => $rs->box_qty,
                                    'pallet_qty'          => $rs->pallet_qty,
                                    'group'               => $rs->group,
                                    'name_export'         => $rs->name_export,
                                    'series'              => $rs->series,
                                    'solution'            => $rs->solution,
                                    'category'            => $rs->category,
                                    'group2'              => $rs->group2,
                                    'net_weight'          => $rs->net_weight,
                                    'check'               => $rs->check,
                                    'duplicate'           => $rs->duplicate,
                                    'active_sta'          => $rs->active_sta,
                                    'product_status'      => $rs->product_status,
                                    'height_old'          => $rs->height_old,
                                    'time_stamp'          => $rs->time_stamp,
                                    'run_newsize'         => $rs->run_newsize,
                                    'height_edit'         => $rs->height_edit,
                                    'area_edit'           => $rs->area_edit,
                                    'box_pallet'          => $rs->box_pallet,
                                    'img_url'             => $rs->img_url,
                                    'box_ecom'            => $rs->box_ecom,
                                    'lead_time_group'     => $rs->lead_time_group,
                                    'lead_time_by_product'=> $rs->lead_time_by_product,
                                    'time_stampLeadTime'  => $rs->time_stampLeadTime,
                                    'on_wh_stock'         => $rs->on_wh_stock,
                                    'status_delivery'     => $rs->status_delivery,
                                    'status_tranfer_km'   => $rs->status_tranfer_km,
                                    'update_dt'           => $rs->update_dt,
                                ]
                            );
                            // นับผลลัพธ์
                            $model->wasRecentlyCreated ? $ins++ : $upd++;

                            // mark ต้นทางว่าโอนแล้ว
                            ComProduct::whereKey($rs->product_id)
                                ->update(['status_tranfer_km' => $rs->update_dt]);

                        } catch (\Throwable $e) {
                            $fail++;
                            Log::error("Row failed [product_id={$rs->product_id}]: ".$e->getMessage());
                        }

                        // ความคืบหน้า
                        $this->output->progressAdvance();
                    }
                });

            DB::connection('mysql_external')->commit();
            DB::connection('mysql')->commit();
            $ok = true; // ✅ สำคัญ: เซ็ตให้จริงหลัง commit ผ่าน

        } catch (\Throwable $e) {
            DB::connection('mysql_external')->rollBack();
            DB::connection('mysql')->rollBack();
            Log::error("Transfer error: ".$e->getMessage());
        } finally {
            $this->output->progressFinish(); // เรียกที่นี่ที่เดียว
            Log::info("Transfer summary: inserted=$ins, updated=$upd, failed=$fail, total=$total");
        }

        // ✅ อัปเดต TaskKm นอก transaction ของงาน transfer
        if ($ok) {
            $aff = TaskKm::whereKey($task->id)->update([
                'is_completed' => true,
                'completed_at' => today(),
                'end_time'     => now()->format('H:i:s'),
            ]);

            if ($aff === 0) {
                Log::warning("TaskKm not updated (id={$task->id}). Check fillable/guarded or column names.");
            }
        }
    }

    // SELECT * FROM product_details WHERE corporation_id = 'CPS' AND ( 
    // (product_id LIKE '0%' AND CHAR_LENGTH(product_id) = 6) -- ขึ้นต้น 0 = 6 หลัก 
    // OR (product_id LIKE '0%' AND CHAR_LENGTH(product_id) < 5) -- ขึ้นต้น 0 < 5 หลัก 
    // OR (product_id REGEXP '^[A-Z]' AND CHAR_LENGTH(product_id) <= 15) -- ขึ้นต้น A-Z ≤ 15 
    // OR (product_id REGEXP '^[0-9]+$' AND CHAR_LENGTH(product_id) <= 4) -- เลขล้วน ≤ 4 หลัก (เช่น 222, 400) 
    // ) 
    // ORDER BY corporation_id ASC, 
    // product_id ASC;


    private function tranfer_details_to_others()
    {
        // SELECT d.product_id, d.corporation_id, p.CATEGORY AS cat_name, p.SHORT_ENG AS item_name 
        // FROM product_details d 
        // LEFT JOIN product_others o ON o.product_id = d.product_id LEFT JOIN product1s p ON p.BRAND = d.corporation_id 
        // AND ( p.PRODUCT = d.product_id OR ( p.PRODUCT REGEXP '^[0-9]+$' 
        //         AND d.product_id REGEXP '^[0-9]+$' 
        //         AND p.PRODUCT+0 = d.product_id+0 -- กันเคสศูนย์นำหน้า ) 
        //     ) 
        // WHERE o.product_id IS NULL ORDER BY d.product_id;
                                    
        // รหัสที่ต่างกัน
        // SELECT DISTINCT o.product_id FROM product_others o LEFT JOIN ( SELECT DISTINCT product_id FROM product_details ) d ON d.product_id = o.product_id WHERE d.product_id IS NULL ORDER BY o.product_id;
        // 00446
        // 00675
        // 750411

        // SELECT product_id, cat_name FROM `product_others` WHERE `product_id` IN ('73261', '73262', '74325') ORDER BY `item_name` ASC;
        
        // dd(1);

        // SELECT 
        //     d.product_id,
        //     d.corporation_id,
        //     d.company_id,
        //     p.CATEGORY   AS cat_name,
        //     p.SHORT_ENG  AS item_name,
        //     d.type1,
        //     d.type2
        // FROM product_details d
        // LEFT JOIN product_others o 
        //     ON o.product_id = d.product_id
        // LEFT JOIN product1s p
        //     ON p.BRAND = d.corporation_id
        //     AND (
        //             p.PRODUCT = d.product_id
        //             OR (
        //                 p.PRODUCT REGEXP '^[0-9]+$' 
        //             AND d.product_id REGEXP '^[0-9]+$'
        //             AND p.PRODUCT+0 = d.product_id+0   -- กันเคสศูนย์นำหน้า
        //             )
        //         )
        // WHERE o.product_id IS NULL
        // ORDER BY d.product_id;

        // UPDATE product_details
        // SET corporation_id = 'CPS'
        // WHERE corporation_id = 'Ssup';

        try {
            $sql = "
                SELECT 
                    d.product_id,
                    d.corporation_id,
                    p.CATEGORY  AS cat_name,
                    p.SHORT_ENG AS item_name,
                    d.upd_user
                FROM product_details d
                LEFT JOIN product_others o 
                    ON o.product_id = d.product_id
                LEFT JOIN product1s p
                    ON p.BRAND = d.corporation_id
                    AND (
                            p.PRODUCT = d.product_id
                            OR (
                                p.PRODUCT REGEXP '^[0-9]+$'
                            AND d.product_id REGEXP '^[0-9]+$'
                            AND p.PRODUCT+0 = d.product_id+0   /* กันเคสศูนย์นำหน้า */
                            )
                        )
                WHERE
                    o.product_id IS NULL                         -- ยังไม่มีใน others
                OR o.cat_name  IS NULL OR o.cat_name  = ''     -- หรือมีแล้วแต่ cat_name ว่าง
                OR o.item_name IS NULL OR o.item_name = ''     -- หรือ item_name ว่าง
            ";
            $productDetails = DB::select($sql);

            $diff_count = count($productDetails);
            $this->info("Transferring $diff_count rows from product_details → product_others");
            $this->output->progressStart($diff_count);

            foreach ($productDetails as $rs) {
                // ถ้า product_others มี unique key ที่ product_id แนะนำใช้ upsert กันซ้ำ
                DB::table('product_others')->updateOrInsert(
                    ['product_id' => $rs->product_id],
                    [
                        'corporation_id' => $rs->corporation_id ?? '',
                        'cat_name'       => $rs->cat_name ?? '',   
                        'item_name'      => $rs->item_name ?? '',  
                        'upd_user'       => $rs->upd_user ?? '',
                        'upd_date'       => now()
                    ]
                );
                $this->output->progressAdvance();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Transfer details → others error: ".$e->getMessage());
        } finally {
            $this->output->progressFinish();
        }
    }

    private function tranfer_product1s_to_details_others()
    {
        // -- ส่วนต่าง (product1s - product_details)
        // SELECT
        // (SELECT COUNT(*) FROM product_details WHERE company_id = 'CPS') - (SELECT COUNT(*) FROM product_others WHERE corporation_id = 'CPS') AS diff;

        // รหัสที่ต่างกัน
        // SELECT DISTINCT o.product_id FROM product_others o LEFT JOIN ( SELECT DISTINCT product_id FROM product_details ) d ON d.product_id = o.product_id WHERE d.product_id IS NULL ORDER BY o.product_id;
        // 00446
        // 00675

        // อันนี้คือข้อมูล BRAND = 'CPS' รหัสสินค้า ใน Table product1s = 4,159 เป็นรหัสสินค้า 
        // รหัสสินค้าที่มีใน product_details & product_others = 1,981(4,159 - 1,981 = 2,178) 
        // รหัสสินค้า 2,178 จะต้องเอามา transfer ไปที่ product_details & product_others ข้อมูลทั้ง 3 table ก็จะเท่ากัน

        // tester 1171082

        // dd(2);

        // SELECT d.product_id FROM product_details d WHERE d.product_id NOT IN (SELECT p.PRODUCT FROM product1s p) ORDER BY d.product_id ASC;
        // SELECT d.product_id FROM product_others d WHERE d.product_id NOT IN (SELECT p.PRODUCT FROM product1s p) ORDER BY d.product_id ASC;

        // company_id = 'CPS';
        // BRAND = 'CPS';

        // 001211 95080842 76275 95080844 76314 76276 76313 95080841

        
        // รหัสที่ลบออก product_details & product_others
        // 11162KY
        // 750411
        // 1171082

        // 28555 28557 28260 

        // 95080843

        // SELECT company_id, product_id, COUNT(*) AS total FROM com_products GROUP BY product_id HAVING total > 1;

        // รหัส test ราคาขาย 28260 production
        // รหัส test ราคาขาย 28270 local

        // https://pdmaster.ssup.co.th/api/sync_products.php?mode=by_product_id&product_id=28518
        // https://pdmaster.ssup.co.th/api/sync_products.php?mode=by_id&id=222361

        // SELECT id, company_id, product_id, price, cost, width, `long`, height FROM `com_products` WHERE `product_id` IN ('28555', '28557', '28260');

        // SELECT * FROM com_products WHERE price = '0.00' AND cost = '0.00' AND LENGTH(product_id) = 5 ORDER BY `com_products`.`product_id` ASC;

        // SELECT * FROM `com_products` WHERE LENGTH(product_id) = 8 AND ((product_id like '9508%' and cost = 0) or (product_id like '9509%')) ORDER BY `com_products`.`product_id` ASC;

        // 28401

        // 76171

        // SELECT product_id, COUNT(*) AS total
        // FROM com_products
        // GROUP BY product_id
        // HAVING COUNT(*) > 1
        // ORDER BY product_id ASC;

        // SELECT p.id, p.company_id, p.product_id, p.img_url, p.ref_barcode_real
        // FROM com_products p
        // LEFT JOIN com_product_images pi ON p.product_id = pi.product_id COLLATE utf8mb4_unicode_ci
        // WHERE pi.product_id IS NULL AND LENGTH(p.product_id) = 5 AND p.product_id REGEXP '^[2-9]'
        // ORDER BY p.product_id ASC;

        // *************************
        // width = 0 AND `long` = 0 AND height = 0 หาย = 0
        // SELECT * FROM com_products WHERE width = 0 AND `long` = 0 AND height = 0 AND LENGTH(product_id) = 5 AND product_id REGEXP '^[1-9]' AND update_dt BETWEEN '2025-09-01' AND '2025-09-12' ORDER BY `com_products`.`product_id` ASC;
        // 28284
        // 28383
        // ***************************

        // SELECT c.*
        // FROM  com_products c
        // LEFT JOIN product1s  p
        //     ON c.product_id = p.PRODUCT
        // WHERE p.PRODUCT IS NULL
        // ORDER BY c.product_id ASC;

        // SELECT p.*
        // FROM  product1s  p
        // LEFT JOIN com_products c
        //     ON p.PRODUCT = c.product_id
        // WHERE c.product_id IS NULL
        // ORDER BY p.PRODUCT ASC;

        // SELECT c.* FROM com_product c INNER JOIN product1s p ON TRIM(c.product_id) = TRIM(p.PRODUCT) WHERE c.company_id = 'GNC' AND TRIM(p.BRAND) = 'GNC' ORDER BY c.product_id ASC;
        
        // SELECT p.PRODUCT FROM product1s p WHERE NOT EXISTS( SELECT 1 FROM com_products c WHERE c.product_id = p.PRODUCT );

        // SELECT a.product_id as product_a,b.PRODUCT as product_b FROM com_products as a left join product1s as b on trim(a.product_id) = trim(b.PRODUCT) where b.PRODUCT is null;
        
        // SELECT 
        //     p.PRODUCT, p.VENDOR AS p_vendor, c.vendor_id AS c_vendor, p.PRICE AS p_price, c.price AS c_price,  p.COST AS p_cost, c.cost AS c_cost 
        // FROM product1s p 
        // JOIN com_products c 
        //     ON TRIM(p.PRODUCT) = TRIM(c.product_id) 
        // WHERE LENGTH(p.PRODUCT) = 5 
        //     AND p.PRODUCT REGEXP '^2' 
        //     AND (p.VENDOR <> c.vendor_id 
        //         OR p.PRICE <> c.price 
        //         OR p.COST <> c.cost)
        // ORDER BY p.PRODUCT ASC;



        // SELECT 
        //     p.PRODUCT, 
        //     p.VENDOR AS p_vendor, 
        //     c.vendor_id AS c_vendor, 
        //     p.PRICE AS p_price, 
        //     c.price AS c_price, 
        //     p.COST AS p_cost, 
        //     c.cost AS c_cost 
        // FROM product1s p 
        // JOIN com_products c 
        //     ON TRIM(p.PRODUCT) = TRIM(c.product_id) 
        // WHERE LENGTH(p.PRODUCT) = 5 
        //     AND p.PRODUCT REGEXP '^7' 
        //     AND (p.VENDOR <> c.vendor_id 
        //         OR p.PRICE <> c.price 
        //         OR p.COST <> c.cost)
        // ORDER BY p.PRODUCT ASC;




        // SELECT p.PRODUCT, p.VENDOR AS p_vendor, c.vendor_id AS c_vendor, p.PRICE AS p_price, c.price AS c_price, p.COST AS p_cost, c.cost AS c_cost FROM product1s p 
        // JOIN com_products c ON TRIM(p.PRODUCT) = TRIM(c.product_id) WHERE LENGTH(p.PRODUCT) >= 5 
        // AND p.PRODUCT REGEXP '^8' 
        // AND (p.VENDOR <> c.vendor_id OR p.PRICE <> c.price OR p.COST <> c.cost) 
        // ORDER BY p.PRODUCT ASC;


        

        // UPDATE com_product_temp
        // SET update_dt = now()
        
        // UPDATE com_product_temp
        // SET company_id = 'KTY'
        // WHERE company_id = 'KU'

        // UPDATE com_product_temp
        // SET company_id = 'GNC'
        // WHERE company_id = 'GC'

        // UPDATE com_product_temp
        // SET company_id = 'CPS'
        // WHERE company_id = 'CP'
        
        // UPDATE com_products
        // SET status_tranfer_km = ''

        // 76170 76171 76175 76179 76183 76186
        // ข้อมูลไม่ครบ 76049
        // 75834 = pack 12

        // 81101393 price, cost ไม่เท่ากัน

        // 9000132 - 9000146 มีแค่ต้นทุนไม่มีราคาขาย

        

        // SELECT id, product_id, company_id, vendor_id, price, cost, unit_id, capacity, non_vat, status, gp, `return`, acc_type, `group` 
        // FROM `com_products` 
        // WHERE `product_id` IN ('76183', '75176', '75659', '75660', '75661', '76013', '76015', '76016', '76183', '76243', '76307') 
        // ORDER BY `com_products`.`return` ASC;

        // SELECT * FROM product1s WHERE EDIT_DT BETWEEN '2025-09-15' AND CURDATE() AND BRAND = 'CPS' AND PRODUCT REGEXP '^7' ORDER BY `product1s`.`PRODUCT` ASC



        
        try {
            // เลือกเฉพาะ BRAND = 'CPS' และยังไม่อยู่ใน details/others (เทียบแบบ normalize)
            $sql = "
                SELECT p.*
                FROM product1s p
                WHERE p.BRAND = 'CPS'
                AND NOT EXISTS (
                        SELECT 1
                        FROM product_details d
                        WHERE d.corporation_id = p.BRAND
                        AND (
                                CASE
                                WHEN p.PRODUCT REGEXP '^[0-9]+$' THEN p.PRODUCT+0
                                ELSE UPPER(TRIM(p.PRODUCT))
                                END
                            ) =
                            (
                                CASE
                                WHEN d.product_id REGEXP '^[0-9]+$' THEN d.product_id+0
                                ELSE UPPER(TRIM(d.product_id))
                                END
                            )
                    )
                AND NOT EXISTS (
                        SELECT 1
                        FROM product_others o
                        WHERE o.corporation_id = p.BRAND
                        AND (
                                CASE
                                WHEN p.PRODUCT REGEXP '^[0-9]+$' THEN p.PRODUCT+0
                                ELSE UPPER(TRIM(p.PRODUCT))
                                END
                            ) =
                            (
                                CASE
                                WHEN o.product_id REGEXP '^[0-9]+$' THEN o.product_id+0
                                ELSE UPPER(TRIM(o.product_id))
                                END
                            )
                    )
                ORDER BY p.PRODUCT
            ";

            $rows = DB::select($sql);

            
            $count = count($rows);
            dd($count);
            $this->info("Transferring $count rows from product1s → product_details & product_others");
            $this->output->progressStart($count);

            // (ออปชัน) ปิด query log กันหน่วยความจำบวมเวลา insert จำนวนมาก
            DB::connection()->disableQueryLog();

            DB::beginTransaction();
            foreach ($rows as $r) {
                // ⬇ product_details: ตั้ง permission = 'N' ตามเงื่อนไข
                DB::table('product_details')->updateOrInsert(
                    [
                        'corporation_id' => $r->BRAND,
                        'product_id'     => $r->PRODUCT,   // ถ้าต้องคงศูนย์นำหน้า ให้คอลัมน์เป็น VARCHAR
                    ],
                    [
                        'fad'             => $r->REGISTER ?? '',
                        'permission'      => 'N',               // << สำคัญ
                        'inner_pack_size' => $r->inner_pack_size ?? '',
                        'case_pack_size'  => $r->case_pack_size ?? '',
                        'upd_user'        => $r->upd_user ?? $r->USER_EDIT ?? '',
                        'upd_date'       => now()
                    ]
                );

                // ⬇ product_others: เติมชื่อจาก product1s
                DB::table('product_others')->updateOrInsert(
                    [
                        'corporation_id' => $r->BRAND,
                        'product_id'     => $r->PRODUCT,
                    ],
                    [
                        // company_id: ถ้าต้องเป็นค่าคงที่/อื่น ๆ ปรับตรงนี้
                        'company_id' => $r->BRAND,              // หรือ null / ค่าอื่นที่คุณต้องการ
                        'cat_name'   => $r->CATEGORY ?? '',
                        'item_name'  => $r->SHORT_ENG ?? '',
                        'upd_user'   => $r->USER_EDIT ?? $r->upd_user ?? '',
                        'upd_date'       => now()
                    ]
                );
                $this->output->progressAdvance();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Transfer p1s → details/others error: ".$e->getMessage());
        } finally {
            $this->output->progressFinish();
        }
    }

    public function production_transfer_data_product1s_to_com_product()
    {

        // UPDATE com_product_20250908duct_
        // SET company_id = 'KTY'
        // WHERE company _id = 'KU'

        // SELECT product_id, COUNT(*) AS total FROM com_product_20250908 GROUP BY product_id HAVING COUNT(*) > 1 ORDER BY product_id ASC;

        try {
            // เลือกเฉพาะ BRAND = 'CPS' และยังไม่อยู่ใน details/others (เทียบแบบ normalize)
            $sql = "
                SELECT p.*
                FROM product1s p
                WHERE p.BRAND = 'CPS'
                AND NOT EXISTS (
                        SELECT 1
                        FROM product_details d
                        WHERE d.corporation_id = p.BRAND
                        AND (
                                CASE
                                WHEN p.PRODUCT REGEXP '^[0-9]+$' THEN p.PRODUCT+0
                                ELSE UPPER(TRIM(p.PRODUCT))
                                END
                            ) =
                            (
                                CASE
                                WHEN d.product_id REGEXP '^[0-9]+$' THEN d.product_id+0
                                ELSE UPPER(TRIM(d.product_id))
                                END
                            )
                    )
                AND NOT EXISTS (
                        SELECT 1
                        FROM product_others o
                        WHERE o.corporation_id = p.BRAND
                        AND (
                                CASE
                                WHEN p.PRODUCT REGEXP '^[0-9]+$' THEN p.PRODUCT+0
                                ELSE UPPER(TRIM(p.PRODUCT))
                                END
                            ) =
                            (
                                CASE
                                WHEN o.product_id REGEXP '^[0-9]+$' THEN o.product_id+0
                                ELSE UPPER(TRIM(o.product_id))
                                END
                            )
                    )
                ORDER BY p.PRODUCT
            ";

            $rows = DB::select($sql);

            
            $count = count($rows);
            dd($count);
            $this->info("Transferring $count rows from product1s → product_details & product_others");
            $this->output->progressStart($count);

            // (ออปชัน) ปิด query log กันหน่วยความจำบวมเวลา insert จำนวนมาก
            DB::connection()->disableQueryLog();

            DB::beginTransaction();
            foreach ($rows as $r) {
                // ⬇ product_details: ตั้ง permission = 'N' ตามเงื่อนไข
                DB::table('product_details')->updateOrInsert(
                    [
                        'company_id' => $r->BRAND,
                        'product_id'     => $r->PRODUCT,
                        'barcode'     => $r->BARCODE,
                    ],
                    [
                        'name_thai'             => $r->REGISTER ?? '',
                        'name_eng'      => 'N',               // << สำคัญ
                        'short_thai' => $r->inner_pack_size ?? '',
                        'short_eng'  => $r->case_pack_size ?? '',
                        'vendor_id'        => $r->case_pack_size ?? '',
                        'price'        => $r->case_pack_size ?? '',
                        'cost'        => $r->case_pack_size ?? '',
                        'status'        => $r->STATUS ?? '',
                        'unit_id'        => $r->UNIT ?? '',
                        'upd_date'       => now()
                    ]
                );
                $this->output->progressAdvance();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Transfer p1s → details/others error: ".$e->getMessage());
        } finally {
            $this->output->progressFinish();
        }
    }

    private function tranfer_product1s_GNC_to_com_products()
    {
        try {
            // เลือกเฉพาะ BRAND = 'GNC' (เทียบแบบ normalize)
            // $sql = "
            //     SELECT     c.*
            //     FROM       com_product c
            //     INNER JOIN product1s p ON TRIM(c.product_id) = TRIM(p.PRODUCT)
            //     WHERE      c.company_id = 'GNC' AND TRIM(p.BRAND) = 'GNC'
            //     ORDER BY   c.product_id ASC;
            // ";
            $sql = "
                SELECT    p.* 
                FROM      product1s p 
                LEFT JOIN com_products c ON TRIM(c.product_id) = TRIM(p.PRODUCT) AND c.company_id = 'GNC' WHERE p.BRAND = 'GNC' AND c.product_id IS NULL 
                ORDER BY  `p`.`PRODUCT` DESC;
            ";

            $rows = DB::select($sql);
            $count = count($rows);

            // dd($count);

            $this->info("Transferring $count rows from product1s → com_products");
            $this->output->progressStart($count);

            DB::beginTransaction();

            // foreach ($rows as $rs) {
            //     DB::table('com_products')->updateOrInsert(
            //         [
            //             'corporation_id'      => $rs->corporation_id,
            //             'company_id'          => $rs->company_id,
            //             'product_id'          => (string) $rs->product_id,
            //         ],
            //         [
            //             'barcode'             => $rs->barcode,
            //             'vendor_id'           => $rs->vendor_id,
            //             'name_thai'           => $rs->name_thai,
            //             'name_eng'            => $rs->name_eng,
            //             'short_thai'          => $rs->short_thai,
            //             'short_eng'           => $rs->short_eng,
            //             'price'               => $rs->price,
            //             'cost'                => $rs->cost,
            //             'unit_id'             => $rs->unit_id,
            //             'currency_id'         => $rs->currency_id,
            //             'capacity_id'         => $rs->capacity_id,
            //             'capacity'            => $rs->capacity,
            //             'non_vat'             => $rs->non_vat,
            //             'status'              => $rs->status,
            //             'warrant_no'          => $rs->warrant_no,
            //             'gp'                  => $rs->gp,
            //             'return'              => $rs->return,
            //             'o_product'           => $rs->o_product,
            //             'shelf_life'          => $rs->shelf_life,
            //             'storage_temp'        => $rs->storage_temp,
            //             'size_id'             => $rs->size_id,
            //             'width'               => $rs->width,
            //             'long'                => $rs->long,
            //             'height'              => $rs->height,
            //             'weight_id'           => $rs->weight_id,
            //             'weight'              => $rs->weight,
            //             'control_stk'         => $rs->control_stk,
            //             'make_buy'            => $rs->make_buy,
            //             'safety_stock'        => $rs->safety_stock,
            //             'lot_size_min'        => $rs->lot_size_min,
            //             'lot_size_multi'      => $rs->lot_size_multi,
            //             'buyer_id'            => $rs->buyer_id,
            //             'planner_id'          => $rs->planner_id,
            //             'lead_time_po'        => $rs->lead_time_po,
            //             'lead_time_pn'        => $rs->lead_time_pn,
            //             'lead_time_inspec'    => $rs->lead_time_inspec,
            //             'acc_type'            => $rs->acc_type,
            //             'acc_date'            => $rs->acc_date,
            //             'acc_time'            => $rs->acc_time,
            //             'acc_user'            => $rs->acc_user,
            //             'reg_date'            => $rs->reg_date,
            //             'reg_time'            => $rs->reg_time,
            //             'reg_user'            => $rs->reg_user,
            //             'upd_date'            => $rs->upd_date,
            //             'upd_time'            => $rs->upd_time,
            //             'upd_user'            => $rs->upd_user,
            //             'lock'                => $rs->lock,
            //             'area'                => $rs->area,
            //             'pick_qty'            => $rs->pick_qty,
            //             'pick_type'           => $rs->pick_type,
            //             'qty_pick'            => $rs->qty_pick,
            //             'box_qty'             => $rs->box_qty,
            //             'pallet_qty'          => $rs->pallet_qty,
            //             'group'               => $rs->group,
            //             'name_export'         => $rs->name_export,
            //             'series'              => $rs->series,
            //             'solution'            => $rs->solution,
            //             'category'            => $rs->category,
            //             'group2'              => $rs->group2,
            //             'net_weight'          => $rs->net_weight,
            //             'check'               => $rs->check,
            //             'duplicate'           => $rs->duplicate,
            //             'active_sta'          => $rs->active_sta,
            //             'product_status'      => $rs->product_status,
            //             'height_old'          => $rs->height_old,
            //             'time_stamp'          => $rs->time_stamp,
            //             'run_newsize'         => $rs->run_newsize,
            //             'height_edit'         => $rs->height_edit,
            //             'area_edit'           => $rs->area_edit,
            //             'box_pallet'          => $rs->box_pallet,
            //             'img_url'             => $rs->img_url,
            //             'box_ecom'            => $rs->box_ecom,
            //             'lead_time_group'     => $rs->lead_time_group,
            //             'lead_time_by_product'=> $rs->lead_time_by_product,
            //             'time_stampLeadTime'  => $rs->time_stampLeadTime,
            //             'on_wh_stock'         => $rs->on_wh_stock,
            //             'status_tranfer_km'   => '',
            //             'update_dt'           => now()
            //         ]
            //     );
            //     $this->output->progressAdvance();
            // }

            foreach ($rows as $rs) {
                DB::table('com_products')->updateOrInsert(
                    [
                        'company_id'          => $rs->BRAND,
                        'product_id'          => (string) $rs->PRODUCT,
                    ],
                    [
                        'barcode'             => $rs->BARCODE,
                        'vendor_id'           => $rs->VENDOR,
                        'name_thai'           => $rs->NAME_THAI,
                        'name_eng'            => $rs->NAME_ENG,
                        'short_thai'          => $rs->SHORT_THAI,
                        'short_eng'           => $rs->SHORT_ENG,
                        'price'               => $rs->PRICE,
                        'cost'                => $rs->COST,
                        'unit_id'             => $rs->UNIT,
                        'non_vat'             => $rs->NON_VAT,
                        'status'              => $rs->STATUS,
                        'gp'                  => $rs->GP,
                        'return'              => $rs->RETURN,
                        'o_product'           => $rs->O_PRODUCT,
                        'shelf_life'          => $rs->AGE,
                        'acc_type'            => $rs->ACC_TYPE,
                        'status_tranfer_km'   => '',
                        'update_dt'           => now()
                    ]
                );
                $this->output->progressAdvance();
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Transfer p1s → com_products: ".$e->getMessage());
        } finally {
            $this->output->progressFinish();
        }
    }

}
