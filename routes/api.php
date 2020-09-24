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
// ========== begin category endpoints ================
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile'], 'namespace'=>'Category'], function(){
    Route::post('mainCategories', 'CategoriesController@Maincategories');
    Route::post('subCategory', 'CategoriesController@subCategories');
    Route::post('categories', 'CategoriesController@categoryWithChildren');
});
// ========== end category endpoints ================

// ========== begin products endpoints ================
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile'], 'namespace'=>'Product'], function(){
    Route::post('products', 'ProductsController@getproducts');
    Route::post('productwithslug', 'ProductsController@show');
    Route::post('product', 'ProductsController@getProductById');
    Route::post('productsbycategory', 'ProductsController@getProductByCategory');
    Route::post('productsWithvariationsbycategory', 'ProductsController@getproductswithVariationsByCategory');
});
// =============== end products endpoints ===================
// =================== begin Auth User =====================
Route::group(['middleware'=>['api','checkPassword', 'logRoute', 'debugProfile'],'namespace'=>'Register', 'prefix'=>'auth'], function(){
 Route::post('register', 'AuthController@register');
 Route::post('login', 'AuthController@login');
});
//=================== end Auth User =======================
//Route::resource('products', 'Product\ProductsController');
//Route::get('product/{id}', 'Product\ProductsController@getProductById');
