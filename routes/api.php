<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\NutritionController;
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

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
});
Route::prefix('sub-category')->group(function () {
    Route::get('/', [SubCategoryController::class, 'index']);
});
Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
});
Route::prefix('nutrition')->group(function () {
    Route::get('/', [NutritionController::class, 'index']);
});
