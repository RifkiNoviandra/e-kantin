<?php

namespace App\Http\Controllers\Admin\Store\Transaction;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;

class transactionController extends Controller
{
    public function index($id){
        $data = Store::where('id' , $id)->first();

        $data_all = DetailTransaction::where('store_id' , $data->id)->where('status' , '1')->get();
        $data_today = Transaction::with(['detail' => function($query) use($id){
            return $query->where('store_id' , $id)->where('status' , '1');
        }])->where('pickup_date' , 'LIKE' , '%'.date('Y-m-d').'%')->get();

        // return response($data_today);

        $total_earning = 0;
        $today_earning = 0;

        foreach ($data_all as $key => $value) {
            $total_earning += $value->price ;
        }

        if (count($data_today) !== 0) {

            foreach ($data_today as $key => $val) {
                if (count($val->detail)  !== 0) {
                    foreach ($data_today->detail as $key => $value) {
                        $today_earning += $value->price ;
                    }
                }
            }
        }

        return view('pages.storeTransaction' , [
            'data' => $data,
            'earning_today' => $today_earning,
            'earning_total' => $total_earning
        ]);
    }

    public function retrieveBalance(Request $request , $id){

        $request->validate([
            'amount' => 'required'
        ]);

        $data = Store::where('id' , $id)->first();

        if ($data->balance < $request->amount) {
            return redirect(route('manage.store.transaction' , $id))->with('message');
        }

        $data->balance -= $request->amount ;
        $data->save();

        return redirect(route('manage.store.transaction' , $id))->with('message');
    }
}
