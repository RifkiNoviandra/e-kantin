<?php

namespace App\Http\Controllers;

use App\Classes\Theme\Menu;
use App\Models\Menu as ModelsMenu;
use App\Models\Store;
use App\Models\topupSetting;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function index()
    {
        $page_title = 'Login';

        return view('pages.login', compact('page_title'));
    }

    public function dashboard()
    {
        $page_title = 'Dashboard';
        $page_description = 'Some description for the page';

        $transaction_months = Transaction::where('pickup_date' , 'LIKE' , '%'.date('Y-m').'%')->get();
        $user = User::where('status' , '1')->get();
        $store = Store::where('status' , '1')->get();
        $menu = ModelsMenu::all();

        return view('pages.dashboard', compact('page_title', 'page_description' , 'transaction_months' , 'user' , 'store' , 'menu'));
    }

    public function transaction(){
        $page_title = 'Transaction';

        return view('pages.transaction' , compact('page_title'));
    }

    public function user(){

        $data = User::all();

        return view('pages.masdatUser' , [
            'user' => $data ,
            'page_title' => 'User'
        ]);
    }

    public function store(){

        $data = Store::all();

        return view('pages.masdatStore' , [
            'store' => $data,
            'page_title' => 'Store'
        ]);
    }

    public function topUp(){

        $user = User::where('status' , '1')->get();

        $setting = topupSetting::where('status' , '1')->get();

        return view('pages.TopUp' , [
            'page_title' => 'Top Up Balance',
            'setting' => $setting,
            'user' => $user
        ]);
    }

    /**
     * Demo methods below
     */

    // Datatables
    public function datatables()
    {
        $page_title = 'Datatables';
        $page_description = 'This is datatables test page';

        return view('pages.datatables', compact('page_title', 'page_description'));
    }

    // KTDatatables
    public function ktDatatables()
    {
        $page_title = 'KTDatatables';
        $page_description = 'This is KTdatatables test page';

        return view('pages.ktdatatables', compact('page_title', 'page_description'));
    }

    // Select2
    public function select2()
    {
        $page_title = 'Select 2';
        $page_description = 'This is Select2 test page';

        return view('pages.select2', compact('page_title', 'page_description'));
    }

    // jQuery-mask
    public function jQueryMask()
    {
        $page_title = 'jquery-mask';
        $page_description = 'This is jquery masks test page';

        return view('pages.jquery-mask', compact('page_title', 'page_description'));
    }

    // custom-icons
    public function customIcons()
    {
        $page_title = 'customIcons';
        $page_description = 'This is customIcons test page';

        return view('pages.icons.custom-icons', compact('page_title', 'page_description'));
    }

    // flaticon
    public function flaticon()
    {
        $page_title = 'flaticon';
        $page_description = 'This is flaticon test page';

        return view('pages.icons.flaticon', compact('page_title', 'page_description'));
    }

    // fontawesome
    public function fontawesome()
    {
        $page_title = 'fontawesome';
        $page_description = 'This is fontawesome test page';

        return view('pages.icons.fontawesome', compact('page_title', 'page_description'));
    }

    // lineawesome
    public function lineawesome()
    {
        $page_title = 'lineawesome';
        $page_description = 'This is lineawesome test page';

        return view('pages.icons.lineawesome', compact('page_title', 'page_description'));
    }

    // socicons
    public function socicons()
    {
        $page_title = 'socicons';
        $page_description = 'This is socicons test page';

        return view('pages.icons.socicons', compact('page_title', 'page_description'));
    }

    // svg
    public function svg()
    {
        $page_title = 'svg';
        $page_description = 'This is svg test page';

        return view('pages.icons.svg', compact('page_title', 'page_description'));
    }

    // Quicksearch Result
    public function quickSearch()
    {
        return view('layout.partials.extras._quick_search_result');
    }

}
