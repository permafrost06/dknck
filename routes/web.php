<?php

use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\IndexController;
use App\Http\Controllers\admin\ItemController;
use App\Http\Controllers\admin\PurchaseController;
use App\Http\Controllers\admin\SalesController;
use App\Http\Controllers\admin\VendorController;
use App\Http\Controllers\admin\StockController;
use App\Http\Controllers\admin\StockItemController;
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

Route::get('/test', 'api\v1\TestController@test');
Route::prefix('/admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');
    Route::get('/search', ['uses' => 'admin\SearchController@searchQuestion', 'as' => 'question.search']);

    Route::prefix('/customers')->name('customers.')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/api', 'api')->name('api');
        Route::get('/create', 'form')->name('create');
        Route::get('/edit/{id}', 'form')->name('edit');
        Route::post('/store/{id?}', 'store')->name('store');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    Route::prefix('/items')->name('items.')->controller(ItemController::class)->group(function(){
        Route::get('/add', 'form')->name('add');
        Route::get('/edit/{id}', 'form')->name('edit');

        Route::post('/store/{id?}', 'store')->name('store');

        Route::delete('/{id}', 'delete')->name('delete');

    });

    Route::prefix('/sales')->name('sales.')->controller(SalesController::class)->group(function () {
        Route::get('/create', 'form')->name('create');

        Route::get('/api/{id?}', 'api')->name('api');

        Route::get('/edit/{id}', 'form')->name('edit');
        Route::post('/store/{id?}', 'store')->name('store');

        Route::get('/{id?}', 'index')->name('index');
        Route::delete('/{id}', 'delete')->name('delete');


        Route::get('/delete/multiple', 'deleteMultiple')->name('delete.multiple');        
        Route::get('/download/{id?}', 'generatePDF')->name('generatePDF');
    });

    Route::prefix('/vendors')->name('vendor.')->controller(VendorController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/api', 'api')->name('api');
        Route::get('/{id}', 'form')->name('form');
        Route::post('/{id?}', 'store')->name('store');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    Route::prefix('/purchase')->name('purchase.')->controller(PurchaseController::class)->group(function () {
        Route::get('/download-report/{id?}', 'generatePDF')->name('generatePDF');
        Route::get('/create', 'form')->name('create');
        Route::get('/edit/{id?}', 'form')->name('edit');
        Route::post('/store/{id?}', 'store')->name('store');
    
        Route::get('/delete/multiple', 'deleteMultiple')->name('delete.multiple');
        
        Route::get('/api/{id?}', 'api')->name('api');
        Route::get('/{id?}', 'index')->name('index');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    Route::prefix('/stocks')->name('stocks.')->group(function () {

        Route::controller(StockItemController::class)->group(function () {
            Route::post('/update', 'store')->name('update');
            Route::get('/', 'index')->name('status');
            Route::get('/items_api', 'items_api')->name('status_api');
        });

        Route::controller(StockController::class)->group(function () {
            Route::post('/{stock}', 'store')->name('store');
            Route::delete('/{stock}', 'destroy')->name('delete');
            Route::get('/logs/{item?}', 'logs')->name('logs');
            Route::get('/logs_api/{item?}', 'logs_api')->name('logs_api');
            Route::get('/{stock}', 'form')->name('form');
        });

    });
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

include __DIR__ . '/auth.php';