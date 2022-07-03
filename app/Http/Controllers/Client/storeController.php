<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Store;
use Illuminate\Http\Request;

class storeController extends Controller
{
    function getStore(Request $request){
        $data = Store::where('status' , '1')->get();

        foreach ($data as $key => $value) {
            $value->image = asset('images/' . $value->image);
        }

        if(!$data){
            return response([
                'message' => 'No Data'
            ] , 400);
        }

        return response([
            'data' => $data
        ]);
    }

    function getMenu(Request $request , $id){
        $data = Menu::where('store_id' , $id)->get();

        foreach ($data as $key => $value) {
            $value->image = asset('images/' . $value->image);
        }

        return response([
            'data' => $data
        ]);
    }

    function getMenuBySearch(Request $request){

        $request->validate([
            'params' => 'required'
        ]);

        $params = $request->params;

        $data = Menu::with('store')->where('name' , 'LIKE' , '%'.$params.'%')->get();

        foreach ($data as $key => $value) {
            $value->image = asset('images/' . $value->image);
        }

        return response([
            'data' => $data
        ]);
    }

    
}
