<?php

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

Route::get('/', [App\Http\Controllers\ProductController::class, 'homePage'])->name('home');
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'singleProduct'])->name('products.single');

Auth::routes();



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// route group
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('admin');
    Route::resource('brands', App\Http\Controllers\BrandController::class)->names([
        'index' => 'brands.index',
        'create' => 'brands.create',
        'store' => 'brands.store',
        'show' => 'brands.show',
        'edit' => 'brands.edit',
        'update' => 'brands.update',
        'destroy' => 'brands.destroy',
    ]);
    Route::resource('products', App\Http\Controllers\ProductController::class)->names([
        'index' => 'products.index',
        'create' => 'products.create',
        'store' => 'products.store',
        'show' => 'products.show',
        'edit' => 'products.edit',
        'update' => 'products.update',
        'destroy' => 'products.destroy',
    ]);
});
