<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);               // Kayıt Ol
    Route::post('login', [AuthController::class, 'login']);                     // Giriş yap
    Route::post('logout', [AuthController::class, 'logout']);                   // Cıkıs yap
});

Route::get("/notAuth", [AuthController::class, 'notAuth']);                     // Giriş yapılmadıysa dönülecek response

Route::middleware('auth:api')->group(function () {
    // Admin-only rotalar
    Route::middleware("isAdmin")->group(function () {
        Route::post('/products', [ProductController::class, 'store']);          // Ürün ekle
        Route::put('/products/{id}', [ProductController::class, 'update']);     // Ürünü güncelle
        Route::delete('/products/{id}', [ProductController::class, 'destroy']); // Urün sil
    });

    // Ürün rotaları
    Route::get('/products', [ProductController::class, 'index']);               // Tüm ürünleri göster
    Route::get('/products/{id}', [ProductController::class, 'show']);           // Belirli bir ürünin detayını göster

    // Sepet rotaları
    Route::get('/cart', [CartController::class, 'index']);                      // Kullanıcının aktif sepetini göster
    Route::post('/cart/items', [CartItemController::class, 'store']);               // Sepete ürün ekle
    Route::put('/cart/items/{id}', [CartItemController::class, 'update']);          // Sepetteki ürünü güncelle
    Route::delete('/cart/items/{id}', [CartItemController::class, 'destroy']);      // Sepetten ürünü kaldır

    // Sipariş rotaları
    Route::post('/orders', [OrderController::class, 'store']);                  // Sipariş oluştur
    Route::get('/orders', [OrderController::class, 'index']);                   // Kullanıcının tüm siparişlerini göster
    Route::get('/orders/{id}', [OrderController::class, 'show']);               // Belirli bir siparişin detayını göster
});
