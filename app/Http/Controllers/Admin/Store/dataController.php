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

        foreach ($data as $key => $value) {
            $value->image = asset('images/' . $value->image);
        }

        return response([
            'data' => $data
        ]);
    }

    function getStoreById(Request $request , $id)
    {
        $data = Store::where('id' , $id)->first();

        $data->image = asset('images/' . $data->image);

        return response([
            'data' => $data
        ]);
    }

    function getStores(Request $request)
    {
        $paginator = Store::where('name', 'like', "%{$request['search']['value']}%")
            ->paginate($request->length, ['*'], 'page', ($request->start + $request->length) / $request->length);

        return response([
            'data' => $paginator->items(),
            'recordsTotal' => $paginator->total(),
            'recordsFiltered' => $paginator->total(),
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
            'image' => 'required'
        ]);

        $input = $request->only('username', 'name', 'owner', 'number');

        $input['unique_id'] = md5($input['username']);

        $input['password'] = Hash::make($request->password);

        $files = $request->file('image');
        $ext = ['jpg', 'jpeg', 'png', 'gif', 'svg' , 'jfif'];
        $file_ext = $files->getClientOriginalExtension();

        if (in_array($file_ext, $ext)) {
            $name = date("Y-m-d").$files->getClientOriginalName();
            $input['image'] = $name;
            $request->image->move(public_path() . "/images", $name);
        } else {
            return response([
                'message' => 'file extension doesnt meet the requirement'
            ]);
        }

        if(isset($request->status)){
            $input['status'] = '1';
        }else{
            $input['status'] = '2';
        }

        if (!$validate) {
            return response([
                'message' => 'Empty Field'
            ], 400);
        }

        $input['name'] = strtoupper($input['name']);

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

        $input['name'] = strtoupper($input['name']);

        if (!$validate) {
            return response([
                'message' => 'Empty Field'
            ], 400);
        }

        $data = Store::where('id', $id)->first();

        if ($files = $request->file('image')) {
            $ext = ['jpg', 'jpeg', 'png', 'gif', 'svg' , 'jfif'];
            $file_ext = $files->getClientOriginalExtension();

            if (in_array($file_ext, $ext)) {
                $name = date("Y-m-d").$files->getClientOriginalName();
                $input['image'] = $name;
                $files->move(public_path() . "/images", $name);
            } else {
                return response([
                    'message' => 'file extension doesnt meet the requirement'
                ]);
            }
        } else {
            $input['image'] = $data->image;
        }

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
