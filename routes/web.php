<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminDocumentController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes (Laravel UI)
Auth::routes();

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    
    // Documents
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    
    // Category browsing
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/khoa/{khoa}', [CategoryController::class, 'showKhoa'])->name('categories.khoa');
    Route::get('/categories/nganh/{nganh}', [CategoryController::class, 'showNganh'])->name('categories.nganh');
    Route::get('/categories/mon/{mon}', [CategoryController::class, 'showMon'])->name('categories.mon');
    
    // Blogs
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');
    Route::post('/blogs/{blog}/comment', [BlogController::class, 'addComment'])->name('blogs.comment');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{document}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/documents', [ProfileController::class, 'documents'])->name('profile.documents');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Users management
    Route::resource('users', AdminUserController::class);
    
    // Documents management
    Route::resource('documents', AdminDocumentController::class);
    
    // Blogs management
    Route::resource('blogs', AdminBlogController::class);
    
    // Orders management
    Route::resource('orders', AdminOrderController::class);
    Route::post('orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Categories management (Khoa, Nganh, Mon)
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    
    // Khoas
    Route::resource('khoas', AdminCategoryController::class.'@khoas');
    Route::get('khoas', [AdminCategoryController::class, 'indexKhoas'])->name('khoas.index');
    Route::post('khoas', [AdminCategoryController::class, 'storeKhoa'])->name('khoas.store');
    Route::delete('khoas/{khoa}', [AdminCategoryController::class, 'destroyKhoa'])->name('khoas.destroy');
    
    // Nganhs
    Route::get('nganhs', [AdminCategoryController::class, 'indexNganhs'])->name('nganhs.index');
    Route::post('nganhs', [AdminCategoryController::class, 'storeNganh'])->name('nganhs.store');
    Route::delete('nganhs/{nganh}', [AdminCategoryController::class, 'destroyNganh'])->name('nganhs.destroy');
    
    // Mons
    Route::get('mons', [AdminCategoryController::class, 'indexMons'])->name('mons.index');
    Route::post('mons', [AdminCategoryController::class, 'storeMon'])->name('mons.store');
    Route::delete('mons/{mon}', [AdminCategoryController::class, 'destroyMon'])->name('mons.destroy');
    
});
