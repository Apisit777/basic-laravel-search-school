<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('app:run-midnight-task')->dailyAt('10:00');
        // $schedule->command('app:production-run-midnight-task')->dailyAt('09:52');

        // $schedule->call(function () {
        //     $incompleteTasks = \App\Models\Task::where('is_completed', false)
        //         ->whereDate('scheduled_date', Carbon::today()) // Only today's tasks
        //         ->get();

        //     if ($incompleteTasks->isEmpty()) {
        //         foreach ($incompleteTasks as $task) {
        //             \Log::info("Processing task: {$task->task_name}");

        //             $task->is_completed = true;
        //             $task->save();
        //         }
        //     } else {
        //         \Log::info('No incomplete tasks for today.');
        //     }
        // })->everyMinute()->between('09:30', '20:00')->when(function () {
        //     return now()->isWeekday(); // Only run on weekdays ทำงานเฉพาะวันจันทร์ถึงศุกร์
        // });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
