<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;

class CommonController extends Controller
{
    public function transfer($task)
    {
        // dd($task);  
        if (!empty($task)) {          
            $output = Artisan::call('app:transfer-data-once ' . $task);
            $output = Artisan::output();
            echo '<pre>';
            print($output);
        } else {
            echo 'no task';
        }
    }

    public function productionTransfer($task)
    {
        // dd($task);  
        if (!empty($task)) {          
            $output = Artisan::call('app:production-transfer-data-once ' . $task);
            $output = Artisan::output();
            echo '<pre>';
            print($output);
        } else {
            echo 'no task';
        }
    }
}
