<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecycleBinController;

// Route trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/danh-sach-san-pham', [HomeController::class, 'productList'])->name('product.index');
Route::get('/san-pham/{id}', [HomeController::class, 'showProductDetail'])->name('product.detail');
// Gửi đánh giá sản phẩm (Client)
Route::post('/san-pham/{id}/danh-gia', [HomeController::class, 'submitReview'])
    ->middleware('auth')
    ->name('client.reviews.store');
Route::get('/posts', [HomeController::class, 'postList'])->name('posts.list');
Route::get('/lien-he', [HomeController::class, 'showContactForm'])->name('contact.form');
Route::post('/lien-he', [HomeController::class, 'submitContactForm'])->name('contact.submit');


// Route đăng ký và đăng nhập
Route::get('/showLogin', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login-post');
Route::get('/showRegister', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register-post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::prefix('admin')->middleware('auth', 'admin')->name('admin.')->group(function () {

    // Các đường dẫn trong nhóm admin sẽ đặt trong đây
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Route quản lý người dùng (Users)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}/show', [UserController::class, 'show'])->name('show');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [UserController::class, 'destroy'])->name('destroy');
    });

    // Route quản lý sản phẩm
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');

        // Route mới để hiển thị danh sách sản phẩm đã xóa mềm
        Route::get('/trashed', [ProductController::class, 'trashed'])->name('trashed');
        Route::get('/{id}/show', [ProductController::class, 'show'])->name('show');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ProductController::class, 'update'])->name('update');
        // Route để xóa mềm một sản phẩm
        Route::delete('/{id}/destroy', [ProductController::class, 'destroy'])->name('destroy');
        // Route mới để khôi phục sản phẩm đã xóa mềm
        Route::post('/{id}/restore', [ProductController::class, 'restore'])->name('restore');
        // Route mới để xóa vĩnh viễn sản phẩm
        Route::delete('/{id}/force-delete', [ProductController::class, 'forceDestroy'])->name('force-delete');
    });

    // Route quản lý danh mục
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/{id}/show', [CategoryController::class, 'show'])->name('show');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Route quản lý khách hàng
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/{id}/show', [CustomerController::class, 'show'])->name('show');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/store', [CustomerController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [CustomerController::class, 'destroy'])->name('destroy');
    });

    // Route quản lý banner
    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/{id}/show', [BannerController::class, 'show'])->name('show');
        Route::get('/create', [BannerController::class, 'create'])->name('create');
        Route::post('/store', [BannerController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BannerController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [BannerController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [BannerController::class, 'destroy'])->name('destroy');
    });

    // Route quản lý bài viết
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/{id}/show', [PostController::class, 'show'])->name('show');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [PostController::class, 'destroy'])->name('destroy');
    });

    // Route quản lý liên hệ
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/{id}/show', [ContactController::class, 'show'])->name('show');
        Route::get('/create', [ContactController::class, 'create'])->name('create');
        Route::post('/store', [ContactController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ContactController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ContactController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [ContactController::class, 'destroy'])->name('destroy');
    });

    // Route quản lý đánh giá
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/{id}/show', [ReviewController::class, 'show'])->name('show');
        Route::get('/create', [ReviewController::class, 'create'])->name('create');
        Route::post('/store', [ReviewController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ReviewController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [ReviewController::class, 'destroy'])->name('destroy');
    });
});

