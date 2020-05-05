<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('login');
});

//Route::get('pathao', 'PathaoController@pathao')->name('pathao');
//Route::get('deliveryTiger', 'DeliveryTigerController@deliveryTiger')->name('deliveryTiger');

Route::get('/user', function (){
    return redirect('user/dashboard');
});
Route::get('/admin', function (){
    return redirect('admin/dashboard');
});

Auth::routes();

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('dashboard/getData', 'DashboardController@getData')->name('getData');

    // Products
    Route::get('product/productSync', 'ProductController@productSync')->name('productSync');
    Route::post('product/image', 'ProductController@image')->name('image');
    Route::post('product/status', 'ProductController@status')->name('status');
    Route::resource('product', 'ProductController');

    // Store
    Route::post('store/status', 'StoreController@status')->name('status');
    Route::resource('store', 'StoreController');

    // Supplier

    Route::post('supplier/status', 'SupplierController@status')->name('status');
    Route::resource('supplier', 'SupplierController');

    // Purchase
    Route::get('purchase/supplier', 'PurchaseController@supplier')->name('supplier');
    Route::get('purchase/product', 'PurchaseController@product')->name('product');
    Route::resource('purchase', 'PurchaseController');

    // Product Stock
    Route::resource('stock', 'StockController');

    // Notification
    Route::resource('notification', 'NotificationController');


    // Order

    Route::get('order/deleteAll', 'OrderController@deleteAll')->name('deleteAll');
    Route::get('order/status', 'OrderController@status')->name('status');
    Route::get('order/orderSync', 'OrderController@orderSync')->name('orderSync');
    Route::get('order/view', 'OrderController@view')->name('view');

    Route::get('order/status/{status}', 'OrderController@ordersByStatus')->name('ordersByStatus');

    Route::get('order/assign', 'OrderController@assign')->name('assign');
    Route::get('order/changeStatusByCheckbox', 'OrderController@changeStatusByCheckbox')->name('changeStatusByCheckbox');
    Route::get('order/getNotes', 'OrderController@getNotes')->name('getNotes');
    Route::get('order/updateNotes', 'OrderController@updateNotes')->name('updateNotes');
    Route::get('order/oldOrders', 'OrderController@oldOrders')->name('oldOrders');


    Route::get('order/product', 'OrderController@product')->name('product');
    Route::get('order/stores', 'OrderController@stores')->name('stores');
    Route::get('order/courier', 'OrderController@courier')->name('courier');
    Route::get('order/city', 'OrderController@city')->name('city');
    Route::get('order/zone', 'OrderController@zone')->name('zone');
    Route::get('order/paymenttype', 'OrderController@paymenttype')->name('paymenttype');
    Route::get('order/paymentnumber', 'OrderController@paymentnumber')->name('paymentnumber');


    Route::get('order/countOrders', 'OrderController@countOrders')->name('countOrders');
    Route::get('order/invoice', 'OrderController@invoice')->name('invoice');
    Route::get('order/storeInvoice', 'OrderController@storeInvoice')->name('storeInvoice');
    Route::get('order/invoice/{id}', 'OrderController@viewInvoice')->name('viewInvoice');

    Route::resource('order', 'OrderController');

    // Order Type

    // Payment Type
    Route::post('payment/type/status', 'PaymentTypeController@status')->name('status');
    Route::resource('payment/type', 'PaymentTypeController');

    // Payment
    Route::get('payment/paymentType', 'PaymentController@paymentType')->name('paymentType');
    Route::post('payment/status', 'PaymentController@status')->name('status');
    Route::resource('payment', 'PaymentController');

    // Courier
    Route::post('courier/status', 'CourierController@status')->name('status');
    Route::resource('courier', 'CourierController');

    // City
    Route::post('city/status', 'CityController@status')->name('status');
    Route::get('city/courier', 'CityController@courier')->name('courier');
    Route::resource('city', 'CityController');

    // Zone
    Route::get('zone/courier', 'ZoneController@courier')->name('courier');
    Route::get('zone/city', 'ZoneController@city')->name('city');
    Route::post('zone/status', 'ZoneController@status')->name('status');
    Route::resource('zone', 'ZoneController');

    // User
    Route::get('user/users', 'UserController@users')->name('users');
    Route::get('user/role', 'UserController@role')->name('role');
    Route::get('user/status', 'UserController@status')->name('status');
    Route::resource('user', 'UserController');

    // Report
    Route::get('report/users', 'Report@users')->name('users');
    Route::get('report/dateCourierUser', 'Report@dateCourierUser')->name('dateCourierUser');
    Route::get('report/getOrdersOnDateCourierUser', 'Report@getOrdersOnDateCourierUser')->name('getOrdersOnDateCourierUser');
    Route::get('report/multipleDateCourierUser', 'Report@multipleDateCourierUser')->name('multipleDateCourierUser');
    Route::get('report/getMultipleDateCourierUser', 'Report@getMultipleDateCourierUser')->name('getMultipleDateCourierUser');
    Route::get('report/dateCourier', 'Report@dateCourier')->name('dateCourier');
    Route::get('report/getDateCourier', 'Report@getDateCourier')->name('getDateCourier');
    Route::get('report/dateUser', 'Report@dateUser')->name('dateUser');
    Route::get('report/getDateUser', 'Report@getDateUser')->name('getDateUser');

});

Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth', 'user']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('dashboard/getData', 'DashboardController@getData')->name('getData');


    // Order

    Route::get('order/deleteAll', 'OrderController@deleteAll')->name('deleteAll');
    Route::get('order/status', 'OrderController@status')->name('status');
    Route::get('order/orderSync', 'OrderController@orderSync')->name('orderSync');
    Route::get('order/view', 'OrderController@view')->name('view');

    Route::get('order/status/{status}', 'OrderController@ordersByStatus')->name('ordersByStatus');

    Route::get('order/assign', 'OrderController@assign')->name('assign');
    Route::get('order/changeStatusByCheckbox', 'OrderController@changeStatusByCheckbox')->name('changeStatusByCheckbox');
    Route::get('order/getNotes', 'OrderController@getNotes')->name('getNotes');
    Route::get('order/updateNotes', 'OrderController@updateNotes')->name('updateNotes');
    Route::get('order/oldOrders', 'OrderController@oldOrders')->name('oldOrders');


    Route::get('order/product', 'OrderController@product')->name('product');
    Route::get('order/stores', 'OrderController@stores')->name('stores');
    Route::get('order/courier', 'OrderController@courier')->name('courier');
    Route::get('order/city', 'OrderController@city')->name('city');
    Route::get('order/zone', 'OrderController@zone')->name('zone');
    Route::get('order/paymenttype', 'OrderController@paymenttype')->name('paymenttype');
    Route::get('order/paymentnumber', 'OrderController@paymentnumber')->name('paymentnumber');


    Route::get('order/countOrders', 'OrderController@countOrders')->name('countOrders');
    Route::get('order/invoice', 'OrderController@invoice')->name('invoice');
    Route::get('order/storeInvoice', 'OrderController@storeInvoice')->name('storeInvoice');
    Route::get('order/invoice/{id}', 'OrderController@viewInvoice')->name('viewInvoice');

    Route::resource('order', 'OrderController');


});


