<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class webController extends Controller
{
    public function checkData($id)
    {
        $data = Transaction::with(['detail' => function($query){
            return $query->with('menu.store')->where('status' ,'0');
        }])->where('id', $id)->first();

        return response([
            'data' => $data
        ]);
    }

    public function cancel(Request $request){
        $request->validate([
            'cancelation' => 'required',
            'unique_id' => 'required'
        ]);

        $data = $request->cancelation;

        $transaction = Transaction::where('transaction_unique_id' , $request->unique_id)->first();

        $user_data = User::where('id' , $transaction->user_id)->first();

        foreach ($data as $key => $value) {

            $detail = DetailTransaction::where('id' , $value)->first();

            $detail->status = '3';
            $detail->save();

            $user_data->balance = $user_data->balance + $detail->price;
            $user_data->save();

            $check_data = DetailTransaction::where('status' , '0')->get();

            if (count($check_data) === 0) {

                $transaction->status = '1';
                $transaction->save();
            }

            return redirect('manage.transaction')->with('message');
        }
    }
}
