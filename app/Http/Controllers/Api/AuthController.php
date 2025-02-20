<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Series;
use App\Models\Solution;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Product1;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function list_user()
    {
        $users = User::select(
            'users.id as user_id',
            'name',
            'username',
            'positions.id as position_id',
            'positions.name_position as role',
            'status'
        )
            ->leftjoin('user_permission', 'user_permission.user_id', '=', 'users.id')
            ->leftjoin('positions', 'positions.id', '=', 'user_permission.position_id')
            ->where('status', '=', 1)
            ->get();

        return response()->json($users);
    }

    public function list_series()
    {
        $series = Series::all();

        return response()->json($series);
    }
    public function list_solutions()
    {
        $solutions = Solution::all();

        return response()->json($solutions);
    }
    public function list_categorys()
    {
        $categorys = Category::all();

        return response()->json($categorys);
    }
    public function list_sub_categorys()
    {
        $sub_categorys = Sub_category::all();

        return response()->json($sub_categorys);
    }

    public function apiLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'message' => $validator->errors()]);
        }

        // $credentials = $request->only('name');
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
                'positions.name_position as role'
            )
            ->leftjoin('user_permission', 'user_permission.user_id', '=', 'users.id')
            ->leftjoin('positions', 'positions.id', '=', 'user_permission.position_id')
            ->where('users.id', '=', Auth::user()->id)
            ->first();

            $data->role = $role;

            return response()->json(['status' => 'success', 'data' => $data]);
        } else {
            return response()->json(['status' => 'fail', 'data' => 'Check Username or Password']);
        }
    }
    public function apiAppsLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'message' => $validator->errors()]);
        }

        $loginUrl = 'https://extrassup.ssup.co.th/api/v2/apps/login';
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'app_key' => 'iBnauPU1C7-H2WXee2OkJATb'
        ];

        $data = Http::withHeaders($headers)->post($loginUrl, $credentials);

        if ($data->successful()) {
            $response = $data->json();
            return response()->json(['status' => 'success', 'response' => $response]);
        } elseif ($data->failed()) {
            $error = $data->json();
            return response()->json(['error' => $error], 401);
        } else {
            return response()->json(['error' => 'Unexpected response status', 'response' => $data->status()]);
        }
    }
}
