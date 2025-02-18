<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//WelcomeController
Route::get('/notice', [WelcomeController::class, 'notice'])->name('notice');
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::post('/filter/{route}', [WelcomeController::class, 'filter'])->name('filter');

//ReservationController
Route::get('/reservation/index/{xfilter?}', [ReservationController::class, 'index'])->middleware(['auth', 'verified'])->name('reservation');
Route::post('/reservation/store', [ReservationController::class, 'store'])->middleware(['auth','access:2', 'verified', 'demo'])->name('reservation_store');
Route::get('/reservation/update_status/{id}/{status_id}', [ReservationController::class, 'update_status'])->middleware(['auth', 'verified', 'access:1', 'demo'])->name('reservation_update_status');

//UserController
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/user/index/{xfilter?}/{type?}', [UserController::class, 'index'])->middleware(['auth', 'verified', 'access:1'])->name('user');
Route::get('/user/view/{id}', [UserController::class, 'view'])->middleware(['auth', 'verified', 'access:1'])->name('user_view');
Route::get('/user/create/{id?}', [UserController::class, 'create'])->middleware(['auth', 'verified', 'access:1'])->name('user_create');
Route::post('/user/store', [UserController::class, 'store'])->middleware(['auth', 'verified', 'access:1', 'demo'])->name('user_store');
Route::get('/user/delete/{id}', [UserController::class, 'delete'])->middleware(['auth', 'verified', 'access:1', 'demo'])->name('user_delete');

//CategoryController
Route::get('/category/index', [CategoryController::class, 'index'])->middleware(['auth','access:1'])->name('category');
Route::post('/category/store', [CategoryController::class, 'store'])->middleware(['auth','access:1', 'demo'])->name('category_store');
Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->middleware(['auth','access:1', 'demo'])->name('category_delete');

//ProductController
Route::get('/product/index/{xfilter?}', [ProductController::class, 'index'])->middleware(['auth','access:1'])->name('product');
Route::get('/product/create/{id?}', [ProductController::class, 'create'])->middleware(['auth','access:1'])->name('product_create');
Route::post('/product/store', [ProductController::class, 'store'])->middleware(['auth','access:1', 'demo'])->name('product_store');
Route::get('/product/delete/{id}', [ProductController::class, 'delete'])->middleware(['auth','access:1', 'demo'])->name('product_delete');
Route::get('cart', [ProductController::class, 'cart'])->name('cart');
Route::get('refresh_cart', [ProductController::class, 'refresh_cart'])->name('refresh_cart');
Route::get('refresh_cart_pos', [ProductController::class, 'refresh_cart_pos'])->name('refresh_cart_pos');
Route::post('add-to-cart', [ProductController::class, 'addToCart'])->name('add.to.cart');
Route::patch('update-cart', [ProductController::class, 'update'])->name('update.cart');
Route::delete('remove-from-cart', [ProductController::class, 'remove'])->name('remove.from.cart');

//AddressController
Route::get('/address/index', [AddressController::class, 'index'])->middleware(['auth', 'verified', 'access:2'])->name('address');
Route::get('/address/create/{id?}', [AddressController::class, 'create'])->middleware(['auth', 'verified', 'access:2'])->name('address_create');
Route::post('/address/store', [AddressController::class, 'store'])->middleware(['auth', 'verified', 'access:2', 'demo'])->name('address_store');
Route::get('/address/delete/{id}', [AddressController::class, 'delete'])->middleware(['auth', 'verified', 'access:2', 'demo'])->name('address_delete');
Route::get('/address/make_default/{id}', [AddressController::class, 'make_default'])->middleware(['auth', 'verified', 'access:2', 'demo'])->name('address_make_default');

//OrderController
Route::match(['get','post'], '/order/summary', [OrderController::class, 'summary'])->middleware(['auth', 'verified', 'access:2'])->name('order_summary');
Route::get('/order/index/{xfilter?}', [OrderController::class, 'index'])->middleware(['auth', 'verified'])->name('orders');
Route::get('/order/view/{id}', [OrderController::class, 'view'])->middleware(['auth', 'verified'])->name('order_view');
Route::get('/order/delete/{id}', [OrderController::class, 'delete'])->middleware(['auth', 'verified', 'access:1', 'demo'])->name('order_delete');
Route::post('/order/status_update', [OrderController::class, 'status_update'])->middleware(['auth', 'verified', 'access:1', 'demo'])->name('order_status_update');
Route::get('/order/pos/{xfilter?}', [OrderController::class, 'pos'])->middleware(['auth', 'verified', 'access:1'])->name('pos');
Route::post('/order/pos_store', [OrderController::class, 'pos_store'])->middleware(['auth', 'verified', 'access:1', 'demo'])->name('pos_store');

//PaymentController
Route::get('payment_gateway/index', [PaymentGatewayController::class, 'index'])->middleware(['auth','access:1'])->name('payment_gateway');
Route::post('payment_gateway/store', [PaymentGatewayController::class, 'store'])->middleware(['auth','access:1', 'demo'])->name('payment_gateway_store');
Route::get('payment_gateway/enable/{id}', [PaymentGatewayController::class, 'enable'])->middleware(['auth','access:1', 'demo'])->name('payment_gateway_enable');
Route::get('payment_gateway/disable/{id}', [PaymentGatewayController::class, 'disable'])->middleware(['auth','access:1', 'demo'])->name('payment_gateway_disable');
Route::get('payment_gateway/success', [PaymentGatewayController::class, 'success'])->name('payment_gateway_success');
Route::get('payment_gateway/fail', [PaymentGatewayController::class, 'fail'])->name('payment_gateway_fail');
Route::get('payment_gateway/stripe_pay', [PaymentGatewayController::class, 'stripe_pay'])->name('stripe_pay');
Route::post('payment_gateway/stripe_verify_payment', [PaymentGatewayController::class, 'stripe_verify_payment'])->middleware(['demo'])->name('stripe_verify_payment');
Route::post('payment_gateway/paystack_verify_payment', [PaymentGatewayController::class, 'paystack_verify_payment'])->middleware(['demo'])->name('paystack_verify_payment');
Route::get('payment_gateway/razorpay_pay', [PaymentGatewayController::class, 'razorpay_pay'])->name('razorpay_pay');
Route::match(['get','post'], 'payment_gateway/razorpay_verify', [PaymentGatewayController::class, 'razorpay_verify'])->middleware(['demo'])->name('razorpay_verify');

//SettingController
Route::get('setting/create', [SettingController::class, 'create'])->middleware(['auth','access:1'])->name('setting_create');
Route::post('setting/store', [SettingController::class, 'store'])->middleware(['auth','access:1', 'demo'])->name('setting_store');
Route::get('setting/icon_create', [SettingController::class, 'icon_create'])->middleware(['auth','access:1'])->name('setting_icon_create');
Route::post('setting/icon_store', [SettingController::class, 'icon_store'])->middleware(['auth','access:1', 'demo'])->name('setting_icon_store');
Route::get('setting/smtp_create', [SettingController::class, 'smtp_create'])->middleware(['auth','access:1'])->name('smtp_create');
Route::post('setting/smtp_store', [SettingController::class, 'smtp_store'])->middleware(['auth','access:1', 'demo'])->name('smtp_store');
Route::get('/setting/social_create', [SettingController::class, 'social_create'])->middleware(['auth','verified','access:1'])->name('setting_social_create');
Route::post('/setting/social_store', [SettingController::class, 'social_store'])->middleware(['auth','verified','access:1', 'demo'])->name('setting_social_store');

//SlidesController
Route::get('slide/index', [SlideController::class, 'index'])->middleware(['auth','access:1'])->name('slide');
Route::get('slide/create', [SlideController::class, 'create'])->middleware(['auth','access:1'])->name('slide_create');
Route::post('slide/store', [SlideController::class, 'store'])->middleware(['auth','access:1', 'demo'])->name('slide_store');
Route::get('slide/delete/{id}', [SlideController::class, 'delete'])->middleware(['auth','access:1', 'demo'])->name('slide_delete');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware(['demo'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware(['demo'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
