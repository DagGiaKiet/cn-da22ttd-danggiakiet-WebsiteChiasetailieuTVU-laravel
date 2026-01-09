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

// Các route công khai - đặt landing page là trang chủ
Route::get('/', function () {
    return view('landing');
})->name('home');
// Trang liên hệ (công khai)
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
// Các trang danh mục công khai
Route::view('/danh-muc', 'categories.search')->name('danh-muc');
Route::view('/categories', 'categories.learn_more')->name('categories.learn-more');
Route::get('/khoa', [CategoryController::class, 'index'])->name('categories.index');

// Các trang blog công khai: danh sách và chi tiết
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');

// Trang chi tiết tài liệu công khai
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');

// Các route xác thực (Laravel UI)
Auth::routes();

// Các route được bảo vệ - yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    
    // Tài liệu (chuyển hướng index sang danh mục)
    Route::get('/documents', function(){ return redirect()->route('danh-muc'); })->name('documents.index');
    // Xóa trang tạo riêng; chuyển hướng đến trang tìm kiếm với modal upload mở sẵn
    Route::get('/documents/create', function () {
        return redirect()->route('categories.search', ['upload' => 1]);
    })->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::post('/documents/{document}/save', [DocumentController::class, 'toggleSave'])->name('documents.save');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    
    // Duyệt danh mục
    Route::get('/categories/khoa/{khoa}', [CategoryController::class, 'showKhoa'])->name('categories.khoa');
    Route::get('/categories/nganh/{nganh}', [CategoryController::class, 'showNganh'])->name('categories.nganh');
    Route::get('/categories/mon/{mon}', [CategoryController::class, 'showMon'])->name('categories.mon');
    
    // Blogs (chỉ các hành động yêu cầu đăng nhập)
    // Thay trang tạo riêng bằng redirect đến index + modal tự mở
    Route::get('/blogs/create', function(){ return redirect()->route('blogs.index', ['new' => 1]); })->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::post('/blogs/{blog}/comment', [BlogController::class, 'addComment'])->name('blogs.comment');
    Route::post('/blogs/{blog}/like', [BlogController::class, 'toggleLike'])->name('blogs.like');
    Route::post('/blogs/{blog}/save', [BlogController::class, 'toggleSave'])->name('blogs.save');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    
    // Giỏ hàng
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{document}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    
    // Đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Hồ sơ cá nhân
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/documents', [ProfileController::class, 'documents'])->name('profile.documents');
    Route::get('/profile/saved-documents', [ProfileController::class, 'savedDocuments'])->name('profile.saved-documents');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/blogs', [ProfileController::class, 'blogs'])->name('profile.blogs');
    Route::get('/profile/saved-blogs', [ProfileController::class, 'savedBlogs'])->name('profile.saved-blogs');
    // Các hành động hồ sơ tương tự UX admin
    Route::post('/profile/lock', [ProfileController::class, 'lock'])->name('profile.lock');
    Route::post('/profile/unlock', [ProfileController::class, 'unlock'])->name('profile.unlock');
    Route::post('/profile/orders/{order}/status', [ProfileController::class, 'updateOrderStatus'])->name('profile.orders.update-status');
    
});

// Các route người quản trị (Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/global-search', [AdminDashboardController::class, 'globalSearch'])->name('global-search');
    
    // Quản lý người dùng
    Route::resource('users', AdminUserController::class);
    Route::resource('contacts', AdminContactController::class)->only(['index', 'destroy']);
    Route::patch('contacts/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.update-status');
    Route::post('users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
    Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::patch('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    
    // Quản lý tài liệu
    Route::resource('documents', AdminDocumentController::class);
    Route::post('documents/{document}/status', [AdminDocumentController::class, 'updateStatus'])->name('documents.update-status');
    
    // Quản lý bài viết (blog)
    Route::resource('blogs', AdminBlogController::class);
    
    // Quản lý đơn hàng
    Route::resource('orders', AdminOrderController::class);
    Route::post('orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Quản lý danh mục (Khoa, Ngành, Môn)
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    // Khoa
    Route::get('khoas', [AdminCategoryController::class, 'indexKhoas'])->name('khoas.index');
    Route::post('khoas', [AdminCategoryController::class, 'storeKhoa'])->name('khoas.store');
    Route::delete('khoas/{khoa}', [AdminCategoryController::class, 'destroyKhoa'])->name('khoas.destroy');
    // Ngành
    Route::get('nganhs', [AdminCategoryController::class, 'indexNganhs'])->name('nganhs.index');
    Route::post('nganhs', [AdminCategoryController::class, 'storeNganh'])->name('nganhs.store');
    Route::delete('nganhs/{nganh}', [AdminCategoryController::class, 'destroyNganh'])->name('nganhs.destroy');
    // Môn
    Route::get('mons', [AdminCategoryController::class, 'indexMons'])->name('mons.index');
    Route::post('mons', [AdminCategoryController::class, 'storeMon'])->name('mons.store');
    Route::delete('mons/{mon}', [AdminCategoryController::class, 'destroyMon'])->name('mons.destroy');
    
});

// Route tùy chọn tới trang chủ app gốc
Route::get('/app', [HomeController::class, 'index'])->name('app.home');

// Trang landing dựa trên HTML tĩnh được cung cấp
Route::get('/landing', function () {
    return view('landing');
})->name('landing');

// API JSON công khai cho các select xếp tầng
Route::prefix('public-api')->group(function () {
    Route::get('/khoas', [PublicCategoryController::class, 'khoas']);
    Route::get('/nganhs', [PublicCategoryController::class, 'nganhs']);
    Route::get('/mons', [PublicCategoryController::class, 'mons']);
    Route::get('/documents', [PublicCategoryController::class, 'documents']);
});

// Các route tin nhắn
Route::middleware(['auth'])->group(function () {
    Route::get('/messages/conversations', [App\Http\Controllers\MessageController::class, 'conversations'])->name('messages.conversations');
    Route::get('/messages/unread-count', [App\Http\Controllers\MessageController::class, 'unreadCount'])->name('messages.unread-count');
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/send', [App\Http\Controllers\MessageController::class, 'send'])->name('messages.send');
});
