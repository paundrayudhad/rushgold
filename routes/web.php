<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProfileController;


Route::get('/home', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('home');
});
Route::get('/shop/{slug}', [ShopController::class, 'index'])->name('shop.category');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register.show');
Route::post('/register', [AuthController::class, 'store'])->name('register.perform');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/addcart', [CartController::class, 'add'])->name('addcart');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}',  [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/payment/{order}', [OrderController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment/{order}', [OrderController::class, 'uploadPaymentProof'])->name('payment.upload');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/order/details/{order}', [OrderController::class, 'show'])->name('order.details');
});

