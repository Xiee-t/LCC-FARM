<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DistributorController;

// --- Landing & Auth ---
Route::get('/', function () { return view('pages.landing_page'); })->name('landing');
Route::get('/login', function () { return view('pages.login'); })->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/signup', function () { return view('pages.signup'); })->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Navigation ---
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

// --- Ordering ---
Route::get('/place-order', [AuthController::class, 'placeOrder'])->name('place-order');
Route::post('/place-order', [AuthController::class, 'storeOrder'])->name('order-confirm');
Route::get('/my-orders', [AuthController::class, 'myOrders'])->name('my-orders');
Route::get('/view-orders', [AuthController::class, 'myOrders'])->name('view-orders'); 
Route::get('/order-history', [AuthController::class, 'myOrders'])->name('order-history');
Route::get('/order-details/{id}', [AuthController::class, 'orderDetails'])->name('order-details');

// --- Social Login ---
Route::get('/auth/{provider}/redirect', [AuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback'])->name('social.callback');

// --- Role Dashboards ---

// 1. Buyer
Route::get('/buyer/dashboard', [AuthController::class, 'buyerDashboard'])->name('buyer-dashboard');
Route::get('/buyer/profile', [AuthController::class, 'profile'])->name('buyer-profile');

// 2. Supplier
Route::get('/supplier/dashboard', [SupplierController::class, 'dashboard'])->name('supplier-dashboard');
Route::get('/supplier/inventory', [SupplierController::class, 'inventory'])->name('supplier-inventory');
Route::post('/supplier/inventory/{id}', [SupplierController::class, 'updateInventory'])->name('supplier-inventory.update');
Route::get('/supplier/orders', [SupplierController::class, 'orders'])->name('supplier-orders');
Route::post('/supplier/orders/{id}', [SupplierController::class, 'updateOrderStatus'])->name('supplier-orders.update');
Route::get('/supplier/profile', [AuthController::class, 'profile'])->name('supplier-profile');

// 3. Distributor (Grouped for organization)
Route::prefix('distributor')->group(function () {
    Route::get('/dashboard', [DistributorController::class, 'dashboard'])->name('distributor-dashboard');
    Route::get('/available-orders', [DistributorController::class, 'availableOrders'])->name('distributor-available-orders');
    Route::post('/accept-order/{id}', [DistributorController::class, 'acceptOrder'])->name('distributor-accept-order');
    Route::get('/track-orders', [DistributorController::class, 'trackOrders'])->name('distributor-track-orders');
    Route::get('/manage-suppliers', [DistributorController::class, 'manageSuppliers'])->name('distributor-manage-suppliers');
    
    // Route for the profile page
    Route::get('/profile', [DistributorController::class, 'profile'])->name('distributor-profile');
});
