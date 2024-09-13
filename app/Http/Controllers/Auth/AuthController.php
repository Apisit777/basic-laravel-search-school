<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\user_permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\position;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'app_key' => 'iBnauPU1C7-H2WXee2OkJATb'
        ])->post('https://extrassup.ssup.co.th/api/v2/apps/login', [
            'username' => '000000',
            'password' => '000000',
        ]);
        // $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        // $response = Http::get('https://ins.schicher.com/api/users');
        // $response = Http::post('http://10.10.35.99:7777/api/checklogin', [
        //     'email' => 'test@gmail.com',
        //     'password' => '1234',
        // ]);
        return $response->json();
    }
    public function register()
    {
        // $list_position = position::select('id', 'name_position')->pluck('name_position')->toArray();
        $list_position = position::select('id', 'name_position')->get();

        // dd($list_position);
        return view('auth.register', compact('list_position'));
    }
    public function registerPost(Request $request)
    {
        // $user = new User();

        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = Hash::make($request->password);

        // $user->save();

        // toastr()->success('Created successfully!', 'Congrats', ['timeOut' => 5000]);

        DB::beginTransaction();
        try {
            $response = false;
            $response = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(trim($request->password)),
            ]);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json($response);
        // return redirect()->back();
        // return back()->with('success', 'Register Successfully');
    }
    public function login()
    {
        $list_position = position::select('id', 'name_position')->get();
        // dd($list_position);
        return view('auth.login', compact('list_position'));
    }
    public function checkLogin(Request $request)
    {
        $credetail = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credetail)) {
            // return redirect('product');

            // $request->session()->regenerate();

            // return response()->json(['success' => 'Log in Success.', 'route' => 'product']);
            // return response()->json([['success']]);
            // dd($credetail);

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
            return response(['error' => 'Check Username Or Password!'], 401);
        }
    }

    public function apiByPassLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'message' => $validator->errors()]);
        }

        $loginUrl = 'https://extrassup.ssup.co.th/api/apps/auth/login-bypass';
        $credentials = $request->only('username');
        $setAuth = [
            'username' => $credentials['username']
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'app_key' => 'iBnauPU1C7-H2WXee2OkJATb'
        ];

        $data = Http::withHeaders($headers)->post($loginUrl, $setAuth);
        
        if ($data->successful()) {
            $response = $data->json();
            $user = User::select('id')
                ->where('username', $request->username)
                ->first(); 

            if($user == NULL) {
                $createUser = User::create([
                    'username' => $request->username
                ]);
                $createUser = user_permission::create([
                    'user_id' => $createUser->id,
                    'position_id' => $request->input('position_id')
                ]);

                $user = User::select('id')
                ->where('username', $request->username)
                ->first(); 
            }
            Auth::login($user, true);
            return response()->json(['status' => 'success', 'response' => $response]);
        } elseif ($data->failed()) {
            $error = $data->json();
            return response()->json(['error' => $error], 401);
        } else {
            return response()->json(['error' => 'Unexpected response status', 'response' => $data->status()]);
        }
    }

    public function apiByPassLogout(Request $request)
    {
        Auth::guard('web')->logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
