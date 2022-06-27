<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    function login(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $input = $request->only('username', 'password');

        if (!$validate) {
            return response([
                'message' => 'Field Empty'
            ], 400);
        }

        $data = User::where('username', $input['username'])->first();

        if (!$data) {
            return response([
                'message' => 'User Not Found'
            ], 400);
        }

        if (!Hash::check($input['password'], $data->password)) {
            return response([
                'message' => 'wrong password'
            ], 400);
        }

        return response([
            'data' => $data
        ]);
    }

    function logout(Request $request, $id)
    {
        $data = User::where('id', $id)->first();

        if (!$data) {
            return response([
                'message' => 'No Data'
            ], 400);
        }

        return response([
            'message' => 'Success'
        ]);
    }

    function Storelogin(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $input = $request->only('username', 'password');

        if (!$validate) {
            return response([
                'message' => 'Field Empty'
            ], 400);
        }

        $data = Store::where('username', $input['username'])->first();


        if (!$data) {
            return response([
                'message' => 'User Not Found'
            ], 400);
        }

        if (!Hash::check($input['password'], $data->password)) {
            return response([
                'message' => 'wrong password'
            ], 400);
        }
        return response([
            'data' => $data
        ]);
    }

    function Storelogout(Request $request, $id)
    {
        $data = Store::where('id', $id)->first();

        if (!$data) {
            return response([
                'message' => 'No Data'
            ], 400);
        }

        return response([
            'message' => 'Success'
        ]);
    }
}
