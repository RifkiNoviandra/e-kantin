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

        return response([
            'data' => $data
        ]);
    }

    
}
