<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class dataController extends Controller
{
    function getUSer(){
        $data = User::all();

        return response([
            'data' => $data
        ]);
    }

    function create(Request $request){
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'number' => 'required',
        ]);

        $input = $request->only('username' , 'name' , 'number');

        $password = $request->password;

        $input['password'] = Hash::make($password);

        if (!$validate) {
            return response([
                'message' => 'Empty Field'
            ], 400);
        }

        $insert = User::create($input);

        if(!$insert){
            return response([
                'message' => "Data Can't Be Processed" 
            ] , 400);
        }

        return response([
            'message' => 'success',
        ]);
    }

    function update(Request $request , $id){
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'number' => 'required',
        ]);

        $input = $request->only('username' , 'name' , 'number');

        $input['password'] = Hash::make($request->password);

        if (!$validate) {
            return response([
                'message' => 'Empty Field'
            ], 400);
        }

        $data = User::where('id' , $id)->first();

        if(!$data){
            return response([
                'message' => 'no user'
            ] , 400);
        }

        $update = $data->update($input);

        if(!$update){
            return response([
                'message' => "Data Can't Be Processed" 
            ] , 400);
        }

        return response([
            'message' => 'success',
        ]);
    }

    function delete(Request $request , $id){
        $data = User::where('id' , $id)->first();

        if(!$data){
            return response([
                'message' => 'no data'
            ] , 400);
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

    function updateBalance(Request $request){

        $request->validate([
            'username' => 'required',
            'balance' => 'required'
        ]);

        $data = User::where('username' , $request->username)->first();

        if(!$data){
            return response([
                'message' => 'no data'
            ] , 400);
        }

        $data->balance = $data->balance + $request->balance;

        if(!$data->save()){
          return response([
            'message' => 'Error When Processing'
          ] , 400);  
        }

        return response([
            'message' => 'success'
        ]);

    }
}
