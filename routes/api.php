<?php

use App\Http\Controllers\Admin\Menu\dataController as MenuDataController;
use App\Http\Controllers\Admin\Store\dataController as StoreDataController;
use App\Http\Controllers\Admin\User\dataController;
use App\Http\Controllers\Auth\authController;
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
        Route::post('login', [authController::class, 'Storelogin']);
        Route::post('logout/{id}', [authController::class, 'Storelogout']);
        Route::post('transaction/accept', [StoreTransactionController::class, 'acceptTransactionComplete']);
        Route::post('transaction/{id}', [StoreTransactionController::class, 'listTransaction']);
    });

    Route::prefix('user')->group(function () {
        Route::post('login', [authController::class, 'login']);
        Route::post('logout/{id}', [authController::class, 'logout']);
        Route::post('transaction', [transactionController::class, 'insert']);
        Route::get('transaction/{id}', [transactionController::class, 'getTransactionListByUser']);

        Route::get('store' , [storeController::class , 'getStore']);
        Route::get('menu/{id}' , [storeController::class , 'getMenu']);
        Route::post('menu/search/' , [storeController::class , 'getMenuBySearch']);
    });
});

Route::prefix('admin')->group(function(){

    Route::prefix('/user')->group(function () {
        Route::get('/data', [dataController::class, 'getUser']);
        Route::post('/data', [dataController::class, 'create']);
        Route::post('/data/{id}', [dataController::class, 'update']);
        Route::delete('/data/{id}', [dataController::class, 'delete']);
    });
    
    Route::prefix('/store')->group(function () {
        Route::get('/data', [StoreDataController::class, 'getStore']);
        Route::post('/data', [StoreDataController::class, 'create']);
        Route::post('/data/{id}', [StoreDataController::class, 'update']);
        Route::delete('/data/{id}', [StoreDataController::class, 'delete']);

        Route::get('/menu/{store_id}' , [MenuDataController::class , 'getMenuByStore']);
        
    });

    Route::prefix('/menu')->group(function () {
        Route::get('/data', [MenuDataController::class, 'getMenu']);
        Route::get('/data/{id}' , [MenuDataController::class , 'getMenuById']);
        Route::post('/data', [MenuDataController::class, 'create']);
        Route::put('/data/{id}', [MenuDataController::class, 'update']);
        Route::delete('/data/{id}', [MenuDataController::class, 'delete']);
    });
});
