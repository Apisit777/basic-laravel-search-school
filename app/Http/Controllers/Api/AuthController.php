<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'message' => $validator->errors()]);
        }

        $credentials = $request->only('name', 'password');
        $setAuth = [
            'name' => $credentials['name'],
            'password' => $credentials['password'],
        ];

        if(Auth::attempt($setAuth, ! empty($request->post('remember')))) {
            $data = Auth::user();
            $token = Auth::user()->createToken('productMastertoken')->plainTextToken;
            $data->token = $token;
            $role = User::select(
                'position.name_position as role'
            )
            ->leftjoin('user_permission', 'user_permission.user_id', '=', 'users.id')
            ->leftjoin('position', 'position.id_position', '=', 'user_permission.position_id')
            ->where('users.id', '=', Auth::user()->id)
            ->first();

            $data->role = $role;

            return response()->json(['status' => 'success', 'data' => $data]);
        } else {
            return response()->json(['status' => 'fail', 'data' => 'Check Username or Password']);
        }
    }
}
