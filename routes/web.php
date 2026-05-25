<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegionController;

/*
|--------------------------------------------------------------------------
| PUBLIC (SEMUA USER)
|--------------------------------------------------------------------------
*/

// ✅ Proxy Wilayah.id (To bypass CORS)
Route::get('/api/regions/provinces', [RegionController::class, 'provinces']);
Route::get('/api/regions/regencies/{code}', [RegionController::class, 'regencies']);
Route::get('/api/regions/districts/{code}', [RegionController::class, 'districts']);
Route::get('/api/regions/villages/{code}', [RegionController::class, 'villages']);

// ✅ Landing page (welcome)
Route::get('/', function () {
    $products = \App\Models\Product::all();
    
    // Get active discounts for today
    $today = date('l'); // e.g. Monday
    $month = (int)date('m'); // e.g. 5
    
    $discounts = \App\Models\Discount::where('is_active', true)
        ->where(function($q) use ($today, $month) {
            $q->where(function($q1) use ($today) {
                $q1->whereNull('active_days')->orWhere('active_days', 'like', "%$today%");
            })->where(function($q2) use ($month) {
                $q2->whereNull('active_months')->orWhere('active_months', 'like', "%$month%");
            });
        })->get();

    return view('welcome', compact('products', 'discounts'));
});

// ✅ Redirect /home ke halaman yang sesuai
Route::get('/home', function () {
    if (!auth()->check()) return redirect('/login');
    
    if (auth()->user()->role == 'admin') return redirect('/admin/dashboard');
    if (auth()->user()->role == 'courier') return redirect('/courier/orders');
    
    return redirect('/profile');
});

// ✅ Halaman produk (user lihat barang)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);


/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isCustomer'])->group(function () {

    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{id}', [CartController::class, 'add']);
    Route::post('/cart/update', [CartController::class, 'updateQty']);
    Route::post('/cart/update/{id}', [CartController::class, 'update']);
    Route::post('/buy-now/{id}', [CartController::class, 'buyNow']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);

    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::post('/checkout', [CheckoutController::class, 'process']);

    Route::get('/pay/{id}', [\App\Http\Controllers\PaymentController::class, 'pay']);
    Route::post('/pay/success/{id}', [\App\Http\Controllers\PaymentController::class, 'success']);

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/my-orders', [\App\Http\Controllers\ProfileController::class, 'myOrders'])->name('profile.orders');
    Route::get('/my-orders/{id}/track', [\App\Http\Controllers\ProfileController::class, 'trackOrder'])->name('profile.track');
    Route::post('/my-orders/{id}/confirm', [\App\Http\Controllers\ProfileController::class, 'confirmOrder'])->name('profile.confirm');
    Route::post('/my-orders/{id}/refund', [\App\Http\Controllers\ProfileController::class, 'refundOrder'])->name('profile.refund');
    Route::get('/my-orders/{id}/location', [\App\Http\Controllers\ProfileController::class, 'getCourierLocation'])->name('profile.courier_location');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/address', [\App\Http\Controllers\ProfileController::class, 'storeAddress'])->name('profile.address.store');
    Route::put('/profile/address/{id}', [\App\Http\Controllers\ProfileController::class, 'updateAddress'])->name('profile.address.update');
    Route::post('/notifications/mark-as-read', [\App\Http\Controllers\ProfileController::class, 'markNotificationsAsRead']);
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isAdmin'])
->prefix('admin')
->group(function () {

    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });

    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard']);

    Route::resource('products', AdminProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders/{id}/confirm', [OrderController::class, 'confirm']);
    Route::post('/orders/{id}/assign', [OrderController::class, 'assignCourier']);
    Route::post('/orders/{id}/notify', [OrderController::class, 'notify']);

    Route::resource('couriers', \App\Http\Controllers\Admin\CourierController::class);
    Route::resource('discounts', \App\Http\Controllers\Admin\DiscountController::class);

    Route::get('/revenue', [RevenueController::class, 'index']);
    Route::get('/revenue/pdf', [RevenueController::class, 'downloadPdf']);
    Route::get('/revenue/excel', [RevenueController::class, 'downloadExcel']);

});


/*
|--------------------------------------------------------------------------
| COURIER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isCourier'])
->prefix('courier')
->group(function () {

    Route::get('/', function () {
        return redirect('/courier/orders');
    });

    Route::get('/orders', [CourierController::class, 'index']);
    Route::post('/orders/{id}/done', [CourierController::class, 'done']);
    Route::post('/location', [CourierController::class, 'updateLocation']);

});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Google Login
Route::get('auth/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/call-back', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

// Captcha
Route::get('/refresh-captcha', [App\Http\Controllers\Auth\LoginController::class, 'refreshCaptcha'])->name('captcha.refresh');



Route::get('/users', [UserController::class, 'index']);
Route::post('/users/{id}/role', [UserController::class, 'updateRole']);