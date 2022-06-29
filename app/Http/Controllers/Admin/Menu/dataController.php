<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class dataController extends Controller
{
    public function getMenu(){
        $data = Menu::all();

        return response([
            'data' => $data
        ]);
    }

    public function getMenuById(Request $request , $id){
        $data = Menu::where('id' , $id)->first();

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

        if(!$data){
            return response([
                'message' => 'no data'
            ] , 400);
        }

        $input = $request->only('store_id' , 'name' , 'price' , 'description');

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
