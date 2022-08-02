<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Models\topupSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {

        $data = topupSetting::all();

        return view('pages.setting', [
            'setting' => $data
        ]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'value' => 'required'
        ]);

        $input = $request->only('value');

        $insert = topupSetting::create($input);

        if (!$insert) {
            return redirect('manage.setting')->with('message');
        }

        return redirect('manage.setting')->with('message');
    }

    public function disableSetting($id)
    {
        $data = topupSetting::where('id', $id)->first();

        if (!$data) {
            return redirect('manage.setting')->with('message');
        }

        $data->status = '2';
        $data->save();

        return redirect('manage.setting')->with('message');
    }

    public function activateSetting($id)
    {
        $data = topupSetting::where('id', $id)->first();

        if (!$data) {
            return redirect('manage.setting')->with('message');
        }

        $data->status = '2';
        $data->save();

        return redirect('manage.setting')->with('message');
    }

    public function delete($id)
    {
        $data = topupSetting::where('id', $id)->first();

        if (!$data) {
            return redirect('manage.setting')->with('message');
        }

        $delete = $data->delete();

        if (!$delete) {
            return redirect('manage.setting')->with('message');
        }

        return redirect('manage.setting')->with('message');
    }
}
