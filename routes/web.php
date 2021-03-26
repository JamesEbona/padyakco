<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\GuidesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InquiriesController;

use App\Mail\BookingDone;
use App\Mail\BookingConfirmed;
use App\Mail\BookingPayment;
use App\Mail\BookingAdminNotification;
use App\Mail\OrderReceipt;
use App\Models\Booking;
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
Route::get('/store', [ProductsController::class, 'index'])->name('store');
Route::post('/store/fetch_data', [ProductsController::class, 'fetch_products_data']);
Route::get('/store/show/{id}', [ProductsController::class, 'show'])->name('viewProduct');
Route::get('/cart', [CartController::class, 'index'])->name('cart')->middleware('logged');
Route::get('/cart/add/{id}', [CartController::class, 'store'])->name('addCart');
Route::get('/cart/addOne/{id}', [CartController::class, 'addByOne'])->name('addOneCart');
Route::get('/cart/reduce/{id}', [CartController::class, 'reduceByOne'])->name('reduceCart');
Route::get('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('removeCart');
Route::get('/guides', [GuidesController::class, 'index'])->name('tripGuides');
Route::post('/guides/fetch_data', [GuidesController::class, 'fetch_guides_data']);
Route::get('/guides/show/{id}', [GuidesController::class, 'show'])->name('viewGuide');
Route::post('/inquiries/store', [InquiriesController::class, 'store'])->name('storeInquiry');

Route::get('/email', function(){
  
    $order = Booking::findOrFail(34);

    return new BookingAdminNotification($order);
});

Route::get('/email/order', function(){
  
    $order = Order::findOrFail(34);

    return new OrderReceipt($order);
});

// Route::get('/email', function(){
  
//     $order = Booking::findOrFail(32);

//     return new BookingPayment($order);
// });

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
    Route::post('/checkout/storeCoupon', 'CheckoutController@storeCoupon')->name('store.storeCoupon');
    Route::post('/checkout/destroyCoupon', 'CheckoutController@destroyCoupon')->name('store.destroyCoupon');
    Route::get('orders', 'OrderController@index')->name('orders');
    Route::get('orders/{id}', 'OrderController@show')->name('orderView');
    Route::get('book', 'BookingController@index')->name('book');
    Route::post('book/process', 'BookingController@book')->name('bookProcess');
    Route::get('book/mybookings', 'BookingController@view')->name('bookView');
    Route::get('book/{id}', 'BookingController@show')->name('bookShow');
    Route::get('book/cancel/{id}', 'BookingController@cancel');
    Route::post('book/pay', 'BookingController@pay')->name('bookPay');
    Route::post('book/storeCoupon', 'BookingController@storeCoupon')->name('repair.storeCoupon');
    Route::post('book/destroyCoupon', 'BookingController@destroyCoupon')->name('repair.destroyCoupon');
    Route::get('contact', 'InquiriesController@index')->name('memberContact');
    Route::post('contact/send', 'InquiriesController@store');
});

Route::group([
    'prefix' => 'admin',
    'namespace' => 'App\Http\Controllers\Admin',
    'middleware' => ['auth','admin','active']
], function () {
    Route::get('/', 'DashboardController@index')->name('adminDashboard');
    Route::get('storeDailySales','DashboardController@storeDailySales');
    Route::get('bookingDailySales','DashboardController@bookingDailySales');
    Route::get('memberusers', 'UsersController@membersindex')->name('memberUsers');
    Route::get('adminusers', 'UsersController@adminsindex')->name('adminUsers');
    Route::get('mechanicusers', 'UsersController@mechanicsindex')->name('mechanicUsers');
    Route::post('users/memberstore', 'UsersController@memberstore');
    Route::post('users/adminstore', 'UsersController@adminstore');
    Route::post('users/mechanicstore', 'UsersController@mechanicstore');
    Route::post('users/modify', 'UsersController@modify');
    Route::post('users/modifyAdmin', 'UsersController@Admin');
    Route::post('users/modifyMechanic', 'UsersController@modifyMechanic');
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
    Route::get('categories/activate/{id}', 'CategoriesController@activate');
    Route::get('categories/deactivate/{id}', 'CategoriesController@deactivate');
    Route::get('categories/delete/{id}', 'CategoriesController@destroy');
    Route::get('subcategories', 'SubCategoriesController@index')->name('subCategories');
    Route::post('subcategories/store', 'SubCategoriesController@store');
    Route::post('subcategories/edit', 'SubCategoriesController@edit');
    Route::get('subcategories/activate/{id}', 'SubCategoriesController@activate');
    Route::get('subcategories/deactivate/{id}', 'SubCategoriesController@deactivate');
    Route::get('subcategories/delete/{id}', 'SubCategoriesController@destroy');
    Route::get('orders', 'OrdersController@index')->name('adminOrders');
    Route::post('orders/modify', 'OrdersController@modify');
    Route::post('orders/updateStatus', 'OrdersController@updateStatus');
    Route::get('orders/show/{id}', 'OrdersController@show')->name('adminOrderView');
    Route::get('bookings', 'BookingsController@index')->name('adminBookings');
    Route::get('bookings/calendar', 'BookingsController@calendar')->name('adminBookingsCalendar');
    Route::get('bookings/calendar/{id}', 'BookingsController@mechanicCalendar');
    Route::post('bookings/modify', 'BookingsController@modify');
    Route::get('bookings/showAddress/{id}', 'BookingsController@showAddress')->name('adminBookingsShowAddress');
    Route::patch('bookings/updateAddress', 'BookingsController@updateAddress')->name('adminBookingUpdateAddress');
    Route::post('bookings/updateMechanic', 'BookingsController@updateMechanic');
    Route::get('prices', 'PricesController@index')->name('adminPrices');
    Route::patch('prices/update', 'PricesController@modify')->name('updatePrices');
    Route::get('guides', 'GuidesController@index')->name('guide.index');
    Route::get('guides/create', 'GuidesController@create')->name('guide.create');
    Route::post('guides/upload', 'GuidesController@upload')->name('guide.upload');
    Route::get('guides/edit/{id}', 'GuidesController@edit')->name('guide.edit');
    Route::patch('guides/update', 'GuidesController@update')->name('guide.update');
    Route::post('guides/store', 'GuidesController@store')->name('guide.store');
    Route::get('guides/activate/{id}', 'GuidesController@activate');
    Route::get('guides/deactivate/{id}', 'GuidesController@deactivate');
    Route::get('guides/delete/{id}', 'GuidesController@destroy');
    Route::get('guideCategories', 'GuideCategoriesController@index')->name('guideCategories');
    Route::post('guideCategories/store', 'GuideCategoriesController@store');
    Route::post('guideCategories/edit', 'GuideCategoriesController@edit');
    Route::get('guideCategories/delete/{id}', 'GuideCategoriesController@destroy');
    Route::get('inquiries', 'InquiriesController@index')->name('inquiries');
    Route::get('inquiries/delete/{id}', 'InquiriesController@destroy');
    Route::post('inquiries/reply', 'InquiriesController@reply');
    Route::get('couriers', 'CouriersController@index')->name('couriers');
    Route::post('couriers/store', 'CouriersController@store');
    Route::post('couriers/edit', 'CouriersController@edit');
    Route::get('couriers/delete/{id}', 'CouriersController@destroy');
    Route::get('coupons', 'CouponsController@index')->name('coupons.index');
    Route::post('coupons/store', 'CouponsController@store');
    Route::post('coupons/update', 'CouponsController@update');
    Route::get('coupons/activate/{id}', 'CouponsController@activate');
    Route::get('coupons/deactivate/{id}', 'CouponsController@deactivate');
    Route::get('coupons/delete/{id}', 'CouponsController@destroy');
   
});

Route::group([
    'prefix' => 'mechanic',
    'namespace' => 'App\Http\Controllers\Mechanic',
    'middleware' => ['auth','mechanic','active']
], function () {
    Route::get('/', 'DashboardController@index')->name('mechanicDashboard');
    Route::get('/viewUser', 'AccountController@show')->name('mechanicViewUser');
    Route::get('/editUser', 'AccountController@edit')->name('mechanicEditUser');
    Route::get('/changePassword', 'AccountController@changepassword');
    Route::patch('/updateUser', 'AccountController@update');
    Route::patch('/submitchangepassword', 'AccountController@updatepassword');
    Route::get('bookings', 'BookingsController@index')->name('mechanicBookings');
    Route::post('bookings/updateStatus', 'BookingsController@updateStatus');
    Route::post('bookings/modify', 'BookingsController@modify');
    Route::get('bookings/showAddress/{id}', 'BookingsController@showAddress')->name('mechanicBookingsShowAddress');
    Route::get('bookings/calendar', 'BookingsController@calendar')->name('mechanicBookingsCalendar');
    
});

require __DIR__.'/auth.php';
