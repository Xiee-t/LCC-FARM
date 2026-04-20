<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\Auth\SocialController;

// --- Authentication & Landing ---
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

// --- Social Login Routes (Added for Google/Facebook) ---
Route::get('/auth/{provider}/redirect', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialController::class, 'callback'])->name('social.callback');

// --- General User ---
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Ordering ---
Route::get('/place-order', [AuthController::class, 'placeOrder'])->name('place-order');
Route::post('/place-order', [AuthController::class, 'storeOrder'])->name('order-confirm');
Route::get('/order-confirmation', function () {
    return view('pages.order_confirmation');
})->name('order-confirmation');

Route::get('/my-orders', [AuthController::class, 'myOrders'])->name('my-orders');
Route::get('/order-details/{id}', [AuthController::class, 'orderDetails'])->name('order-details');
Route::get('/order-history', [AuthController::class, 'orderHistory'])->name('order-history');
Route::get('/view-orders', [AuthController::class, 'viewOrders'])->name('view-orders');

// --- Profiles ---
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::get('/buyer/profile', [AuthController::class, 'profile'])->name('buyer-profile');
Route::get('/supplier/profile', [SupplierController::class, 'profile'])->name('supplier-profile');
Route::get('/distributor/profile', [DistributorController::class, 'profile'])->name('distributor-profile');

Route::get('/welcome', function () {
    return view('welcome');
});

// --- Supplier Routes ---
Route::get('/supplier/dashboard', [SupplierController::class, 'dashboard'])->name('supplier-dashboard');
Route::get('/supplier/inventory', [SupplierController::class, 'inventory'])->name('supplier-inventory');
Route::post('/supplier/inventory/{id}', [SupplierController::class, 'updateInventory'])->name('update-inventory');
Route::get('/supplier/orders', [SupplierController::class, 'orders'])->name('supplier-orders');
Route::post('/supplier/orders/{id}', [SupplierController::class, 'updateOrderStatus'])->name('update-order-status');

// --- Distributor Routes ---
Route::get('/distributor/dashboard', [DistributorController::class, 'dashboard'])->name('distributor-dashboard');
Route::get('/distributor/available-orders', [DistributorController::class, 'availableOrders'])->name('distributor-available-orders');
Route::get('/distributor/track-orders', [DistributorController::class, 'trackOrders'])->name('distributor-track-orders');
Route::get('/distributor/manage-suppliers', [DistributorController::class, 'manageSuppliers'])->name('distributor-manage-suppliers');
Route::post('/distributor/accept-order/{id}', [DistributorController::class, 'acceptOrder'])->name('distributor-accept-order');
Route::get('/distributor/delivery-tracking/{id}', [DistributorController::class, 'deliveryTracking'])->name('distributor-delivery-tracking');

// --- Buyer Routes ---
Route::get('/buyer/dashboard', [AuthController::class, 'buyerDashboard'])->name('buyer-dashboard');
Route::get('/buyer/order-history', [AuthController::class, 'orderHistory'])->name('buyer-order-history');