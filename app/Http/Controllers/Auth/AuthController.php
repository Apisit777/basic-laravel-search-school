<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;    
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
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

        toastr()->success('Data has been saved successfully!', 'Congrats', ['timeOut' => 5000]);

        return redirect()->back();
        // return back()->with('success', 'Register Successfully');
    }
}
