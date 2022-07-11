<?php

namespace App\Http\Controllers\Admin\Store\Menu;

use App\Classes\Theme\Menu;
use App\Http\Controllers\Controller;
use App\Models\Menu as ModelsMenu;
use Illuminate\Http\Request;

class webController extends Controller
{
    function create(Request $request , $id){
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'price' => 'required',
        ]);

        $input = $request->only('name' , 'price' , 'stock');

        $input['store_id'] = $id;

        $files = $request->file('image');
        $ext = ['jpg', 'jpeg', 'png', 'gif', 'svg' , 'jfif'];
        $file_ext = $files->getClientOriginalExtension();

        if (in_array($file_ext, $ext)) {
            $name = date("Y-m-d")."_".$input['username'].$files->getClientOriginalName();
            $input['profile_image'] = $name;
            $request->image->move(public_path() . "/images", $name);
        } else {
            return response([
                'message' => 'file extension doesnt meet the requirement'
            ]);
        }

        $insert = ModelsMenu::create($input);

        if (!$insert) {
            return redirect(route('manage.store.menu' , $id))->with('Fail');
        }

        return redirect(route('manage.store.menu' , $id))->with('Success');
    }

    function checkData(Request $request , $id){

        $data = ModelsMenu::where('id' , $id)->first();

        return response([
            'data' => '
                ' . method_field('PUT') . '
                ' . csrf_field() . '
                <div class="card-body">
                    <div class="form-group">
                        <label for="">name</label>
                        <input type="text" name="name" class="form-control form-control-solid" value="' . $data->name . '">
                    </div>
                    <div class="form-group">
                        <label for="">Price</label>
                        <input type="number" name="price" class="form-control form-control-solid" value="' . $data->price . '">
                    </div>
                    <div class="form-group">
                        <label for="">Image</label>
                        <input type="file" name="image" class="form-control form-control-solid">
                        <span class="form-text text-muted">Opsional</span>
                    </div>
                    <div class="form-group">
                        <label for="">Stock</label>
                        <input type="number" name="stock" class="form-control form-control-solid" value="' . $data->stock . '">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>',

                'action' => '/manage/store/menu/update/' . $data->id
        ]);
    }

    function update(Request $request , $id){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);

        $data = ModelsMenu::where('id' , $id)->first();

        $input = $request->only('name' , 'price' , 'stock');

        if ($files = $request->file('image')) {
            $ext = ['jpg', 'jpeg', 'png', 'gif', 'svg' , 'jfif'];
            $file_ext = $files->getClientOriginalExtension();

            if (in_array($file_ext, $ext)) {
                $name = date("Y-m-d")."".$input['username'].$files->getClientOriginalName();
                $input['profile_image'] = $name;
                $files->move(public_path() . "/images", $name);
            } else {
                return response([
                    'message' => 'file extension doesnt meet the requirement'
                ]);
            }
        } else {
            $input['image'] = $data->image ;
        }

        $update = $data->update($input);

        if (!$update) {
            return redirect(route('manage.store.menu' , $data->store_id))->with('Fail');
        }

        return redirect(route('manage.store.menu' , $data->store_id))->with('Success');
    }

    function delete(Request $request , $id , $store_id){
        $data = ModelsMenu::where('id' , $id)->first();

        if (!$data) {
            return redirect(route('manage.store.menu' , $store_id))->with('no data');
        }

        $delete = $data->delete();

        if (!$delete) {
            return redirect(route('manage.store.menu' , $store_id))->with('fail');
        }

        return redirect(route('manage.store.menu' , $store_id))->with('Success');
    }
}
