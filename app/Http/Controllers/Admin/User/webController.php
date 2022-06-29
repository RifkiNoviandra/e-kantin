<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class webController extends Controller
{
    function getUSer()
    {
        $data = User::all();

        return response([
            'data' => $data
        ]);
    }

    function getUserById(Request $request, $id)
    {
        $data = User::where('id', $id)->first();

        return response(
            ['data' => '
                '.method_field('PUT').'
                '.csrf_field().'
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control form-control-solid" value="'.$data->username.'">
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control form-control-solid" value="'.$data->name.'">
                    </div>
                    <div class="form-group">
                        <label for="">Number</label>
                        <input type="text" name="number" class="form-control form-control-solid" value="'.$data->number.'">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>',

                'action' => '/manage/user/'.$data->id
                
                ]
        );
    }

    function create(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'number' => 'required',
            'identity_as' => 'required'
        ]);

        $input = $request->only('username', 'name', 'number' , 'identity_as');

        if($request->balance){
            $input['balance'] = $request->balance;
        }

        $password = $request->password;

        $input['password'] = Hash::make($password);

        if (!$validate) {
            return response([
                'message' => 'Empty Field'
            ], 400);
        }

        $insert = User::create($input);

        if (!$insert) {
            return response([
                'message' => "Data Can't Be Processed"
            ], 400);
        }

        return redirect(route('manage'))->with('message' , 'success');
    }

    function update(Request $request, $id)
    {
        $validate = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'number' => 'required',
        ]);

        $input = $request->only('username', 'name', 'number');

        $input['password'] = Hash::make($request->password);

        if (!$validate) {
            return response([
                'message' => 'Empty Field'
            ], 400);
        }

        $data = User::where('id', $id)->first();

        if (!$data) {
            return response([
                'message' => 'no user'
            ], 400);
        }

        $update = $data->update($input);

        if (!$update) {
            return response([
                'message' => "Data Can't Be Processed"
            ], 400);
        }

        redirect(route('manage'))->with('message','Success');
    }

    function delete(Request $request, $id)
    {
        $data = User::where('id', $id)->first();

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

        return redirect(route('manage'))->with('message' , 'success');
    }

    function updateBalance(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'balance' => 'required'
        ]);

        $data = User::where('username', $request->username)->first();

        if (!$data) {
            return response([
                'message' => 'no data'
            ], 400);
        }

        $data->balance = $data->balance + $request->balance;

        if (!$data->save()) {
            return response([
                'message' => 'Error When Processing'
            ], 400);
        }

        return redirect(route('manage.topUp'))->with('message' , 'success');
    }
}
