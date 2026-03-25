<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('pages.landing_page');
})->name('landing');

Route::get('/login', function () {
    return view('pages.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/signup', function () {
    return view('pages.signup');
})->name('signup');

Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/place-order', [AuthController::class, 'placeOrder'])->name('place-order');
Route::post('/place-order', [AuthController::class, 'storeOrder'])->name('order-confirm');
Route::get('/order-confirmation', function () {
    return view('pages.order_confirmation');
})->name('order-confirmation');
Route::get('/my-orders', [AuthController::class, 'myOrders'])->name('my-orders');
Route::get('/order-history', [AuthController::class, 'orderHistory'])->name('order-history');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::get('/view-orders', [AuthController::class, 'viewOrders'])->name('view-orders');

Route::get('/welcome', function () {
    return view('welcome');
});
