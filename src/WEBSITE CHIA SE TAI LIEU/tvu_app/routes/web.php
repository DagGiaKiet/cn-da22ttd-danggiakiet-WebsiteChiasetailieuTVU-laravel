<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\Admin\AdminContactController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublicCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes - set landing as home
Route::get('/', function () {
    return view('landing');
})->name('home');
// Contact page (public)
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
// Public category pages
Route::view('/danh-muc', 'categories.search')->name('danh-muc');
Route::view('/categories', 'categories.learn_more')->name('categories.learn-more');
Route::get('/khoa', [CategoryController::class, 'index'])->name('categories.index');

// Public blog pages: list and detail
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');

// Public document detail page
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');

// Authentication Routes (Laravel UI)
Auth::routes();

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    
    // Documents (redirect index to danh-muc)
    Route::get('/documents', function(){ return redirect()->route('danh-muc'); })->name('documents.index');
    // Remove dedicated create page; redirect to search with upload modal open
    Route::get('/documents/create', function () {
        return redirect()->route('categories.search', ['upload' => 1]);
    })->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::post('/documents/{document}/save', [DocumentController::class, 'toggleSave'])->name('documents.save');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    
    // Category browsing
    Route::get('/categories/khoa/{khoa}', [CategoryController::class, 'showKhoa'])->name('categories.khoa');
    Route::get('/categories/nganh/{nganh}', [CategoryController::class, 'showNganh'])->name('categories.nganh');
    Route::get('/categories/mon/{mon}', [CategoryController::class, 'showMon'])->name('categories.mon');
    
    // Blogs (auth-required actions only)
    // Replace standalone create page with redirect to index + modal auto-open
    Route::get('/blogs/create', function(){ return redirect()->route('blogs.index', ['new' => 1]); })->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::post('/blogs/{blog}/comment', [BlogController::class, 'addComment'])->name('blogs.comment');
    Route::post('/blogs/{blog}/like', [BlogController::class, 'toggleLike'])->name('blogs.like');
    Route::post('/blogs/{blog}/save', [BlogController::class, 'toggleSave'])->name('blogs.save');
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
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/documents', [ProfileController::class, 'documents'])->name('profile.documents');
    Route::get('/profile/saved-documents', [ProfileController::class, 'savedDocuments'])->name('profile.saved-documents');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/blogs', [ProfileController::class, 'blogs'])->name('profile.blogs');
    Route::get('/profile/saved-blogs', [ProfileController::class, 'savedBlogs'])->name('profile.saved-blogs');
    // Profile actions similar to admin UX
    Route::post('/profile/lock', [ProfileController::class, 'lock'])->name('profile.lock');
    Route::post('/profile/unlock', [ProfileController::class, 'unlock'])->name('profile.unlock');
    Route::post('/profile/orders/{order}/status', [ProfileController::class, 'updateOrderStatus'])->name('profile.orders.update-status');
    
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/global-search', [AdminDashboardController::class, 'globalSearch'])->name('global-search');
    
    // Users management
    Route::resource('users', AdminUserController::class);
    Route::resource('contacts', AdminContactController::class)->only(['index', 'destroy']);
    Route::patch('contacts/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.update-status');
    Route::post('users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
    Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::patch('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    
    // Documents management
    Route::resource('documents', AdminDocumentController::class);
    Route::post('documents/{document}/status', [AdminDocumentController::class, 'updateStatus'])->name('documents.update-status');
    
    // Blogs management
    Route::resource('blogs', AdminBlogController::class);
    
    // Orders management
    Route::resource('orders', AdminOrderController::class);
    Route::post('orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Categories management (Khoa, Nganh, Mon)
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    // Khoas
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

// Optional route to original app home
Route::get('/app', [HomeController::class, 'index'])->name('app.home');

// Landing page based on provided static HTML
Route::get('/landing', function () {
    return view('landing');
})->name('landing');

// Public JSON API for cascading selects
Route::prefix('public-api')->group(function () {
    Route::get('/khoas', [PublicCategoryController::class, 'khoas']);
    Route::get('/nganhs', [PublicCategoryController::class, 'nganhs']);
    Route::get('/mons', [PublicCategoryController::class, 'mons']);
    Route::get('/documents', [PublicCategoryController::class, 'documents']);
});

// Messages routes
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/send', [App\Http\Controllers\MessageController::class, 'send'])->name('messages.send');
    Route::get('/messages/unread-count', [App\Http\Controllers\MessageController::class, 'unreadCount'])->name('messages.unread-count');
});
