<?php

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

Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');
Route::get('products/{product}', 'ProductsController@show')->name('products.show');
Auth::routes(['verify' => true]);

// auth中间件代表需要登录 verified代表需要邮箱验证
Route::group(['middleware'=>['auth', 'verified']], function(){
    Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
    // 新建地址
    Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
    // 修改地址
    Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
    // 更新地址
    Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
    // 存储地址
    Route::post('user_addresses/store', 'UserAddressesController@store')->name('user_addresses.store');
    // 删除地址
    Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');
    // 收藏商品
    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    // 取消收藏商品
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    // 我的收藏页面
    Route::get('favorites', 'ProductsController@favorites')->name('products.favorites');
    // 添加购物车
    Route::post('cart', 'CartController@add')->name('cart.add');
    // 购物车列表
    Route::get('cart', 'CartController@index')->name('cart.index');
    // 从购物车中删除
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');
    // 添加订单
    Route::post('orders', 'OrdersController@store')->name('orders.store');
});
