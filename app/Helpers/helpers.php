<?php

use App\models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

/**
 * @param $path พาทไฟล์ที่ต้องการบันทึก
 * @param $sesstionTime ระยะเวลาของ Token ที่ต้องการ
 *
 * @return mixed|string
 */

function checkUserTentPermission()
{
    $role = User::select(
        'position.name_position as role'
    )
    ->leftjoin('user_permission', 'user_permission.user_id', '=', 'users.id')
    ->leftjoin('position', 'position.id_position', '=', 'user_permission.position_id')
    ->where('users.id', '=', Auth::user()->id)
    ->first();
}

