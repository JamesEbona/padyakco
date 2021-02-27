<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BicyclesController;
use App\Http\Controllers\CartController;

use App\Mail\OrderDelivered;
use App\Models\Order;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->middleware('logged')->name('home');
Route::get('/bicycles', [BicyclesController::class, 'index'])->name('bicycles');
Route::post('/bicycles/fetch_data', [BicyclesController::class, 'fetch_bicycles_data']);
Route::get('/bicycles/show/{id}', [BicyclesController::class, 'show'])->name('viewBicycle');
Route::get('/cart', [CartController::class, 'index'])->name('cart')->middleware('logged');
Route::get('/cart/add/{id}', [CartController::class, 'store'])->name('addCart');
Route::get('/cart/addOne/{id}', [CartController::class, 'addByOne'])->name('addOneCart');
Route::get('/cart/reduce/{id}', [CartController::class, 'reduceByOne'])->name('reduceCart');
Route::get('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('removeCart');

Route::get('/email', function(){
    $order = Order::where('id',13)->firstOrFail();
    return new OrderDelivered($order);
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::group([
    'prefix' => 'member',
    'namespace' => 'App\Http\Controllers\Member',
    'middleware' => ['auth','member','verified','active']
], function () {
    Route::get('/', 'AccountController@index')->name('myAccount');
    Route::get('editprofile', 'AccountController@edit_profile')->name('editProfile');
    Route::patch('updateprofile', 'AccountController@update_profile');
    Route::get('editpassword', 'AccountController@edit_password')->name('editPassword');
    Route::patch('updatepassword', 'AccountController@update_password');
    Route::get('editaddress', 'AccountController@edit_address')->name('editAddress');
    Route::patch('updateaddress', 'AccountController@update_address');
    Route::get('cart', 'CartController@index')->name('memberCart');
    Route::get('cart/add/{id}', 'CartController@store')->name('memberAddCart');
    Route::get('cart/addOne/{id}', 'CartController@addByOne')->name('memberAddOneCart');
    Route::get('cart/reduce/{id}', 'CartController@reduceByOne')->name('memberReduceCart');
    Route::get('cart/remove/{id}', 'CartController@removeItem')->name('memberRemoveCart');
    Route::get('/checkout/address', 'CheckoutController@address')->name('checkoutAddress');
    Route::patch('/checkout/address/save', 'CheckoutController@saveAddress')->name('saveAddress');
    Route::get('/checkout/review', 'CheckoutController@review')->name('checkoutReview');
    Route::post('/checkout/check', 'CheckoutController@check')->name('check');
    Route::post('/checkout/order', 'CheckoutController@order')->name('order');
    Route::get('/checkout/orderPlaced', 'CheckoutController@orderPlaced')->name('orderPlaced');
    Route::get('orders', 'OrderController@index')->name('orders');
    Route::get('orders/{id}', 'OrderController@show')->name('orderView');
});

Route::group([
    'prefix' => 'admin',
    'namespace' => 'App\Http\Controllers\Admin',
    'middleware' => ['auth','admin','active']
], function () {
    Route::get('/', 'DashboardController@index')->name('adminDashboard');
    Route::get('memberusers', 'UsersController@membersindex')->name('memberUsers');
    Route::get('adminusers', 'UsersController@adminsindex')->name('adminUsers');
    Route::post('users/memberstore', 'UsersController@memberstore');
    Route::post('users/adminstore', 'UsersController@adminstore');
    Route::post('users/modify', 'UsersController@modify');
    Route::get('users/activate/{id}', 'UsersController@activate');
    Route::get('users/deactivate/{id}', 'UsersController@deactivate');
    Route::get('users/delete/{id}', 'UsersController@destroy');
    Route::get('/viewUser', 'UsersController@show')->name('ViewUser');
    Route::get('/editUser', 'UsersController@edit')->name('EditUser');
    Route::get('/changePassword', 'UsersController@changepassword');
    Route::patch('/updateUser', 'UsersController@update');
    Route::patch('/submitchangepassword', 'UsersController@updatepassword');
    Route::get('products', 'ProductsController@index')->name('products');
    Route::post('products/store', 'ProductsController@store');
    Route::post('products/edit', 'ProductsController@edit');
    Route::get('products/activate/{id}', 'ProductsController@activate');
    Route::get('products/deactivate/{id}', 'ProductsController@deactivate');
    Route::get('products/delete/{id}', 'ProductsController@destroy');
    Route::get('categories', 'CategoriesController@index')->name('categories');
    Route::post('categories/store', 'CategoriesController@store');
    Route::post('categories/edit', 'CategoriesController@edit');
    Route::get('categories/delete/{id}', 'CategoriesController@destroy');
    Route::get('subcategories', 'SubCategoriesController@index')->name('subCategories');
    Route::post('subcategories/store', 'SubCategoriesController@store');
    Route::post('subcategories/edit', 'SubCategoriesController@edit');
    Route::get('subcategories/delete/{id}', 'SubCategoriesController@destroy');
    Route::get('orders', 'OrdersController@index')->name('adminOrders');

});

require __DIR__.'/auth.php';
