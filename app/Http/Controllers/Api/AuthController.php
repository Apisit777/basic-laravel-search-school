<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function list_user()
    {
        $users = User::select(
            'users.id as user_id',
            'name',
            'username',
            'position.id_position as position_id',
            'position.name_position as role',
            'status'
        )
            ->leftjoin('user_permission', 'user_permission.user_id', '=', 'users.id')
            ->leftjoin('position', 'position.id_position', '=', 'user_permission.position_id')
            ->where('status', '=', 1)
            ->get();

        return response()->json($users);
    }

    public function checkLogin(Request $request)
    {
        $credetail = [
            'email' => $request->email,
            'password' => $request->password
        ];

        return response()->json($credetail);
    }
}
