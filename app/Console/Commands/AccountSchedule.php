<?php

namespace App\Console\Commands;

use Auth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\AccountScheduleTask; 
use App\Models\Account; 
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
        $start = $now->copy()->setTime(13, 30);
        $end = $now->copy()->setTime(20, 0);
    
        if (now()->isWeekday() === true && $now->between($start, $end)) {
            $incompleteTasks = AccountScheduleTask::where('is_completed', true)
                ->whereDate('scheduled_date', Carbon::today())
                ->get();
    
            if ($incompleteTasks->isEmpty()) {
                $dataProducts = DB::table('product_price_schedules')->where('status_edit_dt', '=', '')->get();

                $diff_count = count($dataProducts);
                $this->info("Update cost data from 'product_price_schedules' to 'accounts'");
                $this->output->progressStart($diff_count);
    
                foreach ($dataProducts as $rs) {

                    $accountData = DB::table('accounts')->where('product', $rs->PRODUCT)->get();
                    // if (!empty($accountData) == true) {
                    if ($accountData->isNotEmpty()) {
                        $updateAccountPrice = Account::updateOrCreate(
                            [
                                'PRODUCT' => $rs->PRODUCT
                            ],
                            [
                                'cost' => $rs->cost ?? '',

                                // 'sale_tp' => $rs->sale_tp ?? '',
                                // 'cost_km' => $rs->cost_km ?? '',
                                // 'perfume_tax' => $rs->perfume_tax ?? '',
                                // 'cost_perfume_tax' => $rs->cost_perfume_tax ?? '',
                                // 'cost5percent' => $rs->cost5percent ?? '',
                                // 'cost10percent' => $rs->cost10percent ?? '',
                                // 'cost_other' => $rs->cost_other ?? '',
                                // 'sale_km' => $rs->sale_km ?? '',
                                // 'sale_km20percent' => $rs->sale_km20percent ?? '',
                                // 'sale_km_other' => $rs->sale_km_other ?? '',

                                'price_start_date' => $rs->active_date ?? '',
                                'note' => $rs->note ?? '',
                                'status_edit_dt' => $rs->active_date,
                                'updated_by' => Auth::user()->username,
                                'updated_at' => date("Y/m/d H:i:s")
                            ]);
                        $this->output->progressAdvance();

                        $updateStatusSchedules = DB::table('product_price_schedules')->where('PRODUCT', $rs->PRODUCT)->update([
                            'status' => 1,
                            'status_edit_dt' => $rs->active_date,
                            'updated_at' => date("Y/m/d H:i:s"),
                        ]);
                    }
                }
                $taskSuccess = AccountScheduleTask::updateOrCreate(
                ['task_name' => __FUNCTION__, 'scheduled_date' => date('Y-m-d')],
                [
                    'is_completed' => true,
                    'scheduled_date' => date('Y-m-d'),
                    'completed_at' => date('Y-m-d')
                ]);
                $this->output->progressFinish();
            } else {
                $taskError = AccountScheduleTask::updateOrCreate(
                    ['task_name' => __FUNCTION__, 'scheduled_date' => date('Y-m-d')],
                    [
                        'is_completed' => false,
                        'scheduled_date' => date('Y-m-d'),
                        'completed_at' => null,
                    ]
                );
                \Log::info('No incomplete tasks for today. Created Task ID: ' . $taskError->id);
            }
        }
    }
}