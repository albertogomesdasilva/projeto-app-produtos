<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product');

//Admin

Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products');

Route::get('/admin/product/create', [AdminProductController::class, 'create'])->name('admin.product.create');
Route::post('/admin/product/create', [AdminProductController::class, 'store'])->name('admin.product.store');

Route::get('/admin/product/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.product.edit');
Route::put('/admin/product/{product}', [AdminProductController::class, 'update'])->name('admin.product.update');


Route::get('/admin/product/{product}/delete', [AdminProductController::class, 'destroy'])->name('admin.product.destroy');

// apagar imagem

Route::get('/admin/product/{product}/delete-image', [AdminProductController::class, 'destroyImage'])->name('admin.product.destroyImage');