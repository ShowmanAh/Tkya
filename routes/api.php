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
/*
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile']], function(){
 Route::post('categories', 'Category\CategoriesController@index');
 Route::post('products', 'Product\ProductsController@index');
 Route::post('product/{slug}', 'Product\ProductsController@show');

});
**/
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile'], 'namespace'=>'Category'], function(){
    Route::post('mainCategories', 'CategoriesController@Maincategories');
    Route::post('subCategory', 'CategoriesController@subCategories');
    Route::post('categories', 'CategoriesController@categoryWithChildren');
});
//Route::resource('products', 'Product\ProductsController');

