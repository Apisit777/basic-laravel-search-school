<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\PusherBroadcast;
use App\Models\User;

class PusherController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function broadcast(Request $request) {
        broadcast(new PusherBroadcast($request->get('message')))->toOthers();

        $data = User::find($request->id);
        $data->status = 2;
        $data->save();

        // return view('broadcast', ['message' => $request->get('message')]);
    }

    public function receive(Request $request) {
        $data = User::select('id')
            ->where('status', '=', 2)
            ->count();

        return response()->json($data);
        // return view('receive', ['message' => $request->get('message')]);
    }
}
