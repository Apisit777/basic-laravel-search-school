<?php

namespace App\Console\Commands;

use Auth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\AccountScheduleTask; 
use App\Models\Account; 
use App\Models\AccountLog; 
use Carbon\Carbon;

class AccountSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:account-schedule {task}';

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
                case 'account_schedule':
                    $this->account_schedule();
                    break;
                default:
                    $this->error('Unknown task. Available tasks: 🚀 account_schedule');
                    break;
            }
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }

    public function account_schedule()
    {
        $now = now();
        $start = $now->copy()->setTime(12, 30);
        $end = $now->copy()->setTime(20, 0);

        if ($now->isWeekday() && $now->between($start, $end)) {
            // ตรวจสอบว่ามี Task ที่ทำเสร็จแล้วหรือไม่
            $incompleteTasks = AccountScheduleTask::where('is_completed', true)
                ->whereDate('scheduled_date', Carbon::today())
                ->exists();

            if (!$incompleteTasks) {
                // ตรวจสอบว่ามีบัญชีที่ยังไม่มีการแก้ไข (status_edit_dt เป็น NULL)
                $dataaccounts = DB::table('accounts')->whereNull('status_edit_dt')->exists();

                // ตรวจสอบว่ามี product_price_schedules ที่ active_date เป็นวันนี้
                $dataSchedules = DB::table('product_price_schedules')
                    ->whereNull('status_edit_dt')
                    ->whereDate('active_date', Carbon::today())
                    ->exists();

                // ถ้ามีข้อมูลตรงตามเงื่อนไข ให้เริ่มการอัปเดต
                if (!$dataaccounts && $dataSchedules) {
                    $dataProducts = DB::table('product_price_schedules')
                        ->whereNull('status_edit_dt')
                        ->whereDate('active_date', Carbon::today())
                        ->get();

                    $diff_count = $dataProducts->count();
                    $this->info("Updating cost data from 'product_price_schedules' to 'accounts'");
                    $this->output->progressStart($diff_count);

                    DB::beginTransaction(); // เริ่ม transaction
                    try {
                        // บันทึกเวลาเริ่มต้นงาน
                        $taskSuccess = AccountScheduleTask::updateOrCreate(
                            ['task_name' => __FUNCTION__, 'scheduled_date' => Carbon::today()],
                            [
                                'is_completed' => false,
                                'scheduled_date' => Carbon::today(),
                                'start_time' => $now->format('H:i:s')
                            ]
                        );
                        // เก็บ log ข้อมูลเก่าก่อนอัปเดต
                        $product1LogData = [];
                        $accountLogData = [];
                        $productPriceScheduleLogData = [];

                        foreach ($dataProducts as $rs) {
                            // ดึงข้อมูลที่เกี่ยวข้องก่อนอัปเดต
                            $product1Data = DB::table('product1s')->where('PRODUCT', $rs->PRODUCT)->get();
                            $accountData = DB::table('accounts')->where('product', $rs->PRODUCT)->get();
                            $productPriceScheduleData = DB::table('product_price_schedules')->where('product_id', $rs->PRODUCT)->get();

                            // แปลงข้อมูลเพื่อใช้เก็บ Log
                            $product1LogData = array_merge(
                                $product1LogData,
                                $product1Data->map(fn($p) => (array) $p)->toArray()
                            );

                            $accountLogData = array_merge(
                                $accountLogData,
                                $accountData->map(fn($a) => (array) $a)->toArray()
                            );

                            $productPriceScheduleLogData = array_merge(
                                $productPriceScheduleLogData,
                                $productPriceScheduleData->map(fn($pps) => (array) $pps)->toArray()
                            );

                            // ทำการอัปเดตข้อมูลใหม่
                            DB::table('product1s')
                                ->where('PRODUCT', $rs->PRODUCT)
                                ->update([
                                    'COST' => $rs->cost ?? '',
                                    'STATUS_EDIT_DT' => $rs->active_date ?? '',
                            ]);
                            Account::updateOrCreate(
                                ['PRODUCT' => $rs->PRODUCT],
                                [
                                    'cost' => $rs->cost ?? '',
                                    'price_start_date' => $rs->active_date ?? '',
                                    'cost5percent' => $rs->cost5percent ?? '',
                                    'cost10percent' => $rs->cost10percent ?? '',
                                    'sale_km' => $rs->sale_km ?? '',
                                    'sale_km20percent' => $rs->sale_km20percent ?? '',
                                    'note' => $rs->note ?? '',
                                    'status_edit_dt' => $rs->active_date,
                                    'updated_by' => Auth::user()->username,
                                    'updated_at' => $rs->active_date

                                    // 'sale_tp' => $rs->sale_tp ?? '',
                                    // 'cost_km' => $rs->cost_km ?? '',
                                    // 'perfume_tax' => $rs->perfume_tax ?? '',
                                    // 'cost_perfume_tax' => $rs->cost_perfume_tax ?? '',
                                    // 'cost_other' => $rs->cost_other ?? '',
                                    // 'sale_km_other' => $rs->sale_km_other ?? '',
                                ]
                            );
                            DB::table('product_price_schedules')
                                ->where('PRODUCT', $rs->PRODUCT)
                                ->update([
                                    'status' => 1,
                                    'status_edit_dt' => $rs->active_date,
                                    'updated_at' => $rs->active_date
                            ]);
                            $this->output->progressAdvance();
                        }
                        // บันทึก Log ลงตารางที่เหมาะสม
                        if (!empty($product1LogData)) {
                            DB::table('product1_logs')->insert($product1LogData);
                        }
                        if (!empty($accountLogData)) {
                            DB::table('account_logs')->insert($accountLogData);
                        }
                        if (!empty($productPriceScheduleLogData)) {
                            DB::table('product_price_schedule_logs')->insert($productPriceScheduleLogData);
                        }
                        // อัปเดตเวลาเสร็จสิ้น
                        $taskSuccess->update([
                            'is_completed' => true,
                            'completed_at' => Carbon::today(),
                            'end_time' => now()->format('H:i:s')
                        ]);
                        DB::commit(); // ยืนยัน transaction
                        $this->output->progressFinish();
                    } catch (\Exception $e) {
                        DB::rollBack(); // ยกเลิก transaction ถ้าเกิดข้อผิดพลาด
                        Log::error("Error updating data: " . $e->getMessage());
                    }
                }
            } else {
                $taskError = AccountScheduleTask::updateOrCreate(
                    ['task_name' => __FUNCTION__, 'scheduled_date' => Carbon::today()],
                    [
                        'is_completed' => false,
                        'scheduled_date' => Carbon::today(),
                        'completed_at' => null,
                    ]
                );
                Log::info('No incomplete tasks for today. Created Task ID: ' . $taskError->id);
            }
        }
    }
}