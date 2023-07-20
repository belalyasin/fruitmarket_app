<?php

use App\Http\Controllers\web\admin\AuthController;
use App\Http\Controllers\web\CategoryController;
use App\Http\Controllers\web\NutritionController;
use App\Http\Controllers\web\ProductController;
use App\Http\Controllers\web\SubCategoryController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('auth.login'));
});
Route::prefix('cms')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'loginView'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::prefix('cms/admin')->middleware('auth')->group(function(){
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('subCategories', SubCategoryController::class);
        Route::resource('nutritions', NutritionController::class);

    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

