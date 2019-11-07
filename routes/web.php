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
    // 下众筹类订单
    Route::post('crowdfunding_orders', 'OrdersController@crowdfunding')->name('crowdfunding_orders.store');
    // 订单列表
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    // 订单详情
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
    // 订单改为收货状态
    Route::post('orders/{order}/received', 'OrdersController@received')->name('orders.received');
    // 支付宝支付
    Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
    // 支付宝前端回调,需要auth认证
    Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');
    // 微信支付
    Route::get('payment/{order}/wechat_pay', 'PaymentController@payByWechat')->name('payment.wechat');
    // 评价页面
    Route::get('orders/{order}/review', 'OrdersController@review')->name('orders.review.show');
    // 提交订单评价
    Route::post('orders/{order}/review', 'OrdersController@sendReview')->name('orders.review.store');
    // 申请退款
    Route::post('orders/{order}/apply_refund', 'OrdersController@applyRefund')->name('orders.apply_refund');
    // 微信退款回调
    Route::post('payment/wechat/refund_notify', 'PaymentController@wechatRefundNotify')->name('payment.wechat.refund_notify');
    // 验证优惠码是否可用
    Route::get('coupon_codes/{code}', 'CouponCodesController@show')->name('coupon_codes.show');
});
// 支付宝后端回调
// 服务器端回调的路由不能放到带有 auth 中间件的路由组中，因为支付宝的服务器请求不会带有认证信息。
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
// 微信支付回调
Route::post('payment/wechat/notify', 'PaymentController@wechatNotify')->name('payment.wechat.notify');
