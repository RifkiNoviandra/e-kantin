<?php

namespace App\Http\Controllers\Client\Store;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;

class transactionController extends Controller
{
    function acceptTransactionComplete(Request $request)
    {

        $request->validate([
            'code' => 'required',
        ]);

        $code = $request->only('code');

        if (strpos($code['code'], "-") !== false) {
            list($d, $l) = explode('-', $code['code'], 2);

            $transaction = Transaction::where('transaction_unique_id', $d)->first();

            if ($transaction) {

                $detail = DetailTransaction::where('transaction_unique_id', $d)->where('store_id', $l)->update(['status' => '1']);
                // $detail->update(['status' => 1]);

                $confirmation = DetailTransaction::where('transaction_unique_id', $d)->where('status', 0)->get();

                if (count($confirmation) === 0) {

                    $confirmation2 = DetailTransaction::where('transaction_unique_id', $d)->where('status', 2)->get();

                    if(count($confirmation2) === 0){
                        $transaction->status = 1;
                        $transaction->save();

                        return response([
                            'message' => 'success'
                        ]);
                    }else{
                        $transaction->status = 2;
                        $transaction->save();

                        return response([
                            'message' => 'success'
                        ]);
                    }
                }

                return response([
                    'message' => 'success'
                ]);
            }
        }
    }

    function listTransaction(Request $request , $id){

        $data = DetailTransaction::where('store_id' , $id)->where('status' , "0")->get();

        return response([
            'data' => $data
        ]);

    }
}
