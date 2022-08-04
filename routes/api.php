<?php

use App\Http\Controllers\Admin\Auth\authController as AuthAuthController;
use App\Http\Controllers\Admin\Menu\dataController as MenuDataController;
use App\Http\Controllers\Admin\Store\dataController as StoreDataController;
use App\Http\Controllers\Admin\Store\Menu\dataController as StoreMenuDataController;
use App\Http\Controllers\Admin\Transaction\dataController as TransactionDataController;
use App\Http\Controllers\Admin\Transaction\webController;
use App\Http\Controllers\Admin\User\dataController;
use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\Client\RandomDataController;
use App\Http\Controllers\Client\Store\transactionController as StoreTransactionController;
use App\Http\Controllers\Client\storeController;
use App\Http\Controllers\Client\transactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::prefix('client')->group(function () {

    Route::prefix('store')->group(function () {
        Route::post('login', [AuthAuthController::class, 'loginApp']);
        Route::post('logout/{id}', [authController::class, 'Storelogout']);
        Route::post('transaction/accept', [StoreTransactionController::class, 'acceptTransactionComplete']);
        Route::post('transaction/{id}', [StoreTransactionController::class, 'listTransaction']);
        Route::get('transaction/done', [StoreTransactionController::class, 'listTransactionDone']);
        Route::post('transaction/count/{id}', [StoreTransactionController::class, 'countTransactionDay']);
        Route::post('transaction/detail/{id}', [StoreTransactionController::class, 'getTransactionByIdAndStore']);
    });

    Route::prefix('user')->group(function () {
        Route::post('login', [authController::class, 'login']);
        Route::post('logout/{id}', [authController::class, 'logout']);
        Route::post('transaction', [transactionController::class, 'insert']);
        Route::get('transaction/{id}', [transactionController::class, 'getTransactionListByUser']);
        Route::get('transaction/detail/{id}', [transactionController::class, 'getTransactionListById']);

        Route::get('store' , [storeController::class , 'getStore']);
        Route::get('menu/{id}' , [storeController::class , 'getMenu']);
        Route::post('menu/search/' , [storeController::class , 'getMenuBySearch']);

        Route::get('menu/data/random' , [RandomDataController::class , 'getRandomMenu']);
        Route::get('store/most' , [RandomDataController::class , 'getStoreMostTransaction']);

    });
});

Route::prefix('admin')->group(function(){

    Route::prefix('/user')->group(function () {
        Route::get('/data', [dataController::class, 'getUser']);
        Route::get('/data/dataTable', [dataController::class, 'getUsers']);
        Route::get('/data/{id}', [dataController::class, 'getUserById']);
        Route::post('/data', [dataController::class, 'create']);
        Route::post('/data/{id}', [dataController::class, 'update']);
        Route::delete('/data/{id}', [dataController::class, 'delete']);

        Route::post('/topup', [dataController::class, 'updateBalance']);
        Route::post('/topup/option', [dataController::class, 'updateBalance'])->name('admin.topup.option');

        Route::get('/data/dummy/migrate' , [dataController::class, 'migrateData']);
    });
    
    Route::prefix('/store')->group(function () {
        Route::get('/data', [StoreDataController::class, 'getStore']);
        Route::get('/data/dataTable', [StoreDataController::class, 'getStores']);
        Route::get('/data/{id}', [StoreDataController::class, 'getStoreById']);
        Route::post('/data', [StoreDataController::class, 'create']);
        Route::post('/data/{id}', [StoreDataController::class, 'update']);
        Route::delete('/data/{id}', [StoreDataController::class, 'delete']);

        Route::get('/menu/{store_id}' , [MenuDataController::class , 'getMenuByStore']);
        Route::get('/data/menu/dataTable/{id}', [StoreMenuDataController::class, 'getMenus']);
    });

    Route::prefix('/menu')->group(function () {
        Route::get('/data', [MenuDataController::class, 'getMenu']);
        Route::get('/data/{id}' , [MenuDataController::class , 'getMenuById']);
        Route::post('/data', [MenuDataController::class, 'create']);
        Route::put('/data/{id}', [MenuDataController::class, 'update']);
        Route::delete('/data/{id}', [MenuDataController::class, 'delete']);
    });

    Route::prefix('/transaction')->group(function(){
        Route::get('/dataTable' , [TransactionDataController::class , 'getTransactions']);
        Route::get('/data/{id}' , [webController::class , 'checkData']);
    });
});
