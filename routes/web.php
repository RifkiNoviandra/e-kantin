<?php

use App\Http\Controllers\Admin\Auth\authController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SettingDataController;
use App\Http\Controllers\Admin\Store\Menu\dataController as MenuDataController;
use App\Http\Controllers\Admin\Store\Menu\webController as MenuWebController;
use App\Http\Controllers\Admin\Store\Transaction\transactionController;
use App\Http\Controllers\Admin\Store\webController as StoreWebController;
use App\Http\Controllers\Admin\Transaction\webController as TransactionWebController;
use App\Http\Controllers\Admin\User\dataController;
use App\Http\Controllers\Admin\User\topUpController;
use App\Http\Controllers\Admin\User\webController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PageController::class ,'index']);
Route::post('/login' , [authController::class , 'login'])->name('guest.login');

Route::get('/datatables', [PageController::class ,'datatables']);
Route::get('/ktdatatables', [PageController::class ,'ktDatatables']);
Route::get('/select2', [PageController::class ,'select2']);
Route::get('/jquerymask', [PageController::class ,'jQueryMask']);
Route::get('/icons/custom-icons', [PageController::class ,'customIcons']);
Route::get('/icons/flaticon', [PageController::class ,'flaticon']);
Route::get('/icons/fontawesome', [PageController::class ,'fontawesome']);
Route::get('/icons/lineawesome', [PageController::class ,'lineawesome']);
Route::get('/icons/socicons', [PageController::class ,'socicons']);
Route::get('/icons/svg', [PageController::class ,'svg']);

Route::prefix('manage')->middleware('session')->group(function() {

    Route::get('/dashboard' , [PageController::class , 'dashboard'])->name('dashboard');

    Route::get('/user' , [PageController::class , 'user'])->name('manage');
    Route::get('/user/topUpBalance' , [PageController::class , 'topUp'])->name('manage.topUp');
    Route::post('/user/check/topUpBalance' , [topUpController::class , 'checkData'])->name('manage.topUp.check');
    Route::post('/user/topUpBalance' , [webController::class , 'updateBalance'])->name('topUp');

    Route::get('/user/{id}' , [webController::class , 'getUserById'])->name('manage.user');
    Route::post('/user' , [webController::class , 'create'])->name('manage.user.create');
    Route::put('/user/{id}' , [webController::class , 'update'])->name('manage.user.update');
    Route::get('/user/delete/{id}' , [webController::class , 'delete'])->name('manage.user.delete');

    Route::get('/store' , [PageController::class , 'store'])->name('store');   
    Route::get('/store/{id}' , [StoreWebController::class , 'getStoreById'])->name('manage.store');
    Route::post('/store' , [StoreWebController::class , 'create'])->name('manage.store.create');
    Route::put('/store/{id}' , [StoreWebController::class , 'update'])->name('manage.store.update');
    Route::get('/store/delete/{id}' , [StoreWebController::class , 'delete'])->name('manage.store.delete');

    Route::get('/disable/store/{id}' , [StoreWebController::class , 'disableStore'])->name('manage.store.disable');
    Route::get('/activate/store/{id}' , [StoreWebController::class , 'activateStore'])->name('manage.store.activate');

    Route::get('/store/menu/{id}' , [StoreWebController::class , 'menuList'])->name('manage.store.menu');
    Route::post('/store/menu/{id}' , [MenuWebController::class , 'create'])->name('manage.store.menu.create');
    Route::get('/store/menu/data/{id}' , [MenuWebController::class , 'checkData'])->name('manage.store.menu.data');
    Route::put('/store/menu/update/{id}' , [MenuWebController::class , 'update'])->name('manage.store..menu.update');
    Route::get('/store/menu/delete/{id}/{store_id}' , [MenuWebController::class , 'delete'])->name('manage.store.menu.delete');

    Route::get('/store/transaction/{id}' , [transactionController::class , 'index'])->name('manage.store.transaction');
    Route::post('/store/retrieve/{id}' , [transactionController::class , 'retrieveBalance'])->name('manage.store.retrieve');

    Route::get('setting' , [SettingDataController::class , 'index'])->name('manage.setting');
    Route::post('setting' , [SettingDataController::class , 'insert'])->name('manage.setting.insert');
    Route::get('setting/disable/{id}' , [SettingDataController::class , 'disableSetting'])->name('manage.setting.disable');
    Route::get('setting/activate/{id}' , [SettingDataController::class , 'activateSetting'])->name('manage.setting.activate');
    Route::get('setting/delete/{id}' , [SettingDataController::class , 'delete'])->name('manage.setting.delete');

    Route::get('transaction' , [PageController::class , 'transaction'])->name('transaction');
    Route::get('transaction/{id}' , [TransactionWebController::class , 'checkData']);
    Route::post('transaction/cancel' , [TransactionWebController::class , 'cancel'])->name('manage.transaction.cancel');
});

// Q]uick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', [PageController::class ,'quickSearch'])->name('quick-search');
