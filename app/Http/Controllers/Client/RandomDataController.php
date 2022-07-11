<?php

namespace App\Http\Controllers\Client;

use App\Classes\Theme\Menu;
use App\Http\Controllers\Controller;
use App\Models\Menu as ModelsMenu;
use Illuminate\Http\Request;

class RandomDataController extends Controller
{
    public function getRandomMenu(){
        $data = ModelsMenu::inRandomOrder()->limit(3)->get();

        return response([
            'data' => $data
        ]);
    }
}
