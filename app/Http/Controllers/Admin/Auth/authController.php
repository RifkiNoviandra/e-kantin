<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $input = $request->only('username' , 'password');

        $data = User::where('username' , $input['username'])->where('password' , $input['password'])->where('identity_as' , 'admin');

        if (!$data) {
            return response([
                'message' => 'Invalid User'
            ] , 400);
        }

        Auth::guard('web')->login($data);

        return response([
            'message' => 'success'
        ]);
    }
}
