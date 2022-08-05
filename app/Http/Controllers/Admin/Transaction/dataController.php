<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class dataController extends Controller
{
    function getTransactions(Request $request)
    {
        $paginator = Transaction::where('transaction_unique_id', 'like', "%{$request['search']['value']}%")
        ->where('status' , '0')
        ->paginate($request->length, ['*'], 'page', ($request->start + $request->length) / $request->length);

        return response([
            'data' => $paginator->items(),
            'recordsTotal' => $paginator->total(),
            'recordsFiltered' => $paginator->total(),
        ]);
    }

    function getTransaction(Request $request)
    {

        $data = Transaction::all();

        return response([
            $data
        ]);
    }
}
