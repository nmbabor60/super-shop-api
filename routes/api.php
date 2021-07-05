<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['namespace'=>'\App\Http\Controllers','middleware'=>'auth:api'],function() {
    Route::get('users', 'UserController@getAllUsers');
    Route::apiResource('category', 'CategoryController');
    Route::apiResource('brand', 'BrandController');
    Route::apiResource('units', 'UnitController');
    Route::apiResource('sub-category', 'SubCategoryController');
    Route::apiResource('products', 'ProductController');
    Route::apiResource('supplier', 'SupplierController');
    Route::apiResource('purchase', 'PurchaseController');
    Route::apiResource('sales', 'SalesController');
});

Route::group(['namespace'=>'\App\Http\Controllers'],function(){
    Route::post('login','AuthController@login');

    Route::post('store-user','UserController@storeUser');
    Route::delete('delete-user/{id}','UserController@userDelete');
});
