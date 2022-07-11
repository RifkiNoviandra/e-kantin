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
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control form-control-solid">
                            <span class="form-text text-muted">Opsional</span>
                        </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control form-control-solid" value="' . $data->name . '">
                    </div>
                    
                    <div class="form-group">
                    <label for="">Class</label>
                    <input type="text" name="class" class="form-control form-control-solid" value="'. $data->class .'" required>
                </div>
                    <div class="form-group">
                        <label for="">Number</label>
                        <input type="text" name="number" class="form-control form-control-solid" value="' . $data->number . '">
                    </div>
                    <div class="form-group">
                        <label for="">Balance</label>
                        <input type="number" name="balance" class="form-control form-control-solid" value="' . $data->number . '">
                    </div>
                    <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" name="image" class="form-control form-control-solid">
                            <span class="form-text text-muted">Opsional</span>
                        </div>
                        <div class="form-group">
                            <label for="">Change Status?</label>
                            <input data-switch="true" name="status" type="checkbox" data-on-text="True" data-handle-width="50" data-off-text="False" data-on-color="success" value="1" />
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>',

                'action' => '/manage/user/' . $data->id

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
            'identity_as' => 'required',
            'image' => 'required',
            'class' => 'required'
        ]);

        $input = $request->only('username', 'name', 'number', 'identity_as', 'status', 'class');

        if (isset($request->status)) {
            $input['status'] = '1';
        } else {
            $input['status'] = '0';
        }

        if ($request->balance) {
            $input['balance'] = $request->balance;
        }

        $password = $request->password;

        $input['password'] = Hash::make($password);

        if (!$validate) {
            return response([
                'message' => 'Empty Field'
            ], 400);
        }

        $files = $request->file('image');
        $ext = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'jfif'];
        $file_ext = $files->getClientOriginalExtension();

        if (in_array($file_ext, $ext)) {
            $name = date("Y-m-d") . "_" . $input['username'] . $files->getClientOriginalName();
            $input['profile_image'] = $name;
            $request->image->move(public_path() . "/images", $name);
        } else {
            return response([
                'message' => 'file extension doesnt meet the requirement'
            ]);
        }

        $insert = User::create($input);

        if (!$insert) {
            return response([
                'message' => "Data Can't Be Processed"
            ], 400);
        }

        return redirect(route('manage'))->with('message', 'success');
    }

    function update(Request $request, $id)
    {
        $validate = $request->validate([
            'username' => 'required',
            'name' => 'required',
            'number' => 'required',
            'class' => 'required',
        ]);

        $input = $request->only('username', 'name', 'number', 'class');

        if($request->balance){
            $input['balance'] = $request->balance;
        }

        $input['password'] = Hash::make($request->password);

        if (!$validate) {
            return response([
                'message' => 'Empty Field'
            ], 400);
        }

        $data = User::where('id', $id)->first();

        if (isset($request->status)) {
            if ($data->status == '0') {
                $input['status'] = '1';
            }
            if ($data->status == '1') {
                $input['status'] = '0';
            }
        } else {
            $input['status'] = $data->status;
        }

        if ($files = $request->file('image')) {
            $ext = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'jfif'];
            $file_ext = $files->getClientOriginalExtension();

            if (in_array($file_ext, $ext)) {
                $name = date("Y-m-d") . "" . $input['username'] . $files->getClientOriginalName();
                $input['profile_image'] = $name;
                $files->move(public_path() . "/images", $name);
            } else {
                return response([
                    'message' => 'file extension doesnt meet the requirement'
                ]);
            }
        } else {
            $input['profile_image'] = $data->profile_image;
        }


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

        return redirect(route('manage'))->with('message', 'Success');
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

        return redirect(route('manage'))->with('message', 'success');
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

        return redirect(route('manage.topUp'))->with('message', 'success');
    }
}
