<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
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
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return response()->json($response);
        // return redirect()->back();
        // return back()->with('success', 'Register Successfully');
    }
    public function login()
    {
        // dd('Test');
        return view('auth.login');
    }
    public function checkLogin(Request $request)
    {
        $credetail = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // dd($request);

        if (Auth::attempt($credetail)) {
            // return redirect('product');

            $request->session()->regenerate();

            // return response()->json(['success' => 'Log in Success.', 'route' => 'product']);
            return response()->json([['success']]);
        } 
        else {
            return response(['error' => 'Check Username Or Password!'], 401);
            // return response([ [2] ]);
        }
    }
}
