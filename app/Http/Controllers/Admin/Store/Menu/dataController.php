<?php

namespace App\Http\Controllers\Admin\Store\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class dataController extends Controller
{
    function getMenus(Request $request , $id)
    {
        $paginator = Menu::where('name', 'like', "%{$request['search']['value']}%")->where('store_id' , $id)
            ->paginate($request->length, ['*'], 'page', ($request->start + $request->length) / $request->length);

        return response([
            'data' => $paginator->items(),
            'recordsTotal' => $paginator->total(),
            'recordsFiltered' => $paginator->total(),
        ]);
    }
}
