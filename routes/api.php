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
 Route::post('me', 'ProfileUserController@me');
});
//=================== end Auth User =======================
//================== begin cart route =====================
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile'],'namespace'=>'Cart'], function(){
    Route::post('cartUser', 'CartController@index');
    Route::post('cart', 'CartController@store');
    Route::post('increaseQuantity', 'CartController@increaseQuantity');
    Route::post('updateQuantity', 'CartController@update');
    Route::post('deleteCart', 'CartController@destroy');

   // Route::post('cart', 'CartController@update');
});
//================== end cart route =====================

// ================ begin Address Route ===================
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile'],'namespace'=>'Address'], function(){
    Route::post('addresses', 'AddressesController@index');
    Route::post('address', 'AddressesController@store');
    Route::post('addressShiping', 'AddressesController@store');
});
// ================ End Address Route   ===================
// ================ begin countries Route ===================
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile'],'namespace'=>'Country'], function(){
    Route::post('countries', 'CountriesController@index');

});
// ================ End countries Route   ===================
// ================ begin AddrssByShipping Route ===================
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile'],'namespace'=>'Address'], function(){
    Route::post('addressShipping', 'AddressShipingController@action');

});
// ================ End Order Route   ===================
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile'],'namespace'=>'Order'], function(){
    Route::post('orders', 'OrderController@index');
    Route::post('order', 'OrderController@store');

});
// ================ End Order Route   ===================

// ================ begin payment Route ===================
Route::group(['middleware'=>['checkPassword', 'logRoute', 'debugProfile'],'namespace'=>'Payment'], function(){
    Route::post('payments', 'PaymentMethodController@index');

     Route::post('storePayment', 'PaymentMethodController@store');


});
// ================ End payment Route   ===================

//Route::resource('products', 'Product\ProductsController');
//Route::get('product/{id}', 'Product\ProductsController@getProductById');
