<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as FacadesSession;

class authController extends Controller
{
    function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $input = $request->only('username', 'password');

        $data = User::where('username', $input['username'])->where('identity_as', 'admin')->first();

        if (!$data) {
            return view(
                'pages.login',
                [
                    'page_title' => 'Login',
                    'message' => 'Wrong Login Credentials'
                ]
            );
        }
        if (!Hash::check($input['password'] , $data->password)) {
            
            return view(
                'pages.login',
                [
                    'page_title' => 'Login',
                    'message' => 'Wrong Login Credentials'
                ]
            );
        }


        Auth::guard('web')->login($data);

        return redirect(route('dashboard'));
    }

    public function logout(){
        Auth::logout();
        FacadesSession::flush();

        return redirect(route('guest.login'))->with('message' , 'Logout Success');
    }
}
