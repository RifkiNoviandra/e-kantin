<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class dataController extends Controller
{
    function getStore()
    {
        $data = Store::all();

        return response([
            'data' => $data
        ]);
    }

    function create(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'owner' => 'required',
            'name' => 'required',
            'number' => 'required',
        ]);

        $input = $request->only('username', 'name', 'owner', 'number');

        $input['unique_id'] = md5($input['username']);

        $input['password'] = Hash::make($request->password);

        if (!$validate) {
            return response([
                'message' => 'Empty Field'
            ], 400);
        }

        $insert = Store::create($input);

        if (!$insert) {
            return response([
                'message' => "Data Can't Be Processed"
            ], 400);
        }

        return response([
            'message' => 'success',
        ]);
    }

    function update(Request $request, $id)
    {
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'owner' => 'required',
            'name' => 'required',
            'number' => 'required',
            'status' => 'required'
        ]);

        $input = $request->only('username', 'name', 'owner', 'number', 'status');

        $input['password'] = Hash::make($request->password);

        $input['unique_id'] = md5($input['username']);

        if (!$validate) {
            return response([
                'message' => 'Empty Field'
            ], 400);
        }

        $data = Store::where('id', $id)->first();

        if (!$data) {
            return response([
                'message' => 'no data'
            ] , 400);
        }

        $update = $data->update($input);

        if (!$update) {
            return response([
                'message' => "Data Can't Be Processed"
            ], 400);
        }

        return response([
            'message' => 'success',
        ]);
    }

    function delete(Request $request, $id)
    {
        $data = Store::where('id', $id)->first();

        if (!$data) {
            return response([
                'message' => 'no data'
            ], 400);
        }

        $delete = $data->delete();

        if (!$delete) {
            return response([
                'message' => "Data Can't Be Deleted"
            ], 400);
        }

        return response([
            'message' => 'success'
        ]);
    }

    function updateBalance(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'balance' => 'required'
        ]);

        $data = Store::where('username', $request->username)->first();

        if (!$data) {
            return response([
                'message' => 'no data'
            ], 400);
        }

        $data->balance = 0;

        if (!$data->save()) {
            return response([
                'message' => 'Error When Processing'
            ], 400);
        }

        return response([
            'message' => 'success'
        ]);
    }
}
