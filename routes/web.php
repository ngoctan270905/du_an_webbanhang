<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\RecycleBinController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Models\Order;

// =====================
// Routes client - cần đăng nhập
// =====================
Route::middleware(['auth', 'verified'])->group(function () {
    // Route của giỏ hàng
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/validate', [CartController::class, 'validateCart'])->name('cart.validate');
    Route::post('/cart/apply-changes', [CartController::class, 'applyChanges'])->name('cart.apply_changes');

    // Route của thanh toán đơn hàng
    Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('order.checkout');
    Route::post('/order/create', [OrderController::class, 'createOrder'])->name('order.create');
    Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('order.success');

    // Route của thông tin cá nhân người dùng
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-orders', [ProfileController::class, 'index'])->name('my-orders.index');
    Route::get('/my-orders/{id}', [ProfileController::class, 'showOrders'])->name('my-orders.show');
    Route::post('/my-orders/{ma_don_hang}/cancel', [OrderController::class, 'cancel'])->name('my-orders.cancel');
    Route::post('/my-orders/{order}/confirm-received', [OrderController::class, 'confirmReceived'])->name('my-orders.confirm-received');
    Route::post('/my-orders/{ma_don_hang}/return', [OrderController::class, 'requestReturn'])->name('my-orders.return');
    Route::get('/my-returns', [OrderController::class, 'returns'])->name('my-returns');
    Route::get('/my-returns/{returnId}', [OrderController::class, 'returnDetail'])->name('my-returns.detail');
    Route::post('/my-returns/{returnId}/cancel', [OrderController::class, 'cancelReturn'])->name('my-returns.cancel');
});

require __DIR__ . '/auth.php';

// =====================
// Routes client - KHông cần đăng nhập
// =====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/danh-sach-san-pham', [HomeController::class, 'productList'])->name('products.list');
Route::get('/san-pham/{id}', [HomeController::class, 'showProductDetail'])->name('product.detail');

// Gửi đánh giá sản phẩm (Client) - Yêu cầu đăng nhập
Route::post('/san-pham/{id}/danh-gia', [HomeController::class, 'submitReview'])
    ->middleware('auth')
    ->name('client.reviews.store');

Route::get('/posts', [HomeController::class, 'postList'])->name('posts.list');
Route::get('/lien-he', [HomeController::class, 'showContactForm'])->name('contact.form');
Route::post('/lien-he', [HomeController::class, 'submitContactForm'])->name('contact.submit');


// =====================
// Routes admin
// =====================
Route::prefix('admin')->middleware('auth', 'verified', 'admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Quản lý Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}/show', [UserController::class, 'show'])->name('show');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [UserController::class, 'destroy'])->name('destroy');
    });

    // Quản lý Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/trashed', [ProductController::class, 'trashed'])->name('trashed');
        Route::get('/{id}/show', [ProductController::class, 'show'])->name('show');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [ProductController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [ProductController::class, 'forceDestroy'])->name('force-delete');
    });

    // Quản lý Categories
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/{id}/show', [CategoryController::class, 'show'])->name('show');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
        Route::get('/trashed', [CategoryController::class, 'trashed'])->name('trashed');
        Route::post('/{id}/restore', [CategoryController::class, 'restore'])->name('restore');
        Route::delete('/{id}/forceDelete', [CategoryController::class, 'forceDelete'])->name('forceDelete');
    });

    // Quản lí đơn hàng
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/{id}', [ReturnController::class, 'show'])->name('returns.show');
    Route::put('/returns/{id}/update-status', [ReturnController::class, 'updateStatus'])->name('returns.update-status');

    // Quản lý Banners
    Route::prefix('banners')->name('banners.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/create', [BannerController::class, 'create'])->name('create');
        Route::post('/store', [BannerController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BannerController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [BannerController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [BannerController::class, 'destroy'])->name('destroy');
    });

    // Quản lý Posts
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/{id}/show', [PostController::class, 'show'])->name('show');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [PostController::class, 'destroy'])->name('destroy');
    });

    // Quản lý Contacts
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/{id}/show', [ContactController::class, 'show'])->name('show');
        Route::post('/{id}/reply', [ContactController::class, 'reply'])->name('reply');
    });

    // Quản lý Reviews
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/{id}/show', [ReviewController::class, 'show'])->name('show');
        Route::get('/create', [ReviewController::class, 'create'])->name('create');
        Route::post('/store', [ReviewController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ReviewController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [ReviewController::class, 'destroy'])->name('destroy');
        Route::get('/{product}/reviews', [ReviewController::class, 'showReviews'])->name('showReviews');
        // Routes cho phản hồi đánh giá
        Route::post('/{id}/reply', [ReviewController::class, 'storeReply'])->name('reply.store');
        Route::delete('/{id}/reply', [ReviewController::class, 'deleteReply'])->name('reply.delete');
    });
});
