<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Store;
use Illuminate\Http\Request;

class dataController extends Controller
{
    public function getMenu(){
        $data = Menu::with('store')->get();

        foreach ($data as $key => $value) {
            $value->image = asset('images/' . $value->image);
        }

        return response([
            'data' => $data
        ]);
    }

    public function getMenuById(Request $request , $id){
        $data = Menu::where('id' , $id)->first();

        $data->image = asset('images/' . $data->image);

        if(!$data){
            return response([
                'message' => 'No Data'
            ] , 400);
        }

        return response([
            'data' => $data
        ]);
    }

    public function getMenuByStore(Request $request , $store_id){
        $data = Menu::where('store_id' , $store_id)->get();

        foreach ($data as $key => $value) {
            $value->image = asset('images/' . $value->image);
        }

        if (!$data) {
            return response([
                'message' => 'No Data'
            ] , 400);
        }

        return response([
            'data' => $data
        ]);
    }

    public function create(Request $request){

        $request->validate([
            'store_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);

        $input = $request->only('store_id' , 'name' , 'price' , 'description');

        $store_data = Store::where('id' , $request->store_id)->first();

        if (!$store_data) {
            return response([
                'message' => 'no data'
            ] , 400);
        }

        $files = $request->file('image');
        $ext = ['jpg', 'jpeg', 'png', 'gif', 'svg' , 'jfif'];
        $file_ext = $files->getClientOriginalExtension();

        if (in_array($file_ext, $ext)) {
            $name = date("Y-m-d").$store_data->unique_id.$files->getClientOriginalName();
            $input['image'] = $name;
            $request->image->move(public_path() . "/images", $name);
        } else {
            return response([
                'message' => 'file extension doesnt meet the requirement'
            ]);
        }

        $insert = Menu::create($input);

        if(!$insert){
            return response([
                'message' => "Data Can't Be Processed"
            ] , 400);
        }

        return response([
            'message' => 'success'
        ]);

    }

    public function update(Request $request , $id){

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);

        $data = Menu::where('id' , $id)->first();

        $store_data = Store::where('id' , $data->store_id)->first();

        if(!$data){
            return response([
                'message' => 'no data'
            ] , 400);
        }

        $input = $request->only('store_id' , 'name' , 'price' , 'description');

        if ($files = $request->file('image')) {
            $ext = ['jpg', 'jpeg', 'png', 'gif', 'svg' , 'jfif'];
            $file_ext = $files->getClientOriginalExtension();

            if (in_array($file_ext, $ext)) {
                $name = date("Y-m-d") .$store_data->unique_id. $files->getClientOriginalName();
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

        $update = $data->update($input);

        if(!$update){
            return response([
                'message' => "Data Can't Be Processed"
            ] , 400);
        }

        return response([
            'message' => 'success'
        ]);

    }

    public function delete(Request $request , $id){
        $data = Menu::where('id' , $id)->first();

        if(!$data){
            return response([
                'message' => 'no data'
            ] , 400);
        }

        $delete = $data->delete();

        if(!$delete){
            return response([
                'message' => "Data Can't Be Deleted"
            ] , 400);
        }

        return response([
            'message' => 'success'
        ]);
    }
}
