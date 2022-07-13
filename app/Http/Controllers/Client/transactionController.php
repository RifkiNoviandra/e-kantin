<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class transactionController extends Controller
{
    function getTransactionListByUser(Request $request, $id)
    {
        $data = Transaction::where('user_id', $id)->OrderBy('created_at', 'DESC')->get();

        return response([
            'data' => $data
        ]);
    }

    function getTransactionListById(Request $request, $id)
    {
        $data = Transaction::with(['user', 'detail.menu.store'])->OrderBy('id', 'DESC')->where('id', $id)->first();

        foreach ($data->detail as $key => $value) {
            $value->menu->image = asset('images/' . $value->menu->image);
        }

        return response([
            'data' => $data
        ]);
    }

    function insert(Request $request)
    {

        $request->validate([
            'order' => 'required',
            'user_id' => 'required',
            'total_price' => 'required',
        ]);

        $input = $request->only('order', 'user_id', 'total_price');

        $inserted_data = [];

        foreach ($input['order'] as $key => $value) {
            $id = $value['store_id'];
            if (array_key_exists("$id", $inserted_data)) {
                array_push($inserted_data["$id"], $value);
            } else {
                $inserted_data["$id"] = [];
                array_push($inserted_data["$id"], $value);
            }
        }

        $input_data = [];

        $user_data = User::where('id', $input['user_id'])->first();

        $transaction_data = Transaction::where('user_id', $input['user_id'])->get();

        $transaction_data_count = count($transaction_data);

        $input_data['transaction_unique_id'] = "20533816" . $user_data->username . $transaction_data_count + 1;

        $input_data['user_id'] = $input['user_id'];

        $input_data['total_price'] = $input['total_price'];

        $input_data['pickup_date'] = date('Y-m-d');

        $input_data['quantity_item'] = 0;

        foreach ($inserted_data as $key => $value) {
            $input_data['quantity_item'] = $input_data['quantity_item'] + count($value);
        }

        $data = Transaction::create($input_data);

        if ($data) {

            $detail_insert = [];

            $detail_insert['transaction_id'] = $data->id;

            $detail_insert['transaction_unique_id'] = $input_data['transaction_unique_id'];

            $key_data = array_keys($inserted_data);

            foreach ($key_data as $key => $value) {

                $store_id_data = (int)$value;

                $store_data = Store::where('id', $store_id_data)->first();

                $store_data->transaction_count += 1;

                $store_data->save();
            }

            foreach ($inserted_data as $key => $value) {



                foreach ($value as $key => $value_object) {

                    $detail_insert['store_id'] = $value_object['store_id'];

                    $detail_insert['menu_id'] = $value_object['menu_id'];

                    $detail_insert['quantity'] = $value_object['quantity'];

                    $detail_insert['price'] = $value_object['price'];

                    DetailTransaction::create($detail_insert);
                }
            }

            $user_data->balance = $user_data->balance - $input_data['total_price'];
            $user_data->save();
        } else {
            return response([
                'message' => 'process failed'
            ], 400);
        }

        return response([
            'message' => 'success'
        ]);
    }
}
