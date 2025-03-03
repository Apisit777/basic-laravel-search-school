<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\user_permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\position;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;

class AuthController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('apiByPassLogout');
    }

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
        // $credetail = [
        //     'username' => $request->username,
        //     'password' => $request->password
        // ];

        // if (Auth::attempt($credetail)) {
        //     // return redirect('product');

        //     // $request->session()->regenerate();

        //     // return response()->json(['success' => 'Log in Success.', 'route' => 'product']);
        //     // return response()->json([['success']]);
        //     // dd($credetail);

        //     $data = Auth::user();
        //     $token = Auth::user()->createToken('productMastertoken')->plainTextToken;
        //     $data->token = $token;
        //     $role = User::select(
        //         'positions.name_position as role'
        //     )
        //     ->leftjoin('user_permission', 'user_permission.user_id', '=', 'users.id')
        //     ->leftjoin('positions', 'positions.id', '=', 'user_permission.position_id')
        //     ->where('users.id', '=', Auth::user()->id)
        //     ->first();

        //     $data->role = $role;

        //     return response()->json(['status' => 'success', 'data' => $data]);
        // } else {
        //     return response(['error' => 'Check Username Or Password!'], 401);
        // }
    }

    public function apiByPassLoginUser(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'username' => 'required',
        //     'password' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['status' => 'fail', 'message' => $validator->errors()]);
        // }

        // $credentials = $request->only('username', 'password');
        // $setAuth = [
        //     'username' => $credentials['username'],
        //     'password' => $credentials['password'],
        // ];

        // if (!Auth::attempt($setAuth, !empty($request->post('remember')))) {
        //     return response([
        //         'message' => 'Provided email address or password is incorrect'
        //     ], 422);
        // }

        // /** @var User $user */
        // $user = Auth::user();
        // $token = $user->createToken('main')->plainTextToken;
        // return response()->json(['status' => 'success', 'token' => $token, 'route' => 'product']);

        // if (Auth::attempt($setAuth, ! empty($request->post('remember')))) {
        //     $request->session()->regenerate();

        //     return response()->json(['status' => 'success', 'route' => 'product']);
        // } else {
        //     return response()->json(['error' => 'Check Username Or Password.'], 401);
        // }

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'message' => $validator->errors()]);
        }

        $loginUrl = 'https://extrassup.ssup.co.th/api/apps/auth/login';
        $credentials = $request->only('username', 'password');
        $setAuth = [
            'username' => $credentials['username'],
            'password' => $credentials['password'],
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
            if ($user == NULL) {
                // dd(1);
                $createUser = User::create([
                    'username' => $request->username
                ]);
                foreach ($response['data']['roles'] as $role) {
                    $namePosition = position::select('id', 'name_position')
                        ->where('name_position', '=', $role)
                        ->first();
                    if ($namePosition) {
                        $namePositionStr_3 = substr($role, -3);
                        if ($namePositionStr_3 == 'CPS' || $namePositionStr_3 == 'KTY' || $namePositionStr_3 == 'GNC' || $namePositionStr_3 == 'ACC') {
                            $createPosition = position::updateOrCreate(['id' => $namePosition->id],
                                [
                                    'name_position' => $role,
                                    'brand' => $namePositionStr_3
                                ]);
                        } else {
                            $namePositionStr_2 = substr($role, -2);
                            $createPosition = position::updateOrCreate(['id' => $namePosition->id],
                                [
                                    'name_position' => $role,
                                    'brand' => $namePositionStr_2
                                ]);
                        }
                    } else {
                        $namePositionStr_3 = substr($role, -3);
                        if ($namePositionStr_3 == 'CPS' || $namePositionStr_3 == 'KTY' || $namePositionStr_3 == 'GNC' || $namePositionStr_3 == 'ACC') {
                            $createPosition = position::create([
                                'name_position' => $role,
                                'brand' => $namePositionStr_3
                            ]);
                        } else {
                            $namePositionStr_2 = substr($role, -2);
                            $createPosition = position::create([
                                'name_position' => $role,
                                'brand' => $namePositionStr_2
                            ]);
                        }
                    }
                    $createUserPermission = user_permission::create([
                        'user_id' => $createUser->id,
                        'position_id' => $createPosition->id
                    ]);
                }
            }

            $userRole = user_permission::select(
                'positions.name_position as role'
            )
            ->leftJoin('positions', 'positions.id', '=', 'user_permission.position_id')
            ->where('user_permission.user_id', '=', $user->id)
            ->pluck('role')
            ->toArray();
            // dd($userRole);

            if (!empty($userRole)) {
                if (count($userRole) > 1) {
                    $defaultRole = $userRole[0];
                } else {
                    $defaultRole = $userRole[0];
                }

                session(['role' => $defaultRole]);
                
                // dd($userRole);
                $user->setRememberToken(Str::random(60));
                // dd(1);
                $user->save();
                Auth::login($user, false);
                return response()->json(['status' => 'success', 'response' => $response, 'default_role' => $defaultRole, 'route' => '/product_master/pd_master']);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No roles assigned to the user'
                ], 400);
            }
        } elseif ($data->failed()) {
            $error = $data->json();
            return response()->json(['error' => $error], 401);
        } else {
            return response()->json(['error' => 'Unexpected response status', 'response' => $data->status()]);
        }

        // if ($data->successful()) {
        //     $response = $data->json();
        //     if (Auth::attempt($setAuth, !empty($request->post('remember')))) {
        //         $request->session()->regenerate();
        //     }
        //     $user = User::select('id')
        //         ->where('username', $request->username)
        //         ->first();
        //     if($user == NULL) {
        //         $createUser = User::create([
        //             'username' => $request->username
        //         ]);
        //         $namePosition = position::select('id', 'name_position')->where('name_position', '=', $response['data']['roles'][0])->first();
        //         if ($response['data']['roles'][0] != $namePosition) {
        //             $createPosition = position::updateOrCreate(['id' => $namePosition->id],
        //         [
        //                     'name_position' => $response['data']['roles'][0]
        //                 ]);
        //         }
        //         $positionId = position::select('id', 'name_position')
        //             ->where('name_position', '=', $response['data']['roles'][0])
        //             ->first();
        //         $createUserPermission = user_permission::create([
        //             'user_id' => $createUser->id,
        //             'position_id' => $positionId->id
        //         ]);
        //         $user = User::select('id')
        //         ->where('username', $request->username)
        //         ->first();
        //     }
        //     $user->setRememberToken(Str::random(60));
        //     $user->save();
        //     Auth::login($user, false);
        //     return response()->json(['status' => 'success', 'response' => $response, 'route' => '/product_master/pd_master']);
        // }
        // else if ($data->failed()) {
        //     $error = $data->json();
        //     return response()->json(['error' => $error], 401);
        // } else {
        //     return response()->json(['error' => 'Unexpected response status', 'response' => $data->status()]);
        // }
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

        // dd($data);

        if ($data->successful()) {
            $response = $data->json();
            $user = User::select('id')
                ->where('username', $request->username)
                ->first();

            // dd([
            //     'User' => $user,
            //     // 'userRole' => $userRole,
            //     'Response' => $response['data']['roles']
            // ]);
            
            if ($user == NULL) {
                // dd(1);
                $createUser = User::create([
                    'username' => $request->username
                ]);
                foreach ($response['data']['roles'] as $role) {
                    $namePosition = position::select('id', 'name_position')
                        ->where('name_position', '=', $role)
                        ->first();
                    if ($namePosition) {
                        $namePositionStr_3 = substr($role, -3);
                        if ($namePositionStr_3 == 'CPS' || $namePositionStr_3 == 'KTY' || $namePositionStr_3 == 'GNC' || $namePositionStr_3 == 'ACC') {
                            $createPosition = position::updateOrCreate(['id' => $namePosition->id],
                                [
                                    'name_position' => $role,
                                    'brand' => $namePositionStr_3
                                ]);
                        } else {
                            $namePositionStr_2 = substr($role, -2);
                            $createPosition = position::updateOrCreate(['id' => $namePosition->id],
                                [
                                    'name_position' => $role,
                                    'brand' => $namePositionStr_2
                                ]);
                        }
                    } else {
                        $namePositionStr_3 = substr($role, -3);
                        if ($namePositionStr_3 == 'CPS' || $namePositionStr_3 == 'KTY' || $namePositionStr_3 == 'GNC' || $namePositionStr_3 == 'ACC') {
                            $createPosition = position::create([
                                'name_position' => $role,
                                'brand' => $namePositionStr_3
                            ]);
                        } else {
                            $namePositionStr_2 = substr($role, -2);
                            $createPosition = position::create([
                                'name_position' => $role,
                                'brand' => $namePositionStr_2
                            ]);
                        }
                    }
                    $createUserPermission = user_permission::create([
                        'user_id' => $createUser->id,
                        'position_id' => $createPosition->id
                    ]);
                }
            }

            $userRole = user_permission::select(
                'positions.name_position as role'
            )
            ->leftJoin('positions', 'positions.id', '=', 'user_permission.position_id')
            ->where('user_permission.user_id', '=', $user->id)
            ->pluck('role')
            ->toArray();
            // dd($userRole);

            if (!empty($userRole)) {
                if (count($userRole) > 1) {
                    $defaultRole = $userRole[0];
                } else {
                    $defaultRole = $userRole[0];
                }

                session(['role' => $defaultRole]);
                
                // dd($userRole);
                $user->setRememberToken(Str::random(60));
                // dd(1);
                $user->save();
                Auth::login($user, false);
                return response()->json(['status' => 'success', 'response' => $response, 'default_role' => $defaultRole, 'route' => '/product_master/pd_master']);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No roles assigned to the user'
                ], 400);
            }
        } elseif ($data->failed()) {
            $error = $data->json();
            return response()->json(['error' => $error], 401);
        } else {
            return response()->json(['error' => 'Unexpected response status', 'response' => $data->status()]);
        }

        // if ($data->successful()) {
        //     $response = $data->json();
        //     $user = User::select('id')
        //         ->where('username', $request->username)
        //         ->first();
        //     if($user == NULL) {
        //         $createUser = User::create([
        //             'username' => $request->username
        //         ]);
        //         $namePosition = position::select('id', 'name_position')->where('name_position', '=', $response['data']['roles'][0])->first();
        //         // dd($namePosition);
        //         if ($namePosition) {
        //             // dd(1);
        //             $namePositionStr_3 = substr($response['data']['roles'][0], -3);
        //             if ($namePositionStr_3 == 'CPS' || $namePositionStr_3 == 'KTY' || $namePositionStr_3 == 'GNC' || $namePositionStr_3 == 'ACC') {
        //                 // dd(1.1);

        //                 // $productUpddate = Product1::where('PRODUCT', $PRODUCT)->update($data_product_upddate);

        //                 $createPosition = position::updateOrCreate(['id' => $namePosition->id],
        //         [
        //                     'name_position' => $response['data']['roles'][0],
        //                     'brand' => $namePositionStr_3
        //                 ]);

        //                 $createUserPermission = user_permission::create([
        //                     'user_id' => $createUser->id,
        //                     'position_id' => $createPosition->id
        //                 ]);

        //             } else {
        //                 // dd(1.2);
        //                 $namePositionStr_2 = substr($response['data']['roles'][0], -2);

        //                 $createPosition = position::updateOrCreate(['id' => $namePosition->id],
        //         [
        //                     'name_position' => $response['data']['roles'][0],
        //                     'brand' => $namePositionStr_2
        //                 ]);

        //                 $createUserPermission = user_permission::create([
        //                     'user_id' => $createUser->id,
        //                     'position_id' => $createPosition->id
        //                 ]);
        //             }
        //         } else {
        //             // dd(2);
        //             $namePositionStr_3 = substr($response['data']['roles'][0], -3);
        //             if ($namePositionStr_3 == 'CPS' || $namePositionStr_3 == 'KTY' || $namePositionStr_3 == 'GNC' || $namePositionStr_3 == 'ACC') {
        //                     $createPosition = position::create([
        //                         'name_position' => $response['data']['roles'][0],
        //                         'brand' => $namePositionStr_3
        //                     ]);

        //                     $createUserPermission = user_permission::create([
        //                         'user_id' => $createUser->id,
        //                         'position_id' => $createPosition->id
        //                     ]);
        //             } else {
        //                 $namePositionStr_2 = substr($response['data']['roles'][0], -2);
        //                 $createPosition = position::create([
        //                     'name_position' => $response['data']['roles'][0],
        //                     'brand' => $namePositionStr_2
        //                 ]);
        //             }
        //         }
        //         // dd(3);
        //         $positionId = position::select('id', 'name_position')
        //             ->where('name_position', '=', $response['data']['roles'][0])
        //             ->first();
        //         // $createUserPermission = user_permission::create([
        //         //     'user_id' => $createUser->id,
        //         //     'position_id' => $positionId->id
        //         // ]);
        //         // dd($createPosition);
        //         $user = User::select('id')
        //         ->where('username', $request->username)
        //         ->first();
        //     }
        //     // dd(1);
        //     $user->setRememberToken(Str::random(60));
        //     $user->save();
        //     Auth::login($user, true);
        //     return response()->json(['status' => 'success', 'response' => $response, 'route' => '/product_master/pd_master']);
        // } elseif ($data->failed()) {
        //     $error = $data->json();
        //     return response()->json(['error' => $error], 401);
        // } else {
        //     return response()->json(['error' => 'Unexpected response status', 'response' => $data->status()]);
        // }
    }

    public function apiByPassLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function tokenExpired()
    {
        // dd(1);
        // return response()->json(['true' => true, 'route' => 'login']);
        return true;
    }
}
