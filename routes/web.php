<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Billing\BillController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {return view('welcome');});

#write here only befor login Routes
Route::group(['middleware'=> 'guest'],function()
{
    Route::get('/', function () {return view('welcome');})->name('welcome');
    Route::get('/register', function () {return view('register');})->name('register');
    Route::post('/authentication', [AuthenticationController::class, 'authentication'])->name('user.authentication');
    Route::post('/create', [AuthenticationController::class, 'create'])->name('user.create');
});


Route::group(['middleware' => 'auth'], function()
{
    Route::get('account/dashboard', function () {return view('account.dashboard');})->name('account.dashboard');
    Route::get('account/logout', [AuthenticationController::class, 'staff_logout'])->name('account.logout');

});


##don't write here any Routes
Route::group(['middleware' => 'admin.guest'], function()
{
    // Route::get('admin/register', function () {return view('admin.register');})->name('admin.register');
     Route::get('admin/login', function () {return view('admin.login');})->name('admin.login');
     Route::post('/admin_authentication', [AuthenticationController::class, 'admin_authentication'])->name('admin.authentication');
});


#write here only admin access Routes
Route::group(['middleware' => 'admin.auth'], function(){

    Route::get('users/userslist', [UsersController::class, 'userslist'])->name('users.userslist');
    Route::get('/add_user',function() { return view('users.add_user_from'); })->name('user.add_user');
    Route::post('user_create',[UsersController::class,'create_user'])->name('users.create_user');
    Route::get('/user/{action}/{id}',[UsersController::class,'user_view'])->name('user.view');
    Route::post('user_delete/{id}',[UsersController::class,'user_destroy'])->name('user.destroy');
    Route::post('user_update/{id}',[UsersController::class,'user_update'])->name('users.update_user');

    Route::get('cache_data', [UsersController::class, 'cache_data'])->name('cache_data');
    Route::get('customer/customerlist', [BillController::class, 'customerlist'])->name('customer.customerlist');
    Route::get('customer/{action}/{id}',[BillController::class,'viewBill'])->name('customer.viewBill');
    Route::post('customer_delete/{id}',[BillController::class,'bill_delete'])->name('customer.bill_delete');


});

#write here  admin / staff  access Routes
Route::group(['middleware' => 'both.aceess'],function(){

    Route::get('productlist', [ProductController::class, 'productlist'])->name('account.productlist');
    Route::get('account/add_product', function () {return view('account.add_product');})->name('account.add_product');
    Route::post('procduct/store', [ProductController::class, 'store'])->name('procduct.store');
    #Route::get('customer/bill', function () {return view('customer.create_bill');})->name('customer.bill');
    Route::get('customer/bill', [BillController::class, 'create_bill'])->name('customer.bill');
    Route::get('customer/bill_list', [BillController::class, 'getCustomerWithDetails'])->name('bills.getCustomerWithDetails');
    #15-11-2024
    Route::post('create_coustmer_bill', [BillController::class, 'create_coustmer_bill'])->name('bills.create_coustmer_bill');
    Route::post('bills/delete_item', [BillController::class,'DeleteCustomerItem'])->name('bills.delete_item');

});


