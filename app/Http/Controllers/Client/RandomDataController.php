<?php

namespace App\Http\Controllers\Client;

use App\Classes\Theme\Menu;
use App\Http\Controllers\Controller;
use App\Models\Menu as ModelsMenu;
use App\Models\Store;
use Illuminate\Http\Request;

class RandomDataController extends Controller
{
    public function getRandomMenu(){
        $data = ModelsMenu::inRandomOrder()->limit(3)->get();

        foreach ($data as $key => $value) {
            $value->image = asset('images/' . $value->image);
        }

        return response([
            'data' => $data
        ]);
    }

    public function getStoreMostTransaction(){
        $data = Store::OrderBy('transaction_count' , 'DESC')->limit(3)->get();

        foreach ($data as $key => $value) {
            $value->image = asset('images/' . $value->image);
        }

        return response([
            'data' => $data
        ]);
    }
}
