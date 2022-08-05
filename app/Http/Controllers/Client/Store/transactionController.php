<?php

namespace App\Http\Controllers\Client\Store;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;

class transactionController extends Controller
{

    public function countTransactionDay(Request $request, $id)
    {
        $data = Transaction::with(['detail' => function ($query) use ($id) {
            return $query->where('store_id', $id);
        }])->where('pickup_date', 'LIKE', '%' . date('Y-m-d') . '%')->get();

        $count_done = 0;

        $count_progress = 0;

        foreach ($data as $key => $value) {
            if (count($value->detail) !== 0) {
                foreach ($value->detail as $key => $val) {
                    if ($val->status == '0') {
                        $count_progress += 1;
                    }
                    if ($val->status == '1') {
                        $count_done += 1;
                    }
                }
            }
        }

        return response([
            'done' => $count_done,
            'progress' => $count_progress
        ]);
    }

    // function acceptTransactionComplete(Request $request)
    // {

    //     $request->validate([
    //         'code' => 'required',
    //     ]);

    //     $code = $request->only('code');

    //     if (strpos($code['code'], "-") !== false) {
    //         list($d, $l) = explode('-', $code['code']);

    //         $transaction = Transaction::where('transaction_unique_id', $d)->first();

    //         if ($transaction) {

    //             $detail_data = DetailTransaction::where('transaction_unique_id', $d)->where('store_id', $l)->get();

    //             $earning = 0;

    //             foreach ($detail_data as $key => $value) {
    //                 $earning = $earning + $value->price;
    //             }

    //             $store = Store::where('id', $l)->first();

    //             $store->balance = $store->balance + $earning;

    //             $store->save();

    //             $detail = DetailTransaction::where('transaction_unique_id', $d)->where('store_id', $l)->update(['status' => '1']);
    //             // $detail->update(['status' => 1]);

    //             $confirmation = DetailTransaction::where('transaction_unique_id', $d)->where('status', '0')->get();



    //             if (count($confirmation) === 0) {

    //                 $transaction->status = '1';
    //                 $transaction->save();

    //                 return response([
    //                     'message' => 'success'
    //                 ]);
    //             }

    //             return response([
    //                 'message' => 'success'
    //             ]);
    //         }
    //     }
    // }

    function acceptTransactionComplete(Request $request)
    {

        $request->validate([
            'code' => 'required',
        ]);

        $code = $request->only('code');

        $transaction = Transaction::where('transaction_unique_id', $code)->first();

        if ($transaction) {

            $detail_data = DetailTransaction::where('transaction_unique_id', $code)->get();

            foreach ($detail_data as $key => $value) {

                $store = Store::where('id', $value->store_id)->first();

                $store->balance = $store->balance + $value->price;
                $store->save();

                $value->status = '1';
                $value->save();
            }
            // $detail->update(['status' => 1]);

            $confirmation = DetailTransaction::where('transaction_unique_id', $code)->where('status', '0')->get();

            if (count($confirmation) === 0) {

                $transaction->status = '1';
                $transaction->save();

                return response([
                    'message' => 'OK'
                ] , 200);
            }

            return response([
                'message' => 'success'
            ]);
        }
    }

    function listTransaction(Request $request, $id)
    {

        $data = Transaction::with(['detail', 'user'])->where('status', "0")->get();

        if (isset($request->parameter)) {
            $search = strtoupper($request->parameter);
            $data = Transaction::with(['detail', 'user' => function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            }])->where('status', '0')->get();

            return response([
                'data' => $data
            ]);
        } else {
            return response([
                'data' => $data
            ]);
        }
    }

    function listTransactionDone(Request $request)
    {

        $data = Transaction::with(['detail','user'])->where('status', '1')->where('pickup_date', 'LIKE' ,'%2022-08%')->get();

        if (isset($request->parameter)) {
            $search = strtoupper($request->parameter);
            $data = Transaction::with(['detail', 'user' => function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            }])->where('status', '1')->where('pickup_date', '%' . date('Y-m-d') . '%')->get();

            return response([
                $data
            ]);
        } else {
            return response([
                'data' => $data
            ]);
        }
    }

    function getTransactionByIdAndStore(Request $request, $id)
    {
        $data = Transaction::with(['user', 'detail.menu'])->where('id', $id)->first();

        return response([
            'data' => $data
        ]);
    }
}
