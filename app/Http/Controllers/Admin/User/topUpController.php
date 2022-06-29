<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class topUpController extends Controller
{
    public function checkData(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'balance' => 'required'
        ]);

        $data = User::where('username', $request->username)->first();

        if (!$data) {
            return response(
                '<div class="card-body">
                    <center><p> No Data </p></center>
                </div>'
            );
        }

        return response(
            [ 'data' =>'
                '.csrf_field().
                '<div class="card-body">
                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="username" class="form-control form-control-solid" placeholder="Enter Username" value="' . $data->username . '" readonly />
                    <span class="form-text text-muted">NISN Siswa</span>
                </div>
                <div class="col-1"></div>
                <div class="form-group">
                    <label>Amount:</label>
                    <input type="number" name="balance" class="form-control form-control-solid" placeholder="Enter amount" value="' . $request->balance . '" readonly />
                    <span class="form-text text-muted">Angka 1-9 tanpa Rp ataupun tanda baca lain</span>
                </div>
            </form>

            <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>',

                'action' => '/manage/user/topUpBalance'
            ]
        );
    }
}
