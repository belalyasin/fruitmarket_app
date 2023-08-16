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
Route::prefix('cms/admin')->middleware('auth')->group(function () {
    Route::put('/update/{admin}', [AuthController::class, 'update'])->name('admin.update');
    Route::get('profile', [AuthController::class, 'show_profile'])->name('admin.admin_profile');
    Route::get('edit-profile', [AuthController::class, 'edit_profile'])->name('edit_admin_profile');
});
Route::prefix('cms/admin')->middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'welcom'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('subCategories', SubCategoryController::class);
    Route::resource('nutritions', NutritionController::class);
//        Route::delete('subCategories/{id}', [SubCategoryController::class, 'destroy'])->name('subCategories.destroy');

//    Route::prefix('product')->group(function(){
//        Route::get('create', [ProductController::class,'create'])->name('product.create');
//        Route::post('store', [ProductController::class,'store'])->name('product.store');
//        Route::post('edite', [ProductController::class,'edit'])->name('product.edite');
//    });
    Route::put('update_profile/{admin}', [AuthController::class, 'update'])->name('admin.update');
    Route::get('profile', [AuthController::class, 'show_profile'])->name('admin.admin_profile');
    Route::get('edit-profile', [AuthController::class, 'edit_profile'])->name('edit_admin_profile');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});


