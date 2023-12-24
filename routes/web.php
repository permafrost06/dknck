<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::prefix('/admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');
   
    Route::prefix('/products')->name('products.')->controller(ProductController::class)->group(function(){
        Route::get('/api/info/{id}', 'infoApi')->name('api.info');
        Route::get('/edit/{id}', 'form')->name('edit');
        
        Route::get('/api', 'api')->name('api');
        Route::get('/add', 'form')->name('add');
        Route::get('/stock', 'stock')->name('stock');

        Route::post('/store/{id?}', 'store')->name('store');
        Route::delete('/delete/{id}', 'delete')->name('delete');

    });

    Route::prefix('/sales')->name('sales.')->controller(SaleController::class)->group(function(){
        
        Route::get('/edit/{id}', 'form')->name('edit');
        
        Route::get('/add', 'form')->name('add');
        Route::get('/api', 'api')->name('api');
        Route::get('/', 'index')->name('index');

        Route::post('/store/{id?}', 'store')->name('store');
        Route::delete('/delete/{id}', 'delete')->name('delete');

    });

    Route::prefix('/settings')->name('settings.')->controller(SettingController::class)->group(function(){
        
        Route::get('/', 'index')->name('index');
        Route::post('/set', 'store')->name('set');

    });
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

include __DIR__ . '/auth.php';