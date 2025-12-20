<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminOrderController;

Route::get('/', function () {
    $featuredMenus = \DB::table('menus')->where('is_available', true)->limit(3)->get();
    return view('welcome', compact('featuredMenus'));
});

Route::get('/menu', function () {
    $menus = \DB::table('menus')->where('is_available', true)->orderBy('category')->get();
    return view('menu.index', compact('menus'));
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/project', [\App\Http\Controllers\ProjectController::class, 'index'])
    ->middleware(['auth', \App\Http\Middleware\ProjectAccess::class]);
Route::get('/project/progress', [\App\Http\Controllers\ProjectController::class, 'getProgress'])
    ->middleware(['auth', \App\Http\Middleware\ProjectAccess::class]);
Route::post('/project/progress', [\App\Http\Controllers\ProjectController::class, 'saveProgress'])
    ->middleware(['auth', \App\Http\Middleware\ProjectAccess::class]);

Route::get('/reservation', [ReservationController::class, 'create']);
Route::post('/reservation', [ReservationController::class, 'store'])->middleware('auth');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('customer')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $userId = auth()->id();
        $orders = \DB::table('orders')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        foreach ($orders as $order) {
            $order->items = \DB::table('order_items')
                ->join('menus', 'order_items.menu_id', '=', 'menus.id')
                ->where('order_items.order_id', $order->id)
                ->select('order_items.*', 'menus.image_url')
                ->get();
        }
        
        $totalOrders = \DB::table('orders')->where('user_id', $userId)->count();
        $totalReservations = \DB::table('reservations')->where('user_id', $userId)->count();
        
        return view('customer.dashboard', compact('orders', 'totalOrders', 'totalReservations'));
    });
    
    Route::get('/orders', function () {
        $userId = auth()->id();
        $orders = \DB::table('orders')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        foreach ($orders as $order) {
            $order->items = \DB::table('order_items')
                ->join('menus', 'order_items.menu_id', '=', 'menus.id')
                ->where('order_items.order_id', $order->id)
                ->select('order_items.*', 'menus.image_url')
                ->get();
        }
        
        return view('customer.orders.index', compact('orders'));
    });
    
    Route::get('/orders/create', function () {
        $menus = \DB::table('menus')->where('is_available', true)->orderBy('category')->get();
        return view('customer.orders.create', compact('menus'));
    });
    
    Route::post('/orders', [OrderController::class, 'store']);
    
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    
    Route::get('/profile', function () {
        $userId = auth()->id();
        $totalOrders = \DB::table('orders')->where('user_id', $userId)->count();
        $totalReservations = \DB::table('reservations')->where('user_id', $userId)->count();
        
        $totalSpend = \DB::table('orders')
            ->where('user_id', $userId)
            ->sum('total');
            
        $points = floor($totalSpend / 10000);
        
        return view('customer.profile', compact('totalOrders', 'totalReservations', 'points'));
    });
});

Route::get('/dashboard', function () {
    if (auth()->check()) {
        return redirect('/customer/dashboard');
    }
    return redirect('/login');
});

Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    
    Route::get('/menus', [AdminMenuController::class, 'index']);
    Route::get('/menus/create', [AdminMenuController::class, 'create']);
    Route::post('/menus', [AdminMenuController::class, 'store']);
    Route::get('/menus/{slug}/edit', [AdminMenuController::class, 'edit']);
    Route::put('/menus/{slug}', [AdminMenuController::class, 'update']);
    Route::delete('/menus/{slug}', [AdminMenuController::class, 'destroy']);
    
    Route::get('/users', [AdminUserController::class, 'index']);
    Route::put('/users/{id}/status', [AdminUserController::class, 'updateStatus']);
    
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
    
    Route::get('/reservations', [AdminReservationController::class, 'index']);
    Route::get('/reservations/{id}', [AdminReservationController::class, 'show']);
    Route::put('/reservations/{id}/status', [AdminReservationController::class, 'updateStatus']);
    
    Route::get('/activities', [AdminActivityController::class, 'index']);
});

Route::get('lang/{locale}', function ($locale) { 
    if (in_array($locale, ['en', 'id'])) { 
        session(['locale' => $locale]); 
    } 
    return redirect()->back(); 
})->name('lang.switch');
