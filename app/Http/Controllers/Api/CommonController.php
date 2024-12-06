<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;

class CommonController extends Controller
{
    public function transfer()
    {
        $output = Artisan::call('app:transfer-data-once');
        $output = Artisan::output();
        echo '<pre>';
        print($output);
    }
}
