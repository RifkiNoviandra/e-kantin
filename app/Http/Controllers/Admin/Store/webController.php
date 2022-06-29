<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class webController extends Controller
{
    function getStore()
    {
        $data = Store::all();

        return response([
            'data' => $data
        ]);
    }

    function getStoreById(Request $request, $id)
    {
        $data = Store::where('id', $id)->first();

        return response(
            [
                'data' => '
                ' . method_field('PUT') . '
                ' . csrf_field() . '
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control form-control-solid" value="' . $data->username . '">
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control form-control-solid" value="' . $data->name . '">
                    </div>
                    <div class="form-group">
                        <label for="">Owner</label>
                        <input type="text" name="owner" class="form-control form-control-solid" value="'.$data->owner.'">
                    </div>
                    <div class="form-group">
                        <label for="">Number</label>
                        <input type="text" name="number" class="form-control form-control-solid" value="' . $data->number . '">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>',

                'action' => '/manage/store/' . $data->id


            ]
        );
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

        if($request->balance){
            $input['balance'] = $request->balance;
        }

        $input['unique_id'] = md5($input['username']);

        $input['password'] = Hash::make($request->password);

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

        $insert = Store::create($input);

        if (!$insert) {
            return response([
                'message' => "Data Can't Be Processed"
            ], 400);
        }

        return redirect(route('store'))->with('message' , 'success');
    }

    function update(Request $request, $id)
    {
        $validate = $request->validate([
            'username' => 'required',
            'owner' => 'required',
            'name' => 'required',
            'number' => 'required',
        ]);

        $input = $request->only('username', 'name', 'owner', 'number');

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
            ], 400);
        }

        $update = $data->update($input);

        if (!$update) {
            return response([
                'message' => "Data Can't Be Processed"
            ], 400);
        }

        return redirect(route('store'))->with('message' , 'success');
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

        return redirect(route('store'))->with('message' , 'success');
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
