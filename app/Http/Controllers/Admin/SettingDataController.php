<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\topupSetting;
use Illuminate\Http\Request;

class SettingDataController extends Controller
{
    public function index()
    {

        $data = topupSetting::all();

        return view('pages.setting', [
            'page_title' => 'Setting',
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
            return redirect(route('manage.setting'))->with('message');
        }

        return redirect(route('manage.setting'))->with('message');
    }

    public function disableSetting($id)
    {
        $data = topupSetting::where('id', $id)->first();

        if (!$data) {
            return redirect(route('manage.setting'))->with('message');
        }

        $data->status = '2';
        $data->save();

        return redirect(route('manage.setting'))->with('message');
    }

    public function activateSetting($id)
    {
        $data = topupSetting::where('id', $id)->first();

        if (!$data) {
            return redirect(route('manage.setting'))->with('message');
        }

        $data->status = '1';
        $data->save();

        return redirect(route('manage.setting'))->with('message');
    }

    public function delete($id)
    {
        $data = topupSetting::where('id', $id)->first();

        if (!$data) {
            return redirect(route('manage.setting'))->with('message');
        }

        $delete = $data->delete();

        if (!$delete) {
            return redirect(route('manage.setting'))->with('message');
        }

        return redirect(route('manage.setting'))->with('message');
    }
}
