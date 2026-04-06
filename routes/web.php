<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== LANDING PAGE ====================
Route::get('/', function () {
    $products = \App\Models\Product::where('is_active', true)
        ->where('stock', '>', 0)
        ->latest()
        ->take(8)
        ->get();
    return view('landing', compact('products'));
})->name('home');

// ==================== AUTENTIKASI ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==================== PRODUK (PUBLIK) ====================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// ==================== ROUTE YANG MEMERLUKAN AUTENTIKASI ====================
Route::middleware(['auth'])->group(function () {
    
    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/photo', [ProfileController::class, 'photoForm'])->name('photo');
        Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo.update');
        Route::delete('/photo', [ProfileController::class, 'deletePhoto'])->name('photo.delete');
    });
    
    // Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::put('/{cart}', [CartController::class, 'update'])->name('update');
        Route::delete('/{cart}', [CartController::class, 'remove'])->name('remove');
    });
    
    // Checkout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'process'])->name('process');
    });
    
    // Orders (Customer)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });
});

// ==================== ROUTE ADMIN ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products Management
    Route::resource('products', AdminProductController::class);
    Route::post('/products/{product}/toggle-active', [AdminProductController::class, 'toggleActive'])
        ->name('products.toggle-active');
    
    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::put('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
        Route::post('/{order}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])->name('confirm-payment');
        Route::post('/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('cancel');
    });
    
    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
        Route::post('/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('toggle-active');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy'); // TAMBAHKAN INI
    });
    
    // Reports Management
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'index'])->name('sales');
        Route::get('/sales/pdf', [ReportController::class, 'exportPDF'])->name('sales.pdf');
    });
});

// ==================== ROUTE DENGAN MIDDLEWARE USER AKTIF ====================
// Gunakan ini jika perlu memastikan user dalam status aktif
Route::middleware(['auth', 'user.active'])->group(function () {
    // Tambahkan route yang hanya bisa diakses user aktif di sini
    // Contoh: Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
});

// ==================== FALLBACK ROUTE (404) ====================
Route::fallback(function () {
    return view('errors.404');
});