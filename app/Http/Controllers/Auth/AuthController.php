<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function registerPost(Request $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        toastr()->success('Created successfully!', 'Congrats', ['timeOut' => 5000]);

        return redirect()->back();
        // return back()->with('success', 'Register Successfully');
    }
    public function login()
    {
        return view('auth.login');
    }
    public function checkLogin(Request $request)
    {
        $credetail = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credetail)) {
            // return redirect('product');

            $request->session()->regenerate();

            return response()->json(['success' => 'Log in Success.', 'route' => 'product']);
        } else {
            return response(['error' => 'Check Username Or Password!'], 401);
        }
    }
}
