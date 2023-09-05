<?php

use App\Http\Controllers\api\Auth\AuthController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\FavouriteController;
use App\Http\Controllers\api\NutritionController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\SubCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/store-user-data', [AuthController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/current-user', [AuthController::class, 'getCurrentUser']);
    Route::PUT('/update-profile', [AuthController::class, 'updateProfile']);
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
    });
    Route::prefix('sub-category')->group(function () {
        Route::get('/', [SubCategoryController::class, 'index']);
    });
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{product}', [ProductController::class, 'show']);
        Route::post('/rate/{product}', [ProductController::class, 'rateProduct']);
        Route::put('/{product}/favorite', [ProductController::class, 'update']);
    });
    Route::prefix('nutrition')->group(function () {
        Route::get('/', [NutritionController::class, 'index']);
    });
    Route::prefix('favorite')->group(function () {
        Route::get('/', [FavouriteController::class, 'index']);
    });
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/add-to-cart/{favoriteId}', [CartController::class, 'addToCart']);
        Route::delete('/{cart}', [CartController::class, 'destroy']);
    });
    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/place-order', [OrderController::class, 'placeOrder']);
    });
});
