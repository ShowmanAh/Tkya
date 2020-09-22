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
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile']], function(){
 Route::post('categories', 'Category\CategoriesController@index');
 Route::post('products', 'Product\ProductsController@index');
 Route::post('product/{slug}', 'Product\ProductsController@show');

 Route::post('hi', function(){
return 'hi';
 });
});


